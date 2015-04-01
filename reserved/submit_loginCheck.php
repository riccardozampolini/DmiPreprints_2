<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'authorization/sec_sess.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'impost_car.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'authorization/auth.php';
if (isset($_POST['uid']) && isset($_POST['pw'])) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    global $mod_uid;
    $inputUID = $_POST['uid'];
    $inputPass = $_POST['pw']; //la password di ateneo può contenere car speciali
    $output_ldap = LDAPAuth($inputUID); //chiamata LDAP
    if ($output_ldap['count'] == 1) {
        echo "autorizzazione OK";
        if (RADIUSAuth($inputUID, $inputPass)) {
            echo "autenticazione OK";
            sec_session_start();
            if ($_POST['uid'] === $mod_uid) {
                $_SESSION['logged_type'] = "mod";
            } else {
                $_SESSION['logged_type'] = "user";
            }
            $_SESSION['uid'] = $inputUID;
            $_SESSION['nome'] = $output_ldap[0]['sn'][0];
            $_SESSION['LAST_ACTIVITY'] = time(); //aggiorna timestamp sessione
        } else {
            print_r("\nNO autenticazione\n");
        }
    } else {
        echo print_r("\nNO autorizzazione\n");
    }
} else {
    echo 'DEBUG: parametri POST non impostati';
}
?>
