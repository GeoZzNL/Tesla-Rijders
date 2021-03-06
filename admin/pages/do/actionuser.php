<?php
    if(isset($_GET['delete'])){
        $username = $_GET['delete'];
        $query  = $handler->query("SELECT * FROM users WHERE username = '$username'");
        $fetch  = $query->fetch(PDO::FETCH_ASSOC);
        $username = $fetch['username'];
        
        if($query->rowCount()){
            $query  = $handler->prepare("UPDATE users SET active = :active WHERE username = '$username'");
            
            try{
                $query->execute(array(
                    ':active'   => '0'
                ));
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
            
            echo'Het account is succevol verwijderd.<br />
                Naam van het account: ' . $username . '<br /><br />
                <a href="index.php?p=cms&do=userlist">Klik hier om terug te gaan</a>';
            
        }
        else{
            echo'Het account dat je probeert te verwijderen bestaat niet.';
        }
    }
    elseif(isset($_GET['activate'])){
        $username = $_GET['activate'];
        $query  = $handler->query("SELECT * FROM users WHERE username = '$username'");
        $fetch  = $query->fetch(PDO::FETCH_ASSOC);
        $username = $fetch['username'];
        
        if($query->rowCount()){
            $query  = $handler->prepare("UPDATE users SET active = :active WHERE username = '$username'");
            
            try{
                $query->execute(array(
                    ':active'   => '1'
                ));
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
            
            echo'Het account is succesvol geactiveerd.<br />
                Naam van het account: ' . $username . '<br /><br />
                <a href="index.php?p=cms&do=userlist">Klik hier om terug te gaan</a>';
            
        }
        else{
            echo'Het account dat je probeert te activeren bestaat niet.';
        }
    }
?>