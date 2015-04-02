<!DOCTYPE html>
<html>
    <head>
        <title>AUTHORS LIST</title>
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
                <div id="div_menu_ricerca" class="contenitore"><center>EDIT LIST</center><br/><br/>
                    <center><table>
                            <tr align="right"><td>Go to arXiv panel:&nbsp&nbsp&nbsp</td>
                            <form name="f1" action="arXiv_panel.php" method="POST">
                                <td><input type="submit" name="bottoni7" value="Back" id="bottone_keyword" class="bottoni"></td>
                            </form></tr>

                            <form name="f2" action="authors_list.php" method="POST">
                                <tr align="right"><td>Add author to table(Use " , " to insert more authors):&nbsp&nbsp&nbsp</td>
                                    <td><input type="submit" name="bottoni8" value="Insert" id="bottone_keyword" class="bottoni"></td></tr>
                                <tr align="center"><td colspan="2"><br/><textarea style="width:450px; height:20px" name="txt1" id="textbox"></textarea></td></tr>
                                            </form>
                                        </table></center>
                                </div>
                                <div>
                    <?php
                    #importo file per utilizzare funzioni...
                    include_once($_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'arXiv/check_nomi_data.php');
                    if (isset($_POST['bottoni8'])) {
                        #controllo del campo testo vuoto
                        if (empty($_POST['txt1'])) {
                            echo "<center>FIELD NAME EMPTY!<br/><br/></center>";
                        } else {
                            $name = $_POST['txt1'];
                            #verifico se il nome è già presente
                            $ris = cercanome($name);
                            #inserimento del nome nel file
                            aggiungiutente($name);
                        }
                    }
                    #visualizzo lista utenti...	
                    $nomi = legginomi();
                    #conto lunghezza array
                    $lunghezza = count($nomi);
                    echo "<center></center><br/>";
                    echo "<form name='f4' action='authors_list.php' id='f1' method='POST'><center><table style='text-align:center;'>";
                    echo "<tr style='height: 30px; width:200px'><td colspan='2' style='width:250px'>AUTHORS LIST:</td></tr><tr style='height: 30px'><td>Name:</td><td>Select all/<br/>Select<br/></td></tr><tr style='margin-top:5px; height: 30px; width:200px'><td></td><td><input type='checkbox' name='checkall' onclick='checkedAll(f1);'></td></tr>";
                    #creazione della tabella html dei file all'interno di pdf_downloads
                    $y = 1;
                    for ($i = 0; $i < $lunghezza; $i++) {
                        echo "<tr style='height: 30px'><td>$y.&nbsp&nbsp&nbsp" . $nomi[$i] . "</td><td><input type='checkbox' name='" . $i . "' value='checked'/></td></tr>";
                        $y++;
                    }
                    echo "</table><br/><input type='submit' name='bottoni9' value='Delete' id='bottone_keyword' class='bottoni'>
</center></form><br/>";

                    if ($lunghezza == 0) {
                        echo "<center>NO AUTHORS INSIDE LIST!</center>";
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
                            echo "<center>NO AUTHOR SELECTED!</center><br/><br/><br/>";
                        } else {
                            echo "<br/><center>" . $nomieliminati . " DELETED FROM LIST! PAGE WILL BEEN UPDATED BETWEEN 2 SECONDS!</center><br/><br/><br/>";
                            echo '<META HTTP-EQUIV="Refresh" Content="2; URL=./authors_list.php">';
                        }
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
