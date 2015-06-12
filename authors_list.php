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
                return confirm("Remove author/s?");
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
                    <br/>
                    <div>
                        <center>
                            <br/>
                            <h2>AUTHORS LIST</h2>
                            Go to arXiv panel 
                            <a style="height:17px; color:white;" href="./arXiv_panel.php" id="bottone_keyword" class="bottoni">Back</a><br>
                            <hr style="display: block; height: 1px; border: 0; border-top: 1px solid #ccc; margin: 1em 0; padding: 0;">
                            <form name="f2" action="authors_list.php" method="POST">
                                <label>
                                    <input type="checkbox" name="insert" value="1" checked/>
                                    Add author to list or search by name:
                                </label>
                                <input type="search" style="width:300px;" id='textbox' class='textbox' autocomplete = "on" required name="txt1" placeholder="name1, name2, name3, name..." autofocus />
                                <input type="submit" name="b2" value="Insert/Search" style="width:80px;" id="bottone_keyword" class="bottoni"/>
                            </form>
                        </center>
                    </div>
                    <hr style="display: block; height: 1px; border: 0; border-top: 1px solid #ccc; margin: 1em 0; padding: 0;">
                    <div>
                        <?php
                        #importo file per utilizzare funzioni...
                        include_once($_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'arXiv/check_nomi_data.php');
                        if (sessioneavviata() == True) {
                            echo "<center><br/><br/>SORRY ONE DOWNLOAD/UPDATE SESSION IS RUNNING AT THIS TIME! THE LIST CAN'T BE CHANGED IN THIS MOMENT!</center><br/>";
                        } else {
                            echo "<center><a style='text-decoration: none;' href='javascript:FinePagina()'> &nbsp&nbsp&nbsp&nbsp&nbsp&#8595; &nbsp&nbsp&nbsp&nbsp&nbsp</a></center>";
                            echo "<hr style='display: block; height: 1px; border: 0; border-top: 1px solid #ccc; margin: 1em 0; padding: 0;'>";
                            if (isset($_POST['b2'])) {
                                $name = $_POST['txt1'];
                                $insert = $_POST['insert'];
                                #funzione inserimento nuovi autori
                                aggiungiutente($name, $insert);
                            }
                            #visualizzo lista utenti...	
                            $nomi = legginomi();
                            #conto lunghezza array
                            $lunghezza = count($nomi);
                            echo "<form name='f4' action='authors_list.php' id='f1' method='POST'><center><table>";
                            echo "<tr><td><input type='checkbox' name='checkall' onclick='checkedAll(f1);'/>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspNAME:</td></tr>";
                            #creazione della tabella html dei file all'interno di pdf_downloads
                            $y = 1;
                            for ($i = 0; $i < $lunghezza; $i++) {
                                echo "<tr><td><label><input type='checkbox' name='" . $i . "' value='checked'/>$y.&nbsp&nbsp&nbsp" . $nomi[$i] . "</label></td></tr>";
                                $y++;
                            }
                            echo "</table></center><br/><center><input type='submit' style='width:50px;' id='bottone_keyword' class='bottoni' name='b3' value='Remove' onclick='return confirmDelete()'></center></form>";
                            if ($lunghezza == 0) {
                                #richiamo funzione per corretto update successivo
                                aggiornanomi();
                                echo '<script type="text/javascript">alert("No author inside list!");</script>';
                            }
                            if (isset($_POST['b3'])) {
                                $k = 0;
                                $z = 0;
                                #lunghezza array nomi
                                $lunghezza = count($nomi);
                                for ($j = 0; $j < $lunghezza; $j++) {
                                    $delete = $_POST[$j];
                                    #controllo di quali checkbox sono state selezionate
                                    if ($delete != "checked") {
                                        $array[$k] = $nomi[$j];
                                        $k++;
                                    } else {
                                        $array2[$z] = $nomi[$j];
                                        $z++;
                                    }
                                }
                                #scrittura dei nomi sul database
                                scrivinomi($array);
                                #inserisco i nomi eliminati all'interno di una stringa per poi visualizzarla all'utente
                                $nomieliminati = implode(", ", $array2);
                                if ($nomieliminati == "") {
                                    echo '<script type="text/javascript">alert("No author selected!");</script>';
                                } else {
                                    echo '<script type="text/javascript">alert("' . $nomieliminati . ' deleted from list!");</script>';
                                    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=./authors_list.php">';
                                }
                            }
                            echo "<hr style='display: block; height: 1px; border: 0; border-top: 1px solid #ccc; margin: 1em 0; padding: 0;'>";
                            echo "<center><a style='text-decoration: none;' href='javascript:window.scrollTo(0,0)'> &nbsp&nbsp&nbsp&nbsp&nbsp&#8593;&nbsp&nbsp&nbsp&nbsp&nbsp </a></center>";
                        }
                    } else {
                        #importo file per utilizzare funzioni...
                        include_once($_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'arXiv/check_nomi_data.php');
                        #visualizzo lista utenti...	
                        $nomi = legginomi();
                        #conto lunghezza array
                        $lunghezza = count($nomi);
                        echo "<form name='f4' action='authors_list.php' id='f1' method='POST'><center><br/><h2>List of authors searched on arXiv.org</h2><table>";
                        echo "<tr><td align='center'><font color='#007897'>NAME:</color></td></tr>";
                        #creazione della tabella html dei file all'interno di pdf_downloads
                        $y = 1;
                        for ($i = 0; $i < $lunghezza; $i++) {
                            echo "<tr><td><label>$y.&nbsp&nbsp&nbsp" . $nomi[$i] . "</label></td></tr>";
                            $y++;
                        }
                        echo "</table></center></form>";
                    }
                } else {
                    #importo file per utilizzare funzioni...
                    include_once($_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'arXiv/check_nomi_data.php');
                    #visualizzo lista utenti...	
                    $nomi = legginomi();
                    #conto lunghezza array
                    $lunghezza = count($nomi);
                    echo "<form name='f4' action='authors_list.php' id='f1' method='POST'><center><br/><h2>List of authors searched on arXiv.org</h2><table>";
                    echo "<tr><td align='center'><font color='#007897'>NAME:</color></td></tr>";
                    #creazione della tabella html dei file all'interno di pdf_downloads
                    $y = 1;
                    for ($i = 0; $i < $lunghezza; $i++) {
                        echo "<tr><td><label>$y.&nbsp&nbsp&nbsp" . $nomi[$i] . "</label></td></tr>";
                        $y++;
                    }
                    echo "</table></center></form>";
                }
                ?>
            </div>
        </div>
        <br/>
        <br/>
    </body>
</html>
