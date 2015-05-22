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
                src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
        </script>
        <script type="text/javascript">
            function FinePagina()
            {
                var w = window.screen.width;
                var h = window.screen.height;
                window.scrollTo(w * h, w * h)
            }
            function confirmDelete()
            {
                return confirm("Remove all archived preprints?");
            }
        </script>
    </head>
    <body>
        <?php
        #importo file per utilizzare funzioni...
        require_once $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'authorization/sec_sess.php';
        include_once($_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'arXiv/check_nomi_data.php');
        include_once($_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'arXiv/insert_remove_db.php');
        sec_session_start();
        if ($_SESSION['logged_type'] === "mod") {
            $nav = "<tr><form name='f2' action='archived_preprints.php' method='GET'>
		<td align='right'>Delete all archived preprints from database&nbsp&nbsp&nbsp</td>
		<td><input type='submit' name='c' value='Remove all' id='bottone_keyword' class='bottoni' onclick='return confirmDelete()'/></td>
		</form></tr>";
            $nav2 = "<header id='header'>
                                    <h1><a href='#' id='logo'>DMI Preprints</a></h1>
                                    <nav id='nav'>
                                        <a href='view_preprints.php?p=1&w=0'>Publications</a>
                                        <a href='reserved.php' class='current-page-item'>Reserved Area</a>
                                    </nav>
                                </header>";
            $rit = "modp.php";
            $cred = 1;
        } else {
            $nav = "";
            $nav2 = "<header id='header'>
                                    <h1><a href='#' id='logo'>DMI Preprints</a></h1>
                                    <nav id='nav'>
                                        <a href='view_preprints.php?p=1&w=0' class='current-page-item'>Publications</a>
                                        <a href='reserved.php'>Reserved Area</a>
                                    </nav>
                                </header>";
        }
        ?>
        <div id="header-wrapper">
            <div class="container">
                <div class="row">
                    <div class="12u">
                        <?php echo $nav2; ?>
                    </div>
                </div>
            </div>
        </div>
        <div><center><br/><br/><h2>ARCHIVED PREPRINTS</h2></center>
        </div><center>
        <?php
        if ($cred == 1) {
            echo "<table><tr><form name='f1' action='" . $rit . "' method='GET'>
                <td align='right'>Go to admin panel&nbsp&nbsp&nbsp</td>
                <td><input type='submit' name='b2' value='Back' id='bottone_keyword' class='bottoni'/></td>
                <input type='text' name='p' value='1' checked hidden/><input type='text' name='w' value='0' checked hidden/>
            </form></tr>";
            echo $nav;
        }
        ?>
    </table>
</center>
<?php
if (sessioneavviata() == True) {
    echo "<br/><br/><center>SORRY ONE DOWNLOAD/UPDATE SESSION IS RUNNING AT THIS TIME! THE SECTION CAN'T BE USED IN THIS MOMENT!</center><br/>";
} else {
    echo "<br/><center><a style='text-decoration: none;' href='javascript:FinePagina()'> &nbsp&nbsp&nbsp&nbsp&nbsp&#8595;&nbsp&nbsp&nbsp&nbsp&nbsp </a></center><center><div>";
    if (isset($_GET['c'])) {
        #funzione gestione preprint archiviati
        leggipreprintarchiviati();
    } else {
        #funzione gestione preprint archiviati
        leggipreprintarchiviati();
        echo "<center><a style='text-decoration: none;' href='javascript:window.scrollTo(0,0)'> &nbsp&nbsp&nbsp&nbsp&nbsp&#8593;&nbsp&nbsp&nbsp&nbsp&nbsp </a></center><br/>";
    }
}
?>
</div></center>
</body>
</html>
