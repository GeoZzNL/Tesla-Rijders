<?php
    include'config.php';
    require'functions.php';
    
    $getp           = $handler->query("SELECT * FROM pages");
    $gett           = $handler->query("SELECT * FROM settings LIMIT 1");
    $fetcht         = $gett->fetch(PDO::FETCH_ASSOC);
    $imagequery     = $handler->query("SELECT * FROM images");
    
    if(isset($_GET['p'])){
        $page       = $_GET['p'];
        $page       = makeFriendly($page);
        $getpn      = $handler->query("SELECT * FROM pages WHERE ptitle = '$page'");
    }
    elseif(empty($_GET['p'])){
        $getpn      = $handler->query("SELECT * FROM pages LIMIT 1");
    }
    $fetchpn    = $getpn->fetch(PDO::FETCH_ASSOC);
    
    $page = (isset($_GET['p']) ? $_GET['p'] : NULL);
    $page = makeFriendly($page);
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta name="author" content="Tom Heek" />
    <meta name="description" content="<?php echo $fetcht['description']; ?>" />
    <meta name="keywords" content="<?php echo $fetcht['keywords']; ?>" />
    <link href="main.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" media="screen" href="http://cdnjs.cloudflare.com/ajax/libs/fancybox/1.3.4/jquery.fancybox-1.3.4.css" />
    <style type="text/css">
        a.fancybox img {
            border: none;
        } 
    </style>
    
	<title><?php echo title($fetcht, $fetchpn); ?></title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="ckeditor/ckeditor.js"></script>
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
	   <div class="font3"><?php echo sname($fetcht); ?></div>
    </header>
    <nav>
    <?php
        echo menu($handler, $getp, $fetcht);
    ?>
    </nav>
    <section>
    <?php
        echo page($handler, $getp, $page, $fetcht, $fetchpn);
    ?>
    </section>
    <footer>
        <?php
            $getse  = $handler->query("SELECT * FROM settings");
            $fetch  = $getse->fetch(PDO::FETCH_ASSOC);
            
            echo $fetch['footer'];
        ?>
    </footer>
</div>
</body>
</html>