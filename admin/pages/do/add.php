<div class="font4">Add page</div>
<hr />
<form method="post">
    <label for="pname">Page name:</label><br />
    <input type="text" name="pname" autocomplete="off" /><br />
    <label for="phidden">Hidden:</label><br />
    <input type="checkbox" name="phidden" /><hr />
    <label for="pcontent">Page content:</label><br />
    <textarea name="pcontent" id="pcontent"></textarea>
    <input type="submit" value="Submit" />
    <script>
        CKEDITOR.replace('pcontent', {enterMode : CKEDITOR.ENTER_BR, extraAllowedContent: 'section article header nav aside[lang,foo]'});
    </script>
</form>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $pname      = $_POST['pname'];
    $titlef     = makeFriendlyFix($pname);
    $phidden    = ((empty($_POST['phidden']))? '' : $_POST['phidden']);
    $pcontent   = $_POST['pcontent'];

    echo add($pname, $titlef, $pcontent, $phidden, $handler);
}
?>