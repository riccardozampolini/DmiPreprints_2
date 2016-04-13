<?php

//libreria Pear Mail
require_once "Mail.php";
require_once "Mail/mime.php";

#funzione controllo se preprint esistente

function check_downloaded($id) {
  global $db_connection;
  $id = trim($id);
  #verifica se esistono preprints precedenti e li sposto...
  $sql = "SELECT COUNT(*) AS TOTALFOUND FROM PREPRINTS WHERE id_pubblicazione='".$id."'";
  $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
  $row = mysqli_fetch_array($query);
  if ($row['TOTALFOUND'] > 0) {
    return true;
  } else {
    return false;
  }
}

#funzione inserimento nuovo utente

function aggiungiutenteAdmin($nome, $a) {
  #leggo i nuovi nomi e li inserisco in array...
  $array = legginomiAdmin();
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
    #verifico se il nome è già presente...
    $array[$l] = $temp;
    $l++;
    $ris = cercanomeAdmin($temp);
    if ($ris == False) {
      if ($a == 1) {
        #aggiorno i nomi se ci sono nomi da aggiungere...
        scrivinomiAdmin($array);
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

#funzione che cerca se il nome è presente

function cercanomeAdmin($nome) {
  global $db_connection;
  #cerca se il nome se era stato gia cercato...
  $nome = trim($nome);
  $var = False;
  $sql = "SELECT * FROM ADMINISTRATORS WHERE uid='" . $nome . "'";
  $result = mysqli_query($db_connection, $sql) or die(mysqli_error());
  $row = mysqli_fetch_array($result);
  if ($row['uid'] == $nome) {
    $var = True;
  }
  return $var;
}

# funzione lettura nomi admins

function legginomiAdmin() {
  global $db_connection;
  $sql = "SELECT uid FROM ADMINISTRATORS";
  $result = mysqli_query($db_connection, $sql) or die(mysqli_error());
  $i = 0;
  while ($row = mysqli_fetch_array($result)) {
    $array[$i] = $row['uid'];
    $i++;
  }
  return $array;
}

#funzione scrittura nomi admins

function scrivinomiAdmin($nomi) {
  global $db_connection;
  $sql = "TRUNCATE TABLE ADMINISTRATORS";
  $result = mysqli_query($db_connection, $sql) or die(mysqli_error());
  $nl2 = count($nomi);
  #aggiorno i nomi...
  for ($i = 0; $i < $nl2; $i++) {
    $sql = "INSERT INTO ADMINISTRATORS (uid) VALUES ('" . $nomi[$i] . "') ON DUPLICATE KEY UPDATE uid = VALUES(uid)";
    $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
  }
}

#funzione inserimento informazioni preprint

function insert_pubb($array, $uid) {
  global $db_connection;
  #adattamento stringhe pericolose per la query...
  $array[1] = addslashes($array[1]);
  $array[2] = addslashes($array[2]);
  $array[3] = addslashes($array[3]);
  $array[4] = addslashes($array[4]);
  $array[5] = addslashes($array[5]);
  $array[6] = addslashes($array[6]);
  $array[7] = addslashes($array[7]);
  #generazione chiave
  $generato = rand();
  while (mysqli_num_rows(mysqli_query($db_connection, "SELECT * FROM PREPRINTS WHERE id_pubblicazione='" . $generato . "v1'") or die(mysqli_error())) != 0) {
    $generato = rand();
  }
  $generato = $generato . "v1";
  $sql = "INSERT INTO PREPRINTS ( uid, id_pubblicazione, titolo, data_pubblicazione, autori, referenze, commenti, categoria, abstract) "
  . "VALUES ('" . $uid . "','" . $generato . "','" . $array[1] . "','" . date("c", time()) . "','" . $array[3] . "','" . $array[4] . "','" . $array[5] . "','" . $array[6] . "','" . $array[7] . "') ON DUPLICATE KEY UPDATE id_pubblicazione = VALUES(id_pubblicazione)";
  $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
  #chiusura connessione al database
  return $generato;
}

#funzione inserimento informazioni preprint

function insert_p($array, $uid) {
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
  $sql = "INSERT INTO PREPRINTS ( uid, id_pubblicazione, titolo, data_pubblicazione, autori, referenze, commenti, categoria, abstract) "
  . "VALUES ('" . $uid . "','" . $array[0] . "','" . $array[1] . "','" . date("c", time()) . "','" . $array[3] . "','" . $array[4] . "','" . $array[5] . "','" . $array[6] . "','" . $array[7] . "') ON DUPLICATE KEY UPDATE id_pubblicazione = VALUES(id_pubblicazione)";
  $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
}

#funzione che inserisce il pdf caricato all'interno dei database

function insertopdf($id) {
  global $db_connection, $copia, $basedir;
  $id = str_replace("-", "/", $id);
  //query
  $sql2 = "SELECT * FROM PREPRINTS WHERE id_pubblicazione='" . $id . "'";
  $query2 = mysqli_query($db_connection, $sql2) or die(mysqli_error());
  $row = mysqli_fetch_array($query2);
  if ($handle = opendir($basedir)) {
    $i = 0;
    while ((false !== ($file = readdir($handle)))) {
      if ($file != '.' && $file != '..' && $file != 'index.php') {
        $idd = substr($file, 0, -4);
        if ($row['id_pubblicazione'] == $idd) {
          $sql = "UPDATE PREPRINTS SET Filename='" . $file . "', checked='1' WHERE id_pubblicazione='" . $id . "'";
          $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
          $i++;
          copy($basedir . $file, $copia . $file);
          unlink($basedir . $file);
        }
      }
    }
    #chiusura della directory...
    closedir($handle);
  }
}

#funzione che inserisce un pdf all'interno dei database

function insertpdf($id, $type) {
  global $db_connection, $copia, $basedir;
  //query
  $sql2 = "SELECT * FROM PREPRINTS WHERE id_pubblicazione='" . $id . "'";
  $query2 = mysqli_query($db_connection, $sql2) or die(mysqli_error());
  $row = mysqli_fetch_array($query2);
  unlink($copia . $row['Filename']);
  if ($handle = opendir($basedir)) {
    $i = 0;
    while ((false !== ($file = readdir($handle)))) {
      if ($file != '.' && $file != '..' && $file != 'index.php') {
        $sql = "UPDATE PREPRINTS SET Filename= '" . $file . "', checked='1' WHERE id_pubblicazione='" . $id . "'";
        $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
        fclose($var);
        $i++;
        copy($basedir . $file, $copia . $file);
        unlink($basedir . $file);
      }
    }
    #chiusura della directory...
    closedir($handle);
  }
}

#funzione che visualizza lista upload

function leggiupload($uid) {
  global $db_connection, $copia;
  if (!isset($_GET['p'])) {
    $p = 1;
  } else {
    $p = $_GET['p'];
  }
  $risperpag = 5;
  $limit = $risperpag * $p - $risperpag;
  $sql = "SELECT * FROM PREPRINTS WHERE uid='" . $uid . "' AND checked='1'";
  $querytotale = mysqli_query($db_connection, $sql) or die(mysqli_error());
  $ristot = mysqli_num_rows($querytotale);
  if ($ristot == 0) {
    echo "<br/>No preprints uploaded.";
  }
  $npag = ceil($ristot / $risperpag);
  #impostazione della navigazione per pagine
  if ($ristot != 0) {
    if ($p != 1) {
      $t1 = $p - 1;
      $t2 = $p - 2;
      $t3 = $p - 3;
      echo '<a style="color:#1976D2; text-decoration: none;" title="First page" href="uploaded.php?p=1&r=' . $uid . '"> &#8656 </a>';
      if ($p >= 3 && $t3 > 0) {
        echo '<a style="color:#1976D2; text-decoration: none;" href="uploaded.php?p=' . ($p - 3) . '&r=' . $uid . '"> ' . " " . $t3 . " " . ' </a>';
      }
      if ($p >= 2 && $t2 > 0) {
        echo '<a style="color:#1976D2; text-decoration: none;" href="uploaded.php?p=' . ($p - 2) . '&r=' . $uid . '"> ' . " " . $t2 . " " . ' </a>';
      }
      echo '<a style="color:#1976D2; text-decoration: none;" href="uploaded.php?p=' . ($p - 1) . '&r=' . $uid . '"> ' . " " . $t1 . " " . ' </a>';
    }
    echo " " . $p . " ";
    if ($p != $npag) {
      $t4 = $p + 1;
      $t5 = $p + 2;
      $t6 = $p + 3;
      echo '<a style="color:#1976D2; text-decoration: none;" href="uploaded.php?p=' . ($p + 1) . '&r=' . $uid . '"> ' . " " . $t4 . " " . ' </a>';
      if ($p < $npag && $t5 <= $npag) {
        echo '<a style="color:#1976D2; text-decoration: none;" href="uploaded.php?p=' . ($p + 2) . '&r=' . $uid . '"> ' . " " . $t5 . " " . ' </a>';
      }
      if ($p < $npag && $t6 <= $npag) {
        echo '<a style="color:#1976D2; text-decoration: none;" href="uploaded.php?p=' . ($p + 3) . '&r=' . $uid . '"> ' . " " . $t6 . " " . ' </a>';
      }
      echo '<a style="color:#1976D2; text-decoration: none;" title="Last page" href="uploaded.php?p=' . $npag . '&r=' . $uid . '"> &#8658 </a>';
    }
  }
  $sql = "SELECT * FROM PREPRINTS WHERE uid='" . $uid . "' AND checked='1' ORDER BY data_pubblicazione DESC LIMIT " . $limit . "," . $risperpag . "";
  $result = mysqli_query($db_connection, $sql) or die(mysqli_error());
  $i = $limit;
  #recupero e visualizzazione dei campi della ricerca effettuata
  while ($row = mysqli_fetch_array($result)) {
    echo '<div class="boxContainerIndex" align="center">'
    . "<div id='TopBox" . $index . "' style='cursor: pointer;'>";
    echo "<div class='titolo'>" . ($row['titolo']) . "</div>";
    echo "<div>" . ($row['data_pubblicazione']) . "</div>";
    echo "<div>" . ($row['autori']) . "</div></div>";
    echo "<div id='BottomBox" . $index . "' hidden><br/>"
    . "<div>" . ($row['categoria']) . "</div><br/>"
    . "<div>" . ($row['commenti']) . "</div><br/>"
    . "<div style='text-align: left; width: 75%;'>" . ($row['abstract']) . "</div><br/>"
    . "<div>" . ($row['referenze']) . "</div>"
    . "<br/><div class='boxID'>ID: " . ($row['id_pubblicazione']) . "</div>";
    if ($_SESSION['uid'] === $row['uid'] && $row['uid'] != "") {
      echo "<div><a target=\"blank\" href='./edit.php?id=" . $row['id_pubblicazione'] . "&r=" . $row['uid'] . "' title='Edit'><img class='ImageOpt' src='./images/ic_image_edit.png'></a></div>";
    }
    echo "<div><a href='" . $copia . $row['Filename'] . "' target=\"_blank\" title='" . $row['id_pubblicazione'] . "'>"
    . "<img class='ImageOpt' src='./images/ic_editor_insert_drive_file.png'></a></div><div style='clear:both;'></div>";
    echo "</div></div><script>"
    . "$(TopBox" . $index . ").click(function(){
      $(BottomBox" . $index . ").toggle(400);
    });"
    . "</script>";
    $index++;
  }
  #visualizzazione della navigazione per pagine
  if ($ristot != 0) {
    if ($p != 1) {
      echo '<a style="color:#1976D2; text-decoration: none;" title="First page" href="uploaded.php?p=1&r=' . $uid . '"> &#8656 </a>';
      if ($p >= 3 && $t3 > 0) {
        echo '<a style="color:#1976D2; text-decoration: none;" href="uploaded.php?p=' . ($p - 3) . '&r=' . $uid . '"> ' . " " . $t3 . " " . ' </a>';
      }
      if ($p >= 2 && $t2 > 0) {
        echo '<a style="color:#1976D2; text-decoration: none;" href="uploaded.php?p=' . ($p - 2) . '&r=' . $uid . '"> ' . " " . $t2 . " " . ' </a>';
      }
      echo '<a style="color:#1976D2; text-decoration: none;" href="uploaded.php?p=' . ($p - 1) . '&r=' . $uid . '"> ' . " " . $t1 . " " . ' </a>';
    }
    echo " " . $p . " ";
    if ($p != $npag) {
      echo '<a style="color:#1976D2; text-decoration: none;" href="uploaded.php?p=' . ($p + 1) . '&r=' . $uid . '"> ' . " " . $t4 . " " . ' </a>';
      if ($p < $npag && $t5 <= $npag) {
        echo '<a style="color:#1976D2; text-decoration: none;" href="uploaded.php?p=' . ($p + 2) . '&r=' . $uid . '"> ' . " " . $t5 . " " . ' </a>';
      }
      if ($p < $npag && $t6 <= $npag) {
        echo '<a style="color:#1976D2; text-decoration: none;" href="uploaded.php?p=' . ($p + 3) . '&r=' . $uid . '"> ' . " " . $t6 . " " . ' </a>';
      }
      echo '<a style="color:#1976D2; text-decoration: none;" title="Last page" href="uploaded.php?p=' . $npag . '&r=' . $uid . '"> &#8658 </a>';
    }
  }
  $x = $limit + 1;
}

#funzione che controlla la versione del preprint e lo archivia eventualmente

function version_preprintd($id1) {
  global $db_connection, $copia, $basedir4;
  #elaborazione dell'id...
  $lunghezza = strlen($id1);
  $id = substr($id1, 0, $lunghezza - 1);
  #verifica se esistono preprints precedenti e li sposto...
  for ($i = 0; $i <= 20; $i++) {
    $sql = "SELECT * FROM PREPRINTS WHERE id_pubblicazione='" . $id . $i . "'";
    $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
    $row = mysqli_fetch_row($query);
    if (strcmp($id1, $row['1']) > 0) {
      #archiviazione preprints precedenti...
      $sql2 = "INSERT INTO PREPRINTS_ARCHIVIATI SELECT * FROM PREPRINTS WHERE id_pubblicazione='" . $id . $i . "' ON DUPLICATE KEY UPDATE id_pubblicazione = VALUES(id_pubblicazione)";
      $query2 = mysqli_query($db_connection, $sql2) or die(mysqli_error());
      copy($copia . $row[9], $basedir4 . $row[9]);
      unlink($copia . $row[9]);
      #rimozione da preprints...
      $sql2 = "DELETE FROM PREPRINTS WHERE id_pubblicazione='" . $id . $i . "'";
      $query2 = mysqli_query($db_connection, $sql2) or die(mysqli_error());
    }
  }
}

#funzione controllo se ci sono preprint da approvare

function check_approve() {
  global $db_connection;
  #verifica se esistono preprints precedenti e li sposto...
  $sql = "SELECT COUNT(*) AS TOTALFOUND FROM PREPRINTS WHERE checked='0'";
  $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
  $row = mysqli_fetch_array($query);
  if ($row['TOTALFOUND'] > 0) {
    return true;
  } else {
    return false;
  }
}

#funzione recupero informazioni degli account

function find_accounts($ord) {
  global $db_connection;
  #verifica se esistono preprints precedenti e li sposto...
  $sql = "SELECT * FROM ACCOUNTS ORDER BY " . $ord;
  $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
  return $query;
}

#funzione eliminazione informazioni account

function remove_accounts($accounts) {
  global $db_connection;
  $k = count($accounts);
  for ($i = 0; $i < $k; $i++) {
    $sql = "DELETE FROM ACCOUNTS WHERE email='" . $accounts[$i] . "'";
    $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
  }
}

#funzione recupero informazioni account

function find_account_info($email) {
  global $db_connection;
  #verifica se esistono preprints precedenti e li sposto...
  $sql = "SELECT * FROM ACCOUNTS WHERE email='" . $email . "'";
  $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
  $row = mysqli_fetch_array($query);
  return $row;
}

#funzione ricerca full text

function searchfulltext() {
  global $db_connection, $copia, $basedir4;
  require_once './authorization/sec_sess.php';
  sec_session_start();
  if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] < 86400)) {
    if ($_SESSION['logged_type'] === "mod") {
      $cred = 1;
    } else {
      $cred = 0;
    }
  }
  #risultati visualizzati per pagina
  if (isset($_GET['rp']) && $_GET['rp'] != "") {
    $risperpag = $_GET['rp'];
  } else {
    $risperpag = 5;
  }
  if ($_GET['st'] == "1") {
    $query = "SELECT *, MATCH (id_pubblicazione, titolo, data_pubblicazione, autori, referenze, commenti, categoria, abstract) AGAINST('*" . addslashes($_GET['ft']) . "*' IN BOOLEAN MODE) AS attinenza FROM PREPRINTS WHERE MATCH (id_pubblicazione, titolo, data_pubblicazione, autori, referenze, commenti, categoria, abstract) AGAINST ('*" . addslashes($_GET['ft']) . "*' IN BOOLEAN MODE) ORDER BY attinenza DESC";
    $cat = "on currents";
  } else {
    $query = "SELECT *, MATCH (id_pubblicazione, titolo, data_pubblicazione, autori, referenze, commenti, categoria, abstract) AGAINST('*" . addslashes($_GET['ft']) . "*' IN BOOLEAN MODE) AS attinenza FROM PREPRINTS_ARCHIVIATI WHERE MATCH (id_pubblicazione, titolo, data_pubblicazione, autori, referenze, commenti, categoria, abstract) AGAINST ('*" . addslashes($_GET['ft']) . "*' IN BOOLEAN MODE) ORDER BY attinenza DESC";
    $cat = "on archived";
  }
  #recupero pagina
  if (isset($_GET['p']) && $_GET['p'] != "") {
    $p = $_GET['p'];
  } else {
    $p = 1;
  }
  #limite risultati
  $limit = $risperpag * $p - $risperpag;
  #query di ricerca
  $querytotale = mysqli_query($db_connection, $query) or die(mysqli_error());
  $ristot = mysqli_num_rows($querytotale);
  if ($ristot != 0) {
    echo "Found " . $ristot . " results:<br/><br/>";
  } else {
    echo "Found " . $ristot . " results:<br/><br/>";
    break;
  }
  $npag = ceil($ristot / $risperpag);
  $query = $query . " LIMIT " . $limit . "," . $risperpag . "";
  $result = mysqli_query($db_connection, $query) or die(mysqli_error());
  #impostazione della paginazione dei risultati
  if ($ristot != 0) {
    if ($p != 1) {
      $t1 = $p - 1;
      $t2 = $p - 2;
      $t3 = $p - 3;
      echo '<a style="color:#1976D2; text-decoration: none;" title="First page" href="view_preprints.php?p=1&r=' . $_GET['r'] . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&rp=' . $_GET['rp'] . '&ft=' . urlencode($_GET['ft']) . '&go=' . $_GET['go'] . '&st=' . $_GET['st'] . '"> &#8656 </a>';
      if ($p >= 3 && $t3 > 0) {
        echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p - 3) . '&r=' . $_GET['r'] . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&rp=' . $_GET['rp'] . '&ft=' . urlencode($_GET['ft']) . '&go=' . $_GET['go'] . '&st=' . $_GET['st'] . '"> ' . " " . $t3 . " " . ' </a>';
      }
      if ($p >= 2 && $t2 > 0) {
        echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p - 2) . '&r=' . $_GET['r'] . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&rp=' . $_GET['rp'] . '&ft=' . urlencode($_GET['ft']) . '&go=' . $_GET['go'] . '&st=' . $_GET['st'] . '"> ' . " " . $t2 . " " . ' </a>';
      }
      echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p - 1) . '&r=' . $_GET['r'] . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&rp=' . $_GET['rp'] . '&ft=' . urlencode($_GET['ft']) . '&go=' . $_GET['go'] . '&st=' . $_GET['st'] . '"> ' . " " . $t1 . " " . ' </a>';
    }
    echo " " . $p . " ";
    if ($p != $npag) {
      $t4 = $p + 1;
      $t5 = $p + 2;
      $t6 = $p + 3;
      echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p + 1) . '&r=' . $_GET['r'] . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&rp=' . $_GET['rp'] . '&ft=' . urlencode($_GET['ft']) . '&go=' . $_GET['go'] . '&st=' . $_GET['st'] . '"> ' . " " . $t4 . " " . ' </a>';
      if ($p < $npag && $t5 <= $npag) {
        echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p + 2) . '&r=' . $_GET['r'] . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&rp=' . $_GET['rp'] . '&ft=' . urlencode($_GET['ft']) . '&go=' . $_GET['go'] . '&st=' . $_GET['st'] . '"> ' . " " . $t5 . " " . ' </a>';
      }
      if ($p < $npag && $t6 <= $npag) {
        echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p + 3) . '&r=' . $_GET['r'] . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&rp=' . $_GET['rp'] . '&ft=' . urlencode($_GET['ft']) . '&go=' . $_GET['go'] . '&st=' . $_GET['st'] . '"> ' . " " . $t6 . " " . ' </a>';
      }
      echo '<a style="color:#1976D2; text-decoration: none;" title="Last page" href="view_preprints.php?p=' . $npag . '&r=' . $_GET['r'] . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&rp=' . $_GET['rp'] . '&ft=' . urlencode($_GET['ft']) . '&go=' . $_GET['go'] . '&st=' . $_GET['st'] . '"> &#8658 </a>';
    }
  }
  $i = $limit;
  $index = 0;
  #recupero e visualizzazione dei campi della ricerca effettuata
  while ($row = mysqli_fetch_array($result)) {
    echo '<div class="boxContainer" align="center">'
    . "<div id='TopBox" . $index . "' style='cursor: pointer;'>";
    echo "<div class='titolo'>" . ($row['titolo']) . "</div>";
    echo "<div>" . ($row['data_pubblicazione']) . "</div>";
    echo "<div>" . ($row['autori']) . "</div></div>";
    echo "<div id='BottomBox" . $index . "' hidden><br/>"
    . "<div>" . ($row['categoria']) . "</div><br/>"
    . "<div>" . ($row['commenti']) . "</div><br/>"
    . "<div style='text-align: left; width: 75%;'>" . ($row['abstract']) . "</div><br/>"
    . "<div>" . ($row['referenze']) . "</div>"
    . "<br/><div class='boxID'>ID: " . ($row['id_pubblicazione']) . "</div>";
    if ($_SESSION['logged_type'] === "mod") {
      if (file_exists($copia . $row['Filename'])) {
        echo "<div><a target=\"blank\" href='./manual_edit.php?id=" . $row['id_pubblicazione'] . "' title='Edit'><img class='ImageOpt' src='./images/ic_image_edit.png'></a></div>";
        echo "<div><a href='" . $copia . $row['Filename'] . "' target=\"_blank\" title='" . $row['id_pubblicazione'] . "'>"
        . "<img class='ImageOpt' src='./images/ic_editor_insert_drive_file.png'></a></div><div style='clear:both;'></div>";
      } else {
        echo "<div><a href='" . $basedir4 . $row['Filename'] . "' target=\"_blank\" title='" . $row['id_pubblicazione'] . "'>"
        . "<img class='ImageOpt' src='./images/ic_editor_insert_drive_file.png'></a></div><div style='clear:both;'></div>";
      }
    } else if ($_SESSION['uid'] === $row['uid'] && $row['uid'] != "") {
      if (file_exists($copia . $row['Filename'])) {
        echo "<div><a target=\"blank\" href='./edit.php?id=" . $row['id_pubblicazione'] . "&r=" . $row['uid'] . "' title='Edit'><img class='ImageOpt' src='./images/ic_image_edit.png'></a></div>";
        echo "<div><a href='" . $copia . $row['Filename'] . "' target=\"_blank\" title='" . $row['id_pubblicazione'] . "'>"
        . "<img class='ImageOpt' src='./images/ic_editor_insert_drive_file.png'></a></div><div style='clear:both;'></div>";
      } else {
        echo "<div><a href='" . $basedir4 . $row['Filename'] . "' target=\"_blank\" title='" . $row['id_pubblicazione'] . "'>"
        . "<img class='ImageOpt' src='./images/ic_editor_insert_drive_file.png'></a></div><div style='clear:both;'></div>";
      }
    } else {
      if (file_exists($copia . $row['Filename'])) {
        echo "<div><a href='" . $copia . $row['Filename'] . "' target=\"_blank\" title='" . $row['id_pubblicazione'] . "'>"
        . "<img class='ImageOpt' src='./images/ic_editor_insert_drive_file.png'></a></div><div style='clear:both;'></div>";
      } else {
        echo "<div><a href='" . $basedir4 . $row['Filename'] . "' target=\"_blank\" title='" . $row['id_pubblicazione'] . "'>"
        . "<img class='ImageOpt' src='./images/ic_editor_insert_drive_file.png'></a></div><div style='clear:both;'></div>";
      }
    }
    echo "</div></div><script>"
    . "$(TopBox" . $index . ").click(function(){
      $(BottomBox" . $index . ").toggle(400);
    });"
    . "</script>";
    $index++;
  }
  #impostazioni della navigazione per pagine
  if ($ristot != 0) {
    if ($p != 1) {
      $t1 = $p - 1;
      $t2 = $p - 2;
      $t3 = $p - 3;
      echo '<a style="color:#1976D2; text-decoration: none;" title="First page" href="view_preprints.php?p=1&r=' . $_GET['r'] . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&rp=' . $_GET['rp'] . '&ft=' . urlencode($_GET['ft']) . '&go=' . $_GET['go'] . '&st=' . $_GET['st'] . '"> &#8656 </a>';
      if ($p >= 3 && $t3 > 0) {
        echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p - 3) . '&r=' . $_GET['r'] . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&rp=' . $_GET['rp'] . '&ft=' . urlencode($_GET['ft']) . '&go=' . $_GET['go'] . '&st=' . $_GET['st'] . '"> ' . " " . $t3 . " " . ' </a>';
      }
      if ($p >= 2 && $t2 > 0) {
        echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p - 2) . '&r=' . $_GET['r'] . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&rp=' . $_GET['rp'] . '&ft=' . urlencode($_GET['ft']) . '&go=' . $_GET['go'] . '&st=' . $_GET['st'] . '"> ' . " " . $t2 . " " . ' </a>';
      }
      echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p - 1) . '&r=' . $_GET['r'] . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&rp=' . $_GET['rp'] . '&ft=' . urlencode($_GET['ft']) . '&go=' . $_GET['go'] . '&st=' . $_GET['st'] . '"> ' . " " . $t1 . " " . ' </a>';
    }
    echo " " . $p . " ";
    if ($p != $npag) {
      $t4 = $p + 1;
      $t5 = $p + 2;
      $t6 = $p + 3;
      echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p + 1) . '&r=' . $_GET['r'] . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&rp=' . $_GET['rp'] . '&ft=' . urlencode($_GET['ft']) . '&go=' . $_GET['go'] . '&st=' . $_GET['st'] . '"> ' . " " . $t4 . " " . ' </a>';
      if ($p < $npag && $t5 <= $npag) {
        echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p + 2) . '&r=' . $_GET['r'] . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&rp=' . $_GET['rp'] . '&ft=' . urlencode($_GET['ft']) . '&go=' . $_GET['go'] . '&st=' . $_GET['st'] . '"> ' . " " . $t5 . " " . ' </a>';
      }
      if ($p < $npag && $t6 <= $npag) {
        echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p + 3) . '&r=' . $_GET['r'] . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&rp=' . $_GET['rp'] . '&ft=' . urlencode($_GET['ft']) . '&go=' . $_GET['go'] . '&st=' . $_GET['st'] . '"> ' . " " . $t6 . " " . ' </a>';
      }
      echo '<a style="color:#1976D2; text-decoration: none;" title="Last page" href="view_preprints.php?p=' . $npag . '&r=' . $_GET['r'] . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&rp=' . $_GET['rp'] . '&ft=' . urlencode($_GET['ft']) . '&go=' . $_GET['go'] . '&st=' . $_GET['st'] . '"> &#8658 </a>';
    }
  }
  $x = $limit + 1;
}

