<?php
    $query = $handler->query('SELECT * FROM newsletter');
?>
<div class="font3">Verstuur een nieuwsbrief</div>
<?php
    if(isset($_GET['allusers'])){
        /**
         * ALL USERS
         **/
        if($_GET['allusers'] == 'true'){
?>
<form method="post">
    <label for="pname" class="font4">Onderwerp:</label><br />
    <input type="text" name="pname" autocomplete="off" /><br /><hr />
    <label for="newsletter" class="font4">Nieuwsbrief content:</label><br />
    <textarea name="newsletter" id="newsletter"></textarea>
    <input type="submit" value="Submit" />
    <script>
        CKEDITOR.replace('newsletter', {enterMode : CKEDITOR.ENTER_BR, extraAllowedContent: 'section article header nav aside[lang,foo]'});
    </script>
</form>
<?php
            if($_SERVER['REQUEST_METHOD'] == 'POST'){                
                if(!empty($_POST['newsletter'])){
                    $newsletter = $_POST['newsletter'];
                    
                    while($fetch = $query->fetch(PDO::FETCH_ASSOC)){
                        $subject = 'Activatie e-mail';
                        $message = nl2br($newsletter);
                        $headers = 'From: webmaster@example.com';
                    
                        mail($fetch['email'], $subject, $message, $headers);
                    }
                    echo'<div class="font3">De niewsbrief is verstuurd.</div>';
                }
                else{
                    echo'<div class="font3">U kunt het veld niet leeglaten.</div>';
                }
            }
            
        /**
         * SELECT USERS
         * */
        }
        elseif($_GET['allusers'] == 'false'){
?>
<form method="post">
    <label for="pname" class="font4">Onderwerp:</label><br />
    <input type="text" name="pname" autocomplete="off" /><br /><hr />
    <div class="userbox">
    <?php
        $i = 0;
            echo'<table class="newsletterlist">';    
        while($fetch = $query->fetch(PDO::FETCH_ASSOC)){
            if($i == 0){
                echo'<tr>';
            }
            echo'<td><input type="checkbox" name="email[]" value="' . $fetch['email'] . '"></td><td>';
            echo $fetch['email'] . '</td>';
            
            if($i == 5){
                echo'</tr>';
                
                $i = 0;
            }
            $i++;
        }
            echo'</table>';
    ?>
    </div><hr />
    <label for="newsletter" class="font4">Nieuwsbrief content:</label><br />
    <textarea name="newsletter" id="newsletter"></textarea>
    <input type="submit" value="Submit" />
    <script>
        CKEDITOR.replace('newsletter', {enterMode : CKEDITOR.ENTER_BR, extraAllowedContent: 'section article header nav aside[lang,foo]'});
    </script>
</form>
<?php
            if($_SERVER['REQUEST_METHOD'] == 'POST'){                
                if(!empty($_POST['newsletter'])){
                    $newsletter = $_POST['newsletter'];
                    
                    foreach($_POST['email'] as $to){
                        $subject = 'Activatie e-mail';
                        $message = nl2br($newsletter);
                        $headers = 'From: webmaster@example.com';
                    
                        mail($to, $subject, $message, $headers);
                    }
                    echo'<div class="font3">De niewsbrief is verstuurd.</div>';
                }
                else{
                    echo'<div class="font3">U kunt het veld niet leeglaten.</div>';
                }
            }
        }
        else{
            header('Location: index.php?p=cms&do=newsletter');
        }
    }
    else{
        header('Location: index.php?p=cms&do=newsletter');
    }
?>