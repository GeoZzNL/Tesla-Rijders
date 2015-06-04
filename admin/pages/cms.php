<?php
$users = $handler->query('SELECT * FROM users');

$fetch = $users->fetchall(PDO::FETCH_COLUMN, 1);

if(isset($_SESSION['admin']) && in_array($_SESSION['admin'], $fetch)){
    if(isset($_GET['do'])){
    if($_GET['p'] == 'cms' && $_GET['do'] == 'logout'){
        session_destroy();
        header('Location: ' . $website_url . 'admin/index.php');
    }
    }
?>
<div class="font3"><?php echo $version; ?></div>
<div class="boxer">
	<div class="box-row">
		<div class="box_cms">
        <a href="index.php?p=cms">
        <div class="marginpx">
            <img src="img/home.png" width="64" height="64" alt="Home" /><br />
            Home
        </div>
        </a>
        </div>
		<div class="box_cms">
        <a href="index.php?p=cms&do=add">
        <div class="marginpx">
            <img src="img/add.png" width="64" height="64" alt="Add" /><br />
            Pagina toevoegen
        </div>
        </a>
        </div>
		<div class="box_cms">
        <a href="index.php?p=cms&do=edit">
        <div class="marginpx">
            <img src="img/edit.png" width="64" height="64" alt="Edit" /><br />
            Pagina aanpassen
        </div>
        </a>
        </div>
		<div class="box_cms">
        <a href="index.php?p=cms&do=edit&edit=uploadhidden">
        <div class="marginpx">
            <img src="img/upload.png" width="64" height="64" alt="Upload" /><br />
            Foto uploaden
        </div>
        </a>
        </div>
		<div class="box_cms">
        <a href="index.php?p=cms&do=gallery">
        <div class="marginpx">
            <img src="img/gallery.png" width="64" height="64" alt="Gallery" /><br />
            Gallerij
        </div>
        </a>
        </div>        
		<div class="box_cms">
        <a href="index.php?p=cms&do=settings">
        <div class="marginpx">
            <img src="img/settings.png" width="64" height="64" alt="Settings" /><br />
            Instellingen
        </div>
        </a>
        </div>
		<div class="box_cms">
        <a href="index.php?p=cms&do=logout">
        <div class="marginpx">
            <img src="img/logout.png" width="64" height="64" alt="Logout" /><br />
            Uitloggen
        </div>
        </a>
        </div>
	</div>
</div>
<?php
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