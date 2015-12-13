<?php

#funzione incremento contatore visualizzazioni
#importazione variabili globali
include '../header.inc.php';
require_once '../authorization/sec_sess.php';
sec_session_start();
#connessione al database...
$db_connection = mysql_connect($hostname_db, $username_db, $password_db) or trigger_error(mysql_error(), E_USER_ERROR);
mysql_select_db($db_monte, $db_connection);
#acquisizione valore
$id = $_GET['id'];
$sql = "SELECT * FROM PREPRINTS WHERE id_pubblicazione='" . $id . "'";
$query = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_array($query);
if ($_SESSION['nome'] . " (" . $_SESSION['uid'] . ")" != $row['uid']) {
    #incremento valore
    $sql = "UPDATE PREPRINTS SET counter='" . ($row['counter'] + 1) . "' WHERE id_pubblicazione='" . $id . "'";
    $query = mysql_query($sql) or die(mysql_error());
}
#chiusura connessione al database
mysql_close($db_connection);
#reindirizzamento al pdf
header('Location:.' . $copia . $row['Filename']);
exit;
?>
