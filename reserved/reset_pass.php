<?php

//inserimento di un nuovo account(registrazione nuovo utente)
include '../header.inc.php';
include '../mysql/db_conn.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (isset($_POST['mail'])) {
    $email = $_POST['mail'];
    //generazione chiave hash password
    $sql = "SELECT COUNT(*) AS TOTALFOUND FROM ACCOUNTS WHERE email='" . $email . "'";
    $query = mysqli_query($db_connection, $sql) or die(mysql_error());
    $row = mysqli_fetch_array($query);
    #chiusura connessione al database
    mysqli_close($db_connection);
    if ($row['TOTALFOUND'] > 0) {
    	//invio della mail per il reset
        echo "The link to reset the password is sent to your email address! (if the mail is not arrived, try again)";
    } else {
        echo "The email address you entered does not exist!<br/>Wait 10 seconds to try again.";
        echo '<META HTTP-EQUIV="REFRESH" CONTENT="10; URL=./recovery_account.php">';
    }
}
?>
