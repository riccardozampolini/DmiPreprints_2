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
            //FUNZIONI
            function show_keyword() {
                var quer = $('#input_keyword').val();
                $("#right_content").load("search/main_keyword_content.php", {query: quer});
            }
        </script>
        <div id="left">
            <div id="left_content">
                <ul>
                    <li>
                        <input placeholder="keyword" class="textbox" id="input_keyword">
                        <submit id="button_cerca_keyword" class="bottoni" onclick="show_keyword()">Search</button>
                    </li>
                </ul>
            </div>

        </div>
        <div id="right">
            <div id="right_content">
            </div>
        </div>


    </body>
</html>