# funzione lettura dei preprint

function searchpreprint() {
  global $db_connection, $copia, $basedir4;
  require_once './authorization/sec_sess.php';
  sec_session_start();
  if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] < 86400)) {
    if ($_SESSION['logged_type'] === "mod") {
      $cred = 1;
    } else {
      $cred = 0;
    }
  }
  #verifica ordine risultati
  if ($_GET['o'] == "dated") {
    $order = "data_pubblicazione DESC";
    $orstr = "decreasing date";
  } else if ($_GET['o'] == "datec") {
    $order = "data_pubblicazione ASC";
    $orstr = "increasing date";
  } else if ($_GET['o'] == "named") {
    $order = "autori DESC";
    $orstr = "decreasing name";
  } else if ($_GET['o'] == "namec") {
    $order = "autori ASC";
    $orstr = "increasing name";
  } else if ($_GET['o'] == "idd") {
    $order = "id_pubblicazione DESC";
    $orstr = "decreasing ID";
  } else {
    $order = "id_pubblicazione ASC";
    $orstr = "increasing ID";
  }
  # controllo ricerca per anno
  if (isset($_GET['year1']) && is_numeric($_GET['year1'])) {
    if ($_GET['d'] != "1") {
      $query = " SELECT * FROM PREPRINTS WHERE autori LIKE '%" . addslashes($_GET['r']) . "%' AND data_pubblicazione <= '" . addslashes($_GET['year1'] + 1) . "' AND checked='1' UNION ";
      $cat3 = "until year " . $_GET['year1'] . ", ";
    } else {
      $query = " SELECT * FROM PREPRINTS WHERE autori LIKE '%" . addslashes($_GET['r']) . "%' AND data_pubblicazione <= '" . addslashes($_GET['year1'] + 1) . "' AND checked='1' UNION
      SELECT * FROM PREPRINTS_ARCHIVIATI WHERE autori LIKE '%" . addslashes($_GET['r']) . "%' AND data_pubblicazione <= '" . addslashes($_GET['year1'] + 1) . "' AND checked='1' UNION ";
      $cat3 = "until year " . $_GET['year1'] . " with archived, ";
    }
  } else if (isset($_GET['year2']) && is_numeric($_GET['year2']) && isset($_GET['year3']) && is_numeric($_GET['year3'])) {
    if ($_GET['d'] != "1") {
      $query = " SELECT * FROM PREPRINTS WHERE autori LIKE '%" . addslashes($_GET['r']) . "%' AND data_pubblicazione BETWEEN '" . addslashes($_GET['year2']) . "' AND '" . addslashes($_GET['year3'] + 1) . "' AND checked='1' UNION ";
      $cat3 = "on range from " . $_GET['year2'] . " to " . $_GET['year3'] . ", ";
    } else {
      $query = " SELECT * FROM PREPRINTS WHERE autori LIKE '%" . addslashes($_GET['r']) . "%' AND data_pubblicazione BETWEEN '" . addslashes($_GET['year2']) . "' AND  '" . addslashes($_GET['year3'] + 1) . "' AND checked='1' UNION SELECT * FROM PREPRINTS_ARCHIVIATI WHERE autori LIKE '%" . addslashes($_GET['r']) . "%' AND data_pubblicazione BETWEEN '" . addslashes($_GET['year2']) . "' AND '" . addslashes($_GET['year3'] + 1) . "' AND checked='1' UNION ";
      $cat3 = "on range from " . $_GET['year2'] . " to " . $_GET['year3'] . " with archived, ";
    }
  } else {
    $cat = 0;
    #verifica parametri ricerca
    if ($_GET['e'] != 1 && $_GET['i'] != 1 && $_GET['t'] != 1 && $_GET['a'] != 1 && $_GET['c'] != 1 && $_GET['j'] != 1 && $_GET['h'] != 1 && $_GET['y'] != 1 && $_GET['all'] != 1 && $_GET['d'] == 1) {
      $query = "
      SELECT * FROM PREPRINTS_ARCHIVIATI WHERE id_pubblicazione LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
      SELECT * FROM PREPRINTS_ARCHIVIATI WHERE titolo LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
      SELECT * FROM PREPRINTS_ARCHIVIATI WHERE data_pubblicazione LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
      SELECT * FROM PREPRINTS_ARCHIVIATI WHERE autori LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
      SELECT * FROM PREPRINTS_ARCHIVIATI WHERE referenze LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
      SELECT * FROM PREPRINTS_ARCHIVIATI WHERE commenti LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
      SELECT * FROM PREPRINTS_ARCHIVIATI WHERE categoria LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
      SELECT * FROM PREPRINTS_ARCHIVIATI WHERE abstract LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION ";
      $cat = "ALL";
    }
    if ($_GET['all'] != "1") {
      if ($_GET['d'] != "1") {
        if ($_GET['h'] == "1") {
          $query = $query . "SELECT * FROM PREPRINTS WHERE autori LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION ";
          $cat++;
          $cat3 = $cat3 . "authors, ";
        }
        if ($_GET['t'] == "1") {
          $query = $query . "SELECT * FROM PREPRINTS WHERE titolo LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION ";
          $cat++;
          $cat3 = $cat3 . "title, ";
        }
        if ($_GET['a'] == "1") {
          $query = $query . "SELECT * FROM PREPRINTS WHERE abstract LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION ";
          $cat++;
          $cat3 = $cat3 . "abstract, ";
        }
        if ($_GET['y'] == "1") {
          $query = $query . "SELECT * FROM PREPRINTS WHERE categoria LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION ";
          $cat++;
          $cat3 = $cat3 . "category, ";
        }
        if ($_GET['c'] == "1") {
          $query = $query . "SELECT * FROM PREPRINTS WHERE commenti LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION ";
          $cat++;
          $cat3 = $cat3 . "comments, ";
        }
        if ($_GET['j'] == "1") {
          $query = $query . "SELECT * FROM PREPRINTS WHERE referenze LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION ";
          $cat++;
          $cat3 = $cat3 . "journal-ref, ";
        }
        if ($_GET['e'] == "1") {
          $query = $query . "SELECT * FROM PREPRINTS WHERE data_pubblicazione LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION ";
          $cat++;
          $cat3 = $cat3 . "year, ";
        }
        if ($_GET['i'] == "1") {
          $query = $query . "SELECT * FROM PREPRINTS WHERE id_pubblicazione LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION ";
          $cat++;
          $cat3 = $cat3 . "ID, ";
        }
      } else {
        if ($_GET['h'] == "1") {
          $query = $query . "SELECT * FROM PREPRINTS WHERE autori LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
          SELECT * FROM PREPRINTS_ARCHIVIATI WHERE autori LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION ";
          $cat++;
          $cat3 = $cat3 . "authors, ";
        }
        if ($_GET['t'] == "1") {
          $query = $query . "SELECT * FROM PREPRINTS WHERE titolo LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
          SELECT * FROM PREPRINTS_ARCHIVIATI WHERE titolo LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION ";
          $cat++;
          $cat3 = $cat3 . "title, ";
        }
        if ($_GET['a'] == "1") {
          $query = $query . "SELECT * FROM PREPRINTS WHERE abstract LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION SELECT * FROM PREPRINTS_ARCHIVIATI WHERE abstract LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION ";
          $cat++;
          $cat3 = $cat3 . "abstract, ";
        }
        if ($_GET['y'] == "1") {
          $query = $query . "SELECT * FROM PREPRINTS WHERE categoria LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION SELECT * FROM PREPRINTS_ARCHIVIATI WHERE categoria LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION ";
          $cat++;
          $cat3 = $cat3 . "category, ";
        }
        if ($_GET['c'] == "1") {
          $query = $query . "SELECT * FROM PREPRINTS WHERE commenti LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION SELECT * FROM PREPRINTS_ARCHIVIATI WHERE commenti LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION ";
          $cat++;
          $cat3 = $cat3 . "comments, ";
        }
        if ($_GET['j'] == "1") {
          $query = $query . "SELECT * FROM PREPRINTS WHERE referenze LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION SELECT * FROM PREPRINTS_ARCHIVIATI WHERE referenze LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION ";
          $cat++;
          $cat3 = $cat3 . "journal-ref, ";
        }
        if ($_GET['e'] == "1") {
          $query = $query . "SELECT * FROM PREPRINTS WHERE data_pubblicazione LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION SELECT * FROM PREPRINTS_ARCHIVIATI WHERE data_pubblicazione LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION ";
          $cat++;
          $cat3 = $cat3 . "year, ";
        }
        if ($_GET['i'] == "1") {
          $query = $query . "SELECT * FROM PREPRINTS WHERE id_pubblicazione LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION SELECT * FROM PREPRINTS_ARCHIVIATI WHERE data_pubblicazione LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION ";
          $cat++;
          $cat3 = $cat3 . "ID, ";
        }
        $cat3 = $cat3 . "included archived, ";
      }
    } else {
      if ($_GET['d'] != "1") {
        $query = "
        SELECT * FROM PREPRINTS WHERE id_pubblicazione LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
        SELECT * FROM PREPRINTS WHERE titolo LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
        SELECT * FROM PREPRINTS WHERE data_pubblicazione LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
        SELECT * FROM PREPRINTS WHERE autori LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
        SELECT * FROM PREPRINTS WHERE referenze LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
        SELECT * FROM PREPRINTS WHERE commenti LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
        SELECT * FROM PREPRINTS WHERE categoria LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
        SELECT * FROM PREPRINTS WHERE abstract LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION ";
        $cat = "all records";
      } else {
        $query = "
        SELECT * FROM PREPRINTS WHERE id_pubblicazione LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
        SELECT * FROM PREPRINTS WHERE titolo LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
        SELECT * FROM PREPRINTS WHERE data_pubblicazione LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
        SELECT * FROM PREPRINTS WHERE autori LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
        SELECT * FROM PREPRINTS WHERE referenze LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
        SELECT * FROM PREPRINTS WHERE commenti LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
        SELECT * FROM PREPRINTS WHERE categoria LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
        SELECT * FROM PREPRINTS WHERE abstract LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
        SELECT * FROM PREPRINTS_ARCHIVIATI WHERE id_pubblicazione LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
        SELECT * FROM PREPRINTS_ARCHIVIATI WHERE titolo LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
        SELECT * FROM PREPRINTS_ARCHIVIATI WHERE data_pubblicazione LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
        SELECT * FROM PREPRINTS_ARCHIVIATI WHERE autori LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
        SELECT * FROM PREPRINTS_ARCHIVIATI WHERE referenze LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
        SELECT * FROM PREPRINTS_ARCHIVIATI WHERE commenti LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
        SELECT * FROM PREPRINTS_ARCHIVIATI WHERE categoria LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
        SELECT * FROM PREPRINTS_ARCHIVIATI WHERE abstract LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION ";
        $cat = "all records";
        $cat3 = $cat3 . ", included archived, ";
      }
    }
  }
  $query = substr($query, 0, -7);
  $cat3 = substr($cat3, 0, -2);
  #risultati visualizzati per pagina
  if (isset($_GET['rp']) && $_GET['rp'] != "") {
    $risperpag = $_GET['rp'];
  } else {
    $risperpag = 5;
  }
  #recupero pagina
  if (isset($_GET['p']) && $_GET['p'] != "") {
    $p = $_GET['p'];
  } else {
    $p = 1;
  }
  #limite risultati
  $limit = $risperpag * $p - $risperpag;
  #query di ricerca
  $querytotale = mysqli_query($db_connection, $query) or die(mysqli_error());
  $ristot = mysqli_num_rows($querytotale);
  if ($cat != "all records") {
    echo "Found " . $ristot . " results:";
  } else {
    echo "Found " . $ristot . " results:";
  }
  $npag = ceil($ristot / $risperpag);
  $query = $query . " ORDER BY " . $order . " LIMIT " . $limit . "," . $risperpag . "";
  $result = mysqli_query($db_connection, $query) or die(mysqli_error());
  #impostazione della paginazione dei risultati
  if ($ristot != 0) {
    echo "<br/><br/>";
    if ($p != 1) {
      $t1 = $p - 1;
      $t2 = $p - 2;
      $t3 = $p - 3;
      echo '<a style="color:#1976D2; text-decoration: none;" title="First page" href="view_preprints.php?p=1&w=&r=' . urlencode($_GET['r']) . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&t=' . $_GET['t'] . '&a=' . $_GET['a'] . '&c=' . $_GET['c'] . '&j=' . $_GET['j'] . '&d=' . $_GET['d'] . '&all=' . $_GET['all'] . '&h=' . $_GET['h'] . '&y=' . $_GET['y'] . '&e=' . $_GET['e'] . '&i=' . $_GET['i'] . '&rp=' . $_GET['rp'] . '&year1=' . $_GET['year1'] . '&year2=' . $_GET['year2'] . '&year3=' . $_GET['year3'] . '&s=' . $_GET['s'] . '"> &#8656 </a>';
      if ($p >= 3 && $t3 > 0) {
        echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p - 3) . '&r=' . urlencode($_GET['r']) . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&t=' . $_GET['t'] . '&a=' . $_GET['a'] . '&c=' . $_GET['c'] . '&j=' . $_GET['j'] . '&d=' . $_GET['d'] . '&all=' . $_GET['all'] . '&h=' . $_GET['h'] . '&y=' . $_GET['y'] . '&e=' . $_GET['e'] . '&i=' . $_GET['i'] . '&rp=' . $_GET['rp'] . '&year1=' . $_GET['year1'] . '&year2=' . $_GET['year2'] . '&year3=' . $_GET['year3'] . '&s=' . $_GET['s'] . '"> ' . " " . $t3 . " " . ' </a>';
      }
      if ($p >= 2 && $t2 > 0) {
        echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p - 2) . '&r=' . urlencode($_GET['r']) . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&t=' . $_GET['t'] . '&a=' . $_GET['a'] . '&c=' . $_GET['c'] . '&j=' . $_GET['j'] . '&d=' . $_GET['d'] . '&all=' . $_GET['all'] . '&h=' . $_GET['h'] . '&y=' . $_GET['y'] . '&e=' . $_GET['e'] . '&i=' . $_GET['i'] . '&rp=' . $_GET['rp'] . '&year1=' . $_GET['year1'] . '&year2=' . $_GET['year2'] . '&year3=' . $_GET['year3'] . '&s=' . $_GET['s'] . '"> ' . " " . $t2 . " " . ' </a>';
      }
      echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p - 1) . '&r=' . urlencode($_GET['r']) . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&t=' . $_GET['t'] . '&a=' . $_GET['a'] . '&c=' . $_GET['c'] . '&j=' . $_GET['j'] . '&d=' . $_GET['d'] . '&all=' . $_GET['all'] . '&h=' . $_GET['h'] . '&y=' . $_GET['y'] . '&e=' . $_GET['e'] . '&i=' . $_GET['i'] . '&rp=' . $_GET['rp'] . '&year1=' . $_GET['year1'] . '&year2=' . $_GET['year2'] . '&year3=' . $_GET['year3'] . '&s=' . $_GET['s'] . '"> ' . " " . $t1 . " " . ' </a>';
    }
    echo " " . $p . " ";
    if ($p != $npag) {
      $t4 = $p + 1;
      $t5 = $p + 2;
      $t6 = $p + 3;
      echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p + 1) . '&r=' . urlencode($_GET['r']) . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&t=' . $_GET['t'] . '&a=' . $_GET['a'] . '&c=' . $_GET['c'] . '&j=' . $_GET['j'] . '&d=' . $_GET['d'] . '&all=' . $_GET['all'] . '&h=' . $_GET['h'] . '&y=' . $_GET['y'] . '&e=' . $_GET['e'] . '&i=' . $_GET['i'] . '&rp=' . $_GET['rp'] . '&year1=' . $_GET['year1'] . '&year2=' . $_GET['year2'] . '&year3=' . $_GET['year3'] . '&s=' . $_GET['s'] . '"> ' . " " . $t4 . " " . ' </a>';
      if ($p < $npag && $t5 <= $npag) {
        echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p + 2) . '&r=' . urlencode($_GET['r']) . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&t=' . $_GET['t'] . '&a=' . $_GET['a'] . '&c=' . $_GET['c'] . '&j=' . $_GET['j'] . '&d=' . $_GET['d'] . '&all=' . $_GET['all'] . '&h=' . $_GET['h'] . '&y=' . $_GET['y'] . '&e=' . $_GET['e'] . '&i=' . $_GET['i'] . '&rp=' . $_GET['rp'] . '&year1=' . $_GET['year1'] . '&year2=' . $_GET['year2'] . '&year3=' . $_GET['year3'] . '&s=' . $_GET['s'] . '"> ' . " " . $t5 . " " . ' </a>';
      }
      if ($p < $npag && $t6 <= $npag) {
        echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p + 3) . '&r=' . urlencode($_GET['r']) . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&t=' . $_GET['t'] . '&a=' . $_GET['a'] . '&c=' . $_GET['c'] . '&j=' . $_GET['j'] . '&d=' . $_GET['d'] . '&all=' . $_GET['all'] . '&h=' . $_GET['h'] . '&y=' . $_GET['y'] . '&e=' . $_GET['e'] . '&i=' . $_GET['i'] . '&rp=' . $_GET['rp'] . '&year1=' . $_GET['year1'] . '&year2=' . $_GET['year2'] . '&year3=' . $_GET['year3'] . '&s=' . $_GET['s'] . '"> ' . " " . $t6 . " " . ' </a>';
      }
      echo '<a style="color:#1976D2; text-decoration: none;" title="Last page" href="view_preprints.php?p=' . $npag . '&r=' . urlencode($_GET['r']) . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&t=' . $_GET['t'] . '&a=' . $_GET['a'] . '&c=' . $_GET['c'] . '&j=' . $_GET['j'] . '&d=' . $_GET['d'] . '&all=' . $_GET['all'] . '&h=' . $_GET['h'] . '&y=' . $_GET['y'] . '&e=' . $_GET['e'] . '&i=' . $_GET['i'] . '&rp=' . $_GET['rp'] . '&year1=' . $_GET['year1'] . '&year2=' . $_GET['year2'] . '&year3=' . $_GET['year3'] . '&s=' . $_GET['s'] . '"> &#8658 </a>';
    }
    echo "<br/>";
  }
  $i = $limit;
  $index = 0;
  #recupero e visualizzazione dei campi della ricerca effettuata
  while ($row = mysqli_fetch_array($result)) {
    echo '<div class="boxContainer" align="center">'
    . "<div id='TopBox" . $index . "' style='cursor: pointer;'>";
    echo "<div class='titolo'>" . ($row['titolo']) . "</div>";
    echo "<div>" . ($row['data_pubblicazione']) . "</div>";
    echo "<div>" . ($row['autori']) . "</div></div>";
    echo "<div id='BottomBox" . $index . "' hidden><br/>"
    . "<div>" . ($row['categoria']) . "</div><br/>"
    . "<div>" . ($row['commenti']) . "</div><br/>"
    . "<div style='text-align: left; width: 75%;'>" . ($row['abstract']) . "</div><br/>"
    . "<div>" . ($row['referenze']) . "</div>"
    . "<br/><div class='boxID'>ID: " . ($row['id_pubblicazione']) . "</div>";
    if ($_SESSION['logged_type'] === "mod") {
      if (file_exists($copia . $row['Filename'])) {
        echo "<div><a target=\"blank\" href='./manual_edit.php?id=" . $row['id_pubblicazione'] . "' title='Edit'><img class='ImageOpt' src='./images/ic_image_edit.png'></a></div>";
        echo "<div><a href='" . $copia . $row['Filename'] . "' target=\"_blank\" title='" . $row['id_pubblicazione'] . "'>"
        . "<img class='ImageOpt' src='./images/ic_editor_insert_drive_file.png'></a></div><div style='clear:both;'></div>";
      } else {
        echo "<div><a href='" . $basedir4 . $row['Filename'] . "' target=\"_blank\" title='" . $row['id_pubblicazione'] . "'>"
        . "<img class='ImageOpt' src='./images/ic_editor_insert_drive_file.png'></a></div><div style='clear:both;'></div>";
      }
    } else if ($_SESSION['uid'] === $row['uid'] && $row['uid'] != "") {
      if (file_exists($copia . $row['Filename'])) {
        echo "<div><a target=\"blank\" href='./edit.php?id=" . $row['id_pubblicazione'] . "&r=" . $row['uid'] . "' title='Edit'><img class='ImageOpt' src='./images/ic_image_edit.png'></a></div>";
        echo "<div><a href='" . $copia . $row['Filename'] . "' target=\"_blank\" title='" . $row['id_pubblicazione'] . "'>"
        . "<img class='ImageOpt' src='./images/ic_editor_insert_drive_file.png'></a></div><div style='clear:both;'></div>";
      } else {
        echo "<div><a href='" . $basedir4 . $row['Filename'] . "' target=\"_blank\" title='" . $row['id_pubblicazione'] . "'>"
        . "<img class='ImageOpt' src='./images/ic_editor_insert_drive_file.png'></a></div><div style='clear:both;'></div>";
      }
    } else {
      if (file_exists($copia . $row['Filename'])) {
        echo "<div><a href='" . $copia . $row['Filename'] . "' target=\"_blank\" title='" . $row['id_pubblicazione'] . "'>"
        . "<img class='ImageOpt' src='./images/ic_editor_insert_drive_file.png'></a></div><div style='clear:both;'></div>";
      } else {
        echo "<div><a href='" . $basedir4 . $row['Filename'] . "' target=\"_blank\" title='" . $row['id_pubblicazione'] . "'>"
        . "<img class='ImageOpt' src='./images/ic_editor_insert_drive_file.png'></a></div><div style='clear:both;'></div>";
      }
    }
    echo "</div></div><script>"
    . "$(TopBox" . $index . ").click(function(){
      $(BottomBox" . $index . ").toggle(400);
    });"
    . "</script>";
    $index++;
  }
  #impostazioni della navigazione per pagine
  if ($ristot != 0) {
    if ($p != 1) {
      $t1 = $p - 1;
      $t2 = $p - 2;
      $t3 = $p - 3;
      echo '<a style="color:#1976D2; text-decoration: none;" title="First page" href="view_preprints.php?p=1&r=' . urlencode($_GET['r']) . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&t=' . $_GET['t'] . '&a=' . $_GET['a'] . '&c=' . $_GET['c'] . '&j=' . $_GET['j'] . '&d=' . $_GET['d'] . '&all=' . $_GET['all'] . '&h=' . $_GET['h'] . '&y=' . $_GET['y'] . '&e=' . $_GET['e'] . '&i=' . $_GET['i'] . '&rp=' . $_GET['rp'] . '&year1=' . $_GET['year1'] . '&year2=' . $_GET['year2'] . '&year3=' . $_GET['year3'] . '&s=' . $_GET['s'] . '"> &#8656 </a>';
      if ($p >= 3 && $t3 > 0) {
        echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p - 3) . '&r=' . urlencode($_GET['r']) . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&t=' . $_GET['t'] . '&a=' . $_GET['a'] . '&c=' . $_GET['c'] . '&j=' . $_GET['j'] . '&d=' . $_GET['d'] . '&all=' . $_GET['all'] . '&h=' . $_GET['h'] . '&y=' . $_GET['y'] . '&e=' . $_GET['e'] . '&i=' . $_GET['i'] . '&rp=' . $_GET['rp'] . '&year1=' . $_GET['year1'] . '&year2=' . $_GET['year2'] . '&year3=' . $_GET['year3'] . '&s=' . $_GET['s'] . '"> ' . " " . $t3 . " " . ' </a>';
      }
      if ($p >= 2 && $t2 > 0) {
        echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p - 2) . '&r=' . urlencode($_GET['r']) . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&t=' . $_GET['t'] . '&a=' . $_GET['a'] . '&c=' . $_GET['c'] . '&j=' . $_GET['j'] . '&d=' . $_GET['d'] . '&all=' . $_GET['all'] . '&h=' . $_GET['h'] . '&y=' . $_GET['y'] . '&e=' . $_GET['e'] . '&i=' . $_GET['i'] . '&rp=' . $_GET['rp'] . '&year1=' . $_GET['year1'] . '&year2=' . $_GET['year2'] . '&year3=' . $_GET['year3'] . '&s=' . $_GET['s'] . '"> ' . " " . $t2 . " " . ' </a>';
      }
      echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p - 1) . '&r=' . urlencode($_GET['r']) . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&t=' . $_GET['t'] . '&a=' . $_GET['a'] . '&c=' . $_GET['c'] . '&j=' . $_GET['j'] . '&d=' . $_GET['d'] . '&all=' . $_GET['all'] . '&h=' . $_GET['h'] . '&y=' . $_GET['y'] . '&e=' . $_GET['e'] . '&i=' . $_GET['i'] . '&rp=' . $_GET['rp'] . '&year1=' . $_GET['year1'] . '&year2=' . $_GET['year2'] . '&year3=' . $_GET['year3'] . '&s=' . $_GET['s'] . '"> ' . " " . $t1 . " " . ' </a>';
    }
    echo " " . $p . " ";
    if ($p != $npag) {
      $t4 = $p + 1;
      $t5 = $p + 2;
      $t6 = $p + 3;
      echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p + 1) . '&r=' . urlencode($_GET['r']) . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&t=' . $_GET['t'] . '&a=' . $_GET['a'] . '&c=' . $_GET['c'] . '&j=' . $_GET['j'] . '&d=' . $_GET['d'] . '&all=' . $_GET['all'] . '&h=' . $_GET['h'] . '&y=' . $_GET['y'] . '&e=' . $_GET['e'] . '&i=' . $_GET['i'] . '&rp=' . $_GET['rp'] . '&year1=' . $_GET['year1'] . '&year2=' . $_GET['year2'] . '&year3=' . $_GET['year3'] . '&s=' . $_GET['s'] . '"> ' . " " . $t4 . " " . ' </a>';
      if ($p < $npag && $t5 <= $npag) {
        echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p + 2) . '&r=' . urlencode($_GET['r']) . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&t=' . $_GET['t'] . '&a=' . $_GET['a'] . '&c=' . $_GET['c'] . '&j=' . $_GET['j'] . '&d=' . $_GET['d'] . '&all=' . $_GET['all'] . '&h=' . $_GET['h'] . '&y=' . $_GET['y'] . '&e=' . $_GET['e'] . '&i=' . $_GET['i'] . '&rp=' . $_GET['rp'] . '&year1=' . $_GET['year1'] . '&year2=' . $_GET['year2'] . '&year3=' . $_GET['year3'] . '&s=' . $_GET['s'] . '"> ' . " " . $t5 . " " . ' </a>';
      }
      if ($p < $npag && $t6 <= $npag) {
        echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p + 3) . '&r=' . urlencode($_GET['r']) . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&t=' . $_GET['t'] . '&a=' . $_GET['a'] . '&c=' . $_GET['c'] . '&j=' . $_GET['j'] . '&d=' . $_GET['d'] . '&all=' . $_GET['all'] . '&h=' . $_GET['h'] . '&y=' . $_GET['y'] . '&e=' . $_GET['e'] . '&i=' . $_GET['i'] . '&rp=' . $_GET['rp'] . '&year1=' . $_GET['year1'] . '&year2=' . $_GET['year2'] . '&year3=' . $_GET['year3'] . '&s=' . $_GET['s'] . '"> ' . " " . $t6 . " " . ' </a>';
      }
      echo '<a style="color:#1976D2; text-decoration: none;" title="Last page" href="view_preprints.php?p=' . $npag . '&r=' . urlencode($_GET['r']) . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&t=' . $_GET['t'] . '&a=' . $_GET['a'] . '&c=' . $_GET['c'] . '&j=' . $_GET['j'] . '&d=' . $_GET['d'] . '&all=' . $_GET['all'] . '&h=' . $_GET['h'] . '&y=' . $_GET['y'] . '&e=' . $_GET['e'] . '&i=' . $_GET['i'] . '&rp=' . $_GET['rp'] . '&year1=' . $_GET['year1'] . '&year2=' . $_GET['year2'] . '&year3=' . $_GET['year3'] . '&s=' . $_GET['s'] . '"> &#8658 </a>';
    }
  }
  $x = $limit + 1;
}

