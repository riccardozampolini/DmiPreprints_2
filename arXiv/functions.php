<?php

#funzione per la verifica se ci sono sessioni attive

function sessioneavviata() {
  global $db_connection;
  #importazione variabili globali
  $var = True;
  $a = date("Ymd", time());
  $datas = datasessione();
  $sql = "SELECT attivo FROM sessione";
  $result = mysqli_query($db_connection, $sql) or die(mysqli_error());
  $row = mysqli_fetch_array($result);
  if (($row['attivo'] == 0) or ( $datas < $a - 1)) {
    $var = False;
  }
  return $var;
}

#funzione di avvio della sessione

function avviasessione() {
  global $db_connection;
  $a = date("Ymd", time());
  $sql = "UPDATE sessione SET attivo='1'";
  $result = mysqli_query($db_connection, $sql) or die(mysqli_error());
  $sql = "UPDATE sessione_data SET data='" . $a . "'";
  $result = mysqli_query($db_connection, $sql) or die(mysqli_error());
}

#funzione per terminare la sessione

function chiudisessione() {
  global $db_connection;
  $sql = "UPDATE sessione SET attivo='0'";
  $result = mysqli_query($db_connection, $sql) or die(mysqli_error());
}

#funzione verifica nuovo nome

function nomiprec($nome) {
  global $db_connection;
  #cerca se il nome se era stato gia cercato...
  $nome = trim($nome);
  $sql = "SELECT * FROM AUTORI_BACKUP WHERE nome='" . $nome . "'";
  $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
  $array = mysqli_fetch_row($query);
  if ($array[0] == $nome) {
    return True;
  } else {
    return False;
  }
}

# funzione cancellazione preprint

function cancellaselected($id) {
  global $db_connection;
  $sql = "DELETE FROM PREPRINTS WHERE id_pubblicazione='" . $id . "'";
  $result = mysqli_query($db_connection, $sql) or die(mysqli_error());
}

# funzione cancellazione preprint archiviati

function cancellapreprint() {
  global $db_connection, $basedir4;
  $sql = "SELECT * FROM PREPRINTS_ARCHIVIATI WHERE checked='1'";
  $result = mysqli_query($db_connection, $sql) or die(mysqli_error());
  while ($row = mysqli_fetch_array($result)) {
    unlink($basedir4 . $row['Filename']);
  }
  $sql = "TRUNCATE TABLE PREPRINTS_ARCHIVIATI";
  $result = mysqli_query($db_connection, $sql) or die(mysqli_error());
}

#funzione che controlla se si sono verificate interruzioni nell'ultimo update

function controllainterruzione() {
  global $db_connection;
  $var = False;
  $sql = "SELECT id FROM temp";
  $result = mysqli_query($db_connection, $sql) or die(mysqli_error());
  if ((mysqli_num_rows($result)) != 0) {
    $var = True;
  }
  return $var;
}

#funzione che cerca se il preprint è stato già scaricato nell'esecuzione in corso

function preprintscaricati($id) {
  global $db_connection;
  $var = False;
  $sql = "SELECT id FROM temp";
  $result = mysqli_query($db_connection, $sql) or die(mysqli_error());
  while ($row = mysqli_fetch_array($result)) {
    if ($row['id'] == $id) {
      $var = True;
    }
  }
  return $var;
}

#funzione per l'inserimento dell'id dentro temp

function aggiornapreprintscaricati($id) {
  global $db_connection;
  $sql = "INSERT INTO temp (id) VALUES ('" . $id . "') ON DUPLICATE KEY UPDATE id = VALUES(id)";
  $result = mysqli_query($db_connection, $sql) or die(mysqli_error());
}

#funzione per la cancellazione del contenuto temp

function azzerapreprint() {
  global $db_connection;
  $sql = "TRUNCATE TABLE temp";
  $result = mysqli_query($db_connection, $sql) or die(mysqli_error());
}

#funzione che cerca se il preprint se è presente

function cercapreprint($id) {
  global $db_connection;
  $id = trim($id);
  $sql = "SELECT * FROM PREPRINTS WHERE id_pubblicazione='" . $id . "'";
  $result = mysqli_query($db_connection, $sql) or die(mysqli_error());
  $row = mysqli_fetch_array($result);
  if ($row['nome'] == $nome) {
    $var[0] = $row['id_pubblicazione'];
    $var[1] = ($row['titolo']);
    $var[2] = ($row['data_pubblicazione']);
    $var[3] = ($row['autori']);
    $var[4] = ($row['referenze']);
    $var[5] = ($row['commenti']);
    $var[6] = ($row['categoria']);
    $var[7] = ($row['abstract']);
    $var[8] = ($row['uid']);
    $var[9] = ($row['Filename']);
  }
  return $var;
}

#funzione che cerca se il nome è presente

