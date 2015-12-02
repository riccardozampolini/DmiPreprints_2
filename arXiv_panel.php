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
        <script type="text/x-mathjax-config">
            MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}});
        </script>
        <script type="text/javascript"
                src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
        </script>
    </head>
    <body>
        <?php
        require_once './authorization/sec_sess.php';
        sec_session_start();
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] < 86400)) {
            if ($_SESSION['logged_type'] === "mod") {
                echo "<div id='gotop' hidden><a id='scrollToTop' title='Go top'><img style='width:25px; height:25px;' src='./images/top.gif'></a></div>";
                if ($_COOKIE['searchbarall'] == "1") {
                    //searchbar bassa
                    require_once './searchbar_bottom.php';
                }
                //sessione moderatore
                ?>
                <div onclick="myFunction2()">
                    <div id="header-wrapper">
                        <div class="container">
                            <div class="row">
                                <div class="12u">
                                    <header id="header">
                                        <h1><a href="#" id="logo">DMI Papers</a></h1>
                                        <nav id="nav">
                                            <a href="./view_preprints.php" onclick="loading(load);">Publications</a>
                                            <a href="./reserved.php" class="current-page-item" class="current-page-item" onclick="loading(load);">Reserved Area</a>
                                        </nav>
                                    </header>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br/><br/>
                    <div>
                        <div>
                            <center><h2>ARXIV PANEL</h2></center>
                            <div id="boxsx">
                                Go to admin panel
                            </div>
                            <div id="boxdx">
                                <a style="color:#3C3C3C;" href="./reserved.php" id="bottone_keyword" class="buttonlink" onclick="loading(load);">Back</a>
                            </div>
                            <div id="boxsx">
                                The authors list
                            </div>
                            <div id="boxdx">
                                <a style="color:#3C3C3C;" href="./authors_list.php" id="bottone_keyword" class="buttonlink" onclick="loading(load);">Authors section</a>
                            </div>
                            <div id="boxsx">
                                Insert a paper
                            </div>
                            <div id="boxdx">
                                <a style="color:#3C3C3C;" href="./manual_insert.php" id="bottone_keyword" class="buttonlink" onclick="loading(load);">Enter manually</a>
                            </div>
                            <div id="boxsx">
                                approve papers
                            </div>
                            <div id="boxdx">
                                <a style="color:#3C3C3C;" href="./check_preprints.php" id="bottone_keyword" class="buttonlink" onclick="loading(load);">Check section</a>
                            </div>
                            <div id="boxsx">
                                Search for new papers
                            </div>
                            <div id="boxdx">
                                <form name="f8" action="arXiv_panel.php" method="POST" onsubmit="loading(load);">
                                    <input style="width:110px;" type="submit" name="b8" value="Start update" id="bottone_keyword" class="button">
                                </form>
                            </div>
                            <div id="boxsx">
                                Download all from arXiv!
                            </div>
                            <div id="boxdx">
                                <form name="f9" action="arXiv_panel.php" method="POST">
                                    <input style="width:110px;" type="submit" name="b9" value="Overwrite All" id="bottone_keyword" class="button" onclick="return confirmDownload()">
                                </form>
                            </div>
                            <div style="clear:both;"></div>
                        </div>
                        <center>
                            <hr style="display: block; height: 1px; border: 0; border-top: 1px solid #ccc; margin: 1em 0; padding: 0;">
                            <?php
                            include_once './arXiv/arXiv_parsing.php';
                            include_once './arXiv/check_nomi_data.php';
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
                                            echo "<br/>PAPERS DOWNLOADED: " . $j . "<br/><br/>";
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
                                            echo "<br/>PAPERS DOWNLOADED: " . $j . "<br/><br/>";
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
                                #controllo se ci sono state interruzioni
                                if (controllainterruzione() == True) {
                                    echo '<script type="text/javascript">alert("The last update was not stopped properly, was performed a new update!");</script>';
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
                                                echo "<br/>PAPERS DOWNLOADED: " . $j . "<br/><br/>";
                                                $dc1 = true;
                                            }
                                        } else {
                                            echo '<script type="text/javascript">alert("UPDATE SESSION IS ALREADY STARTED FROM OTHER ADMIN!");</script>';
                                            $risul = true;
                                            #sessione già avviata
                                        }
                                    }
                                }
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
                </center>
                <?php
                ?>
                <br/>
            </div>
        </div>
        <br/>
        <br/>
    <center>
        <div id="load">
            <img src="./images/loader.gif" alt="Loading" style="width: 192px; height: 94px;">
        </div>
    </center>
</body>
</html>
