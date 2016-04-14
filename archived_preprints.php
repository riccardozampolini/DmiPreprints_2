<!DOCTYPE html>
<html>
<?php
require_once './graphics/header.php';
$nav2 = "<header id='header'>
<h1><a href='./index.php' id='logo'>DMI Preprints</a></h1>
<nav id='nav'>
<a href='./index.php' onclick='loading(load);'>Publications</a>
<a href='./reserved.php' class='current-page-item' onclick='loading(load);'>Reserved Area</a>
</nav>
</header>";
$rit = "modp.php";
?>
<body>
  <script type="text/x-mathjax-config">
  MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}});
  </script>
  <script type="text/javascript"
  src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
  </script>
  <div>
    <div id="header-wrapper">
      <div class="container">
        <div class="row">
          <div class="12u">
            <?php echo $nav2; ?>
          </div>
        </div>
      </div>
    </div><br/>
    <div id="firstContainer">
      <center>
        <br/>
        <a style='color:#ffffff; text-align: center;' href='./modp.php' id='bottone_keyword' class='button' onclick='loading(load);'>Back</a><a style='color:#ffffff; text-align: center;' href='./archived_preprints.php?c=remove' id='bottone_keyword' class='button' onclick='loading(load);'>Remove All</a><br/><br/><br/><h2>ARCHIVED PREPRINTS</h2>
        <div>
          <?php
          if (sessioneavviata() == True) {
            echo "<br/><br/><center>SORRY ONE DOWNLOAD/UPDATE SESSION IS RUNNING AT THIS TIME! THE SECTION CAN'T BE USED IN THIS MOMENT!</center><br/>";
            exit();
          } else {
            if (isset($_GET['c'])) {
              #funzione gestione preprint archiviati
              leggipreprintarchiviati();
            } else {
              #funzione gestione preprint archiviati
              leggipreprintarchiviati();
            }
          }
          ?>
        </div>
      </center>
    </div>
    <br/>
    <br/>
  </div>
  <?php
  require_once './graphics/loader.php';
  require_once './graphics/footer.php';
  ?>
</body>
</html>
