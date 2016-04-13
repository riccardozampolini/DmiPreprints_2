<?php
#importazione della libreria simplepie versione 1.3.1
include_once './arXiv/SimplePie.php';
include_once './arXiv/functions.php';
include_once './arXiv/cURL.php';
include_once './arXiv/insert_remove_db.php';
define('EOL', "<br />\n");
$seconds = 86400;
#tempo massimo di esecuzione di 86400 secondi equivalente a un giorno
set_time_limit($seconds);
#funzione per il recupero delle informazioni da arxiv.org
function arxiv_call($nome, $dataultimolancio, $proc) {
  #importazione variabili globali
  include './conf.php';
  #inizializzo variabile per contare preprints scaricati...
  $k = 0;
  #adattamento stringa nome per chiamata su arXiv...
  $temp1 = $nome;
  $temp2 = "";
  $lunghezza = strlen($temp1);
  $nomed = "";
  for ($i = 0; $i < $lunghezza; $i++) {
    if ($temp1{$i} != " ") {
      $temp2 = $temp2 . $temp1{$i};
    } else {
      $nomed = $temp2 . " AND ";
      $temp2 = "";
    }
  }
  $nomed = $nomed . $temp2;
  #avvio della chiamata al server di arxiv...
  #base api query url
  $base_url = 'http://export.arxiv.org/api/query?';
  #parametri della ricerca
  $search_query = 'all:' . $nomed . '&sortBy=lastUpdatedDate&sortOrder=descending'; # search for ... in all fields
  $start = 0;
  $max_results = 10000;
  #costruzione della query
  $query = "search_query=" . $search_query . "&start=" . $start . "&max_results=" . $max_results;
  $feed = new SimplePie($base_url . $query);
  $feed->enable_order_by_date(false);
  $feed->init();
  $feed->handle_content_type();
  $atom_ns = 'http://www.w3.org/2005/Atom';
  $opensearch_ns = 'http://a9.com/-/spec/opensearch/1.1/';
  $arxiv_ns = 'http://arxiv.org/schemas/atom';
  $last_updated = $feed->get_feed_tags($atom_ns, 'updated');
  $data = $last_updated[0]['data'] . EOL . EOL;
  $totalResults = $feed->get_feed_tags($opensearch_ns, 'totalResults');
  #risultati recuperati per la query
  print("RESULTS FOR " . $nome . ": " . $totalResults[0]['data'] . EOL);
  $startIndex = $feed->get_feed_tags($opensearch_ns, 'startIndex');
  $itemsPerPage = $feed->get_feed_tags($opensearch_ns, 'itemsPerPage');
  $i = 1;
  foreach ($feed->get_items() as $entry) {
    $temp = split('/abs/', $entry->get_id());
    #id pubblicazione
    $arcid = $temp[1];
    $titolo = $entry->get_title() . EOL;
    #data pubblicazione preprint
    $published = $entry->get_item_tags($atom_ns, 'published');
    $datapubbstring = $published[0]['data'];
    #array autori
    $authors = array();
    foreach ($entry->get_item_tags($atom_ns, 'author') as $author) {
      $name = $author['child'][$atom_ns]['name'][0]['data'];
      $name = trim($name);
      $affils = array();
      array_push($authors, '' . $name . EOL);
    }
    $author_string = join('', $authors);
    #link dei pdf per ogni preprints
    foreach ($entry->get_item_tags($atom_ns, 'link') as $link) {
      if ($link['attribs']['']['rel'] == 'alternate') {
        $abs = $link['attribs']['']['href'];
      } else if ($link['attribs']['']['title'] == 'pdf') {
        $pdf = $link['attribs']['']['href'] . ".pdf";
        #download pdf...
        $arcid1 = str_replace("/", "-", $arcid);
        $percorso = $basedir3 . $arcid1 . ".pdf";
        #controllo della data...
        $datapubb = trim($datapubbstring);
        $datapubb = substr($datapubb, 0, 10);
        $datapubb = str_replace("-", "", $datapubb);
        $datapubb = intval($datapubb);
        $ris = nomiprec($nome);
        #controllo della data di pubblicazione con quella di ultimo lancio e controllo del nome se cercato nell'ultima esecuzione
        if ($datapubb > $dataultimolancio or ( $ris == False)) {
          #controllo se il preprint è stato già scaricato
          if (preprintscaricati($arcid1) == False && (!check_downloaded($arcid1) or $proc)) {
            #richiamo della funzione per il versionamento dei preprints
            version_preprint($arcid);
            #richiamo cURL per il download del pdf
            curl_download($pdf, $percorso);
            #incremento del contatore
            $k++;
          }
        }
      }
    }
    #referenze giornalistiche
    $journal_ref_raw = $entry->get_item_tags($arxiv_ns, 'journal_ref');
    if ($journal_ref_raw) {
      $journal_ref = $journal_ref_raw[0]['data'];
    } else {
      $journal_ref = 'No journal ref';
    }
    $comments_raw = $entry->get_item_tags($arxiv_ns, 'comment');
    if ($comments_raw) {
      $comments = $comments_raw[0]['data'];
    } else {
      $comments = 'No journal ref';
    }
    $primary_category_raw = $entry->get_item_tags($arxiv_ns, 'primary_category');
    $primary_category = $primary_category_raw[0]['attribs']['']['term'];
    #categoria preprints
    $categories = array();
    foreach ($entry->get_categories() as $category) {
      array_push($categories, $category->get_label());
    }
    $categories_string = join(', ', $categories);
    $descrizione = $entry->get_description() . EOL . EOL;
    #verifica e inserimento nel array...
    $ris = nomiprec($nome);
    #controllo della data di pubblicazione con quella di ultimo lancio e controllo del nome se cercato nell'ultima esecuzione
    if ($datapubb > $dataultimolancio or ( $ris == False)) {
      #controllo se il preprint è stato già scaricato
      if (preprintscaricati($arcid1) == False && (!check_downloaded($arcid1) or $proc)) {
        $array[0] = $arcid; #ARXIV ID
        $array[1] = $titolo; #TITOLO
        $array[2] = $datapubbstring; #DATA PUBBLICAZIONE
        $author_string = str_replace("<br />", ", ", $author_string);
        $author_string = str_replace("\n", " ", $author_string);
        $array[3] = $author_string; #AUTORI
        $array[4] = $journal_ref; #REFERENZE GIORNALISTICHE
        $array[5] = $comments; #COMMENTI
        $array[6] = $primary_category; #CATEGORIA
        $array[7] = $descrizione; #ABSTRACT
        #richiamo della funzione per inserire le info del preprint all'interno del database
        insert_preprints($array);
        #aggiorna il file temp.txt
        aggiornapreprintscaricati($arcid1);
      }
    }
  }
  return $k;
}
?>
