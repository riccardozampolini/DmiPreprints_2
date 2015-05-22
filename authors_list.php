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
                                        <a href='view_preprints.php?p=1&w=0'>Publications</a>
=======
                                        <a href="main.php">DMI Publications</a>
                                        <a href='view_preprints.php?p=1&w=0'>arXiv Publications</a>
>>>>>>> 9cac3c0f916efa1df43ac8735e569ea4ba074c9a
                                        <a href="reserved.php" class="current-page-item">Reserved Area</a>
                                    </nav>
                                </header>
                            </div>
                        </div>
                    </div>
                </div>
                <br/><div><center><br/><h2>AUTHORS LIST</h2></center>
                    <center><table>
                            <tr><form name="f1" action="arXiv_panel.php" method="GET"><td align="right">Go to arXiv panel&nbsp&nbsp&nbsp</td>
                                <td colspan="2"><input type="submit" name="b1" value="Back" id="bottone_keyword" class="bottoni"/></td></form></tr><tr><td align="center" colspan="3"><br/></td></tr>

                            <tr><form name="f2" action="authors_list.php" method="POST">
                                <td align="right">
                                    <label><input type="checkbox" name="insert" value="1" checked/>
                                        Add author to list or search by name&nbsp&nbsp&nbsp</label>
                                </td>
                                <td>
                                    <input type="search" style="width:173px;" id='textbox' class='textbox' autocomplete = "on" required name="txt1" placeholder="name1, name2, name..." autofocus />
                                </td>
                                <td>
                                    <input type="submit" name="b2" value="Insert/Search" style="width:80px;" id="bottone_keyword" class="bottoni"/>
                                </td>
                            </form></tr>
                        </table></center>
                </div>
                <div>
                    <?php
                    #importo file per utilizzare funzioni...
                    include_once($_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'arXiv/check_nomi_data.php');
                    if (sessioneavviata() == True) {
                        echo "<center><br/><br/>SORRY ONE DOWNLOAD/UPDATE SESSION IS RUNNING AT THIS TIME! THE LIST CAN'T BE CHANGED IN THIS MOMENT!</center><br/>";
                    } else {
                        echo "<center><br/><a style='text-decoration: none;' href='javascript:FinePagina()'> &nbsp&nbsp&nbsp&nbsp&nbsp&#8595; &nbsp&nbsp&nbsp&nbsp&nbsp</a></center>";
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
                        echo "<tr><td><input type='checkbox' name='checkall' onclick='checkedAll(f1);'/>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<font color='#007897'>NAME:</color></td></tr>";
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
    </body>
</html>
