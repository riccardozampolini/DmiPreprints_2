<?php

//inserimento di un nuovo account(registrazione nuovo utente)
include '../conf.php';
include '../mysql/db_conn.php';
include '../mysql/functions.php';
include '../authorization/auth.php';
//se settati correttamente i campi entro
if (isset($_POST['password1']) && isset($_POST['password2']) && isset($_POST['tk'])) {
  $password1 = $_POST['password1']; //password1
  $password2 = $_POST['password2']; //password2
  $password1 = trim($password1); //rimozione degli spazi all'inizio e alla fine
  $password2 = trim($password2); //rimozione degli spazi all'inizio e alla fine
  $token = $_POST['tk']; //token
  if ($password1 === $password2) {//controllo se password corrispondono
    //recupero indirizzo email
    $email = get_email_from_token($token);
    //generazione chiave hash password
    if (sendPassConfirmMail($email)) {//invio mail di conferma
      $hash = md5($password1);
      reset_password_account($hash, $token);
      //chiusura connessione al database
      mysqli_close($db_connection);
      //avviso di conferma
      echo "Your password is successfully changed!";
    }
  } else {
    //errore
    echo "Error, passwords does not match!";
  }
} else {
  echo "Error!";
}
?>
