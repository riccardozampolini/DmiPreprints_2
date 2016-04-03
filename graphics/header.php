<?php

echo "
<head>
<title>DMI Preprints</title>
<!--<script src=\"js/jquery.min.js\"></script>-->
<script type=\"text/javascript\" src=\"js/jquery-1.11.1.min.js\"></script>
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
<script src=\"http://cdn.jsdelivr.net/webshim/1.12.4/extras/modernizr-custom.js\"></script>
<script src=\"http://cdn.jsdelivr.net/webshim/1.12.4/polyfiller.js\"></script>
<script>
webshims.setOptions('waitReady', false);
webshims.setOptions('forms-ext', {types: 'date'});
webshims.polyfill('forms forms-ext');
</script>
<script type=\"text/javascript\" src=\"./js/allscript.js\">
</script>
</head> ";
//importo file per utilizzare funzioni...
require_once './conf.php';
require_once './mysql/db_conn.php';
require_once './mysql/functions.php';
require_once './authorization/sec_sess.php';
require_once './authorization/auth.php';
require_once './arXiv/arXiv_parsing.php';
require_once './arXiv/functions.php';
//
sec_session_start();
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] < 86400)) {
  if ($_SESSION['logged_type'] === "mod" or $_SESSION['logged_type'] === "user") {

  } else {
    echo '<script type="text/javascript">alert("ACCESS DENIED!");</script>';
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=./reserved.php">';
    exit(0);
  }
} else {
  echo '<META HTTP-EQUIV="Refresh" Content="0; URL=./reserved.php">';
  exit(0);
}
?>
