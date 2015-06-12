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
        <script type='text/javascript'>
            //opzioni di visualizzazione
            function showHide2(id) {
                if (id.style.display != 'block') {
                    id.style.display = 'block';
                    showHide2(adv);
                } else {
                    id.style.display = 'none';
                }
            }
            //ricerca avanzata
            function showHide(id) {
                if (id.style.display != 'block') {
                    id.style.display = 'block';
                    showHide(opt);
                } else {
                    id.style.display = 'none';
                }
            }
            //avviso di conferma
            function confirmInsert()
            {
                return confirm("Are you sure?");
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
            //chiudi menu click fuori dalla finestra
            function myFunction() {
                adv.style.display = 'none';
                opt.style.display = 'none';
            }
        </script>
        <script type="text/x-mathjax-config">
            MathJax.Hub.Config({
            tex2jax: {
            inlineMath: [["$","$"],["\\(","\\)"]]
            }
            });
        </script>
        <script type="text/javascript"
                src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS_HTML-full">
        </script>
    </head>
    <body>
        <script>
            //text area title
            (function () {
                window.UpdateMathtit = function (TeX) {
                    //set the MathOutput HTML
                    document.getElementById("titlediv").innerHTML = TeX;
                    //reprocess the MathOutput Element
                    MathJax.Hub.Queue(["Typeset", MathJax.Hub, "titlediv"]);
                }
            })();
            //text area authors
            (function () {
                window.UpdateMathaut = function (TeX) {
                    //set the MathOutput HTML
                    document.getElementById("authordiv").innerHTML = TeX;
                    //reprocess the MathOutput Element
                    MathJax.Hub.Queue(["Typeset", MathJax.Hub, "authordiv"]);
                }
            })();
            //text area jouurnal
            (function () {
                window.UpdateMathjou = function (TeX) {
                    //set the MathOutput HTML
                    document.getElementById("journaldiv").innerHTML = TeX;
                    //reprocess the MathOutput Element
                    MathJax.Hub.Queue(["Typeset", MathJax.Hub, "journaldiv"]);
                }
            })();
            //text area comments
            (function () {
                window.UpdateMathcom = function (TeX) {
                    //set the MathOutput HTML
                    document.getElementById("commentsdiv").innerHTML = TeX;
                    //reprocess the MathOutput Element
                    MathJax.Hub.Queue(["Typeset", MathJax.Hub, "commentsdiv"]);
                }
            })();
            //text area abstract
            (function () {
                window.UpdateMathabs = function (TeX) {
                    //set the MathOutput HTML
                    document.getElementById("abstractdiv").innerHTML = TeX;
                    //reprocess the MathOutput Element
                    MathJax.Hub.Queue(["Typeset", MathJax.Hub, "abstractdiv"]);
                }
            })();
        </script>
        <?php
        #importo file per utilizzare funzioni...
        require_once $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'authorization/sec_sess.php';
        include_once($_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'arXiv/check_nomi_data.php');
        include_once($_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'mysql/func.php');
        #importazione variabili globali
        include $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'impost_car.php';
        sec_session_start();
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] < 86400)) {
            if ($_SESSION['logged_type'] === "mod") {
                //sessione moderatore
                if ($_COOKIE['searchbarall'] == "1") {
                    #search bar
                    echo "<center><div style='z-index:999999; width:100%; padding: 2px; position: fixed; border-bottom: 1px solid; border-top: 1px solid; border-color: #AFAFAF; background-color:#DDDDDD; bottom: 0px;'><form name='f5' action='view_preprints.php' method='GET'  style='height:12px; width:12px; float:left;'>
		    <input type='image' title='Close' name='close' value=1 src='./images/close.jpeg' border='0'  style='height:12px; width:12px; float:left;'/>
		    <input type='text' name='clos' value='1' hidden>
		    </form>
			     <div id='adv' hidden>
			     <div>
			<form name='f4' action='view_preprints.php' method='GET'>
			    <font color='#007897'>Full text search: (<a style='color:#007897;' onclick='window.open(this.href);
				    return false' href='http://en.wikipedia.org/wiki/Full_text_search'>info</a>)</font><br/>
			    <div style='height:30px;'>
				Search: <input type='search' autocomplete = 'on' style='width:50%;' name='ft' placeholder='Insert phrase, name, keyword, etc.' value='" . $_GET['ft'] . "'/>
				<input type='submit' name='go' value='Send'/></div>
			    <div style='height:20px;'>
				Reset selections: <input type='reset' name='reset' value='Reset'>&nbsp&nbsp
				Results for page: 
				<select name='rp'>
				    <option value='5' selected='selected'>5</option>
				    <option value='10'>10</option>
				    <option value='15'>15</option>
				    <option value='20'>20</option>
				    <option value='25'>25</option>
				    <option value='50'>50</option>
				</select>&nbsp&nbsp
				Search on: 
				<label><input type='radio' name='st' value='1' checked>Currents</label>
				<label><input type='radio' name='st' value='0'>Archived</label>
			    </form></div><br/>
		    </div>
			<form name='f4' action='view_preprints.php' method='GET'>
			<font color='#007897'>Advanced search options:</font><br/>
				        <div style='height:30px;'>
			    Reset selections: <input type='reset' name='reset' value='Reset'>&nbsp&nbsp
			    Years restrictions: 
			    until <input type='text' name='year1' style='width:35px' placeholder='Last'>
			    , or from <input type='text' name='year2' style='width:35px' placeholder='First'>
			    to <input type='text' name='year3' style='width:35px' placeholder='Last'>
			    &nbsp&nbspResults for page: 
			    <select name='rp'>
				<option value='5' selected='selected'>5</option>
				<option value='10'>10</option>
				<option value='15'>15</option>
				<option value='20'>20</option>
				<option value='25'>25</option>
				<option value='50'>50</option>
			    </select>
			</div>
			<div>
			    Search on:
			    <label><input type='checkbox' name='d' value='1'>Archived</label>
			    <label><input type='checkbox' name='all' value='1'>Record</label>
			    <label><input type='checkbox' name='h' value='1'>Author</label>
			    <label><input type='checkbox' name='t' value='1'>Title</label>
			    <label><input type='checkbox' name='a' value='1'>Abstract</label>
			    <label><input type='checkbox' name='e' value='1'>Date</label>
			    <label><input type='checkbox' name='y' value='1'>Category</label>
			    <label><input type='checkbox' name='c' value='1'>Comments</label>
			    <label><input type='checkbox' name='j' value='1'>Journal-ref</label>
			    <label><input type='checkbox' name='i' value='1'>ID</label>
			</div>
			<div>Order results by:
			    <label><input type='radio' name='o' value='dated' checked>Date (D)</label>
			    <label><input type='radio' name='o' value='datec'>Date (I)</label>
			    <label><input type='radio' name='o' value='idd'>Identifier (D)</label>
			    <label><input type='radio' name='o' value='idc'>Identifier (I)</label>
			    <label><input type='radio' name='o' value='named'>Author-name (D)</label>
			    <label><input type='radio' name='o' value='namec'>Author-name (I)</label>
			</div><br/>
		    </div>
		        Advanced:
		        <input type='button' value='Show/Hide' onclick='javascript:showHide(adv);'/>
		         Filter results by 
		        <select name='f'>
		            <option value='all' selected='selected'>All papers:</option>
		            <option value='author'>Authors:</option>
		            <option value='category'>Category:</option>
		            <option value='year'>Year:</option>
		            <option value='id'>ID:</option>
		        </select>
		        <input type='search' autocomplete = 'on' style='width:30%;' name='r' placeholder='Author name, part, etc.' value='" . $_GET['r'] . "'/>
		    <input type='submit' name='s' value='Send'/></form>
		    </div></center>";
                }
                ?>
                <div onclick="myFunction()">
                    <div id="header-wrapper">
                        <div class="container">
                            <div class="row">
                                <div class="12u">
                                    <header id="header">
                                        <h1><a href="#" id="logo">DMI Papers</a></h1>
                                        <nav id="nav">
                                            <a href='./view_preprints.php'>Publications</a>
                                            <a href="./reserved.php" class="current-page-item">Reserved Area</a>
                                        </nav>
                                    </header>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <center>
                        <div>
                            <?php
                            print_r("<font style='font-weight: bold;'>Name: </font>");
                            print_r($_SESSION['nome']);
                            print_r(" <font style='font-weight: bold;'>Access type: </font>");
                            print_r($_SESSION['logged_type']);
                            ?>
                        </div>
                        <br/>
                        <div>
                            <div style="float:left; margin-left:0.5%;">
                                <form name="f1" action="modp.php" method="POST">
                                    <input type="submit" name="b1" value="Logout" id="botton_logout" class="bottoni" style="height:17px; color: red;" onclick="return confirmLogout()">
                                </form>
                            </div>
                            <div style="float:left; margin-left:0.5%;">
                                <a style="height:17px; color:white;" href="./uploaded.php?p=1" id="bottone_keyword" class="bottoni">My upload</a>
                            </div>
                            <div style="float:left; margin-left:0.5%;">
                                <a style="height:17px; color:white;" href="./archived_preprints.php" id="bottone_keyword" class="bottoni">Archived section</a>
                            </div>
                            <div style="float:left; margin-left:0.5%;">
                                <a style="height:17px; color:white;" href="./approve_preprints.php" id="bottone_keyword" class="bottoni">Check section</a>
                            </div>
                            <div style="float:left; margin-left:0.5%;">
                                <a style="height:17px; color:white;" href="./check_preprints.php?bb3=1" id="bottone_keyword" class="bottoni">Check arXiv section</a>
                            </div>
                            <div style="float:left; margin-left:0.5%;">
                                <a style="height:17px; color:white;" href="./manual_edit.php" id="bottone_keyword" class="bottoni">Edit section</a>
                            </div>
                            <div style="float:left; margin-left:0.5%;">
                                <a style="height:17px; color:white;" href="./arXiv_panel.php" id="bottone_keyword" class="bottoni">ArXiv panel</a>
                            </div>
                            <div style="clear:both;">

                            </div>
                        </div>
                    </center>
                    <hr style="display: block; height: 1px; border: 0; border-top: 1px solid #ccc; margin: 1em 0; padding: 0;">
                    <form name="f3" action="modp.php" method="POST" enctype="multipart/form-data">
                        <center>
                            <br/>
                            <h2>Insert new paper</h2>
                            <h1>field with "*" are required</h1>
                            <br/>
                            <input type="reset" name="reset" value="Reset">
                            <br/>
                            <br/>
                        </center>
                        <div style="margin-left:1%; margin-right:1%;">
                            <div style="font-weight: bold;">*category:</div><br/>
                            <select name="category" required onchange='Checkcath(this.value);'>
                                <option value="">--Select Category--</option>
                                <option value="Computer Science">Computer Science</option>
                                <option value="Mathematics">Mathematics</option>
                                <option value="Statistics">Statistics</option>
                                <option value="Physics">Physics</option>
                                <option value="Quantitative Biology">Quantitative Biology</option>
                                <option value="Quantitative Finance">Quantitative Finance</option>
                                <option value="Other">Other:</option>
                            </select>
                            <br/>
                            <br/>
                            <div id="cat" hidden><textarea style="width:49%;" name="category2" class="textbox" placeholder="example of category: math.NA..." maxlength="280"></textarea>
                                <br/>
                                <br/>
                            </div>
                            <div style="float:right; width:49%;">
                                <div style="font-weight: bold;">
                                    title preview:
                                </div>
                                <br/>
                                <div id="titlediv">

                                </div>
                            </div>
                            <div style="font-weight: bold;">
                                *title:
                            </div>
                            <br/>
                            <textarea style="width:49%;" name="title" id="textbox" class="textbox" required placeholder="example of title: The geometric..." onkeyup="UpdateMathtit(this.value)" maxlength="280"></textarea>
                            <br/>
                            <br/>
                            <div style="float:right; width:49%;">
                                <div style="font-weight: bold;">
                                    authors preview:
                                </div><br/>
                                <div id="authordiv">

                                </div>
                            </div>
                            <div style="font-weight: bold;">
                                *authors:
                            </div>
                            <br/>
                            <textarea style="width:49%;" name="author" id="textbox" class="textbox" required placeholder="example of author: Mario Rossi, Luca..." onkeyup="UpdateMathaut(this.value)" maxlength="280"></textarea>
                            <br/>
                            <br/>
                            <div style="float:right; width:49%;">
                                <div style="font-weight: bold;">
                                    journal preview:
                                </div>
                                <br/>
                                <div id="journaldiv">

                                </div>
                            </div>
                            <div style="font-weight: bold;">journal reference:
                            </div>
                            <br/>
                            <textarea style="width:49%;" name="journal" id="textbox" class="textbox" placeholder="example of Journal: Numer. Linear Algebra..." onkeyup="UpdateMathjou(this.value)" maxlength="280"></textarea>
                            <br/>
                            <br/>
                            <div style="float:right; width:49%;">
                                <div style="font-weight: bold;">
                                    comments preview:
                                </div>
                                <br/>
                                <div id="commentsdiv">

                                </div>
                            </div>
                            <div style="font-weight: bold;">
                                comments:
                            </div>
                            <br/>
                            <textarea style="width:49%;" name="comments" id="textbox" class="textbox" placeholder="example of comments: 10 pages..." onkeyup="UpdateMathcom(this.value)" maxlength="280"></textarea>
                            <br/>
                            <br/>
                            <div style="float:right; width:49%;">
                                <div style="font-weight: bold;">
                                    abstract preview:
                                </div>
                                <br/>
                                <div id="abstractdiv">

                                </div>
                            </div>
                            <div style="font-weight: bold;">
                                *abstract:
                            </div>
                            <br/>
                            <textarea style="width:49%; height:300px;" name="abstract" id="textbox" class="textbox" required placeholder="example of abstract: The geometric..." onkeyup="UpdateMathabs(this.value)"></textarea>
                            <br/>
                            <br/>
                        </div>
                        <center>
                            <div style="font-weight: bold;">
                                *PDF:
                                <br/>
                            </div>
                            <input type="hidden" name="MAX_FILE_SIZE" value="10000000">
                            <br/>
                            <input type="file" required name="fileToUpload" id="fileToUpload">
                            <br/>
                            <br/>
                            <input type="submit" name="b3" value="Insert paper" style='width:80px;' id='bottone_keyword' class='bottoni' onclick="return confirmInsert()">
                            <br/>
                            <br/>
                        </center>
                    </form>
                    <?php
                    $target_file = $basedir . basename($_FILES["fileToUpload"]["name"]);
                    if (isset($_POST['b1'])) {
                        session_start();
                        session_unset();
                        session_destroy();
                        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=./reserved.php">';
                    }
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
                            $id = insert_pubb($info, $_SESSION['nome'] . " (" . $_SESSION['uid'] . ")");
                            rename($basedir . $_FILES["fileToUpload"]["name"], $basedir . $id . ".pdf");
                            #inserimento file nel database
                            insertpdf($id, $fileType);
                            echo '<script type="text/javascript">alert("Preprint inserted correctly!\nID generated: ' . $id . ', go on my upload to edit your pubblications.");</script>';
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
        </div>
        <br/>
        <br/>
    </body>
</html>
