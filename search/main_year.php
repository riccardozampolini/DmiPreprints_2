<?php

#richiesta anni nel db
require $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints/' . 'mysql/db_select.php';
$lista_anni = listaAnni();


?>
<!DOCTYPE html>
<html>
    <head>
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
        <style>
            #left{
                width: 4%;
                margin: 0 auto;
                float: left;
            }
            #right{
                width: 80%;
                margin: 0 auto;
                float: right;
            }
        </style>
    </head>
    <body>
        <script>
            function ris(quer) {
                $("#right_content").load("search/main_year_content.php", {query : quer});
            }
        </script>
        <div id="left">
                <div id="left_content">
                    <ul>
                    <?php
                    while ($row = mysqli_fetch_array($lista_anni)){
                        $annoRiga = $row['anno'];
                        echo '<li>';
                        echo '<a href="#" onclick=(ris('.$annoRiga.'))>';
                        print $row['anno'];
                        echo '</a>';
                        echo '</li>';
                    }                   
                    ?>
                    </ul>
                </div>
            </div>
            <div id="right">
                <div id="right_content">
                </div>
            </div>
    </body>
</html>
