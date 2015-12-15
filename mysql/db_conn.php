<?php

//connessione al database
//creazione della connessione
$db_connection = mysqli_connect($hostname_db, $username_db, $password_db, $db_monte);
//controllo della connessione
if (!$db_connection) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
