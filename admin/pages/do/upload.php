Upload an image to the gallery.<br /><br />

    <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
        <label for="fileToUpload">Select an image to upload:</label><br />
        <input type="file" name="fileToUpload" id="fileToUpload" /><br />
        <label for="imagedesc">Image description:</label><br />
        <input type="text" name="imagedesc" autocomplete="off" /><br />
        <input type="submit" value="Submit" />
    </form><br />
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['imagedesc'])){
        $galleryn = basename($_FILES['fileToUpload']['name']);
        $gallerydesc = htmlentities($_POST['imagedesc'], ENT_QUOTES);
        
        echo upload($galleryn, $gallerydesc, $handler);
        }
    }
?>