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
        <link rel="stylesheet" href="css/main.css" />
        <link rel="stylesheet" type="text/css" href="css/tabelle.css">
        <link rel="stylesheet" type="text/css" href="css/controlli.css">
        <script src="js/targetweb-modal-overlay.js"></script>
        <link href='css/targetweb-modal-overlay.css' rel='stylesheet' type='text/css'>
        <!--[if lte IE 9]><link rel="stylesheet" href="css/ie9.css" /><![endif]-->
        <!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->
        <script src="http://cdn.jsdelivr.net/webshim/1.12.4/extras/modernizr-custom.js"></script>
        <script src="http://cdn.jsdelivr.net/webshim/1.12.4/polyfiller.js"></script>
        <script>
            webshims.setOptions('waitReady', false);
            webshims.setOptions('forms-ext', {types: 'date'});
            webshims.polyfill('forms forms-ext');
        </script>
        <script type="text/x-mathjax-config">
            MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}});
        </script>
        <script type="text/javascript"
                src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
        </script>
        <script type="text/javascript" src="./js/allscript.js">
        </script>
    </head>
    <body>
        <?php
        #importo file per utilizzare funzioni...
        require_once './authorization/sec_sess.php';
        include_once './arXiv/check_nomi_data.php';
        include_once './arXiv/insert_remove_db.php';
        sec_session_start();
        echo "<div id='gotop' hidden><a id='scrollToTop' title='Go top'><img style='width:25px; height:25px;' src='./images/top.gif'></a></div>";
        if ($_COOKIE['searchbarall'] == "1") {
            #search bar
            require_once './searchbar_bottom.php';
        }
        if ($_SESSION['logged_type'] === "mod") {
            $nav = "<form name='f2' action='archived_preprints.php' method='GET'><div id='boxsx'>
		Delete all archived papers
		</div><div id='boxdx'><input type='submit' name='c' value='Remove all' id='bottone_keyword' class='button' onclick='return confirmDelete5()'/>
		</div></form>";
            $nav2 = "<header id='header'>
                                    <h1><a href='#' id='logo'>DMI Papers</a></h1>
                                    <nav id='nav'>
                                        <a href='./view_preprints.php' onclick='loading(load);'>Publications</a>
                                        <a href='./reserved.php' class='current-page-item' onclick='loading(load);'>Reserved Area</a>
                                    </nav>
                                </header>";
            $rit = "modp.php";
            $cred = 1;
        } else {
            $nav = "";
            $nav2 = "<header id='header'>
                                    <h1><a href='#' id='logo'>DMI Papers</a></h1>
                                    <nav id='nav'>
                                        <a href='./view_preprints.php' class='current-page-item' onclick='loading(load);'>Publications</a>
                                        <a href='./reserved.php' onclick='loading(load);'>Reserved Area</a>
                                    </nav>
                                </header>";
        }
        ?>
        <div onclick="myFunction2()">
            <div id="header-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="12u">
                            <?php echo $nav2; ?>
                        </div>
                    </div>
                </div>
            </div>
            <center>
                <div>
                    <br/>
                    <br/>
                    <h2>ARCHIVED PAPERS</h2></center>
        </div>
        <?php
        if ($cred == 1) {
            echo "
                        <div id='boxsx'>
                        Go to admin panel
                        </div>
                        <div id='boxdx'>
                        <a style='color:#3C3C3C; text-align: center;' href='./modp.php' id='bottone_keyword' class='button' onclick='loading(load);'>Back</a>
                        </div>";
            echo $nav . "";
        }
        ?>
        <div style='clear:both;'></div>
    <center>
        <div onclick="myFunction()">
            <?php
            if (sessioneavviata() == True) {
                echo "<br/><br/><center>SORRY ONE DOWNLOAD/UPDATE SESSION IS RUNNING AT THIS TIME! THE SECTION CAN'T BE USED IN THIS MOMENT!</center><br/>";
            } else {
                if (isset($_GET['c'])) {
                    #funzione gestione preprint archiviati
                    leggipreprintarchiviati();
                } else {
                    #funzione gestione preprint archiviati
                    leggipreprintarchiviati();
                }
            }
            ?>
        </div>
    </center>
</div>
<br/>
<br/>
<center>
    <div id="load">
        <img src="./images/loader.gif" alt="Loading" style="width: 192px; height: 94px;">
    </div>
</center>
</body>
</html>
