<!DOCTYPE html>
<html>
<?php
require_once './graphics/header.php';
?>
<body>
  <div>
    <div id="header-wrapper">
      <div class="container">
        <div class="row">
          <div class="12u">
            <header id="header">
              <h1><a href="./index.php" id="logo">DMI Preprints</a></h1>
              <nav id="nav">
                <a href="./index.php" onclick="loading(load);">Publications</a>
                <a href="./reserved.php" class="current-page-item" class="current-page-item" onclick="loading(load);">Reserved Area</a>
              </nav>
            </header>
          </div>
        </div>
      </div>
    </div>
    <br/>
    <div id="firstContainer">
      <div>
        <div>
          <center><h2>ARXIV PANEL</h2></center>
          <div id="boxsx">
            Go to admin panel
          </div>
          <div id="boxdx">
            <a style="color:#ffffff;" href="./reserved.php" id="bottone_keyword" class="buttonlink" onclick="loading(load);">Back</a>
          </div>
          <div id="boxsx">
            The authors list
          </div>
          <div id="boxdx">
            <a style="color:#ffffff;" href="./authors_list.php" id="bottone_keyword" class="buttonlink" onclick="loading(load);">View</a>
          </div>
          <div id="boxsx">
            Insert one preprint
          </div>
          <div id="boxdx">
            <a style="color:#ffffff;" href="./manual_insert.php" id="bottone_keyword" class="buttonlink" onclick="loading(load);">Enter</a>
          </div>
          <div id="boxsx">
            Approve preprints
          </div>
          <div id="boxdx">
            <a style="color:#ffffff;" href="./check_preprints.php?i=1" id="bottone_keyword" class="buttonlink" onclick="loading(load);">Check</a>
            <?php
            //controllo se ci sono preprint da approvare
            if (check_approve() == true) {
              print_r(" <font style='color:red; font-style: italic'>&#8592; There are preprint to be approved!</font>");
            }
            ?>
          </div>
          <div id="boxsx">
            Search for new preprints
          </div>
          <div id="boxdx">
            <a style="color:#ffffff;" href="./arXiv_panel.php?b8=update" id="bottone_keyword" class="buttonlink" onclick="loading(load);">Update</a>
          </div>
          <div id="boxsx">
            Download all from arXiv!
          </div>
          <div id="boxdx">
            <a style="color:#ffffff;" href="./arXiv_panel.php?b9=overwrite" id="bottone_keyword" class="buttonlink" onclick="return confirmDownload()">Overwrite</a>
          </div>
          <div style="clear:both;"></div>
        </div>
        <center>
          <hr style="display: block; height: 1px; border: 0; border-top: 1px solid #ccc; margin: 1em 0; padding: 0;">
          <?php
          //pulsante aggiorna(cerca se ci sono preprint nuovi)
          if (isset($_GET['b8'])) {
            if ($sock = @fsockopen('www.arxiv.org', 80, $num, $error, 5)) {
              if (sessioneavviata() == False) {
                #avvio della sessione
                avviasessione();
                #inizializzo variabile j per contare elementi scaricati...
                $j = 0;
                #data ultimo lancio...
                $data = dataprec();
                #leggo nomi da file nomi.txt
                $array = legginomi();
                #conto lunghezza dell'array $array
                $nl = count($array);
                if ($nl == 0) {
                  chiudisessione();
                  echo '<script type="text/javascript">setTimeout(function(){alert("No author inside list!")}, 500);</script>';
                } else {
                  #inizializzo variabile per contare preprints scaricati...
                  for ($i = 0; $i < $nl; $i++) {
                    $nomi = $array[$i];
                    #rimozione spazi all'inizio e alla fine della stringa nomi
                    $nomi = trim($nomi);
                    #uso la funzione arxiv call per contare i download
                    $j = $j + arxiv_call($nomi, $data, false);
                  }
                  #aggiornamento dei nomi nel file nomi_ultimo_lancio...
                  aggiornanomi();
                  #aggiornamento file data_ultimo_lancio.txt con la data di oggi...
                  aggiornadata();
                  #azzeramento file temporaneo...
                  azzerapreprint();
                  #chiudo la sessione di download
                  chiudisessione();
                  echo "<br/>PREPRINTS DOWNLOADED: " . $j . "<br/><br/>";
                  $dc1 = true;
                  //controllo se ci sono preprint da approvare
                  if (check_approve() == true) {
                    print_r(" <font style='color:red; font-style: italic'>There are preprint to be approved!</font><br/><br/>");
                  }
                }
              } else {
                $risul = true;
                #sessione già avviata
              }
            }
          }
          //pulsante download(riscarica tutti i preprint)
          if (isset($_GET['b9'])) {
            if ($sock = @fsockopen('www.arxiv.org', 80, $num, $error, 5)) {
              if (sessioneavviata() == False) {
                #avvio della sessione
                avviasessione();
                #inizializzo variabile j per contare elementi scaricati...
                $j = 0;
                #leggo i nomi dal file nomi.txt
                $array = legginomi();
                #conto lunghezza dell'array $array
                $nl = count($array);
                if ($nl == 0) {
                  chiudisessione();
                  #nessun autore
                  echo '<script type="text/javascript">setTimeout(function(){alert("No author inside list!")}, 500);</script>';
                } else {
                  #inizializzo variabile per contare preprints scaricati...
                  for ($i = 0; $i < $nl; $i++) {
                    #inserisco un nome alla volta nella variabile $nomi
                    $nomi = $array[$i];
                    #rimozione dei spazi all'inizio e alla fine della stringha
                    $nomi = trim($nomi);
                    $j = $j + arxiv_call($nomi, 0, true);
                  }
                  #aggiornamento dei nomi nel file nomi_ultimo_lancio...
                  aggiornanomi();
                  #aggiornamento file data_ultimo_lancio.txt con la data di oggi...
                  aggiornadata();
                  #azzeramento temp
                  azzerapreprint();
                  #chiudo la sessione di download
                  chiudisessione();
                  echo "<br/>PREPRINTS DOWNLOADED: " . $j . "<br/><br/>";
                  $dc2 = true;
                  //controllo se ci sono preprint da approvare
                  if (check_approve() == true) {
                    print_r(" <font style='color:red; font-style: italic'>There are preprint to be approved!</font><br/><br/>");
                  }
                }
              } else {
                $risul = true;
              }
            }
          }
          #server arxiv down o server interno non connesso ad internet
          if (!$sock = @fsockopen('www.arxiv.org', 80, $num, $error, 5)) {
            echo 'INTERNAL SERVER OFFLINE OR ARVIX IS DOWN IN THIS MOMENT!<br/><br/>';
          }
          //controllo se ci sono sessioni attive
          if (sessioneavviata() == True) {
            echo "WARNING ONE DOWNLOAD/UPDATE SESSION IS RUNNING AT THIS TIME! THE SECTIONS HAS BEEN BLOCKED!";
          } else {
            #controllo se ci sono state interruzioni
            if (controllainterruzione() == True) {
              echo '<script type="text/javascript">setTimeout(function(){alert("The last update was not stopped properly, was performed a new update!")}, 500);</script>';
              if ($sock = @fsockopen('www.arxiv.org', 80, $num, $error, 5)) {
                if (sessioneavviata() == False) {
                  #avvio della sessione
                  avviasessione();
                  #inizializzo variabile j per contare elementi scaricati...
                  $j = 0;
                  #data ultimo lancio...
                  $data = dataprec();
                  #leggo nomi da file nomi.txt
                  $array = legginomi();
                  #conto lunghezza dell'array $array
                  $nl = count($array);
                  if ($nl == 0) {
                    chiudisessione();
                    echo '<script type="text/javascript">setTimeout(function(){alert("No author inside list!")}, 500);</script>';
                  } else {
                    #inizializzo variabile per contare preprints scaricati...
                    for ($i = 0; $i < $nl; $i++) {
                      $nomi = $array[$i];
                      #rimozione spazi all'inizio e alla fine della stringa nomi
                      $nomi = trim($nomi);
                      #uso la funzione arxiv call per contare i download
                      $j = $j + arxiv_call($nomi, $data, false);
                    }
                    #aggiornamento dei nomi nel file nomi_ultimo_lancio...
                    aggiornanomi();
                    #aggiornamento file data_ultimo_lancio.txt con la data di oggi...
                    aggiornadata();
                    #azzeramento file temporaneo...
                    azzerapreprint();
                    #chiudo la sessione di download
                    chiudisessione();
                    echo "<br/>PREPRINTS DOWNLOADED: " . $j . "<br/><br/>";
                    $dc1 = true;
                    //controllo se ci sono preprint da approvare
                    if (check_approve() == true) {
                      print_r(" <font style='color:red; font-style: italic'>There are preprint to be approved!</font><br/><br/>");
                    }
                  }
                } else {
                  $risul = true;
                  #sessione già avviata
                }
              }
            }
            #memorizzo in $data ultimo aggiornamento e la visualizzo
            $data = datastring();
            echo "LAST UPDATE: " . $data;
            #update o download completato correttamente
            if ($dc1) {
              echo '<script type="text/javascript">setTimeout(function(){alert("Update complete!")}, 500);</script>';
            }
            if ($dc2) {
              echo '<script type="text/javascript">setTimeout(function(){alert("Download complete!")}, 500);</script>';
            }
          }
          ?>
        </center>
        <hr style="display: block; height: 1px; border: 0; border-top: 1px solid #ccc; margin: 1em 0; padding: 0;">
        <br/>
      </div>
    </div>
    <br/>
    <br/>
  </div>
  <?php
  require_once './graphics/loader.php';
  require_once './graphics/footer.php';
  ?>
</body>
</html>
