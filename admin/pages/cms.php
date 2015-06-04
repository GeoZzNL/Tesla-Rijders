<?php
if(isset($_SESSION['admin']) && in_array($_SESSION['admin'], $fetch)){
    if(isset($_GET['do'])){
    if($_GET['p'] == 'cms' && $_GET['do'] == 'logout'){
        session_destroy();
        header('Location: index.php');
    }
    }
    if(empty($_GET['do'])){
?>
<p>Welkom <?php echo $_SESSION['admin']; ?> bij het content management system voor de website.<br /><br />
Voor een FAQ kunt u <a href="index.php?p=cms&do=faq">hier</a> terecht.</p>
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