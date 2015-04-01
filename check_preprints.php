<!DOCTYPE html>
<html>
    <head>
        <title>PREPRINTS CHECK</title>
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
        <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'>
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
    </head>
    <body>
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
        <div id="div_menu_ricerca" class="contenitore"><center>PREPRINTS CHECK</center><br/><br/>
            <center><table>
                    <tr align="right"><td>Go to arXiv panel:&nbsp&nbsp&nbsp</td>
                    <form name="f1" action="arXiv_panel.php" method="POST">
                        <td><input type="submit" name="bottoni4" value="Back" id="bottone_keyword" class="bottoni"></td>
                    </form></tr>
                    <tr align="right"><td>Insert all current preprints into database:&nbsp&nbsp&nbsp<br/></td>
                    <form name="f2" action="check_preprints.php" method="POST">
                        <td><input type="submit" name="bottoni5" value="Insert" id="bottone_keyword" class="bottoni"></td>
                    </form></tr>
                </table></center>
        </div>
        <div>
            <?php
            include_once($_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'arXiv/insert_remove_db.php');
            include_once($_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'arXiv/arXiv_parsing.php');
            #leggere cartella...
            #base link
            $base = "./arXiv/pdf_downloads/";
            #Imposto la directory da leggere
            $directory = $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . "arXiv/pdf_downloads/";
            #Apriamo una directory e leggiamone il contenuto.
            if (is_dir($directory)) {
                #Apro l'oggetto directory
                if ($directory_handle = opendir($directory)) {
                    echo "<form name='f3' action='check_preprints.php' id='f1' method='POST'><center><table style='text-align:center;'>";
                    #Scorro l'oggetto fino a quando non è termnato cioè false
                    echo "<tr style='height: 30px; width:200px'><td colspan='2' style='width:250px'>PDF LIST:</td></tr><tr style='height: 30px'><td>Name:</td><td>Select all/<br/>Select<br/></td></tr><tr style='height: 30px; width:200px'><td></td><td><input type='checkbox' name='checkall' onclick='checkedAll(f1);'></td></tr>";
                    $i = 0;
                    $y = 1;
                    while (($file = readdir($directory_handle)) !== false) {
                        #Se l'elemento trovato è diverso da una directory
                        #o dagli elementi . e .. lo visualizzo a schermo
                        if ((!is_dir($file)) & ($file != ".") & ($file != "..")) {
                            $array[$i] = $file;
                            echo "<tr style='height: 30px'><td>$y.&nbsp&nbsp&nbsp<a href=" . $base . $file . " onclick='window.open(this.href);return false' title='" . $file . "'>" . $file . "</a></td><td><input type='checkbox' name='" . $i . "' value='checked'/></td></tr>";
                            $i++;
                            $y++;
                        }
                    }
                    echo "</table><br/><input type='submit' name='bottoni6' value='Delete' id='bottone_keyword' class='bottoni'></center></form><br/>";
                    #Chiudo la lettura della directory.
                    closedir($directory_handle);
                }
            }
            $z = 0;
            $lunghezza = $i;
            if (isset($_POST['bottoni5'])) {
                if ($i == 0) {
                    echo "<center>NO PREPRINTS!</center>";
                } else {
                    #richiamo funzione per inserire i pdf all'interno del database
                    insert_pdf();
                    echo "<center>HAVE BEEN INCLUEDED " . $i . " PREPRINTS INTO DATABASE!</center>";
                    #aggiorno la pagina dopo 2 secondi
                    page_redirect("./check_preprints.php");
                }
            }
            #eliminazione pdf...
            if (isset($_POST['bottoni6'])) {
                for ($j = 0; $j < $lunghezza; $j++) {
                    $percorso = $base . $array[$j];
                    $delete = $_POST[$j];
                    if ($delete == "checked") {
                        $z++;
                        if (is_dir($directory)) {
                            if ($directory_handle = opendir($directory)) {
                                while (($file = readdir($directory_handle)) !== false) {
                                    if ((!is_dir($file)) & ($file != ".") & ($file != "..")) {
                                        if ($file == $array[$j]) {
                                            #cancello file...
                                            unlink($percorso);
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
                if ($z == 0) {
                    echo "<center>NOTHING SELECTED!</center><br/><br/><br/><br/>";
                } else {
                    echo "<center>" . $z . " SELECTED PREPRINTS REMOVED! PAGE WILL BEEN UPDATED BETWEEN 2 SECONDS!</center><br/><br/><br/><br/>";
                    #aggiorno la pagina dopo 2 secondi
                    page_redirect("./check_preprints.php");
                }
            }
            if ($i == 0) {
                echo "<center>NO PREPRINTS!</center>";
            }
            #funzione di aggiornamento della pagina...

            function page_redirect($location) {
                echo '<META HTTP-EQUIV="Refresh" Content="2; URL=' . $location . '">';
                exit;
            }
            ?>
        </div>
    </body>
</html>
