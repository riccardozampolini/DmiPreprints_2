<!DOCTYPE html>
<html>
    <head>
        <title>DMI Papers</title>
        <!--<script src="js/jquery.min.js"></script>-->
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
        <script src="js/allscript.js"></script>
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
            For access use username and password of the University(University of Perugia),
            for those outside University of Perugia you can register and use the email 
            provided during the registration.
        </div><br/><br/>
        <h1>Login:</h1><br/>
        <?php
        //TEST DEBUG
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        require_once './reserved/submit_loginChooser.php';
        ?>
        <br/><br/>
        <h1>Register:</h1><br/>
        <?php
        //TEST DEBUG
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        require_once './reserved/add_accountForm.php';
        ?>
    </center>
</body>
</html>
