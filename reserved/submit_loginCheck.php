<?php

require_once '../header.inc.php';
require_once '../authorization/sec_sess.php';
require_once '../authorization/auth.php';

if (isset($_POST['uid']) && isset($_POST['pw'])) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    global $mod_uid;
    $inputUID = $_POST['uid'];
    $inputPass = $_POST['pw']; //la password di ateneo può contenere car speciali
    if (!$ldapoff) {
        if (InternalAuth($inputUID, $inputPass)) {
            sec_session_start();
            $_SESSION['logged_type'] = "user";
            $_SESSION['nome'] = GetNameAuth($inputUID);
            $_SESSION['uid'] = $inputUID;
            $_SESSION['LAST_ACTIVITY'] = time(); //aggiorna timestamp sessione
            UpdateLastAuth($inputUID); //aggiorna timestamp database
            echo "Successful login!";
            echo '<META HTTP-EQUIV="REFRESH" CONTENT="1; URL=./reserved.php">';
        } else {
            $output_ldap = LDAPAuth($inputUID); //chiamata LDAP
            if ($output_ldap['count'] == 1) {
                if (RADIUSAuth($inputUID, $inputPass)) {
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
                    echo "Incorrect credentials!<br/>If you forgot the password click 
        	<a href='./recovery_account.php' style='color:#007897;'>here</a>, or wait 10 seconds to try again.";
                    echo '<META HTTP-EQUIV="REFRESH" CONTENT="10; URL=./reserved.php">';
                }
            } else {
                echo "Incorrect credentials!<br/>If you forgot the password click 
        	<a href='./recovery_account.php' style='color:#007897;'>here</a>, or wait 10 seconds to try again.";
                echo '<META HTTP-EQUIV="REFRESH" CONTENT="10; URL=./reserved.php">';
            }
        }
    } else {
        if (InternalAuth($inputUID, $inputPass)) {
            sec_session_start();
            $_SESSION['logged_type'] = "user";
            $_SESSION['nome'] = GetNameAuth($inputUID);
            $_SESSION['uid'] = $inputUID;
            $_SESSION['LAST_ACTIVITY'] = time(); //aggiorna timestamp sessione
            UpdateLastAuth($inputUID); //aggiorna timestamp database
            echo "Successful login!";
            echo '<META HTTP-EQUIV="REFRESH" CONTENT="1; URL=./reserved.php">';
        } else {
            echo "Incorrect credentials!<br/>If you forgot the password click 
        	<a href='./recovery_account.php' style='color:#007897;'>here</a>, or wait 10 seconds to try again.";
            echo '<META HTTP-EQUIV="REFRESH" CONTENT="10; URL=./reserved.php">';
        }
    }
} else {
    echo 'DEBUG: parametri POST non impostati';
}
?>
