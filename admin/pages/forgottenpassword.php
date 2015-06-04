<div class="font3">Wachtwoord vergeten</div>
<div class="boxer">
    <form method="post">
        <div class="box-row"><div class="box-cell" style="vertical-align: middle;"><label for="email">E-mail address</label></div>
        <div class="box-cell"><input type="email" name="email" /></div></div>
        <div class="box-row" style="clear: both; float: right;"><div class="box-cell"><input type="submit" value="Verstuur" /></div></div>
</div>
    </form>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $email  = $_POST['email'];
        $query  = $handler->query("SELECT * FROM users WHERE email = '$email'");
        
        if(!empty($email)){
            if($query->rowCount()){
                $newpassword = generateRandomString();
                $options = [
                    'cost' => 11,
                    'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
                ];
                $securepw   = password_hash($newpassword, PASSWORD_BCRYPT, $options);
                
                $query = $handler->prepare("UPDATE users SET password = :securepw WHERE email = '$email'");
                
                try{
                    $query->execute(array(
                        ':securepw' => $securepw
                    ));
                }
                catch(PDOException $e){
                    die('Er ging iets fout, probeer het opnieuw.');
                }            
                
                $to      = $email;
                $subject = 'Wachtwoord vergeten';
                $message = nl2br("Hallo,
                U geeft aan dat u uw wachtwoord vergeten bent, als dit het geval is klik hier:
                $newpassword");
                $headers = 'From: webmaster@example.com';
                
                mail($to, $subject, $message, $headers);
                
                header('Location: index.php');
            }
            else{
                echo'Er is geen account met dat e-mail address.';
            }
        }
        else{
            echo'Je kan geen velden leeg laten.';
        }
    }
?>