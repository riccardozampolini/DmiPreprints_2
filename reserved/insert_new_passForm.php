<?php

//form creazione nuovo account
echo '<div id="top_content">
Please enter your new password:<br/><br/>
<input type="password" id="pw1" class="textfield" placeholder="Enter new password" required maxlength="100" required><br/>
<input type="password" id="pw2" class="textfield" placeholder="Retype new password" required maxlength="100" required><br/>
<input type="text" id="tk" value=\'' . $_GET['token'] . '\' hidden><br/>
<button id="button_insert" class="buttonlink" onclick="chkInsertReset()">Send</button>
</div>
<div id="bottom_content"></div>';
?>
