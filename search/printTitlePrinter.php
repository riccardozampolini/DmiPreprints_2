<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'mysql/db_select.php';
if (isset($_POST[id])) {
    print_r(recuperaTitolo($_POST[id]));
}
?>