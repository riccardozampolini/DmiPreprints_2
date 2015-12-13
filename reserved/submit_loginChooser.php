<?php

require_once './authorization/sec_sess.php';
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
    echo '<div id="left_content">
          	<input id="input_uid" class="textbox" style="height: 14pt;" placeholder="Enter uid or email" required>
          	<input type="password" id="input_pw" class="textbox" style="height: 14pt;" placeholder="Enter password" required>
          	<br/><br/>
          	<button id="button_login" style="width: 110px;" onclick="chkLogin()" class="button">Login</button>
	  </div>
	  <div id="right_content"></div>';
}
?>
