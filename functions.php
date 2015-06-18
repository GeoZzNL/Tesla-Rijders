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
    
    //Check strpos array
    function strposa($haystack, $needles=array(), $offset=0) {
            $chr = array();
            foreach($needles as $needle) {
                    $res = strpos($haystack, $needle, $offset);
                    if ($res !== false) $chr[$needle] = $res;
            }
            if(empty($chr)) return false;
            return min($chr);
    }
    
    //Get title
    function title($fetcht, $fetchpn){
        if(isset($_GET['p'])){
            if($_GET['p'] == 'gallery'){
                return $fetcht['sname'] . ' - ' . $fetcht['galleryn'];
            }
            else{
                return $fetcht['sname'] . ' - ' . $fetchpn['pname'];
            }
        }
    }
    
    function sname($fetcht){
            return $fetcht['sname'];
    }
    
    function login($handler){
        $username       = $_POST['username'];
        $password       = $_POST['password'];
        $checkuser      = $handler->query("SELECT * FROM users WHERE username = '$username'");
        $fetch          = $checkuser->fetch(PDO::FETCH_ASSOC);
        $pw             = $fetch['password'];
        
        if(!empty($username) && !empty($password)){
            $uiddisplay = (($checkuser->rowCount()? $uiddisplay = $checkuser->fetch(PDO::FETCH_ASSOC) : NULL)); 
            
            $query  = $handler->prepare("INSERT INTO loginattempts (u_id, ip) VALUES (:uiddisplay, :ip)");
            
            if($fetch['active'] == 1){
                try{
                    $query->execute(array(
                    ':uiddisplay'   => $uiddisplay['id'],
                    ':ip'           => $_SERVER['REMOTE_ADDR']
                    ));
                    
                    if(password_verify($_POST['password'], $pw)){                    
                            $_SESSION['admin'] = $username;
                            
                            header('Location: index.php?p=cms');
                    }
                    else{
                        return'<div class="font4">That password is not correct.</div>';
                    }
                }
                catch(PDOException $e){
                    echo $e->getMessage();
                }
            }
            else{
                echo'<div class="font4">Het account is niet actief.</div>';
            }
        }
        else{
            return'<div class="font4">Please fill in all the fields.</div>';
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
                
                return'<div class="font4">U hebt een account geregistreerd</div>';
                }
                catch(PDOException $e){
                    return'<div class="font4">Something went wrong, please try again.</div>';
                }
            }
            else{
                return'<div class="font4">De wachtwoorden kwamen niet overeen.</div>';
            }
        }
        else{
            return'<div class="font4">U kunt het veld niet leeglaten.</div>';
        }
    }
    
    //Add page
    function add($pname, $titlef, $pcontent, $phidden, $htitle, $handler){
        $puseridadd = $_SESSION['admin'];
        $notallowed = array('<script>', '<plaintext>');
        
        /*$query = $handler->query("SELECT * FROM users WHERE username = '$puseridadd'");
        $fetch = $query->fetch(PDO::FETCH_ASSOC);
        $puseridadd = $fetch['id'];*/
        
        if(strposa($pname, $notallowed)){
            if(empty($pname)){
                return"<div class='font4'>You can't leave a field empty.</div>";
            }
            else{
                $sql = 'INSERT INTO pages (ptitle, pname, pcontent, phidden, htitle, puseridadd, postdate) VALUES (:ptitle, :pname, :pcontent, :phidden, :htitle, :puseridadd, current_timestamp)';
                $query = $handler->prepare($sql);
                
                try{
                    $query->execute(array(
                    ':ptitle'       => $titlef,
                    ':pname'        => $pname,
                    ':pcontent'     => $pcontent,
                    ':phidden'      => $phidden,
                    ':htitle'       => $htitle,
                    ':puseridadd'   => $puseridadd
                    ));
                    return'<div class="font4">The page has been submitted.</div>';
                }
                catch(PDOException $e){
                    return'<div class="font4">Something went wrong, please try again.</div>';
                }
            }
        }
        else{
            return'<div class="font4">Je kan geen plaintext of script gebruiken.</div>';
        }
    }
    //Edit page
    function edit($handler, $id, $titlef, $pname, $phidden, $pcontent, $htitle){
        $puseridedit  = $_SESSION['admin'];
        $notallowed = array('<script>', '<plaintext>');
        
        /*$query = $handler->query("SELECT * FROM users WHERE username = '$puseridedit'");
        $fetch = $query->fetch(PDO::FETCH_ASSOC);
        $puseridedit = $fetch['id'];*/
                
        if(strip_tags($pname)){
            if(empty($pname)){
                return"<div class='font4'>You can't leave a field empty.</div>";
            }
            else{
                $sql = "UPDATE pages SET ptitle = :ptitle, pname = :pname, pcontent = :pcontent, phidden = :phidden, htitle = :htitle, puseridedit = :puseridedit, editdate = current_timestamp WHERE id = '$id'";
                
                $query = $handler->prepare($sql);
                
                try{
                    $query->execute(array(
                    ':ptitle'   	=> $titlef,
                    ':pname'    	=> $pname,
                    ':pcontent' 	=> $pcontent,
                    ':phidden'  	=> $phidden,
    				':htitle'		=> $htitle,
                    ':puseridedit'  => $puseridedit
                    ));
                    
                    header('Location: index.php?p=cms&do=edit&edit=' . $titlef);
                    
                    return'<div class="font4">The page has been submitted.</div>';
                }
                catch(PDOException $e){
                    return'<div class="font4">Something went wrong, please try again.</div>';
                }
            }
        }
        else{
            return'<div class="font4">Je kan geen plaintext of script gebruiken.</div>';
        }
    }
    //Edit image
    function editimage(){
        
    }
    //Upload image
    function upload($galleryn, $gallerydesc, $handler){
        $target_dir = '../pages/img/';
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
        $target_dir = '../pages/hiddenimg/';
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
                        <div class="font4">' . $fetchpn['pname'] . '</div>' .
                        
                        $fetchpn['pcontent'];
                    }
                    else{
                        include'pages/404.php';
                    }
                }
            }
            else{
                echo'
                <div class="font4">' . $fetchpn['pname'] . '</div>' .
                
                $fetchpn['pcontent'];
            }
        }
        elseif($getp->rowcount() == 0){
            echo'
            <div class="font4">Error</div>
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
                elseif($_GET['p'] == 'gallery'){
                    
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
            <div class="font4">Error</div>
            There are no pages in the database.';
        }
    }
    
    //Random string
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    //mail
    function newmail(){
        $to      = 'nobody@example.com';
        $subject = 'Activatie e-mail';
        $message = nl2br("Klik aub op deze link om uw account te activeren:
        ");
        $headers = 'From: webmaster@example.com';
        
        mail($to, $subject, $message, $headers);
    }  
	
?>