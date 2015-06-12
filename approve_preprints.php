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
        <script type="text/javascript">
            checked = false;
            function checkedAll(f1) {
                var aa = document.getElementById('f1');
                if (checked == false)
                {
                    checked = true
                }
                else
                {
                    checked = false
                }
                for (var i = 0; i < aa.elements.length; i++) {
                    aa.elements[i].checked = checked;
                }
            }
            function FinePagina()
            {
                var w = window.screen.width;
                var h = window.screen.height;
                window.scrollTo(w * h, w * h)
            }
            function confirmDelete()
            {
                return confirm("Remove selected papers?");
            }
            function confirmInsert()
            {
                return confirm("Insert selected papers?");
            }
            //opzioni di visualizzazione
            function showHide2(id) {
                if (id.style.display != 'block') {
                    id.style.display = 'block';
                    showHide2(adv);
                } else {
                    id.style.display = 'none';
                }
            }
            //ricerca avanzata
            function showHide(id) {
                if (id.style.display != 'block') {
                    id.style.display = 'block';
                    showHide(opt);
                } else {
                    id.style.display = 'none';
                }
            }
            //chiudi menu click fuori dalla finestra
            function myFunction() {
                adv.style.display = 'none';
                opt.style.display = 'none';
            }
        </script>
    </head>
    <body>
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'authorization/sec_sess.php';
        include_once($_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'arXiv/check_nomi_data.php');
        sec_session_start();
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] < 86400)) {
            if ($_SESSION['logged_type'] === "mod") {
                //sessione moderatore
                if ($_COOKIE['searchbarall'] == "1") {
                    #search bar
                    echo "<center><div style='z-index:999999; width:100%; padding: 2px; position: fixed; border-bottom: 1px solid; border-top: 1px solid; border-color: #AFAFAF; background-color:#DDDDDD; bottom: 0px;'><form name='f5' action='view_preprints.php' method='GET'  style='height:12px; width:12px; float:left;'>
		    <input type='image' title='Close' name='close' value=1 src='./images/close.jpeg' border='0'  style='height:12px; width:12px; float:left;'/>
		    <input type='text' name='clos' value='1' hidden>
		    </form>
			     <div id='adv' hidden>
			     <div>
			<form name='f4' action='view_preprints.php' method='GET'>
			    <font color='#007897'>Full text search: (<a style='color:#007897;' onclick='window.open(this.href);
				    return false' href='http://en.wikipedia.org/wiki/Full_text_search'>info</a>)</font><br/>
			    <div style='height:30px;'>
				Search: <input type='search' autocomplete = 'on' style='width:50%;' name='ft' placeholder='Insert phrase, name, keyword, etc.' value='" . $_GET['ft'] . "'/>
				<input type='submit' name='go' value='Send'/></div>
			    <div style='height:20px;'>
				Reset selections: <input type='reset' name='reset' value='Reset'>&nbsp&nbsp
				Results for page: 
				<select name='rp'>
				    <option value='5' selected='selected'>5</option>
				    <option value='10'>10</option>
				    <option value='15'>15</option>
				    <option value='20'>20</option>
				    <option value='25'>25</option>
				    <option value='50'>50</option>
				</select>&nbsp&nbsp
				Search on: 
				<label><input type='radio' name='st' value='1' checked>Currents</label>
				<label><input type='radio' name='st' value='0'>Archived</label>
			    </form></div><br/>
		    </div>
			<form name='f4' action='view_preprints.php' method='GET'>
			<font color='#007897'>Advanced search options:</font><br/>
				        <div style='height:30px;'>
			    Reset selections: <input type='reset' name='reset' value='Reset'>&nbsp&nbsp
			    Years restrictions: 
			    until <input type='text' name='year1' style='width:35px' placeholder='Last'>
			    , or from <input type='text' name='year2' style='width:35px' placeholder='First'>
			    to <input type='text' name='year3' style='width:35px' placeholder='Last'>
			    &nbsp&nbspResults for page: 
			    <select name='rp'>
				<option value='5' selected='selected'>5</option>
				<option value='10'>10</option>
				<option value='15'>15</option>
				<option value='20'>20</option>
				<option value='25'>25</option>
				<option value='50'>50</option>
			    </select>
			</div>
			<div>
			    Search on:
			    <label><input type='checkbox' name='d' value='1'>Archived</label>
			    <label><input type='checkbox' name='all' value='1'>Record</label>
			    <label><input type='checkbox' name='h' value='1'>Author</label>
			    <label><input type='checkbox' name='t' value='1'>Title</label>
			    <label><input type='checkbox' name='a' value='1'>Abstract</label>
			    <label><input type='checkbox' name='e' value='1'>Date</label>
			    <label><input type='checkbox' name='y' value='1'>Category</label>
			    <label><input type='checkbox' name='c' value='1'>Comments</label>
			    <label><input type='checkbox' name='j' value='1'>Journal-ref</label>
			    <label><input type='checkbox' name='i' value='1'>ID</label>
			</div>
			<div>Order results by:
			    <label><input type='radio' name='o' value='dated' checked>Date (D)</label>
			    <label><input type='radio' name='o' value='datec'>Date (I)</label>
			    <label><input type='radio' name='o' value='idd'>Identifier (D)</label>
			    <label><input type='radio' name='o' value='idc'>Identifier (I)</label>
			    <label><input type='radio' name='o' value='named'>Author-name (D)</label>
			    <label><input type='radio' name='o' value='namec'>Author-name (I)</label>
			</div><br/>
		    </div>
		        Advanced:
		        <input type='button' value='Show/Hide' onclick='javascript:showHide(adv);'/>
		         Filter results by 
		        <select name='f'>
		            <option value='all' selected='selected'>All papers:</option>
		            <option value='author'>Authors:</option>
		            <option value='category'>Category:</option>
		            <option value='year'>Year:</option>
		            <option value='id'>ID:</option>
		        </select>
		        <input type='search' autocomplete = 'on' style='width:30%;' name='r' placeholder='Author name, part, etc.' value='" . $_GET['r'] . "'/>
		    <input type='submit' name='s' value='Send'/></form>
		    </div></center>";
                }
                ?>
                <div onclick="myFunction()">
                    <div id="header-wrapper">
                        <div class="container">
                            <div class="row">
                                <div class="12u">
                                    <header id="header">
                                        <h1><a href="#" id="logo">DMI Papers</a></h1>
                                        <nav id="nav">
                                            <a href='./view_preprints.php'>Publications</a>
                                            <a href="./reserved.php" class="current-page-item">Reserved Area</a>
                                        </nav>
                                    </header>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <center>
                            <br/>
                            <br/>
                            <h2>APPROVE DMI PAPER</h2>
                            Go to admin panel&nbsp&nbsp&nbsp
                            <a style="height:17px; color:white;" href="./modp.php" id="bottone_keyword" class="bottoni">Back</a><br/>
                        </center>
                    </div>
                    <br/>
                    <div>
                        <?php
                        include_once($_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'arXiv/insert_remove_db.php');
                        include_once($_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'arXiv/arXiv_parsing.php');
                        include_once($_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'mysql/func.php');
                        #importazione variabili globali
                        include $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'impost_car.php';
                        echo "<center><a style='text-decoration: none;' href='javascript:FinePagina()'> &nbsp&nbsp&nbsp&nbsp&nbsp&#8595;&nbsp&nbsp&nbsp&nbsp&nbsp </a></center>";
                        echo "<hr style='display: block; height: 1px; border: 0; border-top: 1px solid #ccc; margin: 1em 0; padding: 0;'>";
                        #leggere cartella...
                        #Imposto la directory da leggere
                        $directory = $basedir;
                        echo "<form name='f3' action='approve_preprints.php' id='f1' method='GET'><center><table>";
                        #Apriamo una directory e leggiamone il contenuto.
                        if (is_dir($directory)) {
                            #Apro l'oggetto directory
                            if ($directory_handle = opendir($directory)) {
                                #Scorro l'oggetto fino a quando non è termnato cioè false
                                echo "<tr><td><input type='checkbox' name='checkall' onclick='checkedAll(f1);'/></td><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspNAME:</td><td>&nbsp&nbsp&nbspRECORD:</td><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspCREATED:</td></tr>";
                                $i = 0;
                                $y = 1;
                                while (($file = readdir($directory_handle)) !== false) {
                                    #Se l'elemento trovato è diverso da una directory
                                    #o dagli elementi . e .. lo visualizzo a schermo
                                    if ((!is_dir($file)) & ($file != ".") & ($file != "..") & ($file != "index.html")) {
                                        $array[$i] = $file;
                                        $ids = $file;
                                        $ids = substr($ids, 0, -4);
                                        echo "<tr><td colspan='2'><label><input type='checkbox' name='" . $i . "' value='checked'/>$y.&nbsp&nbsp&nbsp<a href=./upload_dmi/" . $file . " onclick='window.open(this.href);return false' title='" . $file . "'>" . $file . "</a></label>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td><td><a href=./manual_edit.php?id=" . $ids . " onclick='window.open(this.href);return false' title='" . $ids . "'>" . $ids . "</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>";
                                        #recupero data creazione file
                                        $dat = date("Y-m-d H:i", filemtime($basedir . $file));
                                        echo "<td>&nbsp&nbsp&nbsp$dat</td></tr>";
                                        $i++;
                                        $y++;
                                    }
                                }
                                echo "</table></center><center><br/><input type='submit' name='b2' value='Remove' style='width:70px;' id='bottone_keyword' class='bottoni' onclick='return confirmDelete()'><input type='submit' name='b3' value='Insert' style='width:70px;' id='bottone_keyword' class='bottoni' onclick='return confirmInsert()'></center></form>";
                                #Chiudo la lettura della directory.
                                closedir($directory_handle);
                            }
                        }
                        $z = 0;
                        $lunghezza = $i;
                        #eliminazione pdf, lettura cartella e ...
                        if (isset($_GET['b2'])) {
                            for ($j = 0; $j < $lunghezza; $j++) {
                                $percorso = $basedir . $array[$j];
                                $percorso2 = $copia . $array[$j];
                                $delete = $_GET[$j];
                                if ($delete == "checked") {
                                    $z++;
                                    if (is_dir($directory)) {
                                        if ($directory_handle = opendir($directory)) {
                                            while (($file = readdir($directory_handle)) !== false) {
                                                if ((!is_dir($file)) & ($file != ".") & ($file != "..") & ($file != "index.html")) {
                                                    if ($file == $array[$j]) {
                                                        #cancello file...
                                                        unlink($percorso);
                                                        unlink($percorso2);
                                                        #cancello riga database...
                                                        remove_preprints($array[$j]);
                                                    }
                                                }
                                            }
                                            #Chiudo la lettura della directory.
                                            closedir($directory_handle);
                                        }
                                    }
                                }
                            }
                            #controllo se sono stati selezionati preprint da rimuovere
                            if ($z == 0) {
                                echo '<script type="text/javascript">alert("No paper selected!");</script>';
                            } else {
                                echo '<script type="text/javascript">alert("' . $z . ' papers removed correctly!");</script>';
                                #aggiorno la pagina dopo 0 secondi
                                echo '<META HTTP-EQUIV="Refresh" Content="0; URL=./approve_preprints.php">';
                            }
                        }
                        #inserimento pdf, lettura cartella e ...
                        if (isset($_GET['b3'])) {
                            for ($j = 0; $j < $lunghezza; $j++) {
                                $percorso = $basedir . $array[$j];
                                $percorso2 = $copia . $array[$j];
                                $delete = $_GET[$j];
                                if ($delete == "checked") {
                                    $z++;
                                    if (is_dir($directory)) {
                                        if ($directory_handle = opendir($directory)) {
                                            while (($file = readdir($directory_handle)) !== false) {
                                                if ((!is_dir($file)) & ($file != ".") & ($file != "..") & ($file != "index.html")) {
                                                    if ($file == $array[$j]) {
                                                        $idd = substr($file, 0, -4);
                                                        #inserimento file nel database
                                                        insertopdf($idd);
                                                    }
                                                }
                                            }
                                            #Chiudo la lettura della directory.
                                            closedir($directory_handle);
                                        }
                                    }
                                }
                            }
                            #controllo se sono stati selezionati preprint da rimuovere
                            if ($z == 0) {
                                echo '<script type="text/javascript">alert("No papers selected!");</script>';
                            } else {
                                echo '<script type="text/javascript">alert("' . $z . ' papers inserted correctly!");</script>';
                                #aggiorno la pagina dopo 0 secondi
                                echo '<META HTTP-EQUIV="Refresh" Content="0; URL=./approve_preprints.php">';
                            }
                        }
                        echo "<hr style='display: block; height: 1px; border: 0; border-top: 1px solid #ccc; margin: 1em 0; padding: 0;'>";
                        echo "<center><a style='text-decoration: none;' href='javascript:window.scrollTo(0,0)'> &nbsp&nbsp&nbsp&nbsp&nbsp&#8593;&nbsp&nbsp&nbsp&nbsp&nbsp </a></center><br/>";
                        #avviso per utente di nessun preprint
                        if ($i == 0) {
                            echo '<script type="text/javascript">alert("No paper to be checked!");</script>';
                        }
                    } else {
                        echo '<script type="text/javascript">alert("ACCESS DENIED!");</script>';
                        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=./reserved.php">';
                    }
                } else {
                    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=./reserved.php">';
                }
                ?>
                <br/>
            </div>
        </div>
        <br/>
        <br/>
    </body>
</html>
