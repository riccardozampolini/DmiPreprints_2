<?php

//import dei parametri per la connessione
include './header.inc.php';
//connessione al database
$db_connection = mysql_connect($hostname_db, $username_db, $password_db) or die(mysql_error());
mysql_select_db($db_monte, $db_connection) or die(mysql_error());
?>
