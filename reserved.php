<!DOCTYPE html>
<html>
    <head>
        <title>DMI Papers</title>
        <!--<script src="js/jquery.min.js"></script>-->
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
        <script src="js/config.js"></script>
        <script src="js/skel.min.js"></script>
        <script src="js/skel-panels.min.js"></script>
        <noscript>
        <link rel="stylesheet" href="css/skel-noscript.css" />
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="css/style-desktop.css" />
        </noscript>
        <link rel="stylesheet" type="text/css" href="css/main.css">
        <!--[if lte IE 9]><link rel="stylesheet" href="css/ie9.css" /><![endif]-->
        <!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->
    </head>
    <body>
        <script>
            function logout() {
                $("#container_principale").load("reserved/logout.php", function () {
                    $("#container_principale").load("reserved/submit_loginChooser.php", function () {
                        location.reload(true);
                    });
                });
            }
            function chkLogin() {
                var uidV = $('#input_uid').val();
                var pwV = $('#input_pw').val();
                $("#left_content").load("reserved/submit_loginCheck.php", {uid: uidV, pw: pwV}, function () {
                    $("#right_content").load("reserved/submit_loginChooser.php");
                    location.reload(true);
                });
            }
        </script>
        <?php
        ?>
        <div id="header-wrapper">
            <div class="container">
                <div class="row">
                    <div class="12u">
                        <header id="header">
                            <h1><a href="#" id="logo">DMI Papers</a></h1>
                            <nav id="nav">
                                <a href="./view_preprints.php">Publications</a>
                                <a href="./reserved.php" class="current-page-item">Reserved Area</a>
                            </nav>
                        </header>
                    </div>
                </div>
            </div>
        </div>
        <br/><br/>
    <center>
        <div style="width: 45%;">
            <h1>It is the first time you access here?</h1><br/>
            For access use username and password of the University xxxxxx@unipg.it,
            for those outside University of Perugia you can register and use the credentials 
            provided during the registration.
        </div><br/><br/>
        <div>
            <?php
            //TEST DEBUG
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            require_once './reserved/submit_loginChooser.php';
            ?>
        </div><br/><br/><br/><br/>
        <div>
            <h1>Register:</h1><br/>
            <div id="left_content">
                <form name="f2" action="" method="post">
                    <table>
                        <tr>
                            <td align="right"> Enter email:<br/></td>
                            <td><input type="email" class="textbox" style="height: 14pt;" placeholder="example@abc.com" required maxlength="100"></td>
                        </tr>
                        <tr>
                            <td align="right">Enter username:<br/></td>
                            <td><input type="text" class="textbox" style="height: 14pt;" placeholder="uid" required maxlength="100"></td>
                        </tr>
                        <tr>
                            <td align="right">Enter password:<br/></td>
                            <td><input type="password" id="input_pw" class="textbox" style="height: 14pt;" placeholder="password(min 6 char)" required minlenght="6" maxlength="100"></td>
                        </tr>
                        <tr>
                            <td align="right">Re-enter password:<br/></td>
                            <td><input type="password" id="input_pw2" class="textbox" style="height: 14pt;" placeholder="retype password" required minlenght="6" maxlength="100"></td>
                        </tr>
                    </table>
                </form>
                <div style="margin: 0 auto"><br/>
                    <button id="button_login" style="width: 110px;" class="button">Submit</button>
                </div>
            </div>
            <div id="right_content"></div>

        </div>
    </center>
</body>
</html>
