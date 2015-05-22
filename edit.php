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
        <script src="http://cdn.jsdelivr.net/webshim/1.12.4/extras/modernizr-custom.js"></script>
        <script src="http://cdn.jsdelivr.net/webshim/1.12.4/polyfiller.js"></script>
        <script>
            webshims.setOptions('waitReady', false);
            webshims.setOptions('forms-ext', {types: 'date'});
            webshims.polyfill('forms forms-ext');
        </script>
        <script type='text/javascript'>
            function confirmDelete()
            {
                return confirm("Delete this preprint?");
            }
            function confirmInsert()
            {
                return confirm("Update preprint information?");
            }
            function confirmUpgrade()
            {
                return confirm("Upgrade preprint version?");
            }
        </script>

    </head>
    <body>
        <?php
        #importo file per utilizzare funzioni...
        require_once $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'authorization/sec_sess.php';
        include_once($_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'arXiv/check_nomi_data.php');
        include_once($_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'arXiv/insert_remove_db.php');
        include_once($_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'mysql/func.php');
        sec_session_start();
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] < 86400)) {
            if (($_SESSION['logged_type'] === "mod" or $_SESSION['logged_type'] === "user") && $_SESSION['uid'] == $_GET['r']) {
                //sessione moderatore
                ?>
                <div id="header-wrapper">
                    <div class="container">
                        <div class="row">
                            <div class="12u">
                                <header id="header">
                                    <h1><a href="#" id="logo">DMI Preprints</a></h1>
                                    <nav id="nav">
                                        <a href='view_preprints.php?p=1&w=0'>Publications</a>
                                        <a href="reserved.php" class="current-page-item">Reserved Area</a>
                                    </nav>
                                </header>
                            </div>
                        </div>
                    </div>
                </div>
                <div><center><br/><br/><h2>manual editing</h2></center>
                </div><center>
                <table>
                    <tr><form name="f1" action="uploaded.php" method="GET"><td align="right" style='width:150px; height:16px'>Go to arXiv panel&nbsp&nbsp&nbsp</td>
                        <td><input type="submit" name="b1" value="Back" id='bottone_keyword' class='bottoni' onclick="return confirmExit()"/></td>
                        </tr>
                    </form></table>
            </center>
            <?php
            if (!isset($_GET['id'])) {
                echo "<center><br/><a style='color:#007897;' href='./view_preprints.php?p=1&w=0' onclick='window.open(this.href); return false' title='Go to preprints list'>View from inserted preprints</a></center>";
                echo "<hr style='display: block; height: 1px; border: 0; border-top: 1px solid #ccc; margin: 1em 0; padding: 0;'>";
                echo " <center><div><form name='f2' action='manual_edit.php' method='POST'>Insert id of pubblication: <input type='search' autocomplete = 'on' style='width:175px;' name='id' id='textbox' required class='textbox' placeholder='example of id: 0000.0000v1' autofocus/> <input type='submit' name='b8' value='Get preprint' style='width:70px;' id='bottone_keyword' class='bottoni'/><br/>
		               </form></div>
		               ";
                $var = False;
            }
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
                <form name='f1' action='edit.php?r=" . $_GET['r'] . "' method='POST' enctype='multipart/form-data'>
                    <center><div><br/><h2>preprint informations</h2><h1>field with '*' are required</h1><br/><input type='reset' name='reset' value='Reset' style='width:40px;' id='bottone_keyword' class='bottoni'><br/><br/>
			    id of pubblication (not editable):<br/><br/>
                            <textarea readonly style='width:65%; height:16px' name='id' id='textbox' class='textbox' placeholder='example of id: 0000.0000v1'>" . $ris[0] . "</textarea><br/><br/><br/>
                            data of pubblication (not editable):<br/><br/>
                            <textarea readonly style='width:65%; height:16px' name='data' id='textbox' class='textbox' placeholder='example of data: 2011-12-30T10:37:35Z'>" . $ris[2] . "</textarea><br/><br/><br/>
                            *preprint title:<br/><br/>
                            <textarea style='width:65%; height:16px' name='title' id='textbox' class='textbox' required placeholder='example of title: The geometric...' autofocus>" . $ris[1] . "</textarea><br/><br/><br/>
                            journal reference:<br/><br/>
                            <textarea style='width:65%; height:16px' name='journal' id='textbox' class='textbox' placeholder='example of Journal: Numer. Linear Algebra...'>" . $ris[4] . "</textarea><br/><br/><br/>
                            comments:<br/><br/>
                            <textarea style='width:65%; height:16px' name='comments' id='textbox' class='textbox' placeholder='example of comments: 10 pages...'>" . $ris[5] . "</textarea><br/><br/><br/>
                            *arXiv category:<br/><br/>
                            <textarea style='width:65%; height:16px' name='category' id='textbox' class='textbox' required placeholder='example of category: math.NA...'>" . $ris[6] . "</textarea><br/><br/><br/>
                            *authors name:<br/><br/>
                            <textarea style='width:65%; height:16px' name='author' id='textbox' class='textbox' required placeholder='example of author: Mario Rossi, Luca...'>" . $ris[3] . "</textarea><br/><br/><br/>
                            *abstract:<br/><br/>
                            <textarea style='width:65%; height:300px' name='abstract' id='textbox' class='textbox' required placeholder='example of abstract: The geometric...'>" . $ris[7] . "</textarea><br/><br/>
                            file to upload: <br/>
                            <input type='hidden' name='MAX_FILE_SIZE' value='10000000'><br/>
                            <input type='file' name='fileToUpload' id='fileToUpload'><br/><br/><br/>
                            <br/><input type='submit' name='b9' value='Remove' style='width:60px;' id='bottone_keyword' class='bottoni' onclick='return confirmDelete()'/>
                            <input type='submit' name='b10' value='Upgrade' style='width:60px;' id='bottone_keyword' class='bottoni' onclick='return confirmUpgrade()'/>
                            <input type='submit' name='b11' value='Complete' style='width:60px;' id='bottone_keyword' class='bottoni' onclick='return confirmInsert()'/><br/><br/>
                            </form>";
                $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints' . "/upload_dmi/";
                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                #bottone cancella
                if (isset($_POST['b9'])) {
                    $id1 = $_POST['id'];
                    #eliminazione del preprint selezionato
                    delete_pdf($id1);
                    cancellaselected($id1);
                    echo '<script type="text/javascript">alert("Preprint ' . $info[0] . ' removed correctly!");</script>';
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
                            rename($target_dir . $_FILES["fileToUpload"]["name"], $target_dir . $info[0] . ".pdf");
                            #spostamento pdf
                            #inserimento nel database del file
                            insertpdf($info[0], $fileType);
                            echo '<script type="text/javascript">alert("Preprint ' . $_POST['id'] . ' upgrated to ' . $info[0] . ' correctly!");</script>';
                            echo '<META HTTP-EQUIV="Refresh" Content="0; URL=./uploaded.php">';
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
                            echo '<script type="text/javascript">alert("Preprint ' . $info[0] . ' updated correctly!");</script>';
                            echo '<META HTTP-EQUIV="Refresh" Content="0; URL=./uploaded.php">';
                        } else {
                            echo '<script type="text/javascript">alert("Error, file not uploaded!");</script>';
                        }
                    } else {
                        echo '<script type="text/javascript">alert("Preprint ' . $info[0] . ' updated correctly!");</script>';
                        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=./uploaded.php">';
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
</div><br/><br/></center>
</body>
</html>
