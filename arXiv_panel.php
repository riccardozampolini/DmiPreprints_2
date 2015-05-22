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
        <script type="text/javascript">
            function FinePagina()
            {
                var w = window.screen.width;
                var h = window.screen.height;
                window.scrollTo(w * h, w * h)
            }
            function confirmDownload()
            {
                return confirm("Warning! this overwrite the existent data and will take more time, continue?");
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
<<<<<<< HEAD
                                        <a href="view_preprints.php?p=1&w=0">Publications</a>
=======
                                        <a href="main.php">DMI Publications</a>
                                        <a href="view_preprints.php?p=1&w=0">arXiv Publications</a>
>>>>>>> 9cac3c0f916efa1df43ac8735e569ea4ba074c9a
                                        <a href="reserved.php" class="current-page-item" class="current-page-item">Reserved Area</a>
                                    </nav>
                                </header>
                            </div>
                        </div>
                    </div>
                </div>
                <div align="center"><center><br/><h2>ARXIV PANEL</h2></center>
                    <center><table>
                            <tr><form name="f1" action="reserved.php" method="GET">
                                <td align="right" style="width:350px;">Go to reserved area&nbsp&nbsp&nbsp</td>
                                <td style="width:350px;"><input type="submit" name="b1" value="Back" id="bottone_keyword" class="bottoni"/></td>
                            </form></tr>
<<<<<<< HEAD
=======
                            <tr><form name="f2" action="view_preprints.php" method="GET">
                                <input type="text" name="p" value="1" checked hidden/><input type="text" name="w" value="0" checked hidden/>
                                <td align="right" style="width:350px;">Preprints checked and inserted on database&nbsp&nbsp&nbsp</td>
                                <td style="width:350px;"><input type="submit" name="b2" value="Approved section" id="bottone_keyword" class="bottoni"/></td>
                            </form></tr>
                            <tr><form name="f3" action="archived_preprints.php" method="GET">
                                <input type="text" name="p" value="1" checked hidden/>
                                <td align="right" style="width:350px;">Archived preprints, contains old publications&nbsp&nbsp&nbsp</td>
                                <td style="width:350px;"><input type="submit" name="b3" value="Archived section" id="bottone_keyword" class="bottoni"/></td>
                            </form></tr>
>>>>>>> 9cac3c0f916efa1df43ac8735e569ea4ba074c9a
                            <tr><form name="f4" action="authors_list.php" method="GET">
                                <td align="right" style="width:350px;">List of authors that will be searched on arXiv&nbsp&nbsp&nbsp</td>
                                <td style="width:350px;"><input type="submit" name="b4" value="Authors section" id="bottone_keyword" class="bottoni"/></td>
                            </form></tr>
                            <tr><form name="f5" action="manual_insert.php" method="GET">
                                <td align="right" style="width:350px;">Insert manually one preprint&nbsp&nbsp&nbsp</td>
                                <td style="width:350px;"><input type="submit" name="b5" value="Insert section" id="bottone_keyword" class="bottoni"/></td>
                            </form></tr>
                            <tr><form name="f6" action="manual_edit.php" method="GET">
                                <td align="right" style="width:350px;">Manual editing for inserted preprints&nbsp&nbsp&nbsp</td>
                                <td style="width:350px;"><input type="submit" name="b6" value="Edit section" id="bottone_keyword" class="bottoni"/></td>
                            </form></tr>
                            <tr><form name="f7" action="check_preprints.php" method="GET">
                                <td align="right" style="width:350px;">
                                    Controls the preprints recently downloaded&nbsp&nbsp&nbsp</td>
                                <td style="width:350px;"><input type="submit" name="b7" value="Check section" id="bottone_keyword" class="bottoni"/></td>
                            </form></tr>
                            <tr><form name="f8" action="arXiv_panel.php" method="POST">
                                <td align="right" style="width:350px;">Refresh from arXiv for new preprints&nbsp&nbsp&nbsp</td>
                                <td style="width:350px;"><input type="submit" name="b8" value="Update from arXiv" id="bottone_keyword" class="bottoni"/></td>
                            </form></tr>
                            <tr><form name="f9" action="arXiv_panel.php" method="POST">
                                <td align="right" style="width:500px;">Download all from arXiv, this overwrites all data!&nbsp&nbsp&nbsp</td>
                                <td style="width:500px;"><input type="submit" name="b9" value="Download from arXiv" id="bottone_keyword" class="bottoni" onclick='return confirmDownload()'/></td>
                            </form></tr>
                        </table></center><br/><a style='text-decoration: none;' href='javascript:FinePagina()'> &nbsp&nbsp&nbsp&nbsp&nbsp&#8595;&nbsp&nbsp&nbsp&nbsp&nbsp </a><br/><hr style="display: block; height: 1px; border: 0; border-top: 1px solid #ccc; margin: 1em 0; padding: 0;">
                    <?php
                    include_once($_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'arXiv/arXiv_parsing.php');
                    include_once($_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'arXiv/check_nomi_data.php');
                    if (isset($_POST['b8'])) {
                        if ($sock = @fsockopen('www.arxiv.org', 80, $num, $error, 5)) {
                            if (sessioneavviata() == False) {
                                #avvio della sessione
                                avviasessione();
                                #inizializzo variabile j per contare elementi scaricati...
                                $j = 0;
                                #data ultimo lancio...
                                $data = dataprec();
                                #leggo nomi da file nomi.txt
                                $array = legginomi();
                                #conto lunghezza dell'array $array
                                $nl = count($array);
                                if ($nl == 0) {
                                    chiudisessione();
                                    echo '<script type="text/javascript">alert("No authors inside list!");</script>';
                                } else {
                                    #inizializzo variabile per contare preprints scaricati...
                                    for ($i = 0; $i < $nl; $i++) {
                                        $nomi = $array[$i];
                                        #rimozione spazi all'inizio e alla fine della stringa nomi
                                        $nomi = trim($nomi);
                                        #uso la funzione arxiv call per contare i download
                                        $j = $j + arxiv_call($nomi, $data);
                                    }
                                    #aggiornamento dei nomi nel file nomi_ultimo_lancio...
                                    aggiornanomi();
                                    #aggiornamento file data_ultimo_lancio.txt con la data di oggi...
                                    aggiornadata();
                                    #azzeramento file temporaneo...
                                    azzerapreprint();
                                    #chiudo la sessione di download
                                    chiudisessione();
                                    echo "<br/>PREPRINTS DOWNLOADED: " . $j . "<br/><br/>";
                                    $dc1 = true;
                                }
                            } else {
                                echo '<script type="text/javascript">alert("UPDATE SESSION IS ALREADY STARTED FROM OTHER ADMIN!");</script>';
                                $risul = true;
                                #sessione già avviata
                            }
                        }
                    }
                    if (isset($_POST['b9'])) {
                        if ($sock = @fsockopen('www.arxiv.org', 80, $num, $error, 5)) {
                            if (sessioneavviata() == False) {
                                #avvio della sessione
                                avviasessione();
                                #inizializzo variabile j per contare elementi scaricati...
                                $j = 0;
                                #leggo i nomi dal file nomi.txt
                                $array = legginomi();
                                #conto lunghezza dell'array $array
                                $nl = count($array);
                                if ($nl == 0) {
                                    chiudisessione();
                                    #nessun autore
                                    echo '<script type="text/javascript">alert("No authors inside list!");</script>';
                                } else {
                                    #inizializzo variabile per contare preprints scaricati...
                                    for ($i = 0; $i < $nl; $i++) {
                                        #inserisco un nome alla volta nella variabile $nomi
                                        $nomi = $array[$i];
                                        #rimozione dei spazi all'inizio e alla fine della stringha
                                        $nomi = trim($nomi);
                                        $j = $j + arxiv_call($nomi, 0);
                                    }
                                    #aggiornamento dei nomi nel file nomi_ultimo_lancio...
                                    aggiornanomi();
                                    #aggiornamento file data_ultimo_lancio.txt con la data di oggi...
                                    aggiornadata();
                                    #azzeramento temp
                                    azzerapreprint();
                                    #chiudo la sessione di download
                                    chiudisessione();
                                    echo "<br/>PREPRINTS DOWNLOADED: " . $j . "<br/><br/>";
                                    $dc2 = true;
                                }
                            } else {
                                echo '<script type="text/javascript">alert("DOWNLOAD SESSION IS ALREADY STARTED FROM OTHER ADMIN!");</script>';
                                $risul = true;
                            }
                        }
                    }
                    #server arxiv down o server interno non connesso
                    if (!$sock = @fsockopen('www.arxiv.org', 80, $num, $error, 5)) {
                        echo '<script type="text/javascript">alert("INTERNAL SERVER OFFLINE OR ARVIX IS DOWN IN THIS MOMENT!");</script>';
                        echo 'INTERNAL SERVER OFFLINE OR ARVIX IS DOWN IN THIS MOMENT!<br/><br/>';
                    }
                    if (sessioneavviata() == True) {
                        if ($risul != true) {
                            echo '<script type="text/javascript">alert("WARNING ONE DOWNLOAD/UPDATE SESSION IS RUNNING AT THIS TIME! THE SECTIONS HAS BEEN BLOCKED!");</script>';
                        }
                        echo "WARNING ONE DOWNLOAD/UPDATE SESSION IS RUNNING AT THIS TIME! THE SECTIONS HAS BEEN BLOCKED!";
                    } else {
                        #memorizzo in $data ultimo aggiornamento e la visualizzo
                        $data = datastring();
                        echo " LAST UPDATE: " . $data;
                        #update o download completato correttamente
                        if ($dc1 == true) {
                            echo '<script type="text/javascript">alert("Update complete!");</script>';
                        }
                        if ($dc2 == true) {
                            echo '<script type="text/javascript">alert("Download complete!");</script>';
                        }
                    }
                    echo "<hr style='display: block; height: 1px; border: 0; border-top: 1px solid #ccc; margin: 1em 0; padding: 0;'>";
                } else {
                    #credenziali non mod
                    echo '<script type="text/javascript">alert("ACCESS DENIED!");</script>';
                    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=./reserved.php">';
                }
            } else {
                echo '<META HTTP-EQUIV="Refresh" Content="0; URL=./reserved.php">';
            }
            ?>
            <center><a style='text-decoration: none;' href='javascript:window.scrollTo(0,0)'> &nbsp&nbsp&nbsp&nbsp&nbsp&#8593;&nbsp&nbsp&nbsp&nbsp&nbsp </a></center>
                <?php
                ?>
            <br/>
        </div>
    </body>
</html>
