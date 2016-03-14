<!DOCTYPE html>
<html>
    <?php
    require_once './graphics/header.php';
    if ($_SESSION['logged_type'] === "mod") {
        $ind = "modp.php";
    } else {
        $ind = "userp.php";
    }
    ?>
    <body>
        <div>
            <div id="header-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="12u">
                            <header id="header">
                                <h1><a href="#" id="logo">DMI Preprints</a></h1>
                                <nav id="nav">
                                    <a href='./index.php' onclick="loading(load);">Publications</a>
                                    <a href="./reserved.php" class="current-page-item" onclick="loading(load);">Reserved Area</a>
                                </nav>
                            </header>
                        </div>
                    </div>
                </div>
            </div>
            <br/>
            <div id="firstContainer">
                <center>
                    <div>
                        <br/>
                        <a style="color:#ffffff;" href="<?php echo $ind; ?>" id="bottoni" class="button" onclick="loading(load);">Back</a>
                    </div><br/><br/>
                    <div id="container">
                        <div style="width: 45%;"><br/>
                            <h2>Profile information</h2>
                            <h1>Here you can see and change your account information.</h1>
                        </div><br/>
                        <?php
                        //lettura informazioni account
                        $info = find_account_info($_SESSION['uid']);
                        //TEST DEBUG
                        error_reporting(E_ALL);
                        ini_set('display_errors', 1);
                        require_once './reserved/edit_accountForm.php';
                        //TEST DEBUG
                        error_reporting(E_ALL);
                        ini_set('display_errors', 1);
                        require_once './reserved/delete_accountForm.php';
                        ?>
                    </div>
                    <br/>
                    <br/>
                    <br/>
                </center>
            </div>
        </div>
        <?php
        require_once './graphics/loader.php';
        require_once './graphics/footer.php';
        ?>
    </body>
</html>
