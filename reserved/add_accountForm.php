<?php

//form creazione nuovo account
echo '<div id="top_content" align="center">
	<input type="text" id="name" class="textfield" placeholder="Enter your name" required maxlength="100"><br/>
	<input type="text" id="surname" class="textfield" placeholder="Enter your surname" required maxlength="100"><br/>
        <input type="email" id="email" class="textfield" placeholder="Enter your email" required maxlength="100"><br/>
        <input type="password" id="pw" class="textfield" placeholder="Password(least 6 char)" required maxlength="100"><br/>
        <input type="password" id="pw2" class="textfield" placeholder="Retype password" required maxlength="100"><br/><br/>
        <button id="button_login" class="button" onclick="chkRegistration()">Submit</button>
    </div>
    <div id="bottom_content"></div>';
?>