# funzione filtro e lettura dei preprint

function filtropreprint() {
  global $db_connection, $copia, $basedir4;
  require_once './authorization/sec_sess.php';
  sec_session_start();
  if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] < 86400)) {
    if ($_SESSION['logged_type'] === "mod") {
      $cred = 1;
    } else {
      $cred = 0;
    }
  }
  #recupero pagina
  if (isset($_GET['p']) && $_GET['p'] != "") {
    $p = $_GET['p'];
  } else {
    $p = 1;
  }
  $order = "data_pubblicazione DESC";
  $orstr = "decreasing date";
  #verifica filtro
  if ($_GET['f'] == "author") {
    $argom = "autori";
  } else if ($_GET['f'] == "category") {
    $argom = "categoria";
  } else if ($_GET['f'] == "year") {
    $argom = "data_pubblicazione";
  } else if ($_GET['f'] == "id") {
    $argom = "id_pubblicazione";
  }
  #risultati visualizzati per pagina
  if (isset($_GET['rp']) && $_GET['rp'] != "") {
    $risperpag = $_GET['rp'];
  } else {
    $risperpag = 5;
  }
  #limite risultati
  $limit = $risperpag * $p - $risperpag;
  #query di ricerca
  if (isset($argom)) {
    $sql = "SELECT * FROM PREPRINTS WHERE " . $argom . " LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1'";
    $querytotale = mysqli_query($db_connection, $sql) or die(mysqli_error());
    $ristot = mysqli_num_rows($querytotale);
    if ($ristot != 0) {
      echo "Found " . $ristot . " results:<br/><br/>";
    } else {
      echo "Found " . $ristot . " results:<br/><br/>";
      exit();
    }
    $npag = ceil($ristot / $risperpag);
    $sql = "SELECT * FROM PREPRINTS WHERE " . $argom . " LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' ORDER BY " . $order . " LIMIT " . $limit . "," . $risperpag . "";
    $result = mysqli_query($db_connection, $sql) or die(mysqli_error());
  } else {
    #senza filtro
    $query = "
    SELECT * FROM PREPRINTS WHERE id_pubblicazione LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
    SELECT * FROM PREPRINTS WHERE titolo LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
    SELECT * FROM PREPRINTS WHERE data_pubblicazione LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
    SELECT * FROM PREPRINTS WHERE autori LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
    SELECT * FROM PREPRINTS WHERE referenze LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
    SELECT * FROM PREPRINTS WHERE commenti LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
    SELECT * FROM PREPRINTS WHERE categoria LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1' UNION
    SELECT * FROM PREPRINTS WHERE abstract LIKE '%" . addslashes($_GET['r']) . "%' AND checked='1'";
    $querytotale = mysqli_query($db_connection, $query) or die(mysqli_error());
    $ristot = mysqli_num_rows($querytotale);
    $npag = ceil($ristot / $risperpag);
    if (isset($_GET['o']) && $_GET['o'] != "") {
      $query = $query . " ORDER BY " . $order . " LIMIT " . $limit . "," . $risperpag . "";
    } else {
      $query = $query . " ORDER BY data_pubblicazione DESC LIMIT " . $limit . "," . $risperpag . "";
    }
    if (!isset($_GET['r']) or $_GET['r'] == "") {
      echo $ristot . " ELEMENTS ON " . $npag . " PAGES";
    } else {
      echo "Found " . $ristot . " results:<br/><br/>";
    }
    $npag = ceil($ristot / $risperpag);
    $result = mysqli_query($db_connection, $query) or die(mysqli_error());
  }
  #impostazione della paginazione dei risultati
  if ($ristot != 0) {
    if ($p != 1) {
      $t1 = $p - 1;
      $t2 = $p - 2;
      $t3 = $p - 3;
      echo '<a style="color:#1976D2; text-decoration: none;" title="First page" href="view_preprints.php?p=1&r=' . urlencode($_GET['r']) . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&rp=' . $_GET['rp'] . '&s=' . $_GET['s'] . '"> &#8656 </a>';
      if ($p >= 3 && $t3 > 0) {
        echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p - 3) . '&r=' . urlencode($_GET['r']) . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&rp=' . $_GET['rp'] . '&s=' . $_GET['s'] . '"> ' . " " . $t3 . " " . ' </a>';
      }
      if ($p >= 2 && $t2 > 0) {
        echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p - 2) . '&r=' . urlencode($_GET['r']) . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&rp=' . $_GET['rp'] . '&s=' . $_GET['s'] . '"> ' . " " . $t2 . " " . ' </a>';
      }
      echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p - 1) . '&r=' . urlencode($_GET['r']) . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&rp=' . $_GET['rp'] . '&s=' . $_GET['s'] . '"> ' . " " . $t1 . " " . ' </a>';
    }
    echo " " . $p . " ";
    if ($p != $npag) {
      $t4 = $p + 1;
      $t5 = $p + 2;
      $t6 = $p + 3;
      echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p + 1) . '&r=' . urlencode($_GET['r']) . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&rp=' . $_GET['rp'] . '&s=' . $_GET['s'] . '"> ' . " " . $t4 . " " . ' </a>';
      if ($p < $npag && $t5 <= $npag) {
        echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p + 2) . '&r=' . urlencode($_GET['r']) . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&rp=' . $_GET['rp'] . '&s=' . $_GET['s'] . '"> ' . " " . $t5 . " " . ' </a>';
      }
      if ($p < $npag && $t6 <= $npag) {
        echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p + 3) . '&r=' . urlencode($_GET['r']) . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&rp=' . $_GET['rp'] . '&s=' . $_GET['s'] . '"> ' . " " . $t6 . " " . ' </a>';
      }
      echo '<a style="color:#1976D2; text-decoration: none;" title="Last page" href="view_preprints.php?p=' . $npag . '&r=' . urlencode($_GET['r']) . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&rp=' . $_GET['rp'] . '&s=' . $_GET['s'] . '"> &#8658 </a>';
    }
  }
  $i = $limit;
  $index = 0;
  #recupero e visualizzazione dei campi della ricerca effettuata
  while ($row = mysqli_fetch_array($result)) {
    echo '<div class="boxContainer" align="center">'
    . "<div id='TopBox" . $index . "' style='cursor: pointer;'>";
    echo "<div class='titolo'>" . ($row['titolo']) . "</div>";
    echo "<div>" . ($row['data_pubblicazione']) . "</div>";
    echo "<div>" . ($row['autori']) . "</div></div>";
    echo "<div id='BottomBox" . $index . "' hidden><br/>"
    . "<div>" . ($row['categoria']) . "</div><br/>"
    . "<div>" . ($row['commenti']) . "</div><br/>"
    . "<div style='text-align: left; width: 75%;'>" . ($row['abstract']) . "</div><br/>"
    . "<div>" . ($row['referenze']) . "</div>"
    . "<br/><div class='boxID'>ID: " . ($row['id_pubblicazione']) . "</div>";
    if ($_SESSION['logged_type'] === "mod") {
      if (file_exists($copia . $row['Filename'])) {
        echo "<div><a target=\"blank\" href='./manual_edit.php?id=" . $row['id_pubblicazione'] . "' title='Edit'><img class='ImageOpt' src='./images/ic_image_edit.png'></a></div>";
        echo "<div><a href='" . $copia . $row['Filename'] . "' target=\"_blank\" title='" . $row['id_pubblicazione'] . "'>"
        . "<img class='ImageOpt' src='./images/ic_editor_insert_drive_file.png'></a></div><div style='clear:both;'></div>";
      } else {
        echo "<div><a href='" . $basedir4 . $row['Filename'] . "' target=\"_blank\" title='" . $row['id_pubblicazione'] . "'>"
        . "<img class='ImageOpt' src='./images/ic_editor_insert_drive_file.png'></a></div><div style='clear:both;'></div>";
      }
    } else if ($_SESSION['uid'] === $row['uid'] && $row['uid'] != "") {
      if (file_exists($copia . $row['Filename'])) {
        echo "<div><a target=\"blank\" href='./edit.php?id=" . $row['id_pubblicazione'] . "&r=" . $row['uid'] . "' title='Edit'><img class='ImageOpt' src='./images/ic_image_edit.png'></a></div>";
        echo "<div><a href='" . $copia . $row['Filename'] . "' target=\"_blank\" title='" . $row['id_pubblicazione'] . "'>"
        . "<img class='ImageOpt' src='./images/ic_editor_insert_drive_file.png'></a></div><div style='clear:both;'></div>";
      } else {
        echo "<div><a href='" . $basedir4 . $row['Filename'] . "' target=\"_blank\" title='" . $row['id_pubblicazione'] . "'>"
        . "<img class='ImageOpt' src='./images/ic_editor_insert_drive_file.png'></a></div><div style='clear:both;'></div>";
      }
    } else {
      if (file_exists($copia . $row['Filename'])) {
        echo "<div><a href='" . $copia . $row['Filename'] . "' target=\"_blank\" title='" . $row['id_pubblicazione'] . "'>"
        . "<img class='ImageOpt' src='./images/ic_editor_insert_drive_file.png'></a></div><div style='clear:both;'></div>";
      } else {
        echo "<div><a href='" . $basedir4 . $row['Filename'] . "' target=\"_blank\" title='" . $row['id_pubblicazione'] . "'>"
        . "<img class='ImageOpt' src='./images/ic_editor_insert_drive_file.png'></a></div><div style='clear:both;'></div>";
      }
    }
    echo "</div></div><script>"
    . "$(TopBox" . $index . ").click(function(){
      $(BottomBox" . $index . ").toggle(400);
    });"
    . "</script>";
    $index++;
  }
  #impostazioni della navigazione per pagine
  if ($ristot != 0) {
    if ($p != 1) {
      $t1 = $p - 1;
      $t2 = $p - 2;
      $t3 = $p - 3;
      echo '<a style="color:#1976D2; text-decoration: none;" title="First page" href="view_preprints.php?p=1&r=' . urlencode($_GET['r']) . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&rp=' . $_GET['rp'] . '&s=' . $_GET['s'] . '"> &#8656 </a>';
      if ($p >= 3 && $t3 > 0) {
        echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p - 3) . '&r=' . urlencode($_GET['r']) . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&rp=' . $_GET['rp'] . '&s=' . $_GET['s'] . '"> ' . " " . $t3 . " " . ' </a>';
      }
      if ($p >= 2 && $t2 > 0) {
        echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p - 2) . '&r=' . urlencode($_GET['r']) . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&rp=' . $_GET['rp'] . '&s=' . $_GET['s'] . '"> ' . " " . $t2 . " " . ' </a>';
      }
      echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p - 1) . '&r=' . urlencode($_GET['r']) . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&rp=' . $_GET['rp'] . '&s=' . $_GET['s'] . '"> ' . " " . $t1 . " " . ' </a>';
    }
    echo " " . $p . " ";
    if ($p != $npag) {
      $t4 = $p + 1;
      $t5 = $p + 2;
      $t6 = $p + 3;
      echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p + 1) . '&r=' . urlencode($_GET['r']) . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&rp=' . $_GET['rp'] . '&s=' . $_GET['s'] . '"> ' . " " . $t4 . " " . ' </a>';
      if ($p < $npag && $t5 <= $npag) {
        echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p + 2) . '&r=' . urlencode($_GET['r']) . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&rp=' . $_GET['rp'] . '&s=' . $_GET['s'] . '"> ' . " " . $t5 . " " . ' </a>';
      }
      if ($p < $npag && $t6 <= $npag) {
        echo '<a style="color:#1976D2; text-decoration: none;" href="view_preprints.php?p=' . ($p + 3) . '&r=' . urlencode($_GET['r']) . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&rp=' . $_GET['rp'] . '&s=' . $_GET['s'] . '"> ' . " " . $t6 . " " . ' </a>';
      }
      echo '<a style="color:#1976D2; text-decoration: none;" title="Last page" href="view_preprints.php?p=' . $npag . '&r=' . urlencode($_GET['r']) . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&rp=' . $_GET['rp'] . '&s=' . $_GET['s'] . '"> &#8658 </a>';
    }
  }
  $x = $limit + 1;
}

