<!DOCTYPE html>
<html>
    <head>
        <title>DMIPreprints</title>
        <!--<script src="js/jquery.min.js"></script>-->
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
        <script src="js/config.js"></script>
        <script src="js/skel.min.js"></script>
        <script src="js/skel-panels.min.js"></script>
        <noscript>
        <link rel="stylesheet" href="css/skel-noscript.css" />
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="css/style-desktop.css" />
        </noscript>
        <link rel="stylesheet" href="css/main.css" />
        <link rel="stylesheet" type="text/css" href="css/tabelle.css">
        <link rel="stylesheet" type="text/css" href="css/controlli.css">
        <script src="js/targetweb-modal-overlay.js"></script>
        <link href='css/targetweb-modal-overlay.css' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
        <!--[if lte IE 9]><link rel="stylesheet" href="css/ie9.css" /><![endif]-->
        <!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->

        <script type="text/x-mathjax-config">
            MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}});
        </script>
        <script type="text/javascript"
                src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
        </script>

    </head>
    <body>

        <script>
            function vistaAnno() {
                $("#contenitore_dinamico").load("search/main_year.php", function() {
                    MathJax.Hub.Typeset();
                });

            }

            function vistaKeyword() {
                $("#contenitore_dinamico").load("search/main_keyword.php", function() {
                    MathJax.Hub.Typeset();
                });
            }

            function visAbstract(id_paper) {
                $("#contenuto_titolo_print").load("search/printTitlePrinter.php", {id: id_paper});
                $("#contenuto_abstract").load("search/abstractPrinter.php", {id: id_paper}, function() {
                    MathJax.Hub.Typeset();
                    TrgModalOverlayLoader("modal1");
                });
            }
        </script>
        <div id="header-wrapper">
            <div class="container">
                <div class="row">
                    <div class="12u">
                        <header id="header">
                            <h1><a href="#" id="logo">DMI Preprints</a></h1>
                            <nav id="nav">
                                <a href="main.php" class="current-page-item">preprint search</a>
                                <a href="reserved.php">Reserved Area</a>
                            </nav>
                        </header>

                    </div>
                </div>
            </div>
        </div>
        <div id="div_menu_ricerca" class="contenitore">
            <div>
                <table>
                    <tr>
                        <td>
                            <button id="bottone_anno" class="bottoni" onclick="vistaAnno()">list by year</button>
                        </td>
                        <td>
                            <button id="bottone_keyword" class="bottoni" onclick="vistaKeyword()">search by keyword</button>
                        </td>
                    </tr>
                </table>
            </div>

        </div>

        <div id="contenitore_dinamico" class="contenitore">
        </div>
        <div id="modal1" class="trg-overlay hide small">
            <div class="trg-modal-header" >
                <h2 id="contenuto_titolo_print" class="wordwrap"></h2>
            </div><!-- Modal header-->
            <div class="wordwrap" id="contenuto_abstract">
            </div>
            <a class="close-overlay">&#215;</a>
        </div>

        <footer>

        </footer>

    </body>
</html>
