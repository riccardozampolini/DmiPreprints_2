<!DOCTYPE html>
<html>
<?php
echo "
<head>
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
//importo file per utilizzare funzioni...
require_once './conf.php';
require_once './mysql/db_conn.php';
require_once './mysql/functions.php';
require_once './authorization/sec_sess.php';
require_once './authorization/auth.php';
require_once './arXiv/arXiv_parsing.php';
require_once './arXiv/functions.php';
//
?>
<body>
  <script type="text/x-mathjax-config">
  MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}});
  </script>
  <script type="text/javascript"
  src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
  </script>
  <div id="header-wrapper">
    <div class="container">
      <div class="row">
        <div class="12u">
          <header id='header'>
            <h1><a href='./index.php' id='logo'>DMI Preprints</a></h1>
            <nav id='nav'>
              <a href='./index.php' class='current-page-item' onclick='loading(load);'>Publications</a>
              <a href='./reserved.php' onclick='loading(load);'>Reserved Area</a>
            </nav>
          </header>
        </div>
      </div>
    </div>
  </div><br/>
  <center>
    <div id="firstContainer">
      <div class="boxContainerSearch">
        <?php
        //fulltext search(risultati per pagina)
        $array_opt = ['5', '10', '15', '20', '25', '50'];
        foreach ($array_opt as $key) {//paginazione
          //(($value[2] == 'desc')) ? $freccia = '&#8595;' : $freccia = '&#8593;';
          if ($_GET['rp'] == $key) {
            $checked = "selected='selected'";
          } else {
            $checked = "";
          }
          $pageopt .= "<option value=" . $key . " " . $checked . ">" . $key . "</option>";
        }
        //dove eseguire la ricerca
        if ($_GET['st'] == "0") {
          $searchopt = "<label><input type='radio' name='st' value='1'>Currents</label><br/>"
          . "<label><input type='radio' name='st' value='0' checked>Archived</label><br/>";
        } else {
          $searchopt = "<label><input type='radio' name='st' value='1' checked>Currents</label><br/>"
          . "<label><input type='radio' name='st' value='0'>Archived</label><br/>";
        }
        //advanced search(checkboxs)
        $array_search = array('d' => 'Archived', 'all' => 'Full Record', 'h' => 'Authors', 't' => 'Title', 'a' => 'Abstract', 'e' => 'Date',
        'y' => 'Category', 'c' => 'Comments', 'j' => 'Journal Ref', 'i' => 'Identifier');
        foreach ($array_search as $key => $value) {//search on
          if ($_GET[$key] == "1") {
            $checked = "checked";
          } else {
            $checked = "";
          }
          if (($_GET['all'] == "1") && ($key == "h")) {
            $disable = "disabled";
          }
          $searchcheckbox .= "<label><input type='checkbox' onChange='DisAllFields(this.id)' id='" . $key . "' name='" . $key . "' value='1' class='checkbox' " . $checked . " " . $disable . ">" . $value . "</label><br/>";
        }
        //ordine dei risultati
        $array_order = array('dated' => 'Publication Date &#8595;', 'datec' => 'Publication Date &#8593;',
        'idd' => 'Identifier &#8595;', 'idc' => 'Identifier &#8593;',
        'named' => 'Author Name &#8595;', 'namec' => 'Author Name &#8593;');
        foreach ($array_order as $key => $value) {
          if ($_GET['o'] == $key) {
            $checked = "checked";
          } else {
            $checked = "";
          }
          $orderradiob .= "<label><input type='radio' name='o' value='" . $key . "' " . $checked . ">" . $value . "</label><br/>";
        }
        if (isset($_GET['go']) && $_GET['go'] != "" or $_GET['fulltext'] == "yes") {//fulltext search
          $html = "<form name='f2' action='view_preprints.php' method='GET' onsubmit='loadingRight(loadRight);'>
          <div class='adv'>
          <h1>Fulltext Search:</h1><br/>
          <input type='search' value='" . $_GET['ft'] . "' autocomplete = 'on' class='searchbarLateral' name='ft' placeholder='Insert phrase, etc.'><br/>
          <input type='submit' name='go' value='Send' class='button'/><br/>
          <div class='restrictionbox'><br/>
          Results for page:
            <select name='rp'>
            " . $pageopt . "
            </select>
            </div>
            <div class='restrictionbox' style='width:100%;'><br/>
            Search on: <br/>
            " . $searchopt . "
            <br/>
            </div>
            </div></form>
            <h1><a href='./view_preprints.php?r=" . urlencode($_GET['ft']) . "&rp=".$_GET['rp']."&s=Send&all=1&o=dated' style='color:#1976D2;' onclick='loading(load);'>Need Advanced Search?</a></h1>";
          } else {//advanced search
            $html = "<div class='adv'>
            <h1>Advanced Search:</h1><br/>
            <form name='f1' action='view_preprints.php' method='GET' onsubmit='loadingRight(loadRight);'>
            <input type='search' value='" . $_GET['r'] . "' autocomplete = 'on' name='r' class='searchbarLateral' placeholder='Author name, etc.' required><br/>
            <input type='submit' name='s' value='Send' class='button'><br/><br/>
            <div class='SearchParam'>
            <div class='restrictionbox'>
            Results for page:
              <select name='rp'>
              " . $pageopt . "
              </select><br/><br/>
              Years restriction:<br/>
              From: <input type='text' value='" . $_GET['year2'] . "' name='year2' style='width:35px' placeholder='First' class='textbox'>
              To: <input type='text' value='" . $_GET['year3'] . "' name='year3' style='width:35px' placeholder='Last' class='textbox'>
              </div>
              <div class='containerS'>
              <div align='left' class='searchonbox'><br/>
              Search on:<br/>
              " . $searchcheckbox . "
              </div>
              <div align='left' class='orderbox'><br/>
              Order results:<br/>
              " . $orderradiob . "
              </div>
              <div style='clear:both;'>
              </div>
              </div>
              </div>
              </form><br/>
              <h1><a href='./view_preprints.php?fulltext=yes&ft=" . urlencode($_GET['r']) . "&rp=".$_GET['rp']."&go=Send&st=1' style='color:#1976D2;' onclick='loading(load);'>Need Fulltext Search?</a></h1>
              </div>";
            }
            echo $html;
            ?>
          </div>
          <div class="resultsContainer" id="secondContainer">
            <?php
            #ricerca full text
            if (isset($_GET['go']) && $_GET['go'] != "") {
              searchfulltext();
            }
            #ricerca normale
            if (isset($_GET['s']) && $_GET['s'] != "") {
              if ($_GET['f'] == "all" or $_GET['f'] == "author" or $_GET['f'] == "category"
              or $_GET['f'] == "year" or $_GET['f'] == "id") {
                filtropreprint();
              } else if ($_GET['all'] == "1" or $_GET['h'] == "1" or $_GET['t'] == "1" or $_GET['a'] == "1" or $_GET['e'] == "1" or $_GET['y'] == "1" or $_GET['c'] == "1" or $_GET['j'] == "1" or $_GET['i'] == "1" or $_GET['d'] == "1") {
                searchpreprint();
              } else {
                echo "Select the field where run the search!";
              }
            }
            ?>
          </div><br/>
        </div>
        <?php
        require_once './graphics/loaderRight.php';
        require_once './graphics/loader.php';
        require_once './graphics/footer.php';
        ?>
      </center>
    </body>
    </html>
