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
            function confirmLogout()
            {
                return confirm("Exit?");
            }
            function Checkcath(val) {
                var element = document.getElementById('cat');
                if (val == 'category' || val == 'Other')
                    element.style.display = 'block';
                else
                    element.style.display = 'none';
            }
        </script>
    </head>
    <body>
        <?php
        #importo file per utilizzare funzioni...
        require_once $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'authorization/sec_sess.php';
        include_once($_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'arXiv/check_nomi_data.php');
        include_once($_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'mysql/func.php');
        sec_session_start();
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] < 86400)) {
            if ($_SESSION['logged_type'] === "mod" or $_SESSION['logged_type'] === "user") {
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
                </div><br/>
            <center><div>
                    <?php
                    print_r(" Name: ");
                    print_r($_SESSION['nome']);
                    print_r(" Access type: ");
                    print_r($_SESSION['logged_type']);
                    ?>
                    <br/><br/>
                    <table>
                        <tr>
                            <td>
                                <form name="f2" action="uploaded.php?p=1" method="POST">
                                    <input type="submit" name="b2" value="View uploaded" id="bottoni" class="bottoni">
                                </form>
                            </td>
                            <td>
                                <form name="f1" action="userp.php" method="POST">
                                    <input type="submit" name="b1" value="Logout" id="botton_logout" class="bottoni" style="color: red;" onclick="return confirmLogout()">
                                </form>
                            </td>
                        </tr>
                    </table>
                </div></center>
            <hr style="display: block; height: 1px; border: 0; border-top: 1px solid #ccc; margin: 1em 0; padding: 0;">
            <?php
            ?>
            <form name="f3" action="userp.php" method="POST" enctype="multipart/form-data">
                <center><div><br/><h2>Insert new preprint</h2><h1>field with "*" are required</h1><br/><br/><input type="reset" name="reset" value="Reset"/><br/><br/><br/>
                        *publication category:<br/><br/>
                        <select name="category" required style="width:200px;" onchange='Checkcath(this.value);'>
                            <option value="">--Select Category--</option>
                            <option value="Computer Science">Computer Science</option>
                            <option value="Mathematics">Mathematics</option>
                            <option value="Statistics">Statistics</option>
                            <option value="Physics">Physics</option>
                            <option value="Quantitative Biology">Quantitative Biology</option>
                            <option value="Quantitative Finance">Quantitative Finance</option>
                            <option value="Other">Other:</option>
                        </select><br/><br/>
                        <div id="cat" hidden><textarea style="width:65%; height:16px;" name="category2" class="textbox" placeholder="example of category: math.NA..."></textarea><br/><br/></div>
                        <br/>
                        *publication title:<br/><br/>
                        <textarea style="width:65%; height:16px" name="title" id="textbox" class="textbox" required placeholder="example of title: The geometric..."></textarea><br/><br/><br/>
                        *authors name:<br/><br/>
                        <textarea style="width:65%; height:16px" name="author" id="textbox" class="textbox" required placeholder="example of author: Mario Rossi, Luca..."></textarea><br/><br/><br/>
                        journal reference:<br/><br/>
                        <textarea style="width:65%; height:16px" name="journal" id="textbox" class="textbox" placeholder="example of Journal: Numer. Linear Algebra..."></textarea><br/><br/><br/>
                        comments:<br/><br/>
                        <textarea style="width:65%; height:16px" name="comments" id="textbox" class="textbox" placeholder="example of comments: 10 pages..."></textarea><br/><br/><br/>
                        *abstract:<br/><br/>
                        <textarea style="width:65%; height:300px" name="abstract" id="textbox" class="textbox" required placeholder="example of abstract: The geometric..."></textarea><br/><br/><br/>
                        *PDF:<br/>
                        <input type="hidden" name="MAX_FILE_SIZE" value="10000000"><br/>
                        <input type="file" required name="fileToUpload" id="fileToUpload"><br/><br/>
                        <input type="submit" name="b3" value="Insert preprint" style='width:80px;' id='bottone_keyword' class='bottoni' onclick="return confirmInsert()"/><br/><br/>
                        </form>
                        <?php
                        $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints' . "/upload_dmi/";
                        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                        #bottone logout
                        if (isset($_POST['b1'])) {
                            session_start();
                            session_unset();
                            session_destroy();
                            echo '<META HTTP-EQUIV="Refresh" Content="0; URL=./reserved.php">';
                        }
                        #bottone inserimento
                        if (isset($_POST['b3'])) {
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
                            if ($_POST['category'] == "Other") {
                                $info[6] = $_POST['category2'];
                            } else {
                                $info[6] = $_POST['category'];
                            }
                            $info[1] = $_POST['title'];
                            $info[3] = $_POST['author'];
                            $info[7] = $_POST['abstract'];
                            #upload del file selezionato
                            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                                $fileType = $_FILES["fileToUpload"]["type"];
                                #richiamo della funzione per inserire le info del preprint all'interno del database
                                $id = insert_pubb($info, $_SESSION['uid']);
                                rename($target_dir . $_FILES["fileToUpload"]["name"], $target_dir . $id . ".pdf");
                                #inserimento file nel database
                                insertpdf($id, $fileType);
                                echo '<script type="text/javascript">alert("Preprint ' . $id . ' inserted correctly! Go to uploaded section to edit your pubblications.");</script>';
                            } else {
                                echo '<script type="text/javascript">alert("Sorry, there was an error uploading your file!");</script>';
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
