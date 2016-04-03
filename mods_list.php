<!DOCTYPE html>
<html>
<?php
require_once './graphics/header.php';
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
          <a style="color:#ffffff;" href="./modp.php" id="bottone_keyword" class="button" onclick="loading(load);">Back</a><br>
          <br/><br/><h2>ADMINISTRATORS LIST</h2>
          <div class="boxContainerInsertAuthors">
            <form name="f2" action="mods_list.php" method="GET" onsubmit="loadingRight(loadRight);">
              <label>
                Add administrator(s)?
                <input type="checkbox" name="insert" value="1" checked/>
              </label><br/><br/>
              <input type="search" style="width:100%;" class='textbox' autocomplete = "on" required name="txt1" placeholder="name1, name2, name3, name..." autofocus />
              <br/><br/>
              <input type="submit" name="b2" value="Send" id="bottone_keyword" class="button"/>
            </form>
          </div>
        </div>
      </center>
      <div id="secondContainer">
        <?php
        if (isset($_GET['b2'])) {
          $name = $_GET['txt1'];
          $insert = $_GET['insert'];
          #funzione inserimento nuovi autori
          aggiungiutenteAdmin($name, $insert);
        }
        #visualizzo lista amministratori...
        //$nomi = legginomi();
        $nomi = legginomiAdmin();
        #conto lunghezza array
        $lunghezza = count($nomi);
        echo "<form name='f1' action='mods_list.php' id='f1' method='POST' onsubmit='loadingRight(loadRight);'>
        <center><table id='table' style='width:35%;'>";
        echo "<tr id='th'>"
        . "<td id='tdh'><input type='checkbox' onChange='toggle(this);'/>N&deg;:</td>"
        . "<td id='tdh' align='center'>UID:</td></tr>";
        #creazione della tabella html dei file all'interno di pdf_downloads
        $y = 1;
        for ($i = 0; $i < $lunghezza; $i++) {
          echo "<tr id='th'>"
          . "<td id='td'><input type='checkbox' name='" . $i . "' value='checked' class='check'/>$y.</td>"
          . "<td id='td'>" . $nomi[$i] . "</td></tr>";
          $y++;
        }
        echo "</table><input type='submit' class='button' name='b3' value='Remove' onclick='return confirmDelete4()'></center></form>";
        if ($lunghezza == 0) {
          #richiamo funzione per corretto update successivo
          aggiornanomiAdmin();
        }
        if (isset($_POST['b3'])) {
          $k = 0;
          $z = 0;
          #lunghezza array nomi
          $lunghezza = count($nomi);
          for ($j = 0; $j < $lunghezza; $j++) {
            $delete = $_POST[$j];
            #controllo di quali checkbox sono state selezionate
            if ($delete != "checked") {
              $array[$k] = $nomi[$j];
              $k++;
            } else {
              $array2[$z] = $nomi[$j];
              $z++;
            }
          }
          #scrittura dei nomi sul database
          scrivinomiAdmin($array);
          #inserisco i nomi eliminati all'interno di una stringa per poi visualizzarla all'utente
          $nomieliminati = implode(", ", $array2);
          if ($nomieliminati == "") {
            echo '<script type="text/javascript">setTimeout(function(){alert("No administrator selected!")}, 500);</script>';
          } else {
            echo '<script type="text/javascript">setTimeout(function(){alert("' . $nomieliminati . ' deleted from list!")}, 500);</script>';
            echo '<META HTTP-EQUIV="Refresh" Content="1; URL=./mods_list.php">';
          }
        }
        ?>
      </div>
    </div>
  </div>
  <?php
  require_once './graphics/loaderRight.php';
  require_once './graphics/loader.php';
  require_once './graphics/footer.php';
  ?>
</body>
</html>
