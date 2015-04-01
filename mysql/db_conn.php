<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/dmipreprints/' . 'impost_car.php';
$db_connect;

function connettiDBManager() {
    global $db_connect, $mysql_addr, $mysql_user, $mysql_pass;
    $db_connect = new mysqli($mysql_addr, $mysql_user, $mysql_pass) or die('errore connessione mysql');
}

function selezionaSchema() {
    global $db_connect;
    mysqli_select_db($db_connect, 'dmipreprints') or die('Could not select database');
}

function disconnettiDBManager() {
    
}
