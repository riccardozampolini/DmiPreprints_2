<?php

//inserimento di un nuovo account(registrazione nuovo utente)
include '../conf.php';
include '../mysql/db_conn.php';
include '../mysql/functions.php';
include '../authorization/auth.php';
//se campi impostati correttamente
if (isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['mail']) && isset($_POST['mailold'])) {
  $name = $_POST['name'];
  $sname = $_POST['surname'];
  $email = $_POST['mail'];
  $emailold = $_POST['mailold'];
  $password = $_POST['password'];
  $passwordold = $_POST['passwordold'];
  $passworddat = $_POST['passworddat'];
  $name = trim($name); //rimozione spazi
  $name = ucwords($name); //prima lettera maiuscola
  $sname = trim($sname); //rimozione spazi
  $sname = ucwords($sname); //prima lettera maiuscola
  $email = trim($email); //rimozione spazi
  $emailold = trim($emailold); //rimozione spazi
  if (isset($_POST['password']) && $_POST['password'] != "") {//quando password viene modificata
    $hash = md5($password); //generazione chiave hash password
    $passwordold = md5($passwordold); //generazione chiave hash password vecchia
    if ($passworddat == $passwordold) {//se sono uguali procedo
      if ($_POST['mail'] != $_POST['mailold']) {//quando email viene modificata
        if (!SearchAccount($email)) {//controllo se nuova email gia presente
          //
          $sql = "UPDATE PREPRINTS SET uid='" . $email . "' WHERE uid='" . $emailold . "'";
          $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
          //
          $sql = "UPDATE ACCOUNTS SET nome='" . $name . "', cognome='" . $sname . "', email='" . $email . "', password='" . $hash . "' WHERE email='" . $emailold . "'";
          $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
          //chiusura della sessione avviata
          session_start();
          session_unset();
          session_destroy();
          //
          sendEmailChanged($emailold, $email);
          echo "<br/><br/>Your account information is successfully updated, you decided to change the email,<br/> the session will be terminated, you must run in again with new email!";
          echo '<META HTTP-EQUIV="Refresh" Content="5; URL=./reserved.php">';
        } else {
          echo "<br/><br/>Error, inserted email already exist!";
          echo '<META HTTP-EQUIV="Refresh" Content="2; URL=./profile.php">';
        }
      } else {//quando email non viene modificata
        //invio email di avviso
        sendPassConfirmMail($emailold);
        $sql = "UPDATE ACCOUNTS SET nome='" . $name . "', cognome='" . $sname . "', email='" . $email . "', password='" . $hash . "' WHERE email='" . $email . "'";
        $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
        echo "<br/><br/>Your account information is successfully updated!";
        echo '<META HTTP-EQUIV="Refresh" Content="2; URL=./reserved.php">';
      }
    } else {
      echo "<br/><br/>Error, old password incorrect!";
      echo '<META HTTP-EQUIV="Refresh" Content="2; URL=./profile.php">';
    }
  } else {//quando password non viene modificata
    if ($_POST['mail'] != $_POST['mailold']) {//quando email viene modificata
      if (!SearchAccount($email)) {//controllo se account gia esistente
        //
        $sql = "UPDATE PREPRINTS SET uid='" . $email . "' WHERE uid='" . $emailold . "'";
        $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
        //
        $sql = "UPDATE ACCOUNTS SET nome='" . $name . "', cognome='" . $sname . "', email='" . $email . "' WHERE email='" . $emailold . "'";
        $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
        //chiusura della sessione
        session_start();
        session_unset();
        session_destroy();
        //
        sendEmailChanged($emailold, $email);
        echo "<br/><br/>Your account information is successfully updated, it is decided to change the email,<br/> the session will be terminated, you must run in again with new email!";
        echo '<META HTTP-EQUIV="Refresh" Content="5; URL=./reserved.php">';
      } else {
        echo "<br/><br/>Error, inserted email already exist!";
        echo '<META HTTP-EQUIV="Refresh" Content="2; URL=./profile.php">';
      }
    } else {//quando email non viene modificata
      $sql = "UPDATE ACCOUNTS SET nome='" . $name . "', cognome='" . $sname . "', email='" . $email . "' WHERE email='" . $email . "'";
      $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
      echo "<br/><br/>Your account information is successfully updated!";
      echo '<META HTTP-EQUIV="Refresh" Content="2; URL=./reserved.php">';
    }
  }
  //chiusura connessione al database
  mysqli_close($db_connection);
}
?>