# funzione lettura dei preprint recenti

function recentspreprints() {
  global $db_connection, $copia;
  require_once './authorization/sec_sess.php';
  sec_session_start();
  $query = "SELECT * FROM PREPRINTS WHERE checked=1 ORDER BY data_pubblicazione DESC LIMIT 10";
  $result = mysqli_query($db_connection, $query) or die(mysqli_error());
  $i = $limit;
  $index = 0;
  #recupero e visualizzazione dei campi della ricerca effettuata
  while ($row = mysqli_fetch_array($result)) {
    echo '<div class="boxContainerIndex" align="center">'
    . "<div id='TopBox" . $index . "' style='cursor: pointer;'>";
    echo "<div class='titolo'>" . ($row['titolo']) . "</div>";
    echo "<div>" . ($row['data_pubblicazione']) . "</div>";
    echo "<div>" . ($row['autori']) . "</div></div>";
    echo "<div id='BottomBox" . $index . "' hidden><br/>"
    . "<div>" . ($row['categoria']) . "</div><br/>"
    . "<div>" . ($row['commenti']) . "</div><br/>"
    . "<div style='text-align: left; width: 75%;'>" . ($row['abstract']) . "</div><br/>"
    . "<div>" . ($row['referenze']) . "</div>"
    . "<br/><div class='boxID'>ID: " . ($row['id_pubblicazione']) . "</div>";
    if ($_SESSION['logged_type'] === "mod") {
      echo "<div><a target=\"blank\" href='./manual_edit.php?id=" . $row['id_pubblicazione'] . "' title='Edit'><img class='ImageOpt' src='./images/ic_image_edit.png'></a></div>";
    } else if ($_SESSION['uid'] === $row['uid'] && $row['uid'] != "") {
      echo "<div><a target=\"blank\" href='./edit.php?id=" . $row['id_pubblicazione'] . "&r=" . $row['uid'] . "' title='Edit'><img class='ImageOpt' src='./images/ic_image_edit.png'></a></div>";
    }
    echo "<div><a href='" . $copia . $row['Filename'] . "' target=\"_blank\" title='" . $row['id_pubblicazione'] . "'>"
    . "<img class='ImageOpt' src='./images/ic_editor_insert_drive_file.png'></a></div><div style='clear:both;'></div>";
    echo "</div></div><script>"
    . "$(TopBox" . $index . ").click(function(){
      $(BottomBox" . $index . ").toggle(400);
    });"
    . "</script>";
    $index++;
  }
  $x = $limit + 1;
}

