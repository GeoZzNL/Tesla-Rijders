<div class="font3">Wijzig uw account</div>
<table>
<form method="post">
    <tr>
        <td><label for="currentpassword">Huidige wachtwoord:</label></td>
        <td><input type="password" name="currentpw" required /></td>
    </tr>
    <tr>
        <td><label for="newpw">Nieuw wachtwoord:</label></td>
        <td><input type="password" name="newpw" required /></td>
    </tr>
    <tr>
        <td><label for="newpwrepeat">Nieuw wachtwoord herhalen:</label></td>
        <td><input type="password" name="newpwrepeat" required /></td>
    </tr>
    <tr>
        <td><label for="newpwrepeat">Verstuur</label></td>
        <td><input type="submit" value="Verstuur" /></td>
    </tr>
</form>
</table>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $currentpw      = $_POST['currentpw'];
        $newpw          = $_POST['newpw'];
        $newpwrepeat    = $_POST['newpwrepeat'];
        $username       = $_SESSION['admin'];
        $checkuser      = $handler->query("SELECT * FROM users WHERE username = '$username'");
        $fetchpw        = $checkuser->fetch(PDO::FETCH_ASSOC);
        $pw             = $fetchpw['password'];
        
        if($newpw == $newpwrepeat){
            if(password_verify($currentpw, $pw)){
                $options = [
                    'cost' => 11,
                    'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
                ];
                $password   = password_hash($newpw, PASSWORD_BCRYPT, $options);
                
                $query = $handler->prepare('UPDATE users SET password = :password');
                
                try{
                    $query->execute(array(
                        ':password' => $password
                    ));
                    
                    echo'Het wachtwoord is veranderd.';
                }
                catch(PDOException $e){
                    echo'Er ging iets fout, probeer het opnieuw.';
                }
            }
            else{
                echo'Het oude wacthwoord klopte niet.';
            }
        }
        else{
            echo'De wachtwoorden waren niet hetzelfde.';
        }
    }
?>