<?php

//inserimento di un nuovo account(registrazione nuovo utente)
include '../conf.php';
include '../mysql/db_conn.php';
include '../mysql/functions.php';
include '../authorization/auth.php';
//se settati correttamente i campi entro
if (isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['mail']) && isset($_POST['password'])) {
    $name = $_POST['name']; //nome
    $sname = $_POST['surname']; //cognome
    $email = $_POST['mail']; //email
    $password = $_POST['password']; //password
    if (!SearchAccount($email)) {//controllo se account e gia esistente
        $name = trim($name); //rimozione degli spazi all'inizio e alla fine
        $name = ucwords($name);
        $sname = trim($sname); //rimozione degli spazi all'inizio e alla fine
        $sname = ucwords($sname);
        $email = trim($email); //rimozione degli spazi all'inizio e alla fine
        //controllo dei dati registrazione e se la mail e stata inviata correttamente
        if (ControllaDatiRegistrazione($email, $name, $sname, $password) && sendConfirmMail($email, $name . " " . $sname)) {
            //generazione chiave hash password
            $hash = md5($password);
            $sql = "INSERT INTO ACCOUNTS (nome, cognome, email, password) VALUES ('" . $name . "','" . $sname . "','" . $email . "','" . $hash . "') ON DUPLICATE KEY UPDATE email = VALUES(email)";
            $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
            //chiusura connessione al database
            mysqli_close($db_connection);
            //avviso di conferma
            echo "Your account is successfully created!<br/> Check your email to complete the registration.";
        } else {
            //errore nella registrazione
            echo "Error, data not correct!";
        }
    } else {
        //errore l'account e gia presente
        echo "Account already exist!";
    }
}
?>
