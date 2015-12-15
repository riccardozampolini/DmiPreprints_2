<?php

//inserimento di un nuovo account(registrazione nuovo utente)
include '../header.inc.php';
include '../mysql/db_conn.php';
include '../authorization/auth.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['mail']) && isset($_POST['mailold'])) {
    $name = $_POST['name'];
    $sname = $_POST['surname'];
    $email = $_POST['mail'];
    $emailold = $_POST['mailold'];
    $password = $_POST['password'];
    $passwordold = $_POST['passwordold'];
    $passworddat = $_POST['passworddat'];
    $name = trim($name);
    $name = ucwords($name);
    $sname = trim($sname);
    $sname = ucwords($sname);
    if (isset($_POST['password']) && $_POST['password'] != "") {
        //generazione chiave hash password
        $hash = md5($password);
        $passwordold = md5($passwordold);
        if ($passworddat == $passwordold) {
            if ($_POST['mail'] != $_POST['mailold']) {
                if (!SearchAccount($email)) {
                    $sql = "UPDATE ACCOUNTS SET nome='" . $name . "', cognome='" . $sname . "', email='" . $email . "', password='" . $hash . "' WHERE email='" . $emailold . "'";
                    $query = mysqli_query($db_connection, $sql) or die(mysql_error());
                    //chiusura della sessione
                    session_start();
                    session_unset();
                    session_destroy();
                    echo "<br/><br/>Your account information is successfully updated, you decided to change the email,<br/> the session will be terminated, you must run in again with new email!";
                    echo '<META HTTP-EQUIV="Refresh" Content="5; URL=./reserved.php">';
                } else {
                    echo "<br/><br/>Error, inserted email already exist!";
                    echo '<META HTTP-EQUIV="Refresh" Content="2; URL=./profile.php">';
                }
            } else {
                $sql = "UPDATE ACCOUNTS SET nome='" . $name . "', cognome='" . $sname . "', email='" . $email . "', password='" . $hash . "' WHERE email='" . $email . "'";
                $query = mysqli_query($db_connection, $sql) or die(mysql_error());
                echo "<br/><br/>Your account information is successfully updated!";
                echo '<META HTTP-EQUIV="Refresh" Content="2; URL=./reserved.php">';
            }
        } else {
            echo "<br/><br/>Error, old password incorrect!";
            echo '<META HTTP-EQUIV="Refresh" Content="2; URL=./profile.php">';
        }
    } else {
        if ($_POST['mail'] != $_POST['mailold']) {
            if (!SearchAccount($email)) {
                $sql = "UPDATE ACCOUNTS SET nome='" . $name . "', cognome='" . $sname . "', email='" . $email . "' WHERE email='" . $emailold . "'";
                $query = mysqli_query($db_connection, $sql) or die(mysql_error());
                session_start();
                session_unset();
                session_destroy();
                echo "<br/><br/>Your account information is successfully updated, it is decided to change the email,<br/> the session will be terminated, you must run in again with new email!";
                echo '<META HTTP-EQUIV="Refresh" Content="5; URL=./reserved.php">';
            } else {
                echo "<br/><br/>Error, inserted email already exist!";
                echo '<META HTTP-EQUIV="Refresh" Content="2; URL=./profile.php">';
            }
        } else {
            $sql = "UPDATE ACCOUNTS SET nome='" . $name . "', cognome='" . $sname . "', email='" . $email . "' WHERE email='" . $email . "'";
            $query = mysqli_query($db_connection, $sql) or die(mysql_error());
            echo "<br/><br/>Your account information is successfully updated!";
            echo '<META HTTP-EQUIV="Refresh" Content="2; URL=./reserved.php">';
        }
    }
    //chiusura connessione al database
    mysqli_close($db_connection);
}
?>
