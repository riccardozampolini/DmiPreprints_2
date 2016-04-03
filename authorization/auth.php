<?php

function LDAPAuth($UID) {
  global $ldaphost, $ldapport;
  $ldapconn = ldap_connect($ldaphost, $ldapport) or die("errore connessione LDAP server:  $ldaphost");
  ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
  $ds = $ldapconn;
  $dn = "ou=users,dc=dmi,dc=unipg,dc=it";
  //l'utente deve avere la licenza all'uso di dmipreprints
  $filter = "(&(carLicense=dmipreprints)(uid=$UID))";
  //selezione dei campi di interesse per il ritorno
  $justthese = array("sn");
  //ricerca nell'albero LDAP
  $sr = ldap_search($ds, $dn, $filter, $justthese);
  $info = ldap_get_entries($ds, $sr);
  return $info;
}

function RADIUSAuth($UID, $PASSWORD) {
  global $ip_radius_server, $shared_secret;
  require_once './radius.class.php';
  $radius = new Radius($ip_radius_server, $shared_secret);
  $result = $radius->AccessRequest($UID, $PASSWORD);
  if ($result) {
    echo 'RADIUS OK';
    return true;
  } else {
    echo 'RADIUS ERRORE';
    return false;
  }
}

function InternalAuth($UID, $PASSWORD) {
  global $db_connection;
  //controllo del formato uid
  if (empty($UID)) {
    return false;
  } else if (!filter_var(trim($UID), FILTER_VALIDATE_EMAIL)) {
    return false;
  } else if (strlen($PASSWORD) < 6) {
    return false;
  }
  $hash = md5($PASSWORD);
  //query
  $sql = "SELECT COUNT(*) AS TOTALFOUND FROM ACCOUNTS WHERE email='" . addslashes($UID) . "' AND password='" . $hash . "' AND verificato='yes'";
  $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
  $row = mysqli_fetch_array($query);
  if ($row['TOTALFOUND'] > 0) {
    return true;
  } else {
    return false;
  }
}

function SearchMods($UID) {
  global $db_connection;
  //query
  $sql = "SELECT COUNT(*) AS TOTALFOUND FROM ADMINISTRATORS WHERE uid='" . addslashes($UID) . "'";
  $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
  $row = mysqli_fetch_array($query);
  if ($row['TOTALFOUND'] > 0) {
    return true;
  } else {
    return false;
  }
}

function confirm_account($token) {
  global $db_connection;
  //query di aggiornamento
  $sql = "UPDATE ACCOUNTS SET verificato='yes' WHERE MD5(email)='" . $token . "'";
  $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
  return true;
}

function get_token_password_account($token) {
  global $db_connection;
  $a = time();
  $b = date('d M y', $a);
  //query
  $sql = "SELECT COUNT(*) AS TOTALFOUND FROM ACCOUNTS WHERE MD5(CONCAT(email,'" . $b . "'))='" . $token . "'";
  $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
  $row = mysqli_fetch_array($query);
  if ($row['TOTALFOUND'] > 0) {
    return true;
  } else {
    return false;
  }
}

function get_email_from_token($token) {
  global $db_connection;
  //token
  $a = time();
  $b = date('d M y', $a);
  //query
  $sql = "SELECT * FROM ACCOUNTS WHERE MD5(CONCAT(email,'" . $b . "'))='" . $token . "'";
  $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
  $row = mysqli_fetch_array($query);
  return $row['email'];
}

function reset_password_account($password, $token) {
  global $db_connection;
  $a = time();
  $b = date('d M y', $a);
  //query di aggiornamento
  $sql = "UPDATE ACCOUNTS SET password='" . $password . "' WHERE MD5(CONCAT(email,'" . $b . "'))='" . $token . "'";
  $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
  return true;
}

function GetNameAuth($UID) {
  global $db_connection;
  $sql = "SELECT nome,cognome FROM ACCOUNTS WHERE email='" . $UID . "'";
  $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
  $row = mysqli_fetch_array($query);
  return $row['nome'] . " " . $row['cognome'];
}

function UpdateLastAuth($UID) {
  global $db_connection;
  $sql = "UPDATE ACCOUNTS SET `accesso`='" . date("c", time()) . "' WHERE `email`='" . $UID . "'";
  $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
}

function SearchAccount($UID) {
  global $db_connection;
  $sql = "SELECT COUNT(*) AS TOTALFOUND FROM ACCOUNTS WHERE email='" . $UID . "'";
  $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
  $row = mysqli_fetch_array($query);
  if ($row['TOTALFOUND'] > 0) {
    return true;
  } else {
    return false;
  }
}

function SearchAccountUser($UID) {
  global $db_connection;
  #verifica se esistono preprints precedenti e li sposto...
  $sql = "SELECT COUNT(*) AS TOTALFOUND FROM ACCOUNTS WHERE email='" . $UID . "'";
  $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
  $row = mysqli_fetch_array($query);
  if ($row['TOTALFOUND'] > 0) {
    return true;
  } else {
    return false;
  }
}

//funzione controllo correttezza dati inseriti per la registrazione
function ControllaDatiRegistrazione($email, $name, $sname, $password) {
  // se la stringa è vuota sicuramente non è una mail
  if (empty($email)) {
    return false;
  } else if (empty($name)) {
    return false;
  } else if (empty($sname)) {
    return false;
  } else if (empty($password)) {
    return false;
  } else if (!filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
    return false;
  } else if (strlen($password) < 6) {
    return false;
  } else {
    return true;
  }
}

?>
