<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'authorization/sec_sess.php';
sec_session_start();

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 86400)) {
    //scadenza temporale sessione dopo 24 ore
    echo 'sessione scaduta';
    session_unset();
    session_destroy();
}
if (isset($_SESSION['logged_type'])) {
    if ($_SESSION['logged_type'] === "user") {
        //sessione utente
        header('Location:./userp.php');
	exit;
    } else {
        if ($_SESSION['logged_type'] === "mod") {
            //sessione moderatore
            header('Location:./modp.php');
	    exit;
        } else {
            echo 'errore login chooser';
        }
    }
} else {
    //deve fare login
    require_once $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'reserved/submit_loginForm.php';
}
?>
