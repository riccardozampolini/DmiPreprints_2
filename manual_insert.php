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
            function confirmInsert()
            {
                return confirm("All data are correct?");
            }
            function confirmDelete()
            {
                return confirm("Delete this preprint?");
            }
            function confirmExit()
            {
                return confirm('All unsaved changes will be lost, continue?');
            }
        </script>
    </head>
    <body>
        <?php
        #importo file per utilizzare funzioni...
        require_once $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'authorization/sec_sess.php';
        include_once($_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'arXiv/check_nomi_data.php');
        include_once($_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'arXiv/insert_remove_db.php');
        include_once($_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'arXiv/arXiv_parsing.php');
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
                                        <a href='view_preprints.php?p=1&w=0'>Publications</a>
                                        <a href="reserved.php" class="current-page-item">Reserved Area</a>
                                    </nav>
                                </header>
                            </div>
                        </div>
                    </div>
                </div>
                <div><center><br/><br/><h2>manual insertion</h2></center>
                </div><center><form name="f1" action="arXiv_panel.php" method="GET">
                    <table>
                        <tr><td align="right">Go to arXiv panel&nbsp&nbsp&nbsp</td>
                            <td><input type="submit" name="b1" value="Back" id='bottone_keyword' class='bottoni' onclick="return confirmExit()"/></td>
                        </tr>
                    </table><br/><a style='color:#007897;' href='http://arxiv.org/' onclick='window.open(this.href);
                                    return false' title='arXiv'>arXiv.org</a>
                </form></center><hr style="display: block; height: 1px; border: 0; border-top: 1px solid #ccc; margin: 1em 0; padding: 0;">
            <?php
            if (sessioneavviata() == True) {
                echo "<br/><br/><center>SORRY ONE DOWNLOAD/UPDATE SESSION IS RUNNING AT THIS TIME! THE SECTION CAN'T BE USED IN THIS MOMENT!</center><br/>";
            } else {
                ?>
                <center><div><form name='f2' action='manual_insert.php' method='POST'>Get informations of the preprint from arXiv: <input type='search' autocomplete = 'on' style='width:175px;' name='id' id='textbox' required class='textbox' placeholder='Insert id(arXiv): 0000.0000' autofocus/> <input type='submit' name='b7' value='Get preprint' style='width:70px;' id='bottone_keyword' class='bottoni'/><br/>
                        </form></div>
                    <hr style='display: block; height: 1px; border: 0; border-top: 1px solid #ccc; margin: 1em 0; padding: 0;'>
                    <?php
                    if (isset($_POST['b7'])) {
                        echo "<div hidden>";
                        $id = trim($_POST['id']);
                        arxiv_call($id, 0);
                        for ($i = 1; $i < 11; $i++) {
                            $id1 = $id . "v" . $i;
                            $ris = cercapreprint($id1);
                            if ($id1 == $ris[0]) {
                                #azzeramento file temporaneo...
                                azzerapreprint();
                                break;
                            }
                        }
                    }
                    echo "</div>";
                    if ($id1 == $ris[0] && isset($_POST['b7'])) {
                        echo "
                <form name='f1' action='manual_insert.php' method='POST' enctype='multipart/form-data'>
                    <center><div><br/><h2>preprint informations</h2><h1>field with '*' are required</h1><br/><input type='reset' name='reset' value='Reset' style='width:40px;' id='bottone_keyword' class='bottoni'><br/><br/>document/pdf:<br/><br/><a href=./pdf_downloads/" . $id1 . ".pdf onclick='window.open(this.href);return false' style='color:#007897;' title='PDF'>LINK</a><br/><br/><br/>
			    id of pubblication (not editable):<br/><br/>
                            <textarea readonly  style='width:65%; height:16px' name='id' id='textbox' class='textbox' placeholder='example of id: 0000.0000v1'>" . $ris[0] . "</textarea><br/><br/><br/>
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
                            <div style='float:left; width:600px;'><input type='submit' name='b9' value='Remove' style='width:60px;' id='bottone_keyword' class='bottoni' onclick='return confirmDelete()'/></div>
                            <div style='float:right; width:600px;'><input type='submit' name='b10' value='Complete' style='width:60px;' id='bottone_keyword' class='bottoni' onclick='return confirmInsert()'/></div><br/><br/>
                            </form>";
                    } else {
                        echo "<form name='f2' action='manual_insert.php' method='POST' enctype='multipart/form-data'>
                    <center><div><br/><h2>preprint informations</h2><h1>field with '*' are required</h1><br/><input type='reset' name='reset' value='Reset' style='width:40px;' id='bottone_keyword' class='bottoni'/><br/><br/>
                            *id of pubblication:<br/><br/>
                            <textarea style='width:65%; height:16px' name='id' id='textbox' class='textbox' required placeholder='example of id: 0000.0000v1' autofocus></textarea><br/><br/><br/>
                            *data of pubblication:<br/><br/>
                            <textarea style='width:65%; height:16px' name='date' id='textbox' class='textbox' required placeholder='example of data: 2011-12-30T10:37:35Z'></textarea><br/><br/><br/>
                            *preprint title:<br/><br/>
                            <textarea style='width:65%; height:16px' name='title' id='textbox' class='textbox' required placeholder='example of title: The geometric...'></textarea><br/><br/><br/>
                            *authors name:<br/><br/>
                            <textarea style='width:65%; height:16px' name='author' id='textbox' class='textbox' required placeholder='example of author: Mario Rossi, Luca...'></textarea><br/><br/><br/>
                            journal reference:<br/><br/>
                            <textarea style='width:65%; height:16px' name='journal' id='textbox' class='textbox' placeholder='example of Journal: Numer. Linear Algebra...'></textarea><br/><br/><br/>
                            comments:<br/><br/>
                            <textarea style='width:65%; height:16px' name='comments' id='textbox' class='textbox' placeholder='example of comments: 10 pages...'></textarea><br/><br/><br/>
                            *arXiv category:<br/><br/>
                            <textarea style='width:65%; height:16px' name='category' id='textbox' class='textbox' required placeholder='example of category: math.NA...'></textarea><br/><br/><br/>
                            *abstract:<br/><br/>
                            <textarea style='width:65%; height:300px' name='abstract' id='textbox' class='textbox' required placeholder='example of abstract: The geometric...'></textarea><br/><br/><br/>
                            *file to upload:<br/>
                            <input type='hidden' name='MAX_FILE_SIZE' value='10000000'><br/>
                            <input type='file' required name='fileToUpload' id='fileToUpload'><br/><br/>
                            <input type='submit' name='b8' value='Insert preprint' style='width:80px;' id='bottone_keyword' class='bottoni' onclick='return confirmInsert()'/><br/><br/>
                            </form>";
                    }
                    $copia = $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints' . "/pdf/";
                    $basedir = $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints' . "/pdf_downloads/";
                    $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints' . "/upload/";
                    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                    $type = "document/pdf"; // impostato il tipo per un'pdf
                    #bottone insert manually
                    if (isset($_POST['b8'])) {
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
                        $info[2] = $_POST['date'];
                        $info[3] = $_POST['author'];
                        $info[6] = $_POST['category'];
                        $info[7] = $_POST['abstract'];
                        #richiamo della funzione per il versionamento dei preprints
                        version_preprint($info[0]);
                        #richiamo della funzione per inserire le info del preprint all'interno del database
                        insert_preprints($info);
                        #upload del file selezionato
                        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                            $fileType = $_FILES["fileToUpload"]["type"];
                            #inserimento file nel database
                            insert_one_pdf($info[0], $fileType);
                            echo '<script type="text/javascript">alert("Preprint ' . $info[0] . ' inserted correctly!");</script>';
                        } else {
                            echo '<script type="text/javascript">alert("Sorry, there was an error uploading your file!");</script>';
                        }
                    }
                    #bottone delete
                    if (isset($_POST['b9'])) {
                        #eliminazione del preprint selezionato
                        unlink($basedir . $_POST['id'] . ".pdf");
                        cancellaselected($_POST['id']);
                        echo '<script type="text/javascript">alert("Preprint ' . $info[0] . ' removed correctly!");</script>';
                        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=./manual_insert.php">';
                    }
                    #bottone inserimento
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
                        $info[0] = $_POST['id'];
                        $info[1] = $_POST['title'];
                        $info[2] = $_POST['data'];
                        $info[3] = $_POST['author'];
                        $info[6] = $_POST['category'];
                        $info[7] = $_POST['abstract'];
                        #richiamo della funzione per il versionamento dei preprints
                        version_preprint($info[0]);
                        #richiamo della funzione per inserire le info del preprint all'interno del database
                        insert_preprints($info);
                        #inserimento del pdf sul database
                        insert_one_pdf2($_POST['id']);
                        #spostamento del file pdf
                        copy($basedir . $_POST['id'] . ".pdf", $copia . $_POST['id'] . ".pdf");
                        unlink($basedir . $_POST['id'] . ".pdf");
                        if ($_FILES["fileToUpload"]["size"] > 0) {
                            #caricamento del file scelto
                            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                                $fileType = $_FILES["fileToUpload"]["type"];
                                #spostamento pdf
                                #inserimento nel database del file
                                insert_one_pdf($info[0], $fileType);
                                echo '<script type="text/javascript">alert("Preprint ' . $info[0] . ' inserted correctly!");</script>';
                                echo '<META HTTP-EQUIV="Refresh" Content="0; URL=./manual_insert.php">';
                            } else {
                                echo '<script type="text/javascript">alert("Error, file not uploaded!");</script>';
                            }
                        } else {
                            echo '<script type="text/javascript">alert("Preprint ' . $info[0] . ' inserted correctly!");</script>';
                            echo '<META HTTP-EQUIV="Refresh" Content="0; URL=./manual_insert.php">';
                        }
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
        <hr style="display: block; height: 1px; border: 0; border-top: 1px solid #ccc; margin: 1em 0; padding: 0;"></div><br/><br/></center>
</body>
</html>
