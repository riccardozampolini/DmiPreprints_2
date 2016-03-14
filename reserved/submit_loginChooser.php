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
        exit();
    } else {
        if ($_SESSION['logged_type'] === "mod") {
            //sessione moderatore
            header('Location:./modp.php');
            exit();
        } else {
            echo 'Credentials not alowed!';
        }
    }
} else {
    //deve fare login
    echo '<div id="left_content">
          	<input type="text" id="input_uid" class="textfield" placeholder="Enter UID or email" autocomplete = "on" required>
          	<input type="password" id="input_pw" class="textfield" placeholder="Enter password" required>
          	<br/><br/>
          	<button id="button_login" onclick="chkLogin()" class="buttonlink">Login</button>
	  </div>
	  <div id="right_content"></div><br/>';
}
?>
