<?php
    $username = $_GET['delete'];

    if(isset($_GET['delete'])){
        $query  = $handler->query("SELECT * FROM users WHERE username = '$username'");
        $fetch  = $query->fetch(PDO::FETCH_ASSOC);
        $username = $fetch['username'];
        
        echo $username;
        
        if($query->rowCount()){
            $query  = $handler->query("DELETE FROM users WHERE username = '$username'");
            
            echo'Het account is succevol verwijderd.<br />
                Naam van het account: ' . $username . '<br /><br />
                <a href="index.php?p=cms&do=userlist">Klik hier om terug te gaan</a>';
            
        }
        else{
            echo'Het account dat je probeert te verwijderen bestaat niet.';
        }
    }
?>