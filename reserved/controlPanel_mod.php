<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'mysql/db_select.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'mysql/db_update.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'search/main_tabella.php';
?>

<div style="float: left">
    <?php
    print_r(" Login: ");
    print_r($_SESSION['nome']);
    print_r(" UID: " . $_SESSION['uid']);
    print_r(" Tipo di accesso: ");
    print_r($_SESSION['logged_type']);
    ?>
</div>
<div style="float: right">
    <button onclick="logout()" id="button_logout" class="bottoni" style="color: red;">logout</button>
    <form name="f1" action="arXiv_panel.php" method="POST">
        <input type="submit" name="botton" value="arXiv panel" id="bottone_keyword" class="bottoni">
    </form></tr>
</div>
<script>
    $(document).ready(function () {
        $("button").click(function (event) {
            if (event.target.id !== "button_logout") {
                var cmd = event.target.id.substring(0, 4);
                if (cmd === "elim") {
                    var idTgt = event.target.id.substring(6);
                    idTgt = idTgt.replace('"', '');
                    if (confirm("Eliminare?")) {
                        $("#cont_feedback").load("reserved/submit_removeFilePHP.php", {id: idTgt}, function () {
                            location.reload();
                        });

                    }
                } else {
                    if (cmd === "appr") {
                        var idTgt = event.target.id.substring(6);
                        idTgt = idTgt.replace('"', '');
                        if (confirm("Approvare?")) {
                            $("#cont_feedback").load("reserved/submit_approvePaper.php", {id: idTgt}, function () {
                                location.reload();
                            });

                        }
                    }
                }
            }
        });
    });
</script>
<div id="contenitore">
    <div>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'reserved/submit_uploadForm.php'; ?>
    </div>
    <div>
        <h2>own preprint</h2>
        <?php stampaTabellaCompleta(interrogaPerUID($_SESSION['uid']), 1) ?>
    </div>
    <div style="margin-top: 20px">
        <h2>all preprint on database</h2>
        <?php stampaTabellaCompleta(interrogaWhole(), 1); ?>
    </div>
</div>
<div id="cont_feedback">

</div>
