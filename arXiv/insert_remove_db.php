<?php

#funzione che inserisce i preprints all'interno del database

function insert_preprints($array) {
  global $db_connection;
  #adattamento stringhe pericolose per la query...
  $array[1] = addslashes($array[1]);
  $array[2] = addslashes($array[2]);
  $array[3] = addslashes($array[3]);
  $array[4] = addslashes($array[4]);
  $array[5] = addslashes($array[5]);
  $array[6] = addslashes($array[6]);
  $array[7] = addslashes($array[7]);
  $sql = "INSERT INTO PREPRINTS ( id_pubblicazione, titolo, data_pubblicazione, autori, referenze, commenti, categoria, abstract) "
  . "VALUES ('" . $array[0] . "','" . $array[1] . "','" . $array[2] . "','" . $array[3] . "','" . $array[4] . "','" . $array[5] . "','" . $array[6] . "','" . $array[7] . "') ON DUPLICATE KEY UPDATE id_pubblicazione = VALUES(id_pubblicazione)";
  $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
}

#funzione che aggiorna i preprints all'interno del database

function update_preprints($array) {
  global $db_connection;
  #adattamento stringhe pericolose per la query...
  $array[1] = addslashes($array[1]);
  $array[2] = addslashes($array[2]);
  $array[3] = addslashes($array[3]);
  $array[4] = addslashes($array[4]);
  $array[5] = addslashes($array[5]);
  $array[6] = addslashes($array[6]);
  $array[7] = addslashes($array[7]);
  //query
  $sql = "UPDATE PREPRINTS SET titolo= '" . $array[1] . "', data_pubblicazione='" . $array[2] . "', autori='" . $array[3] . "', referenze='" . $array[4] . "', commenti='" . $array[5] . "', categoria='" . $array[6] . "', abstract='" . $array[7] . "' WHERE id_pubblicazione='" . $array[0] . "'";
  $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
}

#funzione che cancella il pdf caricato all'interno della cartella

function delete_pdf($id) {
  global $db_connection, $copia;
  $sql = "SELECT * FROM PREPRINTS WHERE id_pubblicazione='" . $id . "'";
  $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
  $row = mysqli_fetch_array($query);
  unlink($copia . $row['Filename']);
}

#funzione che inserisce il pdf selezionato all'interno dei database

function insert_one_pdf2($id) {
  global $db_connection, $basedir3, $copia;
  $type = "pdf/document";
  $id = str_replace("-", "/", $id);
  $sql2 = "SELECT * FROM PREPRINTS WHERE id_pubblicazione='" . $id . "'";
  $query2 = mysqli_query($db_connection, $sql2) or die(mysqli_error());
  $row = mysqli_fetch_array($query2);
  if ($handle = opendir($basedir3)) {
    $i = 0;
    while ((false !== ($file = readdir($handle)))) {
      if ($file != '.' && $file != '..' && $file != 'index.php') {
        $idd = substr($file, 0, -4);
        $idd = str_replace("-", "/", $idd);
        if ($row['id_pubblicazione'] == $idd) {
          $sql = "UPDATE PREPRINTS SET Filename='" . $file . "', checked='1' WHERE id_pubblicazione='" . $id . "'";
          $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
          $i++;
          copy($basedir3 . $file, $copia . $file);
          unlink($basedir3 . $file);
        }
      }
    }
    #chiusura della directory...
    closedir($handle);
  }
}

#funzione che inserisce il pdf caricato all'interno dei database

function insert_one_pdf($id, $type) {
  global $db_connection, $copia, $basedir2;
  $sql2 = "SELECT * FROM PREPRINTS WHERE id_pubblicazione='" . $id . "'";
  $query2 = mysqli_query($db_connection, $sql2) or die(mysqli_error());
  $row = mysqli_fetch_array($query2);
  unlink($copia . $row['Filename']);
  if ($handle = opendir($basedir2)) {
    $i = 0;
    while ((false !== ($file = readdir($handle)))) {
      if ($file != '.' && $file != '..' && $file != 'index.php') {
        $sql = "UPDATE PREPRINTS SET Filename='" . $file . "', checked='1' WHERE id_pubblicazione='" . $id . "'";
        $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
        $i++;
        copy($basedir2 . $file, $copia . $file);
        unlink($basedir2 . $file);
      }
    }
    #chiusura della directory...
    closedir($handle);
  }
}

#funzione che rimuove i preprints dall'database

function remove_preprints($id) {
  global $db_connection;
  $id = str_replace("-", "/", $id);
  $lunghezza = strlen($id);
  $id = substr($id, 0, $lunghezza - 4);
  $sql = "DELETE FROM PREPRINTS WHERE id_pubblicazione='" . $id . "'";
  $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
}

#funzione che controlla la versione del preprint e lo archivia eventualmente

function version_preprint($id1) {
  global $db_connection, $copia, $basedir4;
  #elaborazione dell'id...
  $lunghezza = strlen($id1);
  $id = substr($id1, 0, $lunghezza - 1);
  $i1 = substr($id1, $lunghezza - 1, $lunghezza);
  $index = substr($id1, - 1);
  $index = intval($index);
  #verifica se esistono preprints precedenti e li sposto...
  for ($i = 0; $i <= $index; $i++) {
    $sql = "SELECT * FROM PREPRINTS WHERE id_pubblicazione='" . $id . $i . "'";
    $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
    $array = mysqli_fetch_row($query);
    if ($i1 > $i && $array > 0) {
      #archiviazione preprints precedenti...
      $sql2 = "INSERT INTO PREPRINTS_ARCHIVIATI SELECT * FROM PREPRINTS WHERE id_pubblicazione='" . $id . $i . "' ON DUPLICATE KEY UPDATE id_pubblicazione = VALUES(id_pubblicazione)";
      #controllo se la copia è avvenuta, in caso positivo la cancello...
      if (!$query2 = $query = mysqli_query($db_connection, $sql2)) {
        die(mysql_error());
      } else {
        $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
        $row = mysqli_fetch_array($query);
        copy($copia . $row['Filename'], $basedir4 . $row['Filename']);
        unlink($copia . $row['Filename']);
        #rimozione da preprints...
        $sql2 = "DELETE FROM PREPRINTS WHERE id_pubblicazione='" . $id . $i . "'";
        $query2 = mysqli_query($db_connection, $sql2) or die(mysqli_error());
      }
    }
  }
}

?>
