<!DOCTYPE html>
<html>
    <head>
        <title>DMIPreprints</title>
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
        <link rel="stylesheet" type="text/css" href="css/tabelle.css">
        <link rel="stylesheet" type="text/css" href="css/main.css">
        <link rel="stylesheet" type="text/css" href="css/controlli.css">
        <link rel="stylesheet" type="text/css" href="css/uploadForm.css">
        <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'>
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
        <div id="header-wrapper">
            <div class="container">
                <div class="row">
                    <div class="12u">

                        <header id="header">
                            <h1><a href="#" id="logo">DMI Preprints</a></h1>
                            <nav id="nav">
                                <a href="main.php">preprint search</a>
                                <a href="reserved.php" class="current-page-item">Reserved Area</a>
                            </nav>
                        </header>

                    </div>
                </div>
            </div>
        </div>
        <div id="container_principale" class="contenitore">
            <?php
            //TEST DEBUG
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            require_once $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'reserved/submit_loginChooser.php';
            ?>
        </div>
    </body>
</html>
