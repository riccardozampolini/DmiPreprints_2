<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/dmipreprints/'.'mysql/db_update.php';

if(isset($_POST['id'])){
    $res = approvaPaper($_POST['id']);
    echo $res;
}
?>
