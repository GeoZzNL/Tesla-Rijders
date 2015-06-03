<?php
    //Make URL friendly
    function makeFriendly($string){
        $string = strtolower(trim($string));
        $string = str_replace("'", '', $string);
        $string = preg_replace('#[ ]+#', '_', $string);
        $string = preg_replace('#[^0-9a-z\-]+#', '_', $string);
        $string = preg_replace('#_{2,}#', '_', $string);
        $string = preg_replace('#_-_#', '-', $string);
        return preg_replace('#(^_+|_+$)#D', '', $string);
    }
    
    //Get title
    function title($fetcht, $fetchpn){
        if(isset($_GET['p'])){
            if($_GET['p'] == 'cms' || $_GET['p'] == 'login'){
                return 'Cms';
            }
            elseif($_GET['p'] == 'gallery'){
                return $fetcht['sname'] . ' - ' . $fetcht['galleryn'];
            }
            else{
                return $fetcht['sname'] . ' - ' . $fetchpn['pname'];
            }
        }
        else{
            return $fetcht['sname'] . ' - ' . $fetchpn['pname'];
        }
    }
    
    function sname($fetcht){
            return $fetcht['sname'];
    }
    
    function login($handler){
        $username       = $_POST['username'];
        $password       = $_POST['password'];
        $checkuser      = $handler->query("SELECT * FROM users WHERE username = '$username'");
        $fetchpw        = $checkuser->fetch(PDO::FETCH_ASSOC);
        $pw             = $fetchpw['password'];
        
        if(!empty($username) && !empty($password)){
            if(password_verify($_POST['password'], $pw)){
                $_SESSION['admin'] = $username;
                
                header('Location: index.php?p=cms');
            }
            else{
                return'That password is not correct.';
            }
        }
        else{
            return'Please fill in all the fields.';
        }
    }
        
    //Register
    function register($handler){
        $username       = $_POST['username'];
        $email          = $_POST['email'];
        $password       = $_POST['password'];
        $passwordconf   = $_POST['passwordconf'];
        
        if(!empty($username) && !empty($email) && !empty($password) && !empty($passwordconf)){
            if($password == $passwordconf){
                $options = [
                    'cost' => 11,
                    'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
                ];
                $password   = password_hash($password, PASSWORD_BCRYPT, $options);
                
                $sql = 'INSERT INTO users (username, password, email) VALUES (:username, :password, :email)';
                $query = $handler->prepare($sql);
                
                try{
                $query->execute(array(
                    ':username' => $username,
                    ':password' => $password,
                    ':email'    => $email
                ));
                
                return'You have registered an account.';
                }
                catch(PDOException $e){
                    return'Something went wrong, please try again.';
                }
            }
            else{
                return'The passwords did not match.';
            }
        }
        else{
            return'Please fill in all the fields.';
        }
    }
    
    //Add page
    function add($pname, $titlef, $pcontent, $phidden, $handler){
        if(empty($pname)){
            return"<div class='font4'>You can't leave a field empty.</div>";
        }
        else{
            $sql = 'ALTER TABLE pages AUTO_INCREMENT = 1';
            $handler->query($sql);
            $sql = 'INSERT INTO pages (ptitle, pname, pcontent, phidden) VALUES (:ptitle, :pname, :pcontent, :phidden)';
            $query = $handler->prepare($sql);
            
            try{
                $query->execute(array(
                ':ptitle'   => $titlef,
                ':pname'    => $pname,
                ':pcontent' => $pcontent,
                ':phidden'  => $phidden
                ));
                return'<div class="font4">The page has been submitted.</div>';
            }
            catch(PDOException $e){
                return'<div class="font4">Something went wrong, please try again.</div>';
            }
        }
    }
    //Edit page
    function edit($handler, $id, $titlef, $pname, $phidden, $pcontent, $htitle){
        if(empty($pname)){
            return"<div class='font4'>You can't leave a field empty.</div>";
        }
        else{
            
            $sql = "UPDATE pages SET ptitle = :ptitle, pname = :pname, pcontent = :pcontent, phidden = :phidden, htitle = :htitle WHERE id = '$id'";
            
            $query = $handler->prepare($sql);
            
            try{
                $query->execute(array(
                ':ptitle'   	=> 	$titlef,
                ':pname'    	=> 	$pname,
                ':pcontent' 	=> 	$pcontent,
                ':phidden'  	=> 	$phidden,
				':htitle'		=> 	$htitle,
                ));
                
                return'<div class="font4">The page has been submitted.</div>';
                
                header('Location: index.php?p=cms&do=edit&edit=' . $titlef);
            }
            catch(PDOException $e){
                return'<div class="font4">Something went wrong, please try again.</div>';
            }
        }
    }
    //Edit image
    function editimage(){
        
    }
    //Upload image
    function upload($galleryn, $gallerydesc, $handler){
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/pages/img/';
        $target_file = $target_dir . basename($_FILES['fileToUpload']['name']);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        // Check if image file is a actual image or fake image
        if(isset($_POST['submit'])) {
            $check = getimagesize($_FILES['fileToUpload']['tmp_name']);
            if($check !== false) {
                echo '<div class="font4">File is an image - ' . $check['mime'] . '.</div>';
                $uploadOk = 1;
            } else {
                echo '<div class="font4">File is not an image.</div>';
                $uploadOk = 0;
            }
        }
        // Check if file already exists
        if (file_exists($target_file)){
            echo '<div class="font4">Sorry, file already exists.</div>';
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES['fileToUpload']['size'] > 50000000){
            echo '<div class="font4">Sorry, your file is too large.</div>';
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg'
        && $imageFileType != 'gif' ) {
            echo '<div class="font4">Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div>';
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0){
            echo '<br /><div class="font4">Sorry, your file was not uploaded.</div>';
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file)){
                $sqlimage = 'INSERT INTO images (imagen, imagedesc) VALUES (:imagen, :imagedesc)';
                $queryimage = $handler->prepare($sqlimage);
                
                try{
                    $queryimage->execute(array(
                    ':imagen' => $galleryn,
                    ':imagedesc' => $gallerydesc
                    ));
                }
                catch(PDOException $e){
                    return"<div class='font4'>Something went wrong, please try again.</div>";
                }
                
                echo '<div class="font4">The file '. basename( $_FILES['fileToUpload']['name']). ' has been uploaded.</div>';
                
            } else {
                echo '<div class="font4">Sorry, there was an error uploading your file.</div>';
            }
        }
    }
    
    //Upload hidden image
    function uploadhidden($galleryn, $gallerydesc, $handler){
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/pages/hiddenimg/';
        $target_file = $target_dir . basename($_FILES['fileToUpload']['name']);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        // Check if image file is a actual image or fake image
        if(isset($_POST['submit'])) {
            $check = getimagesize($_FILES['fileToUpload']['tmp_name']);
            if($check !== false) {
                echo '<div class="font4">File is an image - ' . $check['mime'] . '.</div>';
                $uploadOk = 1;
            } else {
                echo '<div class="font4">File is not an image.</div>';
                $uploadOk = 0;
            }
        }
        // Check if file already exists
        if (file_exists($target_file)){
            echo '<div class="font4">Sorry, file already exists.</div>';
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES['fileToUpload']['size'] > 50000000){
            echo '<div class="font4">Sorry, your file is too large.</div>';
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg'
        && $imageFileType != 'gif' ) {
            echo '<div class="font4">Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div>';
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0){
            echo '<br /><div class="font4">Sorry, your file was not uploaded.</div>';
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file)){
                $sqlimage = 'INSERT INTO hiddenimages (imagen, imagedesc) VALUES (:imagen, :imagedesc)';
                $queryimage = $handler->prepare($sqlimage);
                
                try{
                    $queryimage->execute(array(
                    ':imagen' => $galleryn,
                    ':imagedesc' => $gallerydesc
                    ));
                }
                catch(PDOException $e){
                    return"<div class='font4'>Something went wrong, please try again.</div>";
                }
                
                echo '<div class="font4">The file '. basename( $_FILES['fileToUpload']['name']). ' has been uploaded.</div>';
                
            } else {
                echo '<div class="font4">Sorry, there was an error uploading your file.</div>';
            }
        }
    }
    
    //Get menu
    function menu($handler, $getp, $fetcht){
        if($getp->rowcount() > 0 || $fetcht['gallery'] == 'true'){
            echo'
                
                <div class="menu_div">
                <ul>';
                $getp   = $handler->query("SELECT * FROM pages WHERE phidden = ''");
                
                while($fetchp = $getp->fetch()){
                    echo"<li><a href='index.php?p=" . $fetchp['ptitle'] . "'>" . $fetchp['pname'] . "</a></li>";
                }
                if($fetcht['gallery'] == 'true'){
                    echo"<li><a href='index.php?p=gallery'>" . $fetcht['galleryn'] . "</a></li>";
                }
            echo'</ul></div>';
        }
    }
    
    //Get page
    function page($handler, $getp, $page, $fetcht, $fetchpn){
        if($getp->rowcount() > 0){
            if(!empty($page)){
                if($page == 'gallery'){
                    if($fetcht['gallery'] == 'true'){
                        include'pages/gallery.php';
                    }
                    else{
                        echo"<div class='font4'>The gallery is turned off at the moment.</div>";
                    }
                }
                else{
                    $p          = (isset($page) ? $page : NULL);
                    $getpn      = $handler->query("SELECT * FROM pages WHERE ptitle = '$page'");
                    $fetchpn    = $getpn->fetch(PDO::FETCH_ASSOC);
                    
                    if($fetchpn['pname'] != NULL){
                        echo'
                        <div class="font3"></div>' .
                        
                        $fetchpn['pcontent'];
                    }
                    else{
                        include'pages/404.php';
                    }
                }
            }
            else{
                echo'
                <div class="font3">' . $fetchpn['pname'] . '</div>' .
                
                $fetchpn['pcontent'];
            }
        }
        elseif($getp->rowcount() == 0){
            echo'
            <div class="font3">Error</div>
            There are no pages in the database.';
        }
    }
    
    //Submit footer
    function footer($handler, $footer){
            $id = 1;
        
            $sql = "UPDATE settings SET footer = :footer WHERE id = :sid";
            
            $query = $handler->prepare($sql);
            
            try{
                $query->execute(array(
                    ':footer'   => $footer,
                    ':sid'      => $id
                ));
                
                return'<div class="font4">The page has been submitted.</div>';
                
                header('Location: index.php?p=cms&do=edit&edit=footer');
            }
            catch(PDOException $e){
                return'<div class="font4">Something went wrong, please try again.</div>';
            }
    }
	
	function htitle($handler, $getp, $page, $fetcht, $fetchpn){
        if($getp->rowcount() > 0){
            if(!empty($page)){
				$p          = (isset($page) ? $page : NULL);
				$getpn      = $handler->query("SELECT * FROM pages WHERE ptitle = '$page'");
				$fetchpn    = $getpn->fetch(PDO::FETCH_ASSOC);
				
				if($fetchpn['pname'] != NULL){
					echo $fetchpn['htitle'];
				}
				else{
					echo'<h3>404 Error</h3>';
				}
            }
            else{
                echo $fetchpn['htitle'];
            }
        }
        elseif($getp->rowcount() == 0){
            echo'
            <div class="font3">Error</div>
            There are no pages in the database.';
        }
    }
    
	
?>