<?php

//cancellazione dell'account registrato
include '../conf.php';
include '../mysql/db_conn.php';
include '../authorization/auth.php';
//se impostata correttamente la mail procedo
if (isset($_POST['mail'])) {
    $email = $_POST['mail'];
    $email = trim($email);
    //generazione chiave hash password
    $sql = "DELETE FROM ACCOUNTS WHERE email='" . $email . "'";
    $query = mysqli_query($db_connection, $sql) or die(mysqli_error());
    //chiusura connessione al database
    mysqli_close($db_connection);
    echo "<br/><br/>Your account has been deleted successfully!";
    //termino la sessione
    session_start();
    session_unset();
    session_destroy();
    echo '<script type="text/javascript">setTimeout(function(){location.reload();}, 1000);</script>';
}
?>
