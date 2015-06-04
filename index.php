<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo title($fetcht, $fetchpn); ?></title>
	<meta charset="utf-8" />
	<meta name="description" content="<?php echo $fetcht['description']; ?>" />
	<meta name="keywords" content="<?php echo $fetcht['keywords']; ?>" />
	<link href="http://fonts.googleapis.com/css?family=Didact+Gothic" rel="stylesheet" />
	<link href="assets/style/default.css" rel="stylesheet" type="text/css" media="all" />
	<link href="assets/style/fonts.css" rel="stylesheet" type="text/css" media="all" />
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link href="assets/js/bootstrap.min.css" rel="stylesheet" />

	<!--[if IE 6]><link href="default_ie6.css" rel="stylesheet" type="text/css" /><![endif]-->
	
</head>
<body>


	<div style="min-height: 50px;">
        <!-- Jssor Slider Begin -->
        <div id="slider1_container" style="display: none; position: relative; margin: 0 auto;
        top: 0px; left: 0px; width: 1300px; height: 500px; overflow: hidden;">
            <!-- Loading Screen -->
            <div u="loading" style="position: absolute; top: 0px; left: 0px;">
                <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block;
                top: 0px; left: 0px; width: 100%; height: 100%;">
                </div>
                <div style="position: absolute; display: block; background: url(img/loading.gif) no-repeat center center;
                top: 0px; left: 0px; width: 100%; height: 100%;">
                </div>
            </div>
            <!-- Slides Container -->
            <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 1300px; height: 500px; overflow: hidden;">
                <div>
                    <img u="image" src="images/header-bg.jpg" />
                </div>
                <div>
                    <img u="image" src="images/header-bg1.jpg" />
                </div>
                <div>
                    <img u="image" src="images/header-bg2.jpg" />
                </div>
				
            </div>
			
            	<div id="header" class="container">
		<div id="logo">
			<h1><a href="#"><?php echo title($fetcht, $fetchpn); ?></a></h1>
		</div>
		<div id="menu">
			<ul>
				<?php
				echo menu($handler, $getp, $fetcht);
				?>
			</ul>
		</div>
	
		<div id="banner" class="container" style="color:white">
			<div class="title">
				<?php
					echo htitle($handler, $getp, $page, $fetcht, $fetchpn);
				?>
		</div>
	</div>
	</div>
            <style>
                /* jssor slider bullet navigator skin 21 css */
                /*
                .jssorb21 div           (normal)
                .jssorb21 div:hover     (normal mouseover)
                .jssorb21 .av           (active)
                .jssorb21 .av:hover     (active mouseover)
                .jssorb21 .dn           (mousedown)
                */
                .jssorb21 {
                    position: absolute;
                }
                .jssorb21 div, .jssorb21 div:hover, .jssorb21 .av {
                    position: absolute;
                    /* size of bullet elment */
                    width: 19px;
                    height: 19px;
                    text-align: center;
                    line-height: 19px;
                    color: white;
                    font-size: 12px;
                    background: url(img/b21.png) no-repeat;
                    overflow: hidden;
                    cursor: pointer;
                }
                .jssorb21 div { background-position: -5px -5px; }
                .jssorb21 div:hover, .jssorb21 .av:hover { background-position: -35px -5px; }
                .jssorb21 .av { background-position: -65px -5px; }
                .jssorb21 .dn, .jssorb21 .dn:hover { background-position: -95px -5px; }
            </style>
            <!-- bullet navigator container -->
	
            <!-- Arrow Left -->
            <span u="arrowleft" class="jssora21l" style="top: 123px; left: 8px;">
            </span>
            <!-- Arrow Right -->
            <span u="arrowright" class="jssora21r" style="top: 123px; right: 8px;">
            </span>
        </div>
        <!-- Slider End -->
    </div>

    <script src="assets/js/jquery-1.9.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/docs.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>

    <!-- jssor slider scripts-->
    <!-- use jssor.js + jssor.slider.js instead for development -->
    <!-- jssor.slider.mini.js = (jssor.js + jssor.slider.js) -->
    <script type="text/javascript" src="assets/js/jssor.slider.mini.js"></script>
    <script>
        jQuery(document).ready(function ($) {

            var options = {
                $FillMode: 2,                                       //[Optional] The way to fill image in slide, 0 stretch, 1 contain (keep aspect ratio and put all inside slide), 2 cover (keep aspect ratio and cover whole slide), 4 actual size, 5 contain for large image, actual size for small image, default value is 0
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlayInterval: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                                   //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1

                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideEasing: $JssorEasing$.$EaseOutQuint,          //[Optional] Specifies easing for right to left animation, default value is $JssorEasing$.$EaseOutQuad
                $SlideDuration: 800,                               //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 0, 					                //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 1,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 1,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)
              
                $BulletNavigatorOptions: {                          //[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$,                 //[Required] Class to create navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 1,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Lanes: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 8,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 8,                                   //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1,                                //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                    $Scale: false                                   //Scales bullets navigator or not while slider scale
                },

                $ArrowNavigatorOptions: {                           //[Optional] Options to specify and enable arrow navigator or not
                    $Class: $JssorArrowNavigator$,                  //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 1,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 2,                                 //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                }
            };

            //Make the element 'slider1_container' visible before initialize jssor slider.
            $("#slider1_container").css("display", "block");
            var jssor_slider1 = new $JssorSlider$("slider1_container", options);

            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var bodyWidth = document.body.clientWidth;
                if (bodyWidth)
                    jssor_slider1.$ScaleWidth(Math.min(bodyWidth, 1920));
                else
                    window.setTimeout(ScaleSlider, 30);
            }
            ScaleSlider();

            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
            //responsive code end
        });
    </script>



<div id="wrapper">
	<div id="three-column" class="container">
		
	
		<div class="boxB">
		
			<?php
				echo page($handler, $getp, $page, $fetcht, $fetchpn);
			?>
			
		</div>
	
	</div>
</div>
</br>
	<footer>

		<ul class="icons">
			<li><a href="#" class="icon circle fa-twitter"><span class="label">Twitter</span></a></li>
			<li><a href="#" class="icon circle fa-facebook"><span class="label">Facebook</span></a></li>
			<li><a href="#" class="icon circle fa-google-plus"><span class="label">Google+</span></a></li>
			<li><a href="#" class="icon circle fa-github"><span class="label">Github</span></a></li>
			<li><a href="#" class="icon circle fa-dribbble"><span class="label">Dribbble</span></a></li>
		</ul>
        <form method="post">
            <label for="newsletter">Nieuwsbrief:</label>
            <input type="email" name="newsletter" placeholder="Vul hier uw email in" required/>
            <input type="submit" value="Schrijf in" />
        </form>
        <?php
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $email  = $_POST['newsletter'];
                $ip     = $_SERVER['REMOTE_ADDR'];
                
                $query  = $handler->prepare('INSERT INTO newsletter (email, ip) VALUES (:email, :ip)');
                
                try{
                    $query->execute(array(
                        ':email'    => $email,
                        ':ip'       => $ip
                    ));
                }
                catch(PDOException $e){
                    echo'Het email address bestaat al.';
                }
            }
        ?>
	<div id="copyright" class="container">
	 <?php
            $getse  = $handler->query("SELECT * FROM settings");
            $fetch  = $getse->fetch(PDO::FETCH_ASSOC);
            
            echo $fetch['footer'];
    ?>	
	</div>
	</footer>
</body>
</html>
