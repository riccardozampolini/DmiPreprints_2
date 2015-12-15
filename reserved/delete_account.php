<?php
//cancellazione dell'account registrato
include '../header.inc.php';
include '../mysql/db_conn.php';
include '../authorization/auth.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (isset($_POST['mail'])) {
    $email = $_POST['mail'];
    //generazione chiave hash password
    $sql = "DELETE FROM ACCOUNTS WHERE email='".$email."'";
    $query = mysqli_query($db_connection, $sql) or die(mysql_error());
    //chiusura connessione al database
    mysqli_close($db_connection);
    echo "<br/><br/>Your account has been deleted successfully!";
    session_start();
	session_unset();
	session_destroy();
	echo '<META HTTP-EQUIV="Refresh" Content="2; URL=./reserved.php">';
}
?>
