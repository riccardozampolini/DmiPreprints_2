<?php

//inserimento di un nuovo account(registrazione nuovo utente)
include '../conf.php';
include '../mysql/db_conn.php';
include '../mysql/functions.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (isset($_POST['mail'])) {
  $email = $_POST['mail'];
  $email = trim($email);
  //generazione chiave hash password
  $sql = "SELECT COUNT(*) AS TOTALFOUND FROM ACCOUNTS WHERE email='" . $email . "'";
  $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
  $row = mysqli_fetch_array($query);
  #chiusura connessione al database
  mysqli_close($db_connection);
  if ($row['TOTALFOUND'] > 0 && sendResetMail($email)) {
    //invio della mail per il reset della password
    echo "The link to reset the password is sent to your email address!";
  } else {
    echo "The email address you entered does not exist!<br/>Wait 10 seconds to try again.";
    echo '<script type="text/javascript">setTimeout(function(){location.reload();}, 10000);</script>';
  }
}
?>