#funzione lettura dei preprint archiviati

function leggipreprintarchiviati() {
  global $db_connection, $basedir4;
  $risperpag = 5;
  #recupero pagina
  if (isset($_GET['p']) && $_GET['p'] != "") {
    $p = $_GET['p'];
  } else {
    $p = 1;
  }
  $limit = $risperpag * $p - $risperpag;
  $sql = "SELECT * FROM PREPRINTS_ARCHIVIATI";
  $querytotale = mysqli_query($db_connection, $sql) or die(mysqli_error());
  $ristot = mysqli_num_rows($querytotale);
  if ($ristot == 0) {
    echo "<br/>No preprints archived.";
  }
  $npag = ceil($ristot / $risperpag);
  #impostazione della navigazione per pagine
  if ($ristot != 0) {
    if ($p != 1) {
      $t1 = $p - 1;
      $t2 = $p - 2;
      $t3 = $p - 3;
      echo '<a style="color:#007897; text-decoration: none;" title="First page" href="archived_preprints.php?p=1&r=' . $_GET['r'] . '"> &#8656 </a>';
      if ($p >= 3 && $t3 > 0) {
        echo '<a style="color:#007897; text-decoration: none;" href="archived_preprints.php?p=' . ($p - 3) . '&r=' . $_GET['r'] . '"> ' . " " . $t3 . " " . ' </a>';
      }
      if ($p >= 2 && $t2 > 0) {
        echo '<a style="color:#007897; text-decoration: none;" href="archived_preprints.php?p=' . ($p - 2) . '&r=' . $_GET['r'] . '"> ' . " " . $t2 . " " . ' </a>';
      }
      echo '<a style="color:#007897; text-decoration: none;" href="archived_preprints.php?p=' . ($p - 1) . '&r=' . $_GET['r'] . '"> ' . " " . $t1 . " " . ' </a>';
    }
    echo " " . $p . " ";
    if ($p != $npag) {
      $t4 = $p + 1;
      $t5 = $p + 2;
      $t6 = $p + 3;
      echo '<a style="color:#007897; text-decoration: none;" href="archived_preprints.php?p=' . ($p + 1) . '&r=' . $_GET['r'] . '"> ' . " " . $t4 . " " . ' </a>';
      if ($p < $npag && $t5 <= $npag) {
        echo '<a style="color:#007897; text-decoration: none;" href="archived_preprints.php?p=' . ($p + 2) . '&r=' . $_GET['r'] . '"> ' . " " . $t5 . " " . ' </a>';
      }
      if ($p < $npag && $t6 <= $npag) {
        echo '<a style="color:#007897; text-decoration: none;" href="archived_preprints.php?p=' . ($p + 3) . '&r=' . $_GET['r'] . '"> ' . " " . $t6 . " " . ' </a>';
      }
      echo '<a style="color:#007897; text-decoration: none;" title="Last page" href="archived_preprints.php?p=' . $npag . '&r=' . $_GET['r'] . '"> &#8658 </a>';
    }
  }
  #verifica se i preprint devono essere rimossi definitivamente
  if ($_GET['c'] != "remove") {
    $sql = "SELECT * FROM PREPRINTS_ARCHIVIATI WHERE checked='1' ORDER BY data_pubblicazione DESC LIMIT " . $limit . "," . $risperpag . "";
    $result = mysqli_query($db_connection, $sql) or die(mysqli_error());
    $i = $limit;
    $index = 0;
    #recupero e visualizzazione dei campi della ricerca effettuata
    while ($row = mysqli_fetch_array($result)) {
      echo '<div class="boxContainerIndex" align="center">'
      . "<div id='TopBox" . $index . "' style='cursor: pointer;'>";
      echo "<div class='titolo'>" . ($row['titolo']) . "</div>";
      echo "<div>" . ($row['data_pubblicazione']) . "</div>";
      echo "<div>" . ($row['autori']) . "</div></div>";
      echo "<div id='BottomBox" . $index . "' hidden><br/>"
      . "<div>" . ($row['categoria']) . "</div><br/>"
      . "<div>" . ($row['commenti']) . "</div><br/>"
      . "<div style='text-align: left; width: 75%;'>" . ($row['abstract']) . "</div><br/>"
      . "<div>" . ($row['referenze']) . "</div>"
      . "<br/><div class='boxID'>ID: " . ($row['id_pubblicazione']) . "</div>";
      echo "<div><a href='" . $basedir4 . $row['Filename'] . "' target=\"_blank\" title='" . $row['id_pubblicazione'] . "'>"
      . "<img class='ImageOpt' src='./images/ic_editor_insert_drive_file.png'></a></div><div style='clear:both;'></div>";
      echo "</div></div><script>"
      . "$(TopBox" . $index . ").click(function(){
        $(BottomBox" . $index . ").toggle(400);

      });"
      . "</script>";
      $index++;
    }
    #visualizzazione della navigazione per pagine
    if ($ristot != 0) {
      if ($p != 1) {
        echo '<a style="color:#007897; text-decoration: none;" title="First page" href="archived_preprints.php?p=1&r=' . $_GET['r'] . '"> &#8656 </a>';
        if ($p >= 3 && $t3 > 0) {
          echo '<a style="color:#007897; text-decoration: none;" href="archived_preprints.php?p=' . ($p - 3) . '&r=' . $_GET['r'] . '"> ' . " " . $t3 . " " . ' </a>';
        }
        if ($p >= 2 && $t2 > 0) {
          echo '<a style="color:#007897; text-decoration: none;" href="archived_preprints.php?p=' . ($p - 2) . '&r=' . $_GET['r'] . '"> ' . " " . $t2 . " " . ' </a>';
        }
        echo '<a style="color:#007897; text-decoration: none;" href="archived_preprints.php?p=' . ($p - 1) . '&r=' . $_GET['r'] . '"> ' . " " . $t1 . " " . ' </a>';
      }
      echo " " . $p . " ";
      if ($p != $npag) {
        echo '<a style="color:#007897; text-decoration: none;" href="archived_preprints.php?p=' . ($p + 1) . '&r=' . $_GET['r'] . '"> ' . " " . $t4 . " " . ' </a>';
        if ($p < $npag && $t5 <= $npag) {
          echo '<a style="color:#007897; text-decoration: none;" href="archived_preprints.php?p=' . ($p + 2) . '&r=' . $_GET['r'] . '"> ' . " " . $t5 . " " . ' </a>';
        }
        if ($p < $npag && $t6 <= $npag) {
          echo '<a style="color:#007897; text-decoration: none;" href="archived_preprints.php?p=' . ($p + 3) . '&r=' . $_GET['r'] . '"> ' . " " . $t6 . " " . ' </a>';
        }
        echo '<a style="color:#007897; text-decoration: none;" title="Last page" href="archived_preprints.php?p=' . $npag . '&r=' . $_GET['r'] . '"> &#8658 </a>';
      }
    }
  } else {
    #controllo di preprint da rimuovere
    if ($ristot != 0) {
      cancellapreprint();
      echo '<script type="text/javascript">alert("Preprints deleted from database!");</script>';
      echo '<META HTTP-EQUIV="Refresh" Content="0; URL=./archived_preprints.php?p=1">';
    } else {
      $limit = 0;
      echo '<script type="text/javascript">alert("No archived preprints!");</script>';
    }
  }
  $x = $limit + 1;
}

