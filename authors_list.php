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
        <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
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
	</script>
    </head>
    <body>
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'authorization/sec_sess.php';
        sec_session_start();
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] < 86400)) {
            if ($_SESSION['logged_type'] === "mod") {
                //sessione moderatore
                ?>
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
                <div id="div_menu_ricerca" class="contenitore"><center><br/><h2>AUTHOR LIST</h2></center>
                    <center><table>
                            <tr><form name="f1" action="arXiv_panel.php" method="POST"><td align="right">Go to arXiv panel&nbsp&nbsp&nbsp</td>
                                <td><input type="submit" name="bottoni7" value="Back" id="bottone_keyword" class="bottoni"></td><td><label for="insert">&nbsp&nbsp&nbsp&nbspInsert?</label></td></form></tr>


                            <form name="f2" action="authors_list.php" method="POST"><tr><td align="right">Add author to list or search by name&nbsp&nbsp&nbsp</td><td><input type="submit" name="bottoni8" value="Insert / Search" id="bottone_keyword" class="bottoni"></td><td align="center">&nbsp&nbsp&nbsp&nbsp<input type="checkbox" name="insert" value="1" checked/></td></tr>
                                <tr align="center"><td colspan="3"><br/><textarea style="width:100%; height:16px" name="txt1" id="textbox" class="textbox" placeholder="Author name(Use ' , ' to insert/search more authors)" autofocus></textarea></td></tr></form>
                                                    
                                                </table></center>
                                        </div>
                                        <div>
                    <?php
                    #importo file per utilizzare funzioni...
                    include_once($_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'arXiv/check_nomi_data.php');
                    if(sessioneavviata() == True){
                	echo "<center>SORRY ONE DOWNLOAD/UPDATE SESSION IS RUNNING AT THIS TIME! THE LIST CAN'T BE CHANGED IN THIS MOMENT!</center<br/>";
                    }else{
                    echo "<center><a href='javascript:FinePagina()'>&#8595; end of page</a></center><br/>";
                    if (isset($_POST['bottoni8'])) {
                        #controllo del campo testo vuoto
                        if (empty($_POST['txt1'])) {
                            echo "<center>FIELD NAME EMPTY!<br/><br/></center>";
                        } else {
                            $name = $_POST['txt1'];
                            $insert = $_POST['insert'];
                            aggiungiutente($name, $insert);
                        }
                    }
                    #visualizzo lista utenti...	
                    $nomi = legginomi();
                    #conto lunghezza array
                    $lunghezza = count($nomi);
                    echo "<form name='f4' action='authors_list.php' id='f1' method='POST'><center><br/><h2>EDIT LIST</h2><table><br/>";
                    echo "<tr><td>Select all <br/>/ Select</td><td>Name</td></tr>
                    <tr colspan='2'><td><input type='checkbox' name='checkall' onclick='checkedAll(f1);'/></td></tr>";
                    #creazione della tabella html dei file all'interno di pdf_downloads
                    $y = 1;
                    for ($i = 0; $i < $lunghezza; $i++) {
                        echo "<tr colspan='2'><td><input type='checkbox' name='" . $i . "' value='checked' /><label for='".$i."'>$y.&nbsp&nbsp&nbsp" . $nomi[$i] . "</label></td></tr>";
                        $y++;
                    }
                    echo "</table></center><br/><center><input type='submit' name='bottoni9' value='Delete' id='bottone_keyword' class='bottoni'></center></form><br/>";
                    if ($lunghezza == 0) {
                        echo "<center>NO AUTHORS INSIDE LIST!</center><br/>";
                    }
                    if (isset($_POST['bottoni9'])) {
                        $k = 0;
                        $z = 0;
                        #conto lunghezza array nomi
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
                        #scrivo i nomi sul file nomi.txt
                        scrivinomi($array);
                        #inserisco i nomi eliminati all'interno di una stringa per poi visualizzarla
                        $nomieliminati = implode(", ", $array2);
                        if ($nomieliminati == "") {
                            echo "<center>NO AUTHOR SELECTED!</center><br/>";
                        } else {
                            echo "<br/><center>&#171; " . $nomieliminati . " &#187; DELETED FROM LIST! PAGE WILL BEEN UPDATED BETWEEN 2 SECONDS!</center><br/><br/><br/>";
                            echo '<META HTTP-EQUIV="Refresh" Content="2; URL=./authors_list.php">';
                        }
                    }
                    echo "<center><a href='javascript:window.scrollTo(0,0)'>&#8593; top of page</a></center><br/>";
                   }
                } else {
                    echo "<center><br/>ACCESS DENIED!</center>";
                    echo '<META HTTP-EQUIV="Refresh" Content="2; URL=./reserved.php">';
                }
            } else {
                echo '<META HTTP-EQUIV="Refresh" Content="0; URL=./reserved.php">';
            }
            ?>
        </div>
    </body>
</html>
