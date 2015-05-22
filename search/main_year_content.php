<?php
require $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'mysql/db_select.php';
require_once 'main_tabella.php';
if (isset($_POST['query']) && $_POST['query']!=''){
    stampaTabella(interrogaPerAnno($_POST['query'],0),1);
}else{
    print_r ('Invalid query');
}
?>