//invio mail di conferma quando avviene la registrazione

function sendConfirmMail($email, $name) {
  global $base_url, $send_mail_name, $send_mail_host, $send_mail_port, $send_mail_auth, $send_mail_user, $send_mail_pw;
  //generazione del token
  $token = md5($email);
  //invio della mail di conferma
  $from = $send_mail_name;
  $to = $email;
  $subject = 'Confirm Registration';
  $text = "To confirm your account use this link: http://localhost/confirmation.php?token=" . $token;
  $html = "<html><head></head><body>Dear " . $name . ",<br/>To confirm your account click <a href='" . $base_url . "confirmation.php?token=" . $token . "'>here</a>.<br/><br/><br/>Note: Please do not reply this email it has been send automatically.</body></html>";
  $crlf = "\n";
  $headers = array(
    'From' => $from,
    'To' => $to,
    'Subject' => $subject
  );
  $smtp = Mail::factory('smtp', array(
    'host' => $send_mail_host,
    'port' => $send_mail_port,
    'auth' => $send_mail_auth,
    'username' => $send_mail_user,
    'password' => $send_mail_pw
  ));
  $mime_params = array(
    'text_encoding' => '7bit',
    'text_charset' => 'UTF-8',
    'html_charset' => 'UTF-8',
    'head_charset' => 'UTF-8'
  );
  //creazione del messaggio Mime
  $mime = new Mail_mime($crlf);
  //impostazione della pagina html
  $mime->setTXTBody($text);
  $mime->setHTMLBody($html);
  $body = $mime->get();
  $headers = $mime->headers($headers);
  $mail = $smtp->send($to, $headers, $body);
  if (PEAR::isError($mail)) {
    echo('<p>' . $mail->getMessage() . '</p>');
    return false;
  } else {
    //echo('<p>Message successfully sent!</p>');
    return true;
  }
}

