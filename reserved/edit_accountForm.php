<?php

//form creazione nuovo account
echo '<div id="top_content">
	<div style="width:295px; text-align:right; margin:2px;">
		Registration date: ' . $info['registrazione'] . '
	</div>
	<div style="width:360px; text-align:right; margin:2px;">
		<font style="width:180px;">Enter name:</font><input type="text" id="name" value="' . $info['nome'] . '" class="textbox" style="height: 14pt; width:180px;" placeholder="example: Mario" required maxlength="100">
	</div>
	<div style="width:360px; text-align:right; margin:2px;">
        	<font style="width:180px;">Enter surname:</font><input type="text" id="surname" value="' . $info['cognome'] . '" class="textbox" style="height: 14pt; width:180px;" placeholder="example: Rossi" required maxlength="100">
        </div>
        <div style="width:360px; text-align:right; margin:2px;">
        	<font style="width:180px;">Enter email:</font><input type="email" id="email" value="' . $info['email'] . '" class="textbox" style="height: 14pt; width:180px;" placeholder="example@abc.com" required maxlength="100">
        	<input type="email" id="emailold" value="' . $info['email'] . '" class="textbox" style="height: 14pt; width:180px;" placeholder="example@abc.com" required maxlength="100" hidden>
        </div>
        <div style="width: 45%;"><br/><br/>
			   <h1>Fill in the following fields only if you want to change your password.</h1>
			</div><br/>
        <div style="width:360px; text-align:right; margin:2px;">
        	<font style="width:180px;">Enter old password:</font><input type="password" id="pw0" class="textbox" style="height: 14pt; width:180px;" placeholder="your old password" maxlength="100">
        	<input type="text" id="pwd" value="' . $info['password'] . '" class="textbox" style="height: 14pt; width:180px;" placeholder="your old password" maxlength="100" hidden>
        </div>
        <div style="width:360px; text-align:right; margin:2px;">
        	<font style="width:180px;">Enter new password:</font><input type="password" id="pw1" class="textbox" style="height: 14pt; width:180px;" placeholder="new password(least 6 char)" maxlength="100">
        </div>
        <div style="width:360px; text-align:right; margin:2px;">
        	<font style="width:180px;">Re-enter new password:</font><input type="password" id="pw2" class="textbox" style="height: 14pt; width:180px;" placeholder="retype new password" maxlength="100">
        </div style="width:360px;">
        <br/><button id="button_login" style="width: 110px;" class="button" onclick="chkAccountUpdate()">Submit</button>
    	</div>';
?>
