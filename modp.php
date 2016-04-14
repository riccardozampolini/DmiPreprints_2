<!DOCTYPE html>
<html>
<?php
require_once './graphics/header.php';
?>
<body>
  <script type="text/x-mathjax-config">
  MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}});
  </script>
  <script type="text/javascript"
  src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
  </script>
  <center>
    <div>
      <div id="header-wrapper">
        <div class="container">
          <div class="row">
            <div class="12u">
              <header id="header">
                <h1><a href="./index.php" id="logo">DMI Preprints</a></h1>
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
    </div>
    <div id="firstContainer">
      <div>
        <?php
        print_r("<font style='font-weight: bold;'>USER: </font>");
        print_r($_SESSION['nome']);
        print_r(" <font style='font-weight: bold;'>CREDENTIALS: </font>");
        print_r($_SESSION['logged_type']);
        ?>
        <form name="f1" action="modp.php" method="POST" onsubmit="loading(load);"><br/>
          <input style="color:red;" type="submit" name="b1" value="Logout" id="botton_logout" class="button" onclick="return confirmLogout()">
          <?php
          if (SearchAccountUser($_SESSION['uid'])) {
            echo '<a style="color: #ffffff;" href="./profile.php" id="bottone_keyword" class="buttonlink" onclick="loading(load);">Profile</a>';
          }
          ?>
          <a style="color:#ffffff;" href="./uploaded.php?p=1" id="bottone_keyword" class="buttonlink" onclick="loading(load);">Uploads</a>
          <a style="color:#ffffff;" href="./check_preprints.php" id="bottone_keyword" class="buttonlink" onclick="loading(load);">Check</a>
          <a style="color:#ffffff;" href="./manual_edit.php" id="bottone_keyword" class="buttonlink" onclick="loading(load);">Edit</a>
          <a style="color:#ffffff;" href="./arXiv_panel.php" id="bottone_keyword" class="buttonlink" onclick="loading(load);">ArXiv</a>
          <a style="color:#ffffff;" href="./archived_preprints.php" id="bottone_keyword" class="buttonlink" onclick="loading(load);">Archived</a>
          <a style="color:#ffffff;" href="./mods_list.php" id="bottone_keyword" class="buttonlink" onclick="loading(load);">Admins</a>
          <a style="color:#ffffff;" href="./users_list.php?o=regd" id="bottone_keyword" class="buttonlink" onclick="loading(load);">Users</a>
        </form>
        <?php
        if (check_approve() == true) {
          print_r("<font style='color:red; font-style: italic'>There are preprint to be approved!</font>");
        }
        ?>
      </div>
      <br/><br/>
      <h2>Insert new preprint</h2>
      <h1>field with "*" are required.</h1>
      <br/>
    </div>
  </center>
  <div>
    <form name="f3" action="modp.php" method="POST" enctype="multipart/form-data" onsubmit="loading(load);" id="form">
      <div id="divinsertcateg">*category:<br/>
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
        <div id="cat" hidden>
          <textarea id="textboxcat" name="category2" class="textbox1" placeholder="example of category: math.NA..."></textarea>
        </div>
      </div>
      <div>
        <div id="divinsert">
          <div id="divcontinsert">
            *title:<br/>
            <textarea name="title" id="textbox" class="textbox1" required placeholder="example of title: The geometric..." onkeyup="UpdateMathtit(this.value)"></textarea>
          </div>
        </div>
        <div id="divpreview">
          <div style="font-weight: bold;">
            preview:
          </div>
          <div id="divcontpreview">
            <div id="titlediv"></div>
          </div>
        </div>
      </div>
      <div>
        <div id="divinsert">
          <div id="divcontinsert">
            *authors:<br/>
            <textarea name="author" id="textbox" class="textbox1" required placeholder="example of author: Mario Rossi, Luca..." onkeyup="UpdateMathaut(this.value)"></textarea>
          </div>
        </div>
        <div id="divpreview">
          <div style="font-weight: bold;">
            preview:
          </div>
          <div id="divcontpreview">
            <div id="authordiv"></div>
          </div>
        </div>
      </div>
      <div>
        <div id="divinsert">
          <div id="divcontinsert">
            journal ref:<br/>
            <textarea name="journal" id="textbox" class="textbox1" placeholder="example of Journal: Numer. Linear Algebra..." onkeyup="UpdateMathjou(this.value)"></textarea>
          </div>
        </div>
        <div id="divpreview">
          <div style="font-weight: bold;">
            preview:
          </div>
          <div id="divcontpreview">
            <div id="journaldiv"></div>
          </div>
        </div>
      </div>
      <div>
        <div id="divinsert">
          <div id="divcontinsert">
            comments:<br/>
            <textarea name="comments" id="textbox" class="textbox1" placeholder="example of comments: 10 pages..." onkeyup="UpdateMathcom(this.value)"></textarea>
          </div>
        </div>
        <div id="divpreview">
          <div style="font-weight: bold;">
            preview:
          </div>
          <div id="divcontpreview">
            <div id="commentsdiv"></div>
          </div>
        </div>
      </div>
      <div>
        <div id="divinsert">
          <div id="divcontinsertabs">
            *abstract:<br/>
            <textarea name="abstract" id="textboxabs" class="textbox1" required placeholder="example of abstract: The geometric..." onkeyup="UpdateMathabs(this.value)"></textarea>
          </div>
        </div>
        <div id="divpreview">
          <div style="font-weight: bold;">
            preview:
          </div>
          <div id="divcontpreviewabs">
            <div id="abstractdiv"></div>
          </div>
        </div>
      </div><center>
        <div style="clear:both;"></div>
        <div style="font-weight: bold;">
          *PDF:
          <br/>
        </div>
        <input type="hidden" name="MAX_FILE_SIZE" value="10000000">
        <input type="file" required name="fileToUpload" id="fileToUpload">
        <br/>
        <br/>
        <input type="submit" name="b3" value="Insert" style="width:70px;" class='button' onclick="return confirmInsert()"></center>
      </form>
    </div>
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
        $id = insert_pubb($info, $_SESSION['uid']);
        rename($basedir . $_FILES["fileToUpload"]["name"], $basedir . $id . ".pdf");
        #inserimento file nel database
        insertpdf($id, $fileType);
        echo '<script type="text/javascript">alert("Preprint inserted correctly!\nID generated: ' . $id . ', go on my upload to edit your pubblications.");</script>';
      } else {
        echo '<script type="text/javascript">alert("Sorry, there was an error uploading your file!");</script>';
      }
    }
    require_once './graphics/loader.php';
    require_once './graphics/footer.php';
    ?>
  </div>
  <br/><br/>
  <script>
  UpdateMathtit('Here it will show a preview of what you write on title');
  UpdateMathjou('Here it will show a preview of what you write on journal reference');
  UpdateMathcom('Here it will show a preview of what you write on comments');
  UpdateMathaut('Here it will show a preview of what you write on authors');
  UpdateMathabs('Here it will show a preview of what you write on abstract');
  </script>
</body>
</html>