//invio mail di reset per la password

function sendResetMail($email) {
  global $base_url, $send_mail_name, $send_mail_host, $send_mail_port, $send_mail_auth, $send_mail_user, $send_mail_pw;
  //generazione del token
  $a = time();
  $b = date('d M y', $a);
  $token = md5($email . $b);
  //invio della mail di conferma
  $from = $send_mail_name;
  $to = $email;
  $subject = 'Reset Password';
  $text = "To reset the password of your account use this link: http://localhost/recovery_account.php?token=" . $token;
  $html = "<html><head></head><body>To reset the password of your account click <a href='" . $base_url . "recovery_account.php?token=" . $token . "'>here</a>.<br/><br/><br/>Note: Please do not reply this email it has been send automatically.</body></html>";
  $crlf = "\n";
  $headers = array(
    'From' => $from,
    'To' => $to,
    'Subject' => $subject
  );
  $smtp = Mail::factory('smtp', array(
    'host' => $send_mail_host,
    'port' => $send_mail_port,
    'auth' => $send_mail_auth,
    'username' => $send_mail_user,
    'password' => $send_mail_pw
  ));
  $mime_params = array(
    'text_encoding' => '7bit',
    'text_charset' => 'UTF-8',
    'html_charset' => 'UTF-8',
    'head_charset' => 'UTF-8'
  );
  //creazione del messaggio Mime
  $mime = new Mail_mime($crlf);
  //impostazione della pagina html
  $mime->setTXTBody($text);
  $mime->setHTMLBody($html);
  $body = $mime->get();
  $headers = $mime->headers($headers);
  $mail = $smtp->send($to, $headers, $body);
  if (PEAR::isError($mail)) {
    echo('<p>' . $mail->getMessage() . '</p>');
    return false;
  } else {
    //echo('<p>Message successfully sent!</p>');
    return true;
  }
}

