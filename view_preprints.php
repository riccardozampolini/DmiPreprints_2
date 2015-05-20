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
            function showHide(id)
            {
                if (id.style.display != 'block')
                    id.style.display = 'block';
                else
                    id.style.display = 'none';
            }
        </script>
    </head>
    <body>
        <?php
        if ($_GET['w'] != "0") {
            $view = 0;
            $upview = 1;
            $string = "Disable";
        } else {
            $view = 1;
            $upview = 0;
            $string = "Enable";
        }
        #importo file per utilizzare funzioni...
        require_once $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'authorization/sec_sess.php';
        include_once($_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'arXiv/check_nomi_data.php');
        include_once($_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'arXiv/insert_remove_db.php');
        sec_session_start();
        if ($_SESSION['logged_type'] === "mod") {
            $t = "Go to arXiv panel";
            $rit = "arXiv_panel.php";
            $nav = "<header id='header'>
                                    <h1><a href='#' id='logo'>DMI Preprints</a></h1>
                                    <nav id='nav'>
                                        <a href='main.php'>DMI Publications</a>
                                        <a href='view_preprints.php?p=1&w=0'>arXiv Publications</a>
                                        <a href='reserved.php' class='current-page-item'>Reserved Area</a>
                                    </nav>
                                </header>";
        } else if ($_SESSION['logged_type'] === "user") {
            $t = "Go to reserved area";
            $rit = "reserved.php";
            $nav = "<header id='header'>
                                    <h1><a href='#' id='logo'>DMI Preprints</a></h1>
                                    <nav id='nav'>
                                        <a href='main.php'>DMI Publications</a>
                                        <a href='view_preprints.php?p=1&w=0' class='current-page-item'>arXiv Publications</a>
                                        <a href='reserved.php'>Reserved Area</a>
                                    </nav>
                                </header>";
        } else {
            $t = "Go to homepage";
            $rit = "main.php";
            $nav = "<header id='header'>
                                    <h1><a href='#' id='logo'>DMI Preprints</a></h1>
                                    <nav id='nav'>
                                        <a href='main.php'>DMI Publications</a>
                                        <a href='view_preprints.php?p=1&w=0' class='current-page-item'>arXiv Publications</a>
                                        <a href='reserved.php'>Reserved Area</a>
                                    </nav>
                                </header>";
        }
        if ($_SESSION['logged_type'] != "mod") {
            $str1 = "<h1><center>in this section are the preprints that have been published by the <a style='color:#007897;' href='./authors_list.php' onclick='window.open(this.href); return false'>authors</a> of the department on arxiv.org</center></h1>";
        } else {
            $str2 = "<h2>APPROVED PREPRINTS</h2>";
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
        <div><center><br/><?php echo $str2; ?></center>
            <?php
            echo $str1;
            ?>
        </div><center>
        <?php
        if ($_SESSION['logged_type'] === "mod") {
            echo "<form name='f1' action='$rit' method='GET'>
		        $t&nbsp&nbsp&nbsp
		        <input type='submit' name='b1' value='Back' id='bottone_keyword' class='bottoni'/>
		    </form>
		    ";
        }
        ?>
        <br/>
        <form name="f5" action="<?php echo 'view_preprints.php?p=' . $_GET['p'] . '&w=' . $view . '&r=' . $_GET['r'] . '&f=' . $_GET['f'] . '&o=' . $_GET['o'] . '&t=' . $_GET['t'] . '&a=' . $_GET['a'] . '&c=' . $_GET['c'] . '&j=' . $_GET['j'] . '&d=' . $_GET['d'] . '&all=' . $_GET['all'] . '&h=' . $_GET['h'] . '&y=' . $_GET['y'] . '&e=' . $_GET['e'] . '&i=' . $_GET['i'] . '&rp=' . $_GET['rp'] . '&ft=' . $_GET['ft'] . '&go=' . $_GET['go'] . '&s=' . $_GET['s'] . '&year1=' . $_GET['year1'] . '&year2=' . $_GET['year2'] . '&year3=' . $_GET['year3'] . '&st=' . $_GET['st'] . ''; ?>" method="POST">
            Enable/Disable on page view:
            <input type="submit" style="width:40px;" name="w" value="<?php echo $string; ?>" id="bottone_keyword" class="bottoni"/>
            To see <a style='color:#007897;' href="archived_preprints.php?p=1" onclick='window.open(this.href);
                    return false'>archived</a>(old publications)
        </form><br/><div style="height:30px;">
            <form name="f4" action="view_preprints.php" method="GET">
                <input type="text" name="p" value="1" hidden>
                <input type="text" name="w" value="<?php echo $upview; ?>" hidden>
                Advanced search options:
                <input type="button" value="Show/Hide" onclick="javascript:showHide(adv);"/>
                Filter by
                <select name="f">
                    <option value="all" selected="selected">All preprint:</option>
                    <option value="author">Authors:</option>
                    <option value="category">Category:</option>
                    <option value="year">Year:</option>
                    <option value="id">Identifier(ID):</option>
                </select>
                <input type="search" autocomplete = "on" style="width:250px;" name="r" placeholder="Author name, part, etc." value="<?php echo $_GET['r']; ?>"/>
            <input type="submit" name="s" value="Send"/></div>
        <div id="adv" hidden>
            <div style="height:30px;">Years restrictions: 
                until <input type="text" name="year1" style="width:35px" placeholder="Last">
                , or from <input type="text" name="year2" style="width:35px" placeholder="First">
                to <input type="text" name="year3" style="width:35px" placeholder="Last">
                &nbsp&nbspResults for page: 
                <select name="rp">
                    <option value="5" selected="selected">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="25">25</option>
                </select>&nbsp&nbsp
                Reset selections: <input type="reset" name="reset" value="Reset"></div>
            <div style="float:left; width:37%; height:50px;" align="right">
                Search on:<br/></div>
            <div style="float:right; width:63%; height:50px;" align="left">
                <label><input type="checkbox" name="d" value="1">Include-archived</label>
                <label><input type="checkbox" name="all" value="1">Record</label>
                <label><input type="checkbox" name="h" value="1">Author</label>
                <label><input type="checkbox" name="t" value="1">Title</label>
                <label><input type="checkbox" name="e" value="1">Year</label><br/>	
                <label><input type="checkbox" name="a" value="1">Abstract</label>
                <label><input type="checkbox" name="y" value="1">Category</label>
                <label><input type="checkbox" name="c" value="1">Comments</label>
                <label><input type="checkbox" name="j" value="1">Journal-ref</label>
                <label><input type="checkbox" name="i" value="1">ID</label>
            </div>
            <div style="float:right; width:100%; height:30px;" align="center">Order by:
                <label><input type="radio" name="o" value="dated" checked>Date(D)</label>
                <label><input type="radio" name="o" value="datec">Date(I)</label>
                <label><input type="radio" name="o" value="idd">ID(D)</label>
                <label><input type="radio" name="o" value="idc">ID(I)</label>
                <label><input type="radio" name="o" value="named">Name(D)</label>
                <label><input type="radio" name="o" value="namec">Name(I)</label>
            </div><br/><br/>
            </form>
            <div>
                <form name="f4" action="view_preprints.php" method="GET">
                    <input type="text" name="p" value="1" hidden>
                    <input type="text" name="w" value="<?php echo $upview; ?>" hidden>
                    <font color="#007897">Full text search(semantic search)</font><br/>
                    Results for page: 
                    <select name="rp">
                        <option value="5" selected="selected">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        <option value="25">25</option>
                    </select>&nbsp&nbsp
                    Search: <input type="search" autocomplete = "on" style="width:400px;" name="ft" placeholder="Insert phrase, name, keyword, etc." value="<?php echo $_GET['ft']; ?>"/>
                    <input type="submit" name="go" value="Send"/>&nbsp&nbsp
                    Search on: 
                    <label><input type="radio" name="st" value="0" checked>Latest</label>
                    <label><input type="radio" name="st" value="1">Archived</label>
                </form>
                <div align="left" style="margin-left:6%; width:500px;"><br/>
                    EXAMPLE OF USING BOOLEAN OPERATORS(full text search):<br/>
                    <div style="float:left;">&#9679;</div><div style="margin-left:15px;">'Milan Rome': this must be one of the two terms.</div>
                    <div style="float:left;">&#9679;</div><div style="margin-left:15px;">'+Milan +Rome': must be present both terms.</div>
                    <div style="float:left;">&#9679;</div><div style="margin-left:15px;">'+Milan Rome': there must be "Milan" and possibly "Rome".</div>
                    <div style="float:left;">&#9679;</div><div style="margin-left:15px;">'+Milan -Rome': there must be "Milan" but not "Rome".</div>
                    <div style="float:left;">&#9679;</div><div style="margin-left:15px;">'+Milan +(&lt;Rome &gt;Venice)'': must be present or "Milan" and "Rome" or "Milan" and "Venice", but the records with "Milan" and "Venice" are of greater. ("<" Means less important, ">" means greater relevance).</div>
                    <div style="float:left;">&#9679;</div><div style="margin-left:15px;">'"Milan Rome"': This must be the exact sequence "Milan Rome".</div>
                </div>
            </div>
        </div>
        <?php
        echo "<br/><center><a style='text-decoration: none;' href='javascript:FinePagina()'> &nbsp&nbsp&nbsp&nbsp&nbsp&#8595;&nbsp&nbsp&nbsp&nbsp&nbsp </a></center><center>";
        #ricerca full text
        if (isset($_GET['go']) && $_GET['go'] != "") {
            searchfulltext();
            echo "<center><a style='text-decoration: none;' href='javascript:window.scrollTo(0,0)'>&nbsp&nbsp&nbsp&nbsp&nbsp&#8593;&nbsp&nbsp&nbsp&nbsp&nbsp </a></center><br/>";
        }
        #ricerca normale
        if (isset($_GET['s']) && $_GET['s'] != "") {
            if (!is_numeric($_GET['year2']) && is_numeric($_GET['year3'])) {
                echo '<script type="text/javascript">alert("YEAR NOT VALID!(insert both years)");</script>';
                #funzione lettura e filtro preprint
                filtropreprint();
                echo "<center><a style='text-decoration: none;' href='javascript:window.scrollTo(0,0)'>&nbsp&nbsp&nbsp&nbsp&nbsp&#8593;&nbsp&nbsp&nbsp&nbsp&nbsp </a></center><br/>";
            } else {
                if (!is_numeric($_GET['year3']) && is_numeric($_GET['year2'])) {
                    echo '<script type="text/javascript">alert("YEAR NOT VALID!(insert both years)");</script>';
                    #funzione lettura e filtro preprint
                    filtropreprint();
                    echo "<center><a style='text-decoration: none;' href='javascript:window.scrollTo(0,0)'>&nbsp&nbsp&nbsp&nbsp&nbsp&#8593;&nbsp&nbsp&nbsp&nbsp&nbsp </a></center><br/>";
                } else {
                    if ($_GET['t'] == 1 or $_GET['a'] == 1 or $_GET['c'] == 1 or $_GET['j'] == 1 or $_GET['h'] == 1 or $_GET['y'] == 1 or $_GET['all'] == 1 or $_GET['d'] == 1 or $_GET['e'] == 1 or $_GET['i'] == 1 or is_numeric($_GET['year1']) or is_numeric($_GET['year2']) or is_numeric($_GET['year3'])) {
                        searchpreprint();
                        echo "<center><a style='text-decoration: none;' href='javascript:window.scrollTo(0,0)'>&nbsp&nbsp&nbsp&nbsp&nbsp&#8593;&nbsp&nbsp&nbsp&nbsp&nbsp </a></center><br/>";
                    } else {
                        #funzione lettura e filtro preprint
                        filtropreprint();
                        echo "<center><a style='text-decoration: none;' href='javascript:window.scrollTo(0,0)'>&nbsp&nbsp&nbsp&nbsp&nbsp&#8593;&nbsp&nbsp&nbsp&nbsp&nbsp </a></center><br/>";
                    }
                }
            }
        } else {
            if (($_GET['t'] == 1 or $_GET['a'] == 1 or $_GET['c'] == 1 or $_GET['j'] == 1 or $_GET['h'] == 1 or $_GET['y'] == 1 or $_GET['all'] == 1 or $_GET['d'] == 1 or $_GET['e'] == 1 or $_GET['i'] == 1 or is_numeric($_GET['year1']) or is_numeric($_GET['year2']) or is_numeric($_GET['year3'])) && $_GET['go'] != "Send") {
                searchpreprint();
                echo "<center><a style='text-decoration: none;' href='javascript:window.scrollTo(0,0)'>&nbsp&nbsp&nbsp&nbsp&nbsp&#8593;&nbsp&nbsp&nbsp&nbsp&nbsp </a></center><br/>";
            } else {
                if ($_GET['go'] != "Send") {
                    #funzione lettura e filtro preprint
                    filtropreprint();
                    echo "<center><a style='text-decoration: none;' href='javascript:window.scrollTo(0,0)'> &nbsp&nbsp&nbsp&nbsp&nbsp&#8593;&nbsp&nbsp&nbsp&nbsp&nbsp </a></center><br/>";
                }
            }
        }
        ?>
    </div>
</body>
</html>
