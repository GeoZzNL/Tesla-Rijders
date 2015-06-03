<?php
    include '../config.php';
    include '../functions.php';
    include'functions_fix.php';
    
    $getp           = $handler->query("SELECT * FROM pages");
    $gett           = $handler->query("SELECT * FROM settings LIMIT 1");
    $fetcht         = $gett->fetch(PDO::FETCH_ASSOC);
    $imagequery     = $handler->query("SELECT * FROM images");
    
    $version = 'CMS Version 1.2';
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta name="author" content="Tom Heek" />
    <link href="main.css" rel="stylesheet" type="text/css" />
    
	<title><?php echo $version; ?></title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="ckeditor/ckeditor.js"></script>
</head>
<body>
<div class="main">
    <header>
	   <div class="font3"><?php echo sname($fetcht); ?> - CMS</div>
    </header>
    <section>
    <?php 
        if(isset($_GET['p'])){ 
            if(file_exists('pages/'. $_GET['p'] .'.php')){ 
                include('pages/'. $_GET['p'] .'.php'); 
            } 
            else{ 
                include('pages/404.php'); 
            } 
        } 
        else{ 
            include('pages/cms.php'); 
        } 
    ?>
    </section>
</div>
</body>
</html>