//invio mail avviso modifica password

function sendPassConfirmMail($email) {
  global $base_url, $send_mail_name, $send_mail_host, $send_mail_port, $send_mail_auth, $send_mail_user, $send_mail_pw;
  //invio della mail di conferma
  $from = $send_mail_name;
  $to = $email;
  $subject = 'Password Changed';
  $text = "The password of your account has been changed on " . date("c", time()) . ".";
  $html = "<html><head></head><body>The password of your account has been changed on date " . date("c", time()) . ".<br/><br/><br/>Note: Please do not reply this email it has been send automatically.</body></html>";
  $crlf = "\n";
  $headers = array(
    'From' => $from,
    'To' => $to,
    'Subject' => $subject
  );
  $smtp = Mail::factory('smtp', array(
    'host' => $send_mail_host,
    'port' => $send_mail_port,
    'auth' => $send_mail_auth,
    'username' => $send_mail_user,
    'password' => $send_mail_pw
  ));
  $mime_params = array(
    'text_encoding' => '7bit',
    'text_charset' => 'UTF-8',
    'html_charset' => 'UTF-8',
    'head_charset' => 'UTF-8'
  );
  //creazione del messaggio Mime
  $mime = new Mail_mime($crlf);
  //impostazione della pagina html
  $mime->setTXTBody($text);
  $mime->setHTMLBody($html);
  $body = $mime->get();
  $headers = $mime->headers($headers);
  $mail = $smtp->send($to, $headers, $body);
  if (PEAR::isError($mail)) {
    echo('<p>' . $mail->getMessage() . '</p>');
    return false;
  } else {
    //echo('<p>Message successfully sent!</p>');
    return true;
  }
}

//invio mail avviso modifica email

function sendEmailChanged($emailOld, $email) {
  global $base_url, $send_mail_name, $send_mail_host, $send_mail_port, $send_mail_auth, $send_mail_user, $send_mail_pw;
  //invio della mail di conferma
  $from = $send_mail_name;
  $to = $emailOld;
  $subject = 'Email Changed';
  $text = "The email address associated on your account has been changed from " . $emailOld . " with " . $email . " on " . date("c", time()) . ".";
  $html = "<html><head></head><body>The email address associated on your account has been changed from " . $emailOld . " to " . $email . " on date " . date("c", time()) . ", for future access you need to use " . $email . ", the preprint you have published previously will be automatically associated to the new account.<br/><br/><br/>Note: Please do not reply this email it has been send automatically.</body></html>";
  $crlf = "\n";
  $headers = array(
    'From' => $from,
    'To' => $to,
    'Subject' => $subject
  );
  $smtp = Mail::factory('smtp', array(
    'host' => $send_mail_host,
    'port' => $send_mail_port,
    'auth' => $send_mail_auth,
    'username' => $send_mail_user,
    'password' => $send_mail_pw
  ));
  $mime_params = array(
    'text_encoding' => '7bit',
    'text_charset' => 'UTF-8',
    'html_charset' => 'UTF-8',
    'head_charset' => 'UTF-8'
  );
  //creazione del messaggio Mime
  $mime = new Mail_mime($crlf);
  //impostazione della pagina html
  $mime->setTXTBody($text);
  $mime->setHTMLBody($html);
  $body = $mime->get();
  $headers = $mime->headers($headers);
  $mail = $smtp->send($to, $headers, $body);
  if (PEAR::isError($mail)) {
    echo('<p>' . $mail->getMessage() . '</p>');
    return false;
  } else {
    //echo('<p>Message successfully sent!</p>');
    return true;
  }
}

?>
