<!DOCTYPE html>
<html>
<?php
require_once './graphics/header.php';
if ($_GET['i'] == "1") {
  $path = "./arXiv_panel.php";
} else {
  $path = "./modp.php";
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
        <div><br/>
          <a style='color:#ffffff;' href='<?php echo $path; ?>' id='bottone_keyword' class='button' onclick='loading(load);'>Back</a><br/><br/><br/>
          <h2>CHECK PREPRINTS</h2>
        </div>
        <div>
          <?php
          if (sessioneavviata() == True) {
            echo "<center><br/>SORRY ONE DOWNLOAD/UPDATE SESSION IS RUNNING AT THIS TIME! THE LIST CAN'T BE CHANGED IN THIS MOMENT!</center><br/>";
            exit();
          } else {
            ####################################################################################################################################################################
            #Imposto la directory da leggere arxiv papers
            $directory = $basedir3;
            echo "<form name='f1' action='check_preprints.php' id='f1' method='GET' onsubmit='loading(load);'>"
            . "<div id='arxivpreprints'>"
            . "<input type='checkbox' name='i' value='" . $_GET['i'] . "' checked hidden/>"
            . "<table id='table'>";
            #legge contenuto della directory pdf downloads
            if (is_dir($directory)) {
              #Apro l'oggetto directory
              if ($directory_handle = opendir($directory)) {
                #Scorro l'oggetto fino a quando non è termnato cioè false
                echo "<tr id='thhead'><td id='tdh' colspan='4' align='center'>DOWNLOADED FROM ARXIV</td></tr>";
                echo "<tr id='thhead'><td id='tdh'><input type='checkbox' id='all' class='check1' value='all1' name='all' onChange='toggleARXIV(this);'/>N&deg;:</td>"
                . "<td id='tdh' align='center'>FILE:</td>"
                . "<td id='tdh' align='center'>RECORD:</td>"
                . "<td id='tdh' align='center'>CREATED:</td></tr>";
                $i = 0;
                $y = 1;
                //legge file delle cartelle e li inserisce come righe nella tabella
                while (($file = readdir($directory_handle)) !== false) {
                  #Se l'elemento trovato è diverso da una directory
                  #o dagli elementi . e .. lo visualizzo a schermo
                  if ((!is_dir($file)) & ($file != ".") & ($file != "..") & ($file != "index.php")) {
                    $array[$i] = $file;
                    $ids = $file;
                    $ids = substr($ids, 0, -4);
                    $ids = str_replace("-", "/", $ids);
                    echo "<tr id='th'><td id='td'><input type='checkbox' name='ch" . $i . "' value='checked' class='check1'/>$y.</td><td id='td'><a href=./pdf_downloads/" . $file . " target='_blank' title='" . $file . "'>" . $file . "</a></td><td id='td'><a href=./manual_edit.php?id=" . $ids . " target='_blank' title='" . $ids . "'>" . $ids . "</a></td>";
                    #recupero data creazione file
                    $dat = date("Y-m-d H:i", filemtime($basedir3 . $file));
                    echo "<td id='td'>$dat</td></tr>";
                    $i++;
                    $y++;
                  }
                }
                echo "</table></div>";
                #Chiudo la lettura della directory.
                closedir($directory_handle);
              }
            }
            $z = 0;
            $lunghezza = $i;
            #Imposto la directory da leggere upload dmi
            $directory2 = $basedir;
            echo "<div id='dmipreprints'><table id='table1'>";
            #legge contenuto della directory
            if (is_dir($directory2)) {
              #Apro l'oggetto directory
              if ($directory_handle = opendir($directory2)) {
                #Scorro l'oggetto fino a quando non è termnato cioè false
                echo "<tr id='thhead'><td id='tdh' colspan='4' align='center'>SUBMITTED TO DMI</td></tr>";
                echo "<tr id='thhead'><td id='tdh'><input type='checkbox' id='all' name='all2' class='check2' onChange='toggleDMI(this);'/>N&deg;:</td>"
                . "<td id='tdh' align='center'>FILE:</td><td id='tdh' align='center'>RECORD:</td>"
                . "<td id='tdh' align='center'>CREATED:</td></tr>";
                $y = 1;
                while (($file = readdir($directory_handle)) !== false) {
                  #Se l'elemento trovato è diverso da una directory
                  #o dagli elementi . e .. lo visualizzo a schermo
                  if ((!is_dir($file)) & ($file != ".") & ($file != "..") & ($file != "index.php")) {
                    $array[$i] = $file;
                    $ids = $file;
                    $ids = substr($ids, 0, -4);
                    $ids = str_replace("-", "/", $ids);
                    echo "<tr id='th'><td id='td'><input type='checkbox' name='ch" . $i . "' value='checked' class='check2'/>$y.</td><td id='td'><a href=./upload_dmi/" . $file . " target='_blank' title='" . $file . "'>" . $file . "</a></td><td id='td'><a href=./manual_edit.php?id=" . $ids . " target='_blank' title='" . $ids . "'>" . $ids . "</a></td>";
                    #recupero data creazione file
                    $dat = date("Y-m-d H:i", filemtime($basedir . $file));
                    echo "<td id='td'>$dat</td></tr>";
                    $i++;
                    $y++;
                  }
                }
                echo "</table></div>"
                . "<input type='submit' name='b1' value='Remove' id='bottone_keyword' class='button' onclick='return confirmDelete3()'>"
                . "<input type='submit' name='b2' value='Insert' id='bottone_keyword' class='button' onclick='return confirmInsert3()'>"
                . "</div></form>";
                #Chiudo la lettura della directory.
                closedir($directory_handle);
              }
            }
            #################################################################################################################################################
            $k = 0;
            $lunghezza2 = $i;
            #bottone elimina
            if (isset($_GET['b1'])) {
              for ($j = 0; $j < $lunghezza2; $j++) {
                $percorso2 = $copia . $array[$j];
                if (isset($_GET["ch" . $j])) {
                  $k++;
                  if ($j < $lunghezza) {
                    $directory2 = $basedir3;
                    $percorso = $basedir3 . $array[$j];
                  } else {
                    $directory2 = $basedir;
                    $percorso = $basedir . $array[$j];
                  }
                  if (is_dir($directory2)) {
                    if ($directory_handle = opendir($directory2)) {
                      while (($file = readdir($directory_handle)) !== false) {
                        if ((!is_dir($file)) & ($file != ".") & ($file != "..") & ($file != "index.php")) {
                          if ($file == $array[$j]) {
                            #cancello file...
                            unlink($percorso);
                            unlink($percorso2);
                            #cancello riga database...
                            remove_preprints($array[$j]);
                          }
                        }
                      }
                      #Chiudo la lettura della directory.
                      closedir($directory_handle);
                    }
                  }
                }
              }
              #controllo se sono stati selezionati preprint da rimuovere
              if ($k == 0) {
                echo '<script type="text/javascript">setTimeout(function(){alert("No preprint selected!")}, 500);</script>';
              } else {
                echo '<script type="text/javascript">setTimeout(function(){alert("' . $k . ' preprint removed correctly!")}, 500);</script>';
                #aggiorno la pagina dopo 0 secondi
                echo '<META HTTP-EQUIV="Refresh" Content="1; URL=./check_preprints.php">';
              }
            }
            ####################################################################################################################################################################
            #bottone inserisci
            if (isset($_GET['b2'])) {
              for ($j = 0; $j < $lunghezza2; $j++) {
                $percorso2 = $copia . $array[$j];
                if (isset($_GET["ch" . $j])) {
                  $k++;
                  if ($j < $lunghezza) {
                    $directory2 = $basedir3;
                    $percorso = $basedir3 . $array[$j];
                  } else {
                    $directory2 = $basedir;
                    $percorso = $basedir . $array[$j];
                  }
                  if (is_dir($directory2)) {
                    if ($directory_handle = opendir($directory2)) {
                      while (($file = readdir($directory_handle)) !== false) {
                        if ((!is_dir($file)) & ($file != ".") & ($file != "..") & ($file != "index.php")) {
                          if ($file == $array[$j]) {
                            if ($j < $lunghezza) {
                              $idd = substr($file, 0, -4);
                              #inserimento file nel database
                              insert_one_pdf2($idd);
                            } else {
                              $idd = substr($file, 0, -4);
                              #inserimento file nel database
                              insertopdf($idd);
                            }
                          }
                        }
                      }
                      #Chiudo la lettura della directory.
                      closedir($directory_handle);
                    }
                  }
                }
              }
              #controllo se sono stati selezionati preprint da rimuovere
              if ($k == 0) {
                echo '<script type="text/javascript">setTimeout(function(){alert("No preprint selected!")}, 500);</script>';
              } else {
                echo '<script type="text/javascript">setTimeout(function(){alert("' . $k . ' preprint inserted correctly!")}, 500);</script>';
                #aggiorno la pagina dopo 0 secondi
                echo '<META HTTP-EQUIV="Refresh" Content="1; URL=./check_preprints.php">';
              }
            }
          }
          ?>
        </div>
      </center>
    </div><br/>
  </div>
  <?php
  require_once './graphics/loader.php';
  require_once './graphics/footer.php';
  ?>
</body>
</html>
