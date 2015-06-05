<?php
    $username = $_GET['delete'];

    if(isset($_GET['delete'])){
        $query  = $handler->query("SELECT * FROM users WHERE username = '$username'");
        
        if($query->rowCount()){
            $query  = $handler->query("DELETE FROM users WHERE username = '$username'");
        }
        else{
            echo'bla';
        }
    }
?>