<!DOCTYPE html>
<html>
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
$t = "Go to homepage";
$rit = "main.php";
$nav = "<header id='header'>
<h1><a href='#' id='logo'>DMI Preprints</a></h1>
<nav id='nav'>
<a href='./index.php' class='current-page-item' onclick='loading(load);'>Publications</a>
<a href='./reserved.php' onclick='loading(load);'>Reserved Area</a>
</nav>
</header>";
?>
<body>
  <script type="text/x-mathjax-config">
  MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}});
  </script>
  <script type="text/javascript"
  src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
  </script>
  <div id="header-wrapper">
    <div class="container">
      <div class="row">
        <div class="12u">
          <?php echo $nav; ?>
        </div>
      </div>
    </div>
  </div>
  <br/>
  <center>
  </div>
  <div id="firstContainer">
    <div class="searchboxContainer" align="center">
      <form name="f1" action="view_preprints.php" method="GET" onsubmit="loading(load);">
        <?php
        if ($_GET['advanced'] == "yes") {
          echo '<div><a href="./index.php" style="color:#ffffff; float:left;" class="buttonNav2" >Simple Search</a></div>
          <div><a href="./index.php?advanced=yes" style="color:#3C3C3C; float:left;" class="buttonNav" >Advanced Search</a></div>
          <div><a href="./index.php?fulltext=yes" style="color:#ffffff; float:left;" class="buttonNav2" >Fulltext Search</a></div>';
          $html = "<div class='adv' align='center'>
          <input type='search' value='" . $_GET['r'] . "' autocomplete = 'on' class='searchbar' name='r' placeholder='Author name, id of publication, year of publication, etc.' required>
          <input type='submit' name='s' value='Send' class='button'><br/>
          <div class='searchCountainerBox'>
          <div align='left' class='restrictionboxHome'>
          Reset selections:<br/>
          <input type='reset' name='reset' value='Reset'><br/><br/><br/>
          Years restriction:<br/>
          From <input type='text' name='year2' style='width:35px' placeholder='First' class='textbox'> to <input type='text' name='year3' style='width:35px' placeholder='Last' class='textbox'>
          <br/><br/><br/>
          Results for page:<br/>
          <select name='rp'>
          <option value='5' selected='selected'>5</option>
          <option value='10'>10</option>
          <option value='15'>15</option>
          <option value='20'>20</option>
          <option value='25'>25</option>
          <option value='50'>50</option>
          </select><br/>
          </div>
          <div align='left' class='searchonboxHome'>
          Search on:<br/>
          <label><input type='checkbox' name='d' value='1' id='d' class='checkbox'>Archived</label><br/>
          <label><input type='checkbox' name='all' value='1' id='all' class='checkbox' onChange='DisAllFields(this.id);'>Full Record</label><br/>
          <label><input type='checkbox' name='h' value='1' id='h' class='checkbox'>Authors</label><br/>
          <label><input type='checkbox' name='t' value='1' id='t' class='checkbox'>Title</label><br/>
          <label><input type='checkbox' name='a' value='1' id='a' class='checkbox'>Abstract</label><br/>
          <label><input type='checkbox' name='e' value='1' id='e' class='checkbox'>Date</label><br/>
          <label><input type='checkbox' name='y' value='1' id='y' class='checkbox'>Category</label><br/>
          <label><input type='checkbox' name='c' value='1' id='c' class='checkbox'>Comments</label><br/>
          <label><input type='checkbox' name='j' value='1' id='j' class='checkbox'>Journal Ref</label><br/>
          <label><input type='checkbox' name='i' value='1' id='i' class='checkbox'>Identifier</label><br/>
          </div>
          <div align='left' class='orderboxHome'>
          Order results:<br/>
          <label><input type='radio' name='o' value='dated' checked>Publication Date &#8595;</label><br/>
          <label><input type='radio' name='o' value='datec'>Publication Date &#8593;</label><br/>
          <label><input type='radio' name='o' value='idd'>Identifier &#8595;</label><br/>
          <label><input type='radio' name='o' value='idc'>Identifier &#8593;</label><br/>
          <label><input type='radio' name='o' value='named'>Author Name &#8595;</label><br/>
          <label><input type='radio' name='o' value='namec'>Author Name &#8593;</label><br/>
          </div>
          <div style='clear:both;'></div></div></div>";
        } else if ($_GET['fulltext'] == "yes") {
          echo '<div><a href="./index.php" style="color:#ffffff; float:left;" class="buttonNav2" >Simple Search</a></div>'
          . '<div><a href="./index.php?advanced=yes" style="color:#ffffff; float:left;" class="buttonNav2" >Advanced Search</a></div>'
          . '<div><a href="./index.php?fulltext=yes" style="color:#3C3C3C; float:left;" class="buttonNav" >Fulltext Search</a></div>';
          $html = "<div class='fulltext' align='center'>
          <form name='f2' action='view_preprints.php' method='GET' onsubmit='loading(load);'>
          <input type='search' value='" . $_GET['ft'] . "' autocomplete = 'on' class='searchbar' name='ft' placeholder='Insert phrase, name, keyword, etc.'/>
          <input type='submit' name='go' value='Send' class='button'/><br/>
          <div class='searchCountainerBox'>
          <div align='left' class='restrictionboxHome'>
          Reset selections:<br/>
          <input type='reset' name='reset' value='Reset'>
          </div>
          <div align='left' class='restrictionboxHome'>
          Results for page:<br/>
          <select name='rp'>
          <option value='5' selected='selected'>5</option>
          <option value='10'>10</option>
          <option value='15'>15</option>
          <option value='20'>20</option>
          <option value='25'>25</option>
          <option value='50'>50</option>
          </select>
          </div>
          <div align='left' class='searchonboxHome'>
          Search on: <br/>
          <label><input type='radio' name='st' value='1' checked>Currents</label><br/>
          <label><input type='radio' name='st' value='0'>Archived</label>
          </div>
          </form><div style='clear:both;'></div></div>
          </div>";
        } else {
          echo '<div><a href="./index.php" style="color:#3C3C3C; float:left;" class="buttonNav" >Simple Search</a></div>'
          . '<div><a href="./index.php?advanced=yes" style="color:#ffffff; float:left;" class="buttonNav2" >Advanced Search</a></div>'
          . '<div><a href="./index.php?fulltext=yes" style="color:#ffffff; float:left;" class="buttonNav2" >Fulltext Search</a></div>';
          $html = "<div class='simple'>
          <select name='f' class='selector'>
          <option value='all' selected='selected'>All:</option>
          <option value='author'>Authors:</option>
          <option value='category'>Category:</option>
          <option value='year'>Year:</option>
          <option value='id'>ID:</option>
          </select>
          <input type='radio' name='o' value='dated' checked hidden>
          <input type='search' autocomplete = 'on' class='SimpleSearchBar' name='r' placeholder='Author name, year of publication, etc.' required>
          <input type='submit' name='s' value='Send' class='button'><br/>
          </div>";
        }
        ?>
        <div class="searchbox"><br/>
          <?php
          echo $html;
          ?>
        </div>
      </form>
    </div><br/><br/><br/>
    <div align="center">
      <h2>Latest insertions</h2>
      <?php
      recentspreprints();
      ?>
    </div>
  </center>
</div>
</div>
<?php
require_once './graphics/loader.php';
require_once './graphics/footer.php';
?>
</body>
</html>
