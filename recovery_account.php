<!DOCTYPE html>
<html>
<?php
include './conf.php';
include './mysql/db_conn.php';
include './mysql/functions.php';
include './authorization/auth.php';
echo "
<head>
<title>DMI Preprints</title>
<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js\"></script>
<script src=\"js/config.js\"></script>
<script src=\"js/skel.min.js\"></script>
<script src=\"js/skel-panels.min.js\"></script>
<noscript>
<link rel=\"stylesheet\" href=\"css/skel-noscript.css\" />
<link rel=\"stylesheet\" href=\"css/style.css\" />
<link rel=\"stylesheet\" href=\"css/style-desktop.css\" />
</noscript>
<script src=\"js/targetweb-modal-overlay.js\"></script>
<link href='css/targetweb-modal-overlay.css' rel='stylesheet' type='text/css'>
<!--[if lte IE 9]><link rel=\"stylesheet\" href=\"css/ie9.css\" /><![endif]-->
<!--[if lte IE 8]><script src=\"js/html5shiv.js\"></script><![endif]-->
<script>
</script>
<script type=\"text/javascript\" src=\"./js/allscript.js\">
</script>
</head>";
?>
<body>
  <div id="header-wrapper">
    <div class="container">
      <div class="row">
        <div class="12u">
          <header id="header">
            <h1><a href="./index.php" id="logo">DMI Preprints</a></h1>
            <nav id="nav">
              <a href="./index.php">Publications</a>
              <a href="./reserved.php" class="current-page-item">Reserved Area</a>
            </nav>
          </header>
        </div>
      </div>
    </div>
  </div>
  <br/><br/>
  <center>
    <div id="firstContainer">
      <?php
      require_once './graphics/loader.php';
      //controllo token
      if ($_GET['token'] != "" && get_token_password_account($_GET['token'])) {
        require_once './reserved/insert_new_passForm.php';
        //require_once './graphics/footer.php';
      } else {
        require_once './reserved/reset_passForm.php';
      }
      ?>
    </center>
  </center>
</body>
</html>
