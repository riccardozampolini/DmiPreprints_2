<!DOCTYPE html>
<html>
<?php
require_once './graphics/header.php';
//sessione moderatore
if ($_SESSION['logged_type'] === "mod") {
  $ind = "modp.php";
} else {
  $ind = "userp.php";
}
?>
<body>
  <script type="text/x-mathjax-config">
  MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}});
  </script>
  <script type="text/javascript"
  src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
  </script>
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
          <br/><br/><br/>
          <h2>My Uploads</h2>
        </div>
        <?php
        #lettura preprint caricati
        leggiupload($_SESSION['uid']);
        ?>
      </center>
    </div>
    <br/>
    <br/>
    <br/>
  </div>
  <?php
  require_once './graphics/loader.php';
  require_once './graphics/footer.php';
  ?>
</body>
</html>
