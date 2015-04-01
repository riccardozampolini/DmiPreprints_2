<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/dmipreprints/'.'mysql/db_conn.php';

function approvaPaper($id_PAPER){
    global $db_connect;
    connettiDBManager();
    mysqli_select_db($db_connect, 'dmipreprints') or die('Could not select database');
    
    $query = "UPDATE PRINTS set approvato=1 ".'where id_PRINTS='.$id_PAPER;
    $result = mysqli_query($db_connect, $query) or die('\n\nQuery failed: ' . mysqli_error($db_connect));
    return $result;
}