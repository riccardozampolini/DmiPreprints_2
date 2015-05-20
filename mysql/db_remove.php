<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/dmipreprints/'.'mysql/db_conn.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/dmipreprints/'.'mysql/db_sec.php';

function rimuoviPaper($id_PAPER){
    connettiDBManager();
    selezionaSchema();
    global $db_connect;
    $query = 'delete from PRINTS where id_PRINTS=' . $id_PAPER;
    
    $result = mysqli_query($db_connect, $query) or die(mysqli_error($db_connect));
    echo 'rimosso print id:'.$id_PAPER;
    mysqli_close($db_connect);
    return $result;
}

?>