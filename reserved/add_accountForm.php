<?php

//form creazione nuovo account
echo '<div id="top_content">
	<div style="width:320px; text-align:right; margin:2px;">
		Enter name:<input type="text" id="name" class="textbox" style="height: 14pt; width:160px;" placeholder="example: Mario" required maxlength="100">
	</div>
	<div style="width:320px; text-align:right; margin:2px;">
        	Enter surname:<input type="text" id="surname" class="textbox" style="height: 14pt; width:160px;" placeholder="example: Rossi" required maxlength="100">
        </div>
        <div style="width:320px; text-align:right; margin:2px;">
        	Enter email:<input type="email" id="email" class="textbox" style="height: 14pt; width:160px;" placeholder="example@abc.com" required maxlength="100">
        </div>
        <div style="width:320px; text-align:right; margin:2px;">
        	Enter password:<input type="password" id="pw" class="textbox" style="height: 14pt; width:160px;" placeholder="password(least 6 char)" required maxlength="100">
        </div>
        <div style="width:320px; text-align:right; margin:2px;">
        	Re-enter password:<input type="password" id="pw2" class="textbox" style="height: 14pt; width:160px;" placeholder="retype password" required maxlength="100">
        </div style="width:320px; text-align:right; margin:2px;">
        	<br/><button id="button_login" style="width: 110px;" class="button" onclick="chkRegistration()">Submit</button>
    	</div>
    <div id="bottom_content"></div>';
?>
