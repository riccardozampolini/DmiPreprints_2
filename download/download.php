<?php
if (isset($_GET) && isset($_GET['file'])) {
    #$filename = filter_input($_GET['file']); //path assoluto al file sul server
    $path = $_SERVER['DOCUMENT_ROOT'].'/dmipreprints/'.'reserved/uploads/'.$_GET['file'];
    header('Pragma: public');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Cache-Control: private', false);
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . basename($path) . '";');
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . filesize($path));

    readfile($path);

    exit;
}

?>