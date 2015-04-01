<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'authorization/sec_sess.php';
sec_session_start();

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 900)) {
    //scadenza temporale sessione dopo 15 minuti
    echo 'sessione scaduta';
    session_unset();
    session_destroy();
}
if (isset($_SESSION['logged_type'])) {
    if ($_SESSION['logged_type'] === "user") {
        //sessione utente
        require_once $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'reserved/controlPanel_user.php';
    } else {
        if ($_SESSION['logged_type'] === "mod") {
            //sessione moderatore
            require_once $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'reserved/controlPanel_mod.php';
        } else {
            echo 'errore login chooser';
        }
    }
} else {
    //deve fare login
    require_once $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'reserved/submit_loginForm.php';
}
?>
