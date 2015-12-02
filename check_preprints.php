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
        <script type="text/javascript" src="./js/allscript.js">
        </script>     
    </head>
    <body>
        <?php
        require_once './authorization/sec_sess.php';
        include_once './arXiv/check_nomi_data.php';
        sec_session_start();
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] < 86400)) {
            if ($_SESSION['logged_type'] === "mod") {
                //sessione moderatore
                echo "<div id='gotop' hidden><a id='scrollToTop' title='Go top'><img style='width:25px; height:25px;' src='./images/top.gif'></a></div>";
                if ($_COOKIE['searchbarall'] == "1") {
                    #search bar
                    require_once './searchbar_bottom.php';
                }
                ?>
                <div onclick="myFunction2()">
                    <div id="header-wrapper">
                        <div class="container">
                            <div class="row">
                                <div class="12u">
                                    <header id="header">
                                        <h1><a href="#" id="logo">DMI Papers</a></h1>
                                        <nav id="nav">
                                            <a href='./view_preprints.php' onclick="loading(load);">Publications</a>
                                            <a href="./reserved.php" class="current-page-item" onclick="loading(load);">Reserved Area</a>
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
                            <h2>CHECK PAPER</h2>
                            Go to admin panel&nbsp&nbsp&nbsp
                            <a style='color:#3C3C3C;' href='./modp.php' id='bottone_keyword' class='button' onclick='loading(load);'>Back</a><br/>
                        </center>
                    </div>
                    <div>
                        <?php
                        include_once './arXiv/insert_remove_db.php';
                        include_once './arXiv/arXiv_parsing.php';
                        include_once './mysql/func.php';
                        #importazione variabili globali
                        include './header.inc.php';
                        if (sessioneavviata() == True) {
                            echo "<center><br/>SORRY ONE DOWNLOAD/UPDATE SESSION IS RUNNING AT THIS TIME! THE LIST CAN'T BE CHANGED IN THIS MOMENT!</center><br/>";
                        } else {
                            echo "<hr style='display: block; height: 1px; border: 0; border-top: 1px solid #ccc; margin: 1em 0; padding: 0;'>";
####################################################################################################################################################################
                            #arxiv papers
                            #leggere cartella...
                            #Imposto la directory da leggere
                            $directory = $basedir3;
                            echo "<form name='f1' action='check_preprints.php' id='f1' method='GET' onsubmit='loading(load);'>"
                            . "<div id='arxivpreprints'>"
                            . "<center><table id='table'>";
                            #Apriamo una directory e leggiamone il contenuto.
                            if (is_dir($directory)) {
                                #Apro l'oggetto directory
                                if ($directory_handle = opendir($directory)) {
                                    #Scorro l'oggetto fino a quando non è termnato cioè false
                                    echo "<tr id='thhead'>"
                                    . "<td id='tdh' colspan='4' align='center'>DOWNLOADED FROM ARXIV</td>"
                                    . "</tr>";
                                    echo "<tr id='thhead'>"
                                    . "<td id='tdh'><label><input type='checkbox' class='checkall1' value='all1' name='all' onChange='toggle(this)'/>N&deg;:</label></td>"
                                    . "<td id='tdh' align='center'>FILE:</td>"
                                    . "<td id='tdh' align='center'>RECORD:</td>"
                                    . "<td id='tdh' align='center'>FOUNDED:</td>"
                                    . "</tr>";
                                    $i = 0;
                                    $y = 1;
                                    while (($file = readdir($directory_handle)) !== false) {
                                        #Se l'elemento trovato è diverso da una directory
                                        #o dagli elementi . e .. lo visualizzo a schermo
                                        if ((!is_dir($file)) & ($file != ".") & ($file != "..") & ($file != "index.html")) {
                                            $array[$i] = $file;
                                            $ids = $file;
                                            $ids = substr($ids, 0, -4);
                                            $ids = str_replace("-", "/", $ids);
                                            echo "<tr id='th'><td id='td'><label><input type='checkbox' name='ch" . $i . "' value='checked' class='checkall1'/>$y.</label></td><td id='td'><a href=./pdf_downloads/" . $file . " onclick='window.open(this.href);return false' title='" . $file . "'>" . $file . "</a></td><td id='td'><a href=./manual_edit.php?id=" . $ids . " onclick='window.open(this.href);return false' title='" . $ids . "'>" . $ids . "</a></td>";
                                            #recupero data creazione file
                                            $dat = date("Y-m-d H:i", filemtime($basedir3 . $file));
                                            echo "<td id='td'>$dat</td></tr>";
                                            $i++;
                                            $y++;
                                        }
                                    }
                                    echo "</table></div>";
                                    #Chiudo la lettura della directory.
                                    closedir($directory_handle);
                                }
                            }
                            $z = 0;
                            $lunghezza = $i;
                            #dmi papers
                            #Imposto la directory da leggere
                            $directory2 = $basedir;
                            echo "<center><div id='dmipreprints'>"
                            . "<table id='table1'>";
                            #Apriamo una directory e leggiamone il contenuto.
                            if (is_dir($directory2)) {
                                #Apro l'oggetto directory
                                if ($directory_handle = opendir($directory2)) {
                                    #Scorro l'oggetto fino a quando non è termnato cioè false
                                    echo "<tr id='thhead'>"
                                    . "<td id='tdh' colspan='4' align='center'>SUBMITTED TO DMI</td>"
                                    . "</tr>";
                                    echo "<tr id='thhead'>"
                                    . "<td id='tdh'><label><input type='checkbox' name='all2' class='checkall2' onChange='toggle(this)'/>N&deg;:</label></td>"
                                    . "<td id='tdh' align='center'>FILE:</td><td id='tdh' align='center'>RECORD:</td>"
                                    . "<td id='tdh' align='center'>FOUNDED:</td>"
                                    . "</tr>";
                                    $y = 1;
                                    while (($file = readdir($directory_handle)) !== false) {
                                        #Se l'elemento trovato è diverso da una directory
                                        #o dagli elementi . e .. lo visualizzo a schermo
                                        if ((!is_dir($file)) & ($file != ".") & ($file != "..") & ($file != "index.html")) {
                                            $array[$i] = $file;
                                            $ids = $file;
                                            $ids = substr($ids, 0, -4);
                                            $ids = str_replace("-", "/", $ids);
                                            echo "<tr id='th'><td id='td'><label><input type='checkbox' name='ch" . $i . "' value='checked' class='checkall2'/>$y.</td><td id='td'><a href=./upload_dmi/" . $file . " onclick='window.open(this.href);return false' title='" . $file . "'>" . $file . "</a></label></td><td id='td'><a href=./manual_edit.php?id=" . $ids . " onclick='window.open(this.href);return false' title='" . $ids . "'>" . $ids . "</a></td>";
                                            #recupero data creazione file
                                            $dat = date("Y-m-d H:i", filemtime($basedir . $file));
                                            echo "<td id='td'>$dat</td></tr>";
                                            $i++;
                                            $y++;
                                        }
                                    }
                                    echo "</table></div>"
                                    . "<div style='clear:both;'><br/>"
                                    . "<hr style='display: block; height: 1px; border: 0; border-top: 1px solid #ccc; margin: 1em 0; padding: 0;'>"
                                    . "<input type='submit' name='b1' value='Remove' style='width:70px;' id='bottone_keyword' class='button' onclick='return confirmDelete3()'>"
                                    . "<input type='submit' name='b2' value='Insert' style='width:70px;' id='bottone_keyword' class='button' onclick='return confirmInsert3()'>"
                                    . "</div></center></form>";
                                    #Chiudo la lettura della directory.
                                    closedir($directory_handle);
                                }
                            }
#################################################################################################################################################
                            #bottone elimina 
                            $k = 0;
                            $lunghezza2 = $i;
                            #eliminazione pdf, lettura cartella e ...
                            if (isset($_GET['b1'])) {
                                for ($j = 0; $j < $lunghezza2; $j++) {
                                    $percorso2 = $copia . $array[$j];
                                    if (isset($_GET["ch" . $j])) {
                                        $k++;
                                        if ($j < $lunghezza) {
                                            $directory2 = $basedir3;
                                            $percorso = $basedir3 . $array[$j];
                                        } else {
                                            $directory2 = $basedir;
                                            $percorso = $basedir . $array[$j];
                                        }
                                        if (is_dir($directory2)) {
                                            if ($directory_handle = opendir($directory2)) {
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
                                if ($k == 0) {
                                    echo '<script type="text/javascript">alert("No paper selected!");</script>';
                                } else {
                                    echo '<script type="text/javascript">alert("' . $k . ' papers removed correctly!");</script>';
                                    #aggiorno la pagina dopo 0 secondi
                                    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=./check_preprints.php">';
                                }
                            }
####################################################################################################################################################################
                            #bottone inserisci
                            #inserimento pdf, lettura cartella e ...
                            if (isset($_GET['b2'])) {
                                for ($j = 0; $j < $lunghezza2; $j++) {
                                    $percorso2 = $copia . $array[$j];
                                    if (isset($_GET["ch" . $j])) {
                                        $k++;
                                        if ($j < $lunghezza) {
                                            $directory2 = $basedir3;
                                            $percorso = $basedir3 . $array[$j];
                                        } else {
                                            $directory2 = $basedir;
                                            $percorso = $basedir . $array[$j];
                                        }
                                        if (is_dir($directory2)) {
                                            if ($directory_handle = opendir($directory2)) {
                                                while (($file = readdir($directory_handle)) !== false) {
                                                    if ((!is_dir($file)) & ($file != ".") & ($file != "..") & ($file != "index.html")) {
                                                        if ($file == $array[$j]) {
                                                            if ($j < $lunghezza) {
                                                                $idd = substr($file, 0, -4);
                                                                #inserimento file nel database
                                                                insert_one_pdf2($idd);
                                                            } else {
                                                                $idd = substr($file, 0, -4);
                                                                #inserimento file nel database
                                                                insertopdf($idd);
                                                            }
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
                                if ($k == 0) {
                                    echo '<script type="text/javascript">alert("No papers selected!");</script>';
                                } else {
                                    echo '<script type="text/javascript">alert("' . $k . ' papers inserted correctly!");</script>';
                                    #aggiorno la pagina dopo 0 secondi
                                    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=./check_preprints.php">';
                                }
                            }
                            echo "<hr style='display: block; height: 1px; border: 0; border-top: 1px solid #ccc; margin: 1em 0; padding: 0;'>";
                            #avviso per utente di nessun preprint
                            if ($i + $t == 0) {
                                echo '<script type="text/javascript">alert("No paper to be checked!");</script>';
                            }
                        }
                    } else {
                        echo '<script type="text/javascript">alert("ACCESS DENIED!");</script>';
                        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=./reserved.php">';
                    }
                } else {
                    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=./reserved.php">';
                }
                ?>
            </div>
        </div><br/>
    <center>
        <div id="load">
            <img src="./images/loader.gif" alt="Loading" style="width: 192px; height: 94px;">
        </div>
    </center>
</body>
</html>
