<?php

//form creazione nuovo account
echo '<div id="top_content">
	<div>
		Registration date: ' . $info['registrazione'] . '
	</div>
	<div>
		<input type="text" id="name" value="' . $info['nome'] . '" class="textfield" placeholder="Enter name" required maxlength="100">
	</div>
	<div>
        	<input type="text" id="surname" value="' . $info['cognome'] . '" class="textfield" placeholder="Enter surname" required maxlength="100">
        </div>
        <div>
        	<input type="email" id="email" value="' . $info['email'] . '" class="textfield" placeholder="example@abc.com" required maxlength="100">
        	<input type="email" id="emailold" value="' . $info['email'] . '" class="textbox" placeholder="example@abc.com" required maxlength="100" hidden>
        </div>
        <div style="width: 45%;"><br/><br/>
			   <h1>Fill in the following fields only if you want to change your password.</h1>
			</div><br/>
        <div>
        	<input type="password" id="pw0" class="textfield" placeholder="your old password" maxlength="100">
        	<input type="text" id="pwd" value="' . $info['password'] . '" class="textbox" placeholder="your old password" maxlength="100" hidden>
        </div>
        <div>
			<input type="password" id="pw1" class="textfield" placeholder="new password(least 6 char)" maxlength="100">
        </div>
        <div>
        	<input type="password" id="pw2" class="textfield" placeholder="retype new password" maxlength="100">
        </div>
        <br/><button id="button_login" style="width: 110px;" class="button" onclick="chkAccountUpdate()">Submit</button>
    	</div>';
?>
