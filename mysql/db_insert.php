<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/dmipreprints/'.'mysql/db_conn.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/dmipreprints/'.'authorization/sec_sess.php';
##INSERIMENTO PAPER
function inserisciPaper($titolo, $uploader,$collaboratori, $abstract, $nome_file, $data, $anno) {
    global $db_connect;
    connettiDBManager();

    #selezione dello schema dmipreprints
    mysqli_select_db($db_connect, 'dmipreprints') or die('Could not select database');
    
    //controllo uploader presente
    $query = "select count(*) from UPLOADERS where uid = '".$uploader."'";
    $result = mysqli_query($db_connect, $query) or die('\n\nQuery failed: ' . mysqli_error($db_connect) . $query);
    $row = mysqli_fetch_array($result,MYSQLI_NUM);
    mysqli_free_result($result);
    if($row[0] == 0){
        echo '#INSERIMENTO UPLOADER NON PRESENTE#';
        sec_session_start();
        $nome = $_SESSION['nome'];
        print "\$nome = " . $nome . "\n";

        $uid = $_SESSION['uid'];
        print "\$uid = " . $uid . "\n";

        //insert nuovo uploader
        $query = "insert into UPLOADERS (uid, nome) values ('".$uid."','".$nome."')";
        $result = mysqli_query($db_connect, $query) or die('\n\nQuery failed: ' . mysqli_error($db_connect) . $query);
    }
    echo '::::::::::::inserimento prints::::::';
    $query = "INSERT INTO PRINTS(titolo,uploader,collaboratori,abstract,nome_file,data_inserimento,anno) values ('" . $titolo . "','" . $uploader . "','" . $collaboratori . "','" . $abstract . "','" . $nome_file . "','" . $data . "'," . $anno . ")";
    $result = mysqli_query($db_connect, $query) or die('\n\nQuery failed: ' . mysqli_error($db_connect) . $query);
    
    
    echo ':::FINE DB_INSERT:::';
    return $result;
}

?>