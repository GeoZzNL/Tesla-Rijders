<?php
if(isset($_SESSION['admin']) && in_array($_SESSION['admin'], $fetch)){
    if(isset($_GET['do'])){
    if($_GET['p'] == 'cms' && $_GET['do'] == 'logout'){
        session_destroy();
        header('Location: ' . $website_url . 'admin/index.php');
    }
    }
    if(empty($_GET['do'])){
?>
<p>U bent ingelogd als Tesla Rijders Admin, u kunt de website beheren met de bovenstaande knoppen.</p>
<?php
    }
?>
<div class="mtop">
<?php
if(isset($_GET['do'])){
            if(file_exists('pages/do/'. $_GET['do'] .'.php')){
                include('pages/do/'. $_GET['do'] .'.php');
            }
        }
?>
</div>
<?php        
}
else{
    include'login.php';
}
?>