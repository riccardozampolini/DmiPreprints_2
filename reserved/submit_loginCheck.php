<?php

require_once '../conf.php';
require_once '../mysql/db_conn.php';
require_once '../authorization/sec_sess.php';
require_once '../authorization/auth.php';

if (isset($_POST['uid']) && isset($_POST['pw'])) {
    //error_reporting(E_ALL);
    //ini_set('display_errors', 1);
    //global $mod_uid;
    $inputUID = $_POST['uid'];
    $inputPass = $_POST['pw']; //la password di ateneo può contenere car speciali
    //controllo i dati per il login
//disattiva ldap se true
    if (!$ldapoff) {
        if (InternalAuth($inputUID, $inputPass)) {
            sec_session_start();
            $_SESSION['logged_type'] = "user";
            $_SESSION['nome'] = GetNameAuth($inputUID);
            $_SESSION['uid'] = $inputUID;
            $_SESSION['LAST_ACTIVITY'] = time(); //aggiorna timestamp sessione
            UpdateLastAuth($inputUID); //aggiorna timestamp database
            echo 'Successful login!<script type="text/javascript">location.reload();</script>';
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
                    echo 'Incorrect credentials!<br/>If you forgot the password click <a href="./recovery_account.php" style="color:#1976D2;">here</a>, or wait 10 seconds to try again. <script type="text/javascript">setTimeout(function(){location.reload();}, 10000);</script>';
                }
            } else {
                echo 'Incorrect credentials!<br/>If you forgot the password click <a href="./recovery_account.php" style="color:#1976D2;">here</a>, or wait 10 seconds to try again. <script type="text/javascript">setTimeout(function(){location.reload();}, 10000);</script>';
            }
        }
    } else {
        if (InternalAuth($inputUID, $inputPass)) {
            //if (true){
            sec_session_start();
            $_SESSION['logged_type'] = "mod";
            $_SESSION['nome'] = GetNameAuth($inputUID);
            $_SESSION['uid'] = $inputUID;
            $_SESSION['LAST_ACTIVITY'] = time(); //aggiorna timestamp sessione
            UpdateLastAuth($inputUID); //aggiorna timestamp database
            echo 'Successful login!<script type="text/javascript">location.reload();</script>';
            exit;
        } else {
            echo 'Incorrect credentials!<br/>If you forgot the password click <a href="./recovery_account.php" style="color:#1976D2;">here</a>, or wait 10 seconds to try again. <script type="text/javascript">setTimeout(function(){location.reload();}, 10000);</script>';
        }
    }
} else {
    echo 'DEBUG: parametri POST non impostati';
}
?>
