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
    <div id="firstContainer">
      <center>
        <div>
          <br/>
          <a style="color:#ffffff;" href="./modp.php" id="bottone_keyword" class="button" onclick="return confirmExit()" >Back</a><br/><br/><br/>
          <h2>manual editing</h2>
        </div>
      </center>
      <?php
      if (sessioneavviata() == True) {
        echo "<br/><center>SORRY ONE DOWNLOAD/UPDATE SESSION IS RUNNING AT THIS TIME! THE SECTION CAN'T BE USED IN THIS MOMENT!</center><br/>";
        break;
      } else {
        if (!isset($_GET['id'])) {
          echo "<center><div><a style='color:#1976D2;' href='./view_preprints.php' target='_blank' title='Go to preprints list'>Do you need to find ID?</a>";
          echo "<form name='f2' action='manual_edit.php' method='POST' onsubmit='loading(load);'><br/>
          <input type='search' autocomplete = 'on' name='id' required class='textfield' placeholder='Insert publication ID'/>
          <input type='submit' name='bottoni8' value='Get' class='button' ><br/>
          </form></div></center>
          ";
          $var = False;
        }
        if (isset($_POST['bottoni8']) or isset($_POST['bottoni9']) or isset($_POST['bottoni10']) or isset($_GET['id'])) {
          if (empty($_POST['id'])) {
            $id = $_GET['id'];
          } else {
            $id = $_POST['id'];
          }
          #adattamento stringa
          $id = trim($id);
          #funzione per recupero informazioni dell'preprint
          $ris = cercapreprint($id);
          if ($ris[0] == $id) {
            #sblocco altri campi
            $var = True;
          } else {
            echo '<script type="text/javascript">alert("ID incorrect!");</script>';
          }
        }
        if ($var == True) {
          echo "<script type='text/javascript'>
          function confirmExit(){
            var x = confirm('All unsaved changes will be lost, continue?');
            if (x) {
              loading(load);
              return x;
            } else {
              return x;
            }
          }
          </script>
          <form name='f1' action='manual_edit.php' method='POST' enctype='multipart/form-data' onsubmit='loading(load);'>
          <center>
          <div>
          <h1>field with '*' are required.</h1><br/>
          </div></center>
          <div id='divinsertcateg'>
          <div style='float:right; width:49%;'>
          <div style='font-weight: bold;'>
          document:
          </div>
          <div style='float:right; width:49%;'>
          <a href=./pdf/" . $ris[9] . " target='_blank' style='color:#1976D2;' title='" . $ris[9] . "'>VIEW</a>
          </div>
          </div>
          <div style='font-weight: bold;'>
          UID(not editable):
          </div>
          <textarea readonly style='width:49%;' name='uid' id='textbox' class='textbox1'>" . $ris[8] . "</textarea><br/><br/>
          <div style='font-weight: bold;'>
          id(not editable):
          </div>
          <textarea readonly style='width:49%;' name='id' id='textbox' class='textbox1' placeholder='example of id: 0000.0000v1'>" . $ris[0] . "</textarea><br/><br/>
          <div style='font-weight: bold;'>
          date(not editable):
          </div>
          <textarea readonly style='width:49%;' name='data' id='textbox' class='textbox1' placeholder='example of data: 2011-12-30T10:37:35Z'>" . $ris[2] . "</textarea>
          </div>

          <div>
          <div id='divinsert'>
          <div id='divcontinsert'>
          *category:<br/>
          <textarea name='category' id='textbox' class='textbox1' required placeholder='example of category: math.NA...' onkeyup='UpdateMathcat(this.value)' >" . $ris[6] . "</textarea>
          </div>
          </div>
          <div id='divpreview'>
          <div style='font-weight: bold;'>
          preview:
          </div>
          <div id='divcontpreview'>
          <div id='categorydiv'></div>
          </div>
          </div>
          </div>
          <div>
          <div id='divinsert'>
          <div id='divcontinsert'>
          *title:<br/>
          <textarea name='title' id='textbox' class='textbox1' required placeholder='example of title: The geometric...' onkeyup='UpdateMathtit(this.value)'>" . $ris[1] . "</textarea>
          </div>
          </div>
          <div id='divpreview'>
          <div style='font-weight: bold;'>
          preview:
          </div>
          <div id='divcontpreview'>
          <div id='titlediv'></div>
          </div>
          </div>
          </div>
          <div>
          <div id='divinsert'>
          <div id='divcontinsert'>
          *authors:<br/>
          <textarea name='author' id='textbox' class='textbox1' required placeholder='example of author: Mario Rossi, Luca...' onkeyup='UpdateMathaut(this.value)'>" . $ris[3] . "</textarea>
          </div>
          </div>
          <div id='divpreview'>
          <div style='font-weight: bold;'>
          preview:
          </div>
          <div id='divcontpreview'>
          <div id='authordiv'></div>
          </div>
          </div>
          </div>
          <div>
          <div id='divinsert'>
          <div id='divcontinsert'>
          journal reference:<br/>
          <textarea name='journal' id='textbox' class='textbox1' placeholder='example of Journal: Numer. Linear Algebra...' onkeyup='UpdateMathjou(this.value)'>" . $ris[4] . "</textarea>
          </div>
          </div>
          <div id='divpreview'>
          <div style='font-weight: bold;'>
          preview:
          </div>
          <div id='divcontpreview'>
          <div id='journaldiv'></div>
          </div>
          </div>
          </div>
          <div>
          <div id='divinsert'>
          <div id='divcontinsert'>
          comments:<br/>
          <textarea name='comments' id='textbox' class='textbox1' placeholder='example of comments: 10 pages...' onkeyup='UpdateMathcom(this.value)'>" . $ris[5] . "</textarea>
          </div>
          </div>
          <div id='divpreview'>
          <div style='font-weight: bold;'>
          preview:
          </div>
          <div id='divcontpreview'>
          <div id='commentsdiv'></div>
          </div>
          </div>
          </div>
          <div>
          <div id='divinsert'>
          <div id='divcontinsertabs'>
          *abstract:<br/>
          <textarea name='abstract' id='textboxabs' class='textbox1' required placeholder='example of abstract: The geometric...' onkeyup='UpdateMathabs(this.value)'>" . $ris[7] . "</textarea>
          </div>
          </div>
          <div id='divpreview'>
          <div style='font-weight: bold;'>
          preview:
          </div>
          <div id='divcontpreviewabs'>
          <div id='abstractdiv'></div>
          </div>
          </div>
          </div><center>
          <div style='clear:both;'></div>
          <center><div style='font-weight: bold;'>file to upload:</div>
          <input type='hidden' name='MAX_FILE_SIZE' value='10000000'>
          <input type='file' name='fileToUpload' id='fileToUpload'><br/><br/>
          <input type='submit' name='bottoni9' value='Remove' id='bottone_keyword' class='button' onclick='return confirmDelete()'/>
          <input type='submit' name='bottoni10' value='Complete' id='bottone_keyword' class='button' onclick='return confirmInsert()'/></center>
          </form></div></center>";
          $ris[1] = str_replace("<br />", "", $ris[1]);
          $ris[1] = str_replace("\n", "", $ris[1]);
          $ris[7] = str_replace("<br />", "", $ris[7]);
          $ris[7] = str_replace("\n", "", $ris[7]);
          echo "<script type='text/javascript'>UpdateMathcat('" . $ris[6] . "')</script>
          <script type='text/javascript'>UpdateMathtit('" . $ris[1] . "')</script>
          <script type='text/javascript'>UpdateMathaut('" . $ris[3] . "')</script>
          <script type='text/javascript'>UpdateMathjou('" . $ris[4] . "')</script>
          <script type='text/javascript'>UpdateMathcom('" . $ris[5] . "')</script>
          <script type='text/javascript'>UpdateMathabs('" . $ris[7] . "')</script>";
          #importazione variabili globali
          $target_file = $basedir2 . basename($_FILES["fileToUpload"]["name"]);
          if (isset($_POST['bottoni9'])) {
            $id1 = $_POST['id'];
            #eliminazione del preprint selezionato
            delete_pdf($id1);
            cancellaselected($id1);
            echo '<script type="text/javascript">
            alert("Paper ' . $_POST['id'] . ' removed correctly!");
            window.close();</script>';
          }
          if (isset($_POST['bottoni10'])) {
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
            $info[0] = $_POST['id'];
            $info[1] = $_POST['title'];
            $info[2] = $_POST['data'];
            $info[3] = $_POST['author'];
            $info[6] = $_POST['category'];
            $info[7] = $_POST['abstract'];
            #richiamo della funzione per inserire le info del preprint all'interno del database
            update_preprints($info);
            $check = $_POST['check'];
            #controllo se ci sono file da caricare
            if ($_FILES["fileToUpload"]["size"] > 0) {
              #caricamento del file scelto
              if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $fileType = $_FILES["fileToUpload"]["type"];
                #inserimento nel database del file
                insert_one_pdf($info[0], $fileType);
                echo '<script type="text/javascript">
                alert("Paper ' . $_POST['id'] . ' updated correctly!");
                window.close();</script>';
              } else {
                echo '<script type="text/javascript">alert("Error, file not uploaded!");</script>';
              }
            } else {
              echo '<script type="text/javascript">
              alert("Paper ' . $_POST['id'] . ' updated correctly!");
              window.close();</script>';
            }
          }
        }
      }
      ?>
    </div><br/>
  </div>
  <?php
  require_once './graphics/loader.php';
  require_once './graphics/footer.php';
  ?>
</body>
</html>
