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
        <script src="http://cdn.jsdelivr.net/webshim/1.12.4/extras/modernizr-custom.js"></script>
        <script src="http://cdn.jsdelivr.net/webshim/1.12.4/polyfiller.js"></script>
        <script>
            webshims.setOptions('waitReady', false);
            webshims.setOptions('forms-ext', {types: 'date'});
            webshims.polyfill('forms forms-ext');
        </script>
        <script type="text/x-mathjax-config">
            MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}});
        </script>
        <script type="text/javascript"
                src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
        </script>
        <script type="text/javascript" src="./js/allscript.js">
        </script>
    </head>
    <body>
        <?php
        #importo file per utilizzare funzioni...
        require_once './graphics/loader.php';
        require_once './authorization/sec_sess.php';
        include_once './arXiv/check_nomi_data.php';
        include_once './arXiv/insert_remove_db.php';
        include_once './mysql/func.php';
        #importazione variabili globali
        include './header.inc.php';
        sec_session_start();
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] < 86400)) {
            #if ($_SESSION['nome']." (".$_SESSION['uid'].")" == $row['uid'] && $row['uid'] != ""){
            if (($_SESSION['logged_type'] === "mod" or $_SESSION['logged_type'] === "user") &&
                    ($_SESSION['uid'] == $_GET['r'])) {
                //sessione moderatore
                echo "<div id='gotop' hidden><a id='scrollToTop' title='Go top'><img style='width:25px; height:25px;' src='./images/top.gif'></a></div>";
                if ($_COOKIE['searchbarall'] == "1") {
                    #search bar
                    require_once './graphics/searchbar_bottom.php';
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
                    <center>
                        <div>
                            <br/>
                            <br/>
                            <h2>manual editing</h2>
                        </div>
                    </center>
                    <form name="f1" action="uploaded.php" method="GET">
                        <div id="boxsx">Go to uploaded
                        </div>
                        <div id="boxdx">
                            <input type="submit" name="b1" value="Back" id='bottone_keyword' class='button' onclick="return confirmExit()">
                        </div>
                    </form><br/>
                    <?php
                    echo "<hr style='display: block; height: 1px; border: 0; border-top: 1px solid #ccc; margin: 1em 0; padding: 0;'>";
                    if (isset($_POST['b8']) or isset($_POST['b9']) or isset($_POST['b11']) or isset($_POST['b10']) or isset($_GET['id'])) {
                        if (empty($_POST['id'])) {
                            $id = $_GET['id'];
                        } else {
                            $id = $_POST['id'];
                        }
                        #adattamento stringa
                        $id = trim($id);
                        #funzione per recupero informazioni dell'preprint
                        $ris = cercapreprint($id);
                        if ($ris[0] == $id) {
                            #sblocco altri campi
                            $var = True;
                        } else {
                            echo '<script type="text/javascript">alert("ID incorrect!");</script>';
                        }
                    }
                    if ($var == True) {
                        echo "<script type='text/javascript'>
				function confirmExit()
				{
				   return confirm('All unsaved changes will be lost, continue?');
				}
			</script>
                <form name='f1' action='edit.php?r=" . $_GET['r'] . "' method='POST' enctype='multipart/form-data' onsubmit='loading(load);'>
                    <center><h2>Publication informations</h2><h1>field with '*' are required.</h1><br/><input type='reset' name='reset' value='Reset'><br/><br/></center>
                            <div id='divinsertcateg'>
                            <div style='float:right; width:49%;'>
                                <div style='font-weight: bold;'>
                                    document:
                                </div>
                                <div style='float:right; width:49%;'>
                                    <a href=./pdf/" . $ris[9] . " onclick='window.open(this.href);return false' style='color:#007897;' title='" . $ris[9] . "'>VIEW</a>
                                </div>
                            </div>
                                <div style='font-weight: bold;'>
                                    id(not editable):</div>
                                <textarea readonly style='width:49%;' name='id' id='textbox' class='textbox' placeholder='example of id: 0000.0000v1'>" . $ris[0] . "</textarea><br/><br/>
                                <div style='font-weight: bold;'>
                                    date(not editable):
                                </div>
                                <textarea readonly style='width:49%;' name='data' id='textbox' class='textbox' placeholder='example of data: 2011-12-30T10:37:35Z'>" . $ris[2] . "</textarea>
                        </div>
                        
                        <div>
                            <div id='divinsert'>
                                <div id='divcontinsert'>
                                    *category:<br/>
                                    <textarea name='category' id='textbox' class='textbox' required placeholder='example of category: math.NA...' onkeyup='UpdateMathcat(this.value)' >" . $ris[6] . "</textarea>
                                </div>
                            </div>
                            <div id='divpreview'>
                                <div style='font-weight: bold;'>
                                    preview:
                                </div>
                                <div id='divcontpreview'>
                                    <div id='categorydiv'></div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div id='divinsert'>
                                <div id='divcontinsert'>
                                    *title:<br/>
                                    <textarea name='title' id='textbox' class='textbox' required placeholder='example of title: The geometric...' onkeyup='UpdateMathtit(this.value)'>" . $ris[1] . "</textarea>
                                </div>
                            </div>
                            <div id='divpreview'>
                                <div style='font-weight: bold;'>
                                    preview:
                                </div>
                                <div id='divcontpreview'>
                                    <div id='titlediv'></div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div id='divinsert'>
                                <div id='divcontinsert'>
                                    *authors:<br/>
                                    <textarea name='author' id='textbox' class='textbox' required placeholder='example of author: Mario Rossi, Luca...' onkeyup='UpdateMathaut(this.value)'>" . $ris[3] . "</textarea>
                                </div>
                            </div>
                            <div id='divpreview'>
                                <div style='font-weight: bold;'>
                                    preview:
                                </div>
                                <div id='divcontpreview'>
                                    <div id='authordiv'></div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div id='divinsert'>
                                <div id='divcontinsert'>
                                    journal reference:<br/>
                                    <textarea name='journal' id='textbox' class='textbox' placeholder='example of Journal: Numer. Linear Algebra...' onkeyup='UpdateMathjou(this.value)'>" . $ris[4] . "</textarea>
                                </div>
                            </div>
                            <div id='divpreview'>
                                <div style='font-weight: bold;'>
                                    preview:
                                </div>
                                <div id='divcontpreview'>
                                    <div id='journaldiv'></div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div id='divinsert'>
                                <div id='divcontinsert'>
                                    comments:<br/>
                                    <textarea name='comments' id='textbox' class='textbox' placeholder='example of comments: 10 pages...' onkeyup='UpdateMathcom(this.value)'>" . $ris[5] . "</textarea>
                                </div>
                            </div>
                            <div id='divpreview'>
                                <div style='font-weight: bold;'>
                                    preview:
                                </div>
                                <div id='divcontpreview'>
                                    <div id='commentsdiv'></div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div id='divinsert'>
                                <div id='divcontinsertabs'>
                                    *abstract:<br/>
                                    <textarea name='abstract' id='textboxabs' class='textbox' required placeholder='example of abstract: The geometric...' onkeyup='UpdateMathabs(this.value)'>" . $ris[7] . "</textarea>
                                </div>
                            </div>
                            <div id='divpreview'>
                                <div style='font-weight: bold;'>
                                    preview:
                                </div>
                                <div id='divcontpreviewabs'>
                                    <div id='abstractdiv'></div>
                                </div>
                            </div>
                        </div>
                        <div style='clear:both;'></div>

                            <center><div style='font-weight: bold;'>file to upload:</div>
                            <input type='hidden' name='MAX_FILE_SIZE' value='10000000'>
                            <input type='file' name='fileToUpload' id='fileToUpload'><br/>
                            <br/><input type='submit' name='b9' value='Remove' style='width:60px;' id='bottone_keyword' class='button' onclick='return confirmDelete2()'/>
                            <input type='submit' name='b10' value='Upgrade' style='width:60px;' id='bottone_keyword' class='button' onclick='return confirmUpgrade()'/>
                            <input type='submit' name='b11' value='Update' style='width:60px;' id='bottone_keyword' class='button' onclick='return confirmInsert2()'/></center>
                            </form>";
                        $ris[1] = str_replace("<br />", "", $ris[1]);
                        $ris[1] = str_replace("\n", "", $ris[1]);
                        $ris[7] = str_replace("<br />", "", $ris[7]);
                        $ris[7] = str_replace("\n", "", $ris[7]);
                        echo "<script type='text/javascript'>UpdateMathcat('" . $ris[6] . "')</script>
				    <script type='text/javascript'>UpdateMathtit('" . $ris[1] . "')</script>
				    <script type='text/javascript'>UpdateMathaut('" . $ris[3] . "')</script>
				    <script type='text/javascript'>UpdateMathjou('" . $ris[4] . "')</script>
				    <script type='text/javascript'>UpdateMathcom('" . $ris[5] . "')</script>
				    <script type='text/javascript'>UpdateMathabs('" . $ris[7] . "')</script>";
                        $target_file = $basedir . basename($_FILES["fileToUpload"]["name"]);
                        #bottone cancella
                        if (isset($_POST['b9'])) {
                            $id1 = $_POST['id'];
                            #eliminazione del preprint selezionato
                            delete_pdf($id1);
                            cancellaselected($id1);
                            echo '<script type="text/javascript">
                            alert("Publication ' . $_POST['id'] . ' removed correctly!");
                            window.close();</script>';
                            echo '<META HTTP-EQUIV="Refresh" Content="0; URL=./uploaded.php">';
                        }
                        #bottone upgrade
                        if (isset($_POST['b10'])) {
                            if (empty($_POST['journal'])) {
                                $info[4] = "No journal ref";
                            } else {
                                $info[4] = $_POST['journal'];
                            }
                            if (empty($_POST['comments'])) {
                                $info[5] = "No journal ref";
                            } else {
                                $info[5] = $_POST['comments'];
                            }
                            $rest = substr($_POST['id'], 0, -1);
                            $len = strlen($_POST['id']);
                            $ver = substr($_POST['id'], $len - 1, $len);
                            $ver++;
                            $info[0] = $rest . $ver;
                            $info[1] = $_POST['title'];
                            $info[2] = $_POST['data'];
                            $info[3] = $_POST['author'];
                            $info[6] = $_POST['category'];
                            $info[7] = $_POST['abstract'];
                            if ($_FILES["fileToUpload"]["size"] > 0) {
                                #caricamento del file scelto
                                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                                    $fileType = $_FILES["fileToUpload"]["type"];
                                    #richiamo della funzione per il versionamento dei preprints
                                    version_preprintd($info[0]);
                                    #richiamo della funzione per inserire le info del preprint all'interno del database
                                    insert_p($info, $_GET['r']);
                                    rename($basedir . $_FILES["fileToUpload"]["name"], $basedir . $info[0] . ".pdf");
                                    #spostamento pdf
                                    #inserimento nel database del file
                                    insertpdf($info[0], $fileType);
                                    echo '<script type="text/javascript">
                                    alert("Publication ' . $_POST['id'] . ' upgrated to ' . $info[0] . ' correctly!");
                                    window.close();</script>';
                                } else {
                                    echo '<script type="text/javascript">alert("Error, file not uploaded!");</script>';
                                }
                            } else {
                                echo '<script type="text/javascript">alert("Select file to upload!");</script>';
                            }
                        }
                        #bottone aggiorna info
                        if (isset($_POST['b11'])) {
                            if (empty($_POST['journal'])) {
                                $info[4] = "No journal ref";
                            } else {
                                $info[4] = $_POST['journal'];
                            }
                            if (empty($_POST['comments'])) {
                                $info[5] = "No journal ref";
                            } else {
                                $info[5] = $_POST['comments'];
                            }
                            $info[0] = $_POST['id'];
                            $info[1] = $_POST['title'];
                            $info[2] = $_POST['data'];
                            $info[3] = $_POST['author'];
                            $info[6] = $_POST['category'];
                            $info[7] = $_POST['abstract'];
                            #richiamo della funzione per inserire le info del preprint all'interno del database
                            update_preprints($info);
                            $check = $_POST['check'];
                            #controllo se ci sono file da caricare
                            if ($_FILES["fileToUpload"]["size"] > 0) {
                                #caricamento del file scelto
                                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                                    $fileType = $_FILES["fileToUpload"]["type"];
                                    #inserimento nel database del file
                                    insert_one_pdf($info[0], $fileType);
                                    echo '<script type="text/javascript">alert("Publication ' . $_POST['id'] . ' updated correctly!");
                                    window.close();</script>';
                                } else {
                                    echo '<script type="text/javascript">alert("Error, file not uploaded!");</script>';
                                }
                            } else {
                                echo '<script type="text/javascript">alert("Publication ' . $_POST['id'] . ' updated correctly!");
                                window.close();</script>';
                            }
                        }
                        echo "<hr style='display: block; height: 1px; border: 0; border-top: 1px solid #ccc; margin: 1em 0; padding: 0;'>";
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
        <br/>
        <br/>
</body>
</html>
