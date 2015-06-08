<?php
    include '../config.php';
    include '../functions.php';
    include'functions_fix.php';
    
    $getp           = $handler->query("SELECT * FROM pages");
    $gett           = $handler->query("SELECT * FROM settings LIMIT 1");
    $fetcht         = $gett->fetch(PDO::FETCH_ASSOC);
    $imagequery     = $handler->query("SELECT * FROM images");
    
    $users = $handler->query('SELECT * FROM users');
    
    $fetch = $users->fetchall(PDO::FETCH_COLUMN, 1);
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta name="author" content="Tom Heek" />
    <link href="main.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" media="screen" href="http://cdnjs.cloudflare.com/ajax/libs/fancybox/1.3.4/jquery.fancybox-1.3.4.css" />
    <style type="text/css">
        a.fancybox img {
            border: none;
        } 
    </style>
    
	<title>CMS</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="//cdn.ckeditor.com/4.4.7/full/ckeditor.js"></script>
    <script src="codemirror/lib/codemirror.js"></script>
    <script src="codemirror/mode/javascript/javascript.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/fancybox/1.3.4/jquery.fancybox-1.3.4.pack.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
</head>
<body>
<div class="main">
    <header>
	   <div class="font3"><?php echo sname($fetcht); ?> - CMS</div>
    </header>
    <?php
        if(isset($_SESSION['admin']) && in_array($_SESSION['admin'], $fetch)){
    ?>
        <nav class="main-menu">
            <ul>
                <li>
                    <a href="index.php?p=cms">
                        <i class="fa fa-home fa-2x"></i>
                        <span class="nav-text">
                            Dashboard
                        </span>
                    </a>
                  
                </li>
                <li class="has-subnav">
                    <a href="index.php?p=cms&do=add">
                        <i class="fa fa-plus fa-2x"></i>
                        <span class="nav-text">
                            Pagina toevoegen
                        </span>
                    </a>
                    
                </li>
                <li class="has-subnav">
                    <a href="index.php?p=cms&do=edit">
                       <i class="fa fa-edit fa-2x"></i>
                        <span class="nav-text">
                            Pagina bewerken
                        </span>
                    </a>
                    
                </li>
                <li class="has-subnav">
                    <a href="index.php?p=cms&do=edit&edit=uploadhidden">
                       <i class="fa fa-upload fa-2x"></i>
                        <span class="nav-text">
                            Upload plaatje
                        </span>
                    </a>
                   
                </li>
                <li>
                    <a href="index.php?p=cms&do=gallery">
                        <i class="fa fa-picture-o fa-2x"></i>
                        <span class="nav-text">
                            Foto's beheren
                        </span>
                    </a>
                </li>
                <li>
                    <a href="index.php?p=cms&do=usermanagement">
                        <i class="fa fa-users fa-2x"></i>
                        <span class="nav-text">
                            Gebruikersbeheer
                        </span>
                    </a>
                </li>
                <li>
                   <a href="index.php?p=cms&do=settings">
                       <i class="fa fa-cog fa-2x"></i>
                        <span class="nav-text">
                            Instellingen
                        </span>
                    </a>
                </li>
            </ul>

            <ul class="logout">
                <li>
                   <a href="index.php?p=cms&do=logout">
                         <i class="fa fa-power-off fa-2x"></i>
                        <span class="nav-text">
                            Logout
                        </span>
                    </a>
                </li>  
            </ul>
        </nav>
        <?php
            }
        ?>
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