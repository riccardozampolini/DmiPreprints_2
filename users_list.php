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
    </head>
    <body>
        <?php
        require_once './graphics/loader.php';
        require_once './authorization/sec_sess.php';
        #importo file per utilizzare funzioni...
        include_once './arXiv/check_nomi_data.php';
        include_once './mysql/func.php';
        sec_session_start();
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] < 86400)) {
            if ($_SESSION['logged_type'] === "mod") {
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
                    <br/>
                    <div>
                        <center>
                            <br/>
                            <h2>EXTERNAL USERS</h2>
                            Go to admin panel 
                            <a style="color:#3C3C3C;" href="./modp.php" id="bottone_keyword" class="button" onclick="loading(load);">Back</a><br>
                        </center>
                    </div>
                    <div>
                        <hr style="display: block; height: 1px; border: 0; border-top: 1px solid #ccc; margin: 1em 0; padding: 0;">
                        <div id="container">
                            <?php
                            echo "<center><form name='f1' action='users_list.php' id='f1' method='GET' onsubmit='loading(load);'>
                            <div onchange='chkOrder()'>
				    Order by:
					<label><input type='radio' name='o' value='regd'";
                            if ($_GET['o'] == "regd" or $_GET['o'] == "") {
                                echo "checked";
                                $order = "registrazione DESC";
                            }
                            echo">Registration &#8595;</label>
					<label><input type='radio' name='o' value='regc'";
                            if ($_GET['o'] == "regc") {
                                echo "checked";
                                $order = "registrazione ASC";
                            }
                            echo ">Registration &#8593;</label>
					<label><input type='radio' name='o' value='accd'";
                            if ($_GET['o'] == "accd") {
                                echo "checked";
                                $order = "accesso DESC";
                            }
                            echo ">Access &#8595;</label>
					<label><input type='radio' name='o' value='accc'";
                            if ($_GET['o'] == "accc") {
                                echo "checked";
                                $order = "accesso ASC";
                            }
                            echo ">Access &#8593;</label>
					<label><input type='radio' name='o' value='named'";
                            if ($_GET['o'] == "named") {
                                echo "checked";
                                $order = "nome DESC";
                            }
                            echo ">Name &#8595;</label>
					<label><input type='radio' name='o' value='namec'";
                            if ($_GET['o'] == "namec") {
                                echo "checked";
                                $order = "nome ASC";
                            }
                            echo ">Name &#8593;</label>
					<label><input type='radio' name='o' value='snamed'";
                            if ($_GET['o'] == "snamed") {
                                echo "checked";
                                $order = "cognome DESC";
                            }
                            echo ">Surname &#8595;</label>
					<label><input type='radio' name='o' value='snamec'";
                            if ($_GET['o'] == "snamec") {
                                echo "checked";
                                $order = "cognome ASC";
                            }
                            echo ">Surname &#8593;</label>
					<label><input type='radio' name='o' value='verd'";
                            if ($_GET['o'] == "verd") {
                                echo "checked";
                                $order = "verificato DESC";
                            }
                            echo ">Verification &#8595;</label>
					<label><input type='radio' name='o' value='verc'";
                            if ($_GET['o'] == "verc") {
                                echo "checked";
                                $order = "verificato ASC";
                            }
                            echo ">Verification &#8593;</label>
			    <br/><input type='image' class='refresh' src='./images/refresh.png' alt='Submit' style='width:15px; height:15px; margin-top:20px;' title='Update'>
			    </div>
			    <hr style='display: block; height: 1px; border: 0; border-top: 1px solid #ccc; margin: 1em 0; padding: 0;'>";
                            #lista utenti registrati
                            $nomi = find_accounts($order);
                            echo "<table id='table' style='width:90%; margin-left: 0%;'>
                            <tr id='thhead'><td id='tdh' colspan='7' align='center'>EXTERNAL MEMBERS</td></tr>";
                            echo "<tr id='th'><td id='tdh'><label><input type='checkbox' class='checkall1' name='all1' onChange='toggle(this)'/>N&deg;:</label></td><td id='tdh' align='center'>NAME:</td><td id='tdh' align='center'>SURNAME:</td><td id='tdh' align='center'>EMAIL:</td><td id='tdh' align='center'>LAST ACCESS:</td><td id='tdh' align='center'>REGISTERED:</td><td id='tdh' align='center'>VERIFIED:</td></tr>";
                            #creazione della tabella html dei file all'interno di pdf_downloads
                            $y = 1;
                            $i = 0;
                            while ($row = mysqli_fetch_array($nomi)) {
                                echo "<tr id='th'><td id='td'><label><input type='checkbox' name='" . $i . "' value='checked' class='checkall1'/>$y.</label></td><td id='td'>" . $row['nome'] . "</td><td id='td'>" . $row['cognome'] . "</td><td id='td'>" . $row['email'] . "</td><td id='td'>" . $row['accesso'] . "</td><td id='td'>" . $row['registrazione'] . "</td><td id='td'>" . $row['verificato'] . "</td></tr>";
                                $array[$i] = $row['email'];
                                $y++;
                                $i++;
                            }
                            echo "</table></center><center><hr style='display: block; height: 1px; border: 0; border-top: 1px solid #ccc; margin: 1em 0; padding: 0;'>"
                            . "<input type='submit' id='bottone_keyword' class='button' name='b3' value='Remove' onclick='return confirmDelete6()'></center></form>";
                            if (isset($_GET['b3'])) {
                                $k = 0;
                                for ($j = 0; $j < $i; $j++) {
                                    #controllo di quali checkbox sono state selezionate
                                    if ($_GET[$j] == "checked") {
                                        $array2[$k] = $array[$j];
                                        $k++;
                                    }
                                }
                                //eliminazione utenti selezionati
                                remove_accounts($array2);
                                //inserisco i nomi eliminati all'interno di una stringa per poi visualizzarla all'utente
                                $nomieliminati = implode(", ", $array2);
                                if ($nomieliminati == "") {
                                    echo '<script type="text/javascript">alert("No users selected!");</script>';
                                } else {
                                    echo '<script type="text/javascript">alert("User/s deleted correctly!");</script>';
                                    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=./users_list.php">';
                                }
                            }
                            echo "<hr style='display: block; height: 1px; border: 0; border-top: 1px solid #ccc; margin: 1em 0; padding: 0;'>";
                        } else {
                            //avviso
                            echo '<script type="text/javascript">alert("ACCESS DENIED!");</script>';
                            echo '<META HTTP-EQUIV="Refresh" Content="0; URL=./reserved.php">';
                        }
                    } else {
                        //avviso
                        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=./reserved.php">';
                    }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
