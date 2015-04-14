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
                
                <div id="div_menu_ricerca" class="contenitore"><center><br/><h2>ARXIV PANEL</h2></center><a href="" title="Guide">Help</a><br/><br/><br/>
                    <center><table>
                            <tr><form name="f5" action="reserved.php" method="POST">
                                <td align="right" style="width:350px;">Go to reserved area&nbsp&nbsp&nbsp</td>
                                <td style="width:350px;"><input type="submit" name="bottoni4" value="Back" id="bottone_keyword" class="bottoni"></td>
                            </form></tr>
                            <tr><form name="f2" action="check_preprints.php" method="POST">
                                <td align="right" style="width:350px;">
Controls the preprints recently downloaded&nbsp&nbsp&nbsp</td>
                                <td style="width:350px;"><input type="submit" name="bottoni1" value="Displays" id="bottone_keyword" class="bottoni"></td>
                            </form></tr>
                            <tr><form name="f3" action="authors_list.php" method="POST">
                                <td align="right" style="width:350px;">List of authors&nbsp&nbsp&nbsp</td>
                                <td style="width:350px;"><input type="submit" name="bottoni2" value="View" id="bottone_keyword" class="bottoni"></td>
                            </form></tr>
                            <tr><form name="f1" action="arXiv_panel.php" method="POST">
                                <td align="right" style="width:350px;">Refresh from arXiv for new preprints&nbsp&nbsp&nbsp</td>
                                <td style="width:350px;"><input type="submit" name="bottoni" value="Update" id="bottone_keyword" class="bottoni"></td>
                            </form></tr>
                            <tr><form name="f4" action="arXiv_panel.php" method="POST">
                                <td align="right" style="width:350px;">Download all from arXiv, this take several time!&nbsp&nbsp&nbsp</td>
                                <td style="width:350px;"><input type="submit" name="bottoni3" value="Download" id="bottone_keyword" class="bottoni"></td>
                            </form></tr>
                        </table></center><br/><br/>
                    <?php
                    include_once($_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'arXiv/arXiv_parsing.php');
                    include_once($_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'arXiv/check_nomi_data.php');
                    if (isset($_POST['bottoni'])) {
                    	if(sessioneavviata() == False){
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
		                if($nl == 0){
		                    echo "<center><br/>NO AUTHORS INSIDE LIST!<br/></center>";
		                }else{
		                    echo "<center><a href='javascript:FinePagina()'>&#8595;end of page</a></center><br/>AUTHORS UPDATE:<br/>";
		                }
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
		                echo "<br/>ALL AUTHORS UPDATES COMPLETE! " . "NEW PREPRINTS DOWNLOADED &#8658; " . $j . "<br/>";
                        }else{
                        	echo "UPDATE SESSION IS ALREADY STARTED FROM OTHER USER!<br/>";
                        }
                    }
                    if (isset($_POST['bottoni3'])) {
                        if(sessioneavviata() == False){
		                #avvio della sessione
		            	avviasessione();
		                #inizializzo variabile j per contare elementi scaricati...
		                $j = 0;
		                #leggo i nomi dal file nomi.txt
		                $array = legginomi();
		                #conto lunghezza dell'array $array
		                $nl = count($array);
		                if($nl == 0){
		                    echo "<center><br/>NO AUTHORS INSIDE LIST!<br/></center>";
		               	}else{
		               	    echo "<center><a href='javascript:FinePagina()'>&#8595;end of page</a></center><br/>AUTHORS UPDATE:<br/>";
		               	}
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
		                echo "<br/>ALL AUTHORS DOWNLOADS COMPLETE! " . "PREPRINTS DOWNLOADED &#8658; " . $j . "<br/>";
                        }else{
                        	echo "DOWNLOAD SESSION IS ALREADY STARTED FROM OTHER USER!<br/>";
                        }
                    }
                    if(sessioneavviata() == True){
                    	echo "WARNING ONE DOWNLOAD/UPDATE SESSION IS RUNNING AT THIS TIME! THE SECTIONS 'PREPRINTS CHECK' AND 'AUTHORS LIST' HAS BEEN BLOCKED!";
                    }else{
		            #memorizzo in $data dell'ultimo aggiornamento e la visualizzo
		            $data = datastring();
		            echo " LAST UPDATE: " . $data;
                    }
                    if((isset($_POST['bottoni']) or isset($_POST['bottoni3']))and($nl != 0)){
                    	echo "<br/><br/><center><a href='javascript:window.scrollTo(0,0)'>&#8593; top of page</a></center>";
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
