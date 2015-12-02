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
        <?php
        #controllo cookie pageview
        if ($_COOKIE['pageview'] == "") {
            echo "<script>javascript:checkCookie4();</script>";
        } else {
            if ($_COOKIE['pageview'] == "0") {
                $string = "Enable";
            } else {
                $string = "Disable";
            }
        }
        #disabilita searchbar su altre pagine
        if ($_GET['clos'] == "1" && $_COOKIE['searchbarall'] == "1") {
            echo "<script>javascript:checkCookie7();</script>";
            echo "<meta http-equiv='refresh' content='0'; URL=./view_preprints.php>";
        }
        #controllo cookie searchbar all
        if ($_COOKIE['searchbarall'] == "0" or ! isset($_COOKIE['searchbarall'])) {
            $string3 = "Enable";
        } else {
            $string3 = "Disable";
        }
        ?>
    </head>
    <body>
        <?php
        #importo file per utilizzare funzioni...
        require_once './authorization/sec_sess.php';
        include_once './arXiv/check_nomi_data.php';
        include_once './arXiv/insert_remove_db.php';
        sec_session_start();
        if ($_SESSION['logged_type'] === "mod") {
            $t = "Go to arXiv panel";
            $rit = "arXiv_panel.php";
            $nav = "<header id='header'>
                                    <h1><a href='#' id='logo'>DMI Papers</a></h1>
                                    <nav id='nav'>
                                        <a href='./view_preprints.php' class='current-page-item' onclick='loading(load);'>Publications</a>
                                        <a href='./reserved.php' onclick='loading(load);'>Reserved Area</a>
                                    </nav>
                                </header>";
        } else if ($_SESSION['logged_type'] === "user") {
            $t = "Go to reserved area";
            $rit = "reserved.php";
            $nav = "<header id='header'>
                                    <h1><a href='#' id='logo'>DMI Papers</a></h1>
                                    <nav id='nav'>
                                        <a href='./view_preprints.php' class='current-page-item' onclick='loading(load);'>Publications</a>
                                        <a href='./reserved.php' onclick='loading(load);'>Reserved Area</a>
                                    </nav>
                                </header>";
        } else {
            $t = "Go to homepage";
            $rit = "main.php";
            $nav = "<header id='header'>
                                    <h1><a href='#' id='logo'>DMI Papers</a></h1>
                                    <nav id='nav'>
                                        <a href='./view_preprints.php' class='current-page-item' onclick='loading(load);'>Publications</a>
                                        <a href='./reserved.php' onclick='loading(load);'>Reserved Area</a>
                                    </nav>
                                </header>";
        }
        if ($_SESSION['logged_type'] != "mod") {
            $str1 = "<h1><center>in this section are the papers that have been published on DMI archive and papers published by the <a style='color:#007897;' href='./authors_list.php' onclick='window.open(this.href); return false'>authors</a> of the department on arxiv.org</center></h1><br/>";
        }
        ?>
        <div id="header-wrapper">
            <div class="container">
                <div class="row">
                    <div class="12u">
                        <?php echo $nav; ?>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <br/><br/>
            <?php
            echo $str1;
            ?>
        </div>
    <center>
        <?php
        echo "<div id='gotop' hidden><a id='scrollToTop' title='Go top'><img style='width:25px; height:25px;' src='./images/top.gif'></a></div>";
        echo "
        <div id='sticker'>
            <form name='f1' action='view_preprints.php' method='GET' onsubmit='loading(load);'>
                <div style='float:right; width:100%;'>
                    To see <a style='color:#007897;' href='archived_preprints.php' onclick='window.open(this.href);
                            return false'>archived</a> (old publications)
                    <input type='button' value='Display Options' onclick='javascript:showHide3(adv,adv2,opt)'; class='button'>
                    <input type='button' value='Search Options' onclick='javascript:showHide4(adv,adv2,opt);' class='button'>
                    Filter results by
                    <select name='f' class='selector'>
                        <option value='all' selected='selected'>All papers:</option>
                        <option value='author'>Authors:</option>
                        <option value='category'>Category:</option>
                        <option value='year'>Year:</option>
                        <option value='id'>ID:</option>
                    </select>
                    <input type='search' autocomplete = 'on' style='width:33%; height: 19px;' class='textbox' name='r' placeholder='Author name, id of publication, year of publication, etc.' value='" . $_GET['r'] . "'>
                        <input type='submit' name='s' value='Send' class='button'>
                </div>
                <div style='clear:both;'></div>
                <div id='adv' hidden=''>
                        Reset selections: 
                        <input type='reset' name='reset' value='Reset' class='button'>&nbsp&nbsp
                        Years restrictions: 
                        until 
                        <input type='text' name='year1' style='width:35px' placeholder='Last' class='textbox'>
                        , or from 
                        <input type='text' name='year2' style='width:35px' placeholder='First' class='textbox'>
                        to 
                        <input type='text' name='year3' style='width:35px' placeholder='Last' class='textbox'>
                        &nbsp&nbspResults for page: 
                        <select name='rp' class='selector' style='height:19px;'>
                            <option value='5' selected='selected'>5</option>
                            <option value='10'>10</option>
                            <option value='15'>15</option>
                            <option value='20'>20</option>
                            <option value='25'>25</option>
                            <option value='50'>50</option>
                        </select>
                        &nbsp&nbspGo to page:
                        <input type='text' name='p' style='width:25px' placeholder='n&#176;' class='textbox'>
                        <br/>
                        Search on:
                        <label><input type='checkbox' name='d' value='1' class='checkbox'>Archived</label>
                        <label><input type='checkbox' name='all' value='1' class='checkbox'>Record</label>
                        <label><input type='checkbox' name='h' value='1' class='checkbox'>Author</label>
                        <label><input type='checkbox' name='t' value='1' class='checkbox'>Title</label>
                        <label><input type='checkbox' name='a' value='1' class='checkbox'>Abstract</label>
                        <label><input type='checkbox' name='e' value='1' class='checkbox'>Date</label>
                        <label><input type='checkbox' name='y' value='1' class='checkbox'>Category</label>
                        <label><input type='checkbox' name='c' value='1' class='checkbox'>Comments</label>
                        <label><input type='checkbox' name='j' value='1' class='checkbox'>Journal-ref</label>
                        <label><input type='checkbox' name='i' value='1' class='checkbox'>ID</label>
                        <br/>
                        Order results by:
                        <label><input type='radio' name='o' value='dated' checked>Date &#8595;</label>
                        <label><input type='radio' name='o' value='datec'>Date &#8593;</label>
                        <label><input type='radio' name='o' value='idd'>Identifier &#8595;</label>
                        <label><input type='radio' name='o' value='idc'>Identifier &#8593;</label>
                        <label><input type='radio' name='o' value='named'>Author-name &#8595;</label>
                        <label><input type='radio' name='o' value='namec'>Author-name &#8593;</label>
                </div>
            </form>
            <div id='adv2' hidden=''>
                <form name='f2' action='view_preprints.php' method='GET' onsubmit='loading(load);'>
                    <font color='#007897'>Full text search: (<a style='color:#007897;' onclick='window.open(this.href);
                            return false' href='http://en.wikipedia.org/wiki/Full_text_search'>info</a>)
                    </font>
                    <br/>
                        Search: <input type='search' autocomplete = 'on' class='textbox' style='width:60%; height: 19px;' name='ft' placeholder='Insert phrase, name, keyword, etc.' value='" . $_GET['ft'] . "'/>
                                       <input type='submit' name='go' value='Send' class='button'/><br/>
                        Reset selections: 
                        <input type='reset' name='reset' value='Reset' class='button'>&nbsp&nbsp
                        Results for page: 
                        <select name='rp' class='selector' style='height:19px;'>
                            <option value='5' selected='selected'>5</option>
                            <option value='10'>10</option>
                            <option value='15'>15</option>
                            <option value='20'>20</option>
                            <option value='25'>25</option>
                            <option value='50'>50</option>
                        </select>
                        &nbsp&nbspGo to page:
                        <input type='text' name='p' style='width:25px' placeholder='n&#176;' class='textbox'>
                        &nbsp&nbsp
                        Search on: 
                        <label><input type='radio' name='st' value='1' checked>Currents</label>
                        <label><input type='radio' name='st' value='0'>Archived</label>
                </form>
            </div>
            <div hidden id='opt' hidden=''>
                Search Bar on all pages:&nbsp
                <input type='button' value='" . $string3 . "' onclick='javascript:checkCookie6();' class='button'/>&nbsp
                On page view for PDF:&nbsp
                <input type='button' value='" . $string . "' onclick='javascript:checkCookie3();' class='button'/>&nbsp
            </div>
        </div>
        ";
        ?>
        <br/>
        <div onclick="myFunction()">
            <?php
#ricerca full text
            if (isset($_GET['go']) && $_GET['go'] != "") {
                searchfulltext();
            }
#ricerca normale
            if (isset($_GET['s']) && $_GET['s'] != "") {
                if (!is_numeric($_GET['year2']) && is_numeric($_GET['year3'])) {
                    echo '<script type="text/javascript">alert("YEAR NOT VALID!(insert both years)");</script>';
                    #funzione lettura e filtro preprint
                    filtropreprint();
                } else {
                    if (!is_numeric($_GET['year3']) && is_numeric($_GET['year2'])) {
                        echo '<script type="text/javascript">alert("YEAR NOT VALID!(insert both years)");</script>';
                        #funzione lettura e filtro preprint
                        filtropreprint();
                    } else {
                        if ($_GET['t'] == 1 or $_GET['a'] == 1 or $_GET['c'] == 1 or $_GET['j'] == 1 or $_GET['h'] == 1 or $_GET['y'] == 1 or $_GET['all'] == 1 or $_GET['d'] == 1 or $_GET['e'] == 1 or $_GET['i'] == 1 or is_numeric($_GET['year1']) or is_numeric($_GET['year2']) or is_numeric($_GET['year3'])) {
                            searchpreprint();
                        } else {
                            #funzione lettura e filtro preprint
                            filtropreprint();
                        }
                    }
                }
            } else {
                if (($_GET['t'] == 1 or $_GET['a'] == 1 or $_GET['c'] == 1 or $_GET['j'] == 1 or $_GET['h'] == 1 or $_GET['y'] == 1 or $_GET['all'] == 1 or $_GET['d'] == 1 or $_GET['e'] == 1 or $_GET['i'] == 1 or is_numeric($_GET['year1']) or is_numeric($_GET['year2']) or is_numeric($_GET['year3'])) && $_GET['go'] != "Send") {
                    searchpreprint();
                } else {
                    if ($_GET['go'] != "Send") {
                        #funzione lettura e filtro preprint
                        filtropreprint();
                    }
                }
            }
            ?>
        </div><br/>
    </center>
    <center>
        <div id="load">
            <img src="./images/loader.gif" alt="Loading" style="width: 192px; height: 94px;">
        </div>
    </center>
</body>
</html>
