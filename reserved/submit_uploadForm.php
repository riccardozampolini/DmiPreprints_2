<div id="upload_form_div" style="margin: 20px auto;width: 100%;display: table">
    <div id="upload_table" style="margin: 0 auto;width: 100%;display: table">
        <form enctype="multipart/form-data" action="reserved/submit_uploadPHP.php" method="POST" >
            <h2>Upload new Preprint</h2><br/><br/>
                    <label for="uid">Title</label><br/><br/>
                    <textarea style="width:800px; height:16px" type="text" class="textbox" name="titolo" required autofocus></textarea><br/><br/>
                    <label for="uid">Authors</label><br/><br/>
                    <textarea style="width:800px; height:16px" type="text" class="textbox" name="collaboratori" required></textarea><br/><br/>
                    <label for="abstract">Abstract</label><br/><br/>
                    <textarea style="width:800px; height:300px" maxlength="1000" name="abstract" class="textbox" required></textarea><br/><br/>		    PDF or other document file
                    <input type="hidden" name="MAX_FILE_SIZE" value="10000000" /><br/><br/>
                    <input name="userfile" type="file"/><br/>
                    <br/><input type="submit" class="bottoni" value="Insert preprint" /><br/><br/>
        </form>
    </div>
</div>