function cercanome($nome) {
  global $db_connection;
  #cerca se il nome se era stato gia cercato...
  $nome = trim($nome);
  $var = False;
  $sql = "SELECT * FROM AUTORI WHERE nome='" . $nome . "'";
  $result = mysqli_query($db_connection, $sql) or die(mysqli_error());
  $row = mysqli_fetch_array($result);
  if ($row['nome'] == $nome) {
    $var = True;
  }
  return $var;
}

#funzione aggiornamento nomi_ultimo_lancio

function aggiornanomi() {
  global $db_connection;
  #leggo i nuovi nomi e li inserisco in array...
  $array = legginomi();
  $sql = "TRUNCATE TABLE AUTORI_BACKUP";
  $result = mysqli_query($db_connection, $sql) or die(mysqli_error());
  $nl2 = count($array);
  #aggiorno i nomi...
  for ($i = 0; $i < $nl2; $i++) {
    $sql = "INSERT INTO AUTORI_BACKUP (nome) VALUES ('" . $array[$i] . "')";
    $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
  }
}

# funzione lettura nomi

function legginomi() {
  global $db_connection;
  $sql = "SELECT nome FROM AUTORI";
  $result = mysqli_query($db_connection, $sql) or die(mysqli_error());
  $i = 0;
  while ($row = mysqli_fetch_array($result)) {
    $array[$i] = $row['nome'];
    $i++;
  }
  return $array;
}

#funzione scrittura nomi

function scrivinomi($nomi) {
  global $db_connection;
  $sql = "TRUNCATE TABLE AUTORI";
  $result = mysqli_query($db_connection, $sql) or die(mysqli_error());
  $nl2 = count($nomi);
  #aggiorno i nomi...
  for ($i = 0; $i < $nl2; $i++) {
    $sql = "INSERT INTO AUTORI (nome) VALUES ('" . $nomi[$i] . "') ON DUPLICATE KEY UPDATE nome = VALUES(nome)";
    $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
  }
}

#funzione inserimento nuovo utente

function aggiungiutente($nome, $a) {
  #leggo i nuovi nomi e li inserisco in array...
  $array = legginomi();
  while (strpos($nome, "  ") !== FALSE) {
    echo '<script type="text/javascript">alert("NAME NOT VALID! DETECTED CONSECUTIVE SPACE INSIDE FIELD NAME!");</script>';
    return;
  }
  $array2 = explode(",", $nome);
  $nl = count($array2);
  $l = count($array);
  for ($i = 0; $i < $nl; $i++) {
    $temp = $array2[$i];
    $temp = trim($temp);
    $temp = ucwords($temp);
    #verifico se il nome è già presente...
    $array[$l] = $temp;
    $l++;
    $ris = cercanome($temp);
    if ($ris == False) {
      if ($a == 1) {
        #aggiorno i nomi se ci sono nomi da aggiungere...
        scrivinomi($array);
        echo '<script type="text/javascript">alert("' . $temp . ' inserted!");</script>';
      } else {
        echo '<script type="text/javascript">alert("' . $temp . ' not found!");</script>';
      }
    } else {
      if ($a == 1) {
        echo '<script type="text/javascript">alert("' . $temp . ' exists!");</script>';
      } else {
        echo '<script type="text/javascript">alert("' . $temp . ' found!");</script>';
      }
    }
  }
}

#data ultima sessione

function datasessione() {
  global $db_connection;
  $sql = "SELECT data FROM sessione_data";
  $result = mysqli_query($db_connection, $sql) or die(mysqli_error());
  $row = mysqli_fetch_array($result);
  $data = $row['data'];
  return $data;
}

#ritorno la data come intero

function dataprec() {
  global $db_connection;
  $sql = "SELECT data FROM DATA_ULTIMO_LANCIO";
  $result = mysqli_query($db_connection, $sql) or die(mysqli_error());
  $row = mysqli_fetch_array($result);
  $data = $row['data'];
  $data = trim($data);
  $data = substr($data, 0, 10);
  $data = str_replace("-", "", $data);
  #conversione della stringa in intero
  $data = intval($data);
  return $data;
}

#ritorno la data come una stringa

function datastring() {
  global $db_connection;
  $sql = "SELECT data FROM DATA_ULTIMO_LANCIO";
  $result = mysqli_query($db_connection, $sql) or die(mysqli_error());
  $row = mysqli_fetch_array($result);
  $data = $row['data'];
  return $data;
}

#aggiorno data_ultimo_lancio con la data di ultimo lancio

function aggiornadata() {
  global $db_connection;
  $a = date("Y-m-d H:i", time());
  $sql = "SELECT data FROM DATA_ULTIMO_LANCIO";
  $result = mysqli_query($db_connection, $sql) or die(mysqli_error());
  $row = mysqli_fetch_array($result);
  $sql = "DELETE FROM DATA_ULTIMO_LANCIO WHERE data='" . $row['data'] . "'";
  $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
  #aggiorno la data...
  $sql = "INSERT INTO DATA_ULTIMO_LANCIO (data) VALUES ('" . $a . "') ON DUPLICATE KEY UPDATE data = VALUES(data)";
  $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
}

?>
