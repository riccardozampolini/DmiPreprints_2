<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'authorization/sec_sess.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'mysql/db_remove.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'mysql/db_select.php';
sec_session_start();
if (isset($_POST['id'])) {
    eliminaFile($_POST['id']);
} else {
    echo 'removefile: parametro post non impostato';
}

function eliminaFile($id_PAPER) {
    $result = interrogaPerIdPaper($id_PAPER);
    $rigaSQL = mysqli_fetch_array($result);

    $pathCompleto = $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'reserved/uploads/' . $rigaSQL['nome_file'];
    $ris = unlink($pathCompleto);

    if ($ris === TRUE) {
        rimuoviPaper($id_PAPER);
    } else {
        echo 'errore rimoz file';
    }

    return $ris;
}
