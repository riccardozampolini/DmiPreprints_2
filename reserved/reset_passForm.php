<?php

//form creazione nuovo account
echo '<div id="top_content">
<div style="width: 45%;">
<h1>You forgot your login credentials?</h1><br/>
To reset your password please enter the email address provided during registration.
</div><br/><br/>
Enter email:<input type="email" id="email" class="textfield" placeholder="example@abc.com" required maxlength="100">
<button id="button_reset" class="buttonlink" onclick="chkReset()">Send</button>
</div>
<div id="bottom_content"></div>';
?>
