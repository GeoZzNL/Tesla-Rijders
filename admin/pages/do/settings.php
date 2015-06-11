<div class="font4">Settings</div>
<?php
    $getse  = $handler->query("SELECT * FROM settings");
    $fetch  = $getse->fetch(PDO::FETCH_ASSOC);
?>
    <div class="boxer" style="width: 50%;">
        <div class="box-row">
            <div class="box_edit">Setting:</div>
            <div class="box_edit_small">Option:</div>
        </div>
        <div class="box-row">
            <div class="box_edit">Site name</div>
            <div class="box_edit_small"><form method="post"><input type="text" name="sname" value="<?php echo $fetch['sname']; ?>" autocomplete="off" /></div>
        </div>
        <div class="box-row">
            <div class="box_edit">Gallery On/Off</div>
            <div class="box_edit_small"><input type="checkbox" name="gallery" value="true" <?php echo($fetch['gallery'] == 'true' ? 'checked="checked"' : ''); ?> /></div>
        </div>
        <div class="box-row">
            <div class="box_edit">Gallery name</div>
            <div class="box_edit_small"><input type="text" name="galleryn" value="<?php echo $fetcht['galleryn']; ?>" autocomplete="off" /></div>
        </div>
        <div class="box-row">
            <div class="box_edit">Contact E-mail</div>
            <div class="box_edit_small"><input type="email" name="email" value="<?php echo $fetcht['email']; ?>" autocomplete="off" /></div>
        </div>
        <div class="box-row">
            <div class="box_edit">Short description of the site</div>
            <div class="box_edit_small"><input type="text" name="description" value="<?php echo $fetcht['description']; ?>" autocomplete="off" /></div>
        </div>
        <div class="box-row">
            <div class="box_edit">Keywords for the site</div>
            <div class="box_edit_small"><input type="text" name="keywords" value="<?php echo $fetcht['keywords']; ?>" autocomplete="off" /></div>
        </div>
        <div class="box-row">
            <div class="box_edit">Save</div>
            <div class="box_edit_small"><input type="submit" value="Save" /></form></div>
        </div>
    </div>
    <?php
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $sname = $_POST['sname'];
            $galleryn = $_POST['galleryn'];
            $email = $_POST['email'];
            $description = ((!empty($_POST['description']))? $_POST['description'] : '');
            $keywords = ((!empty($_POST['keywords']))? $_POST['keywords'] : '');
            
            if(!isset($_POST['advanced'])){
                $advanced = 'false';
            }
            else{
                $advanced = $_POST['advanced'];
            }
            
            if(!isset($_POST['gallery'])){
                $gallery = 'false';
            }
            else{
                $gallery = $_POST['gallery'];
            }
            $id = 1;
            
            $sql = "UPDATE settings SET sname = :sname, gallery = :gallery, galleryn = :galleryn, email = :email, description = :description, keywords = :keywords WHERE id = :sid";
            $query = $handler->prepare($sql);
            
            try{
            $query->execute(array(
                ':sname'        => $sname,
                ':gallery'      => $gallery,
                ':galleryn'     => $galleryn,
                ':email'        => $email,
                ':description'  => $description,
                ':keywords'     => $keywords,
                ':sid'          => $id
            ));
            header('Refresh:0');
            }
            catch(PDOException $e){
                echo'<div class="font4">Something went wrong, please try again.</div>';
                echo $e;
            }
        }
    ?>
<!--
    <div class="boxer" style="width: 50%;">
        <div class="box-row">
            <div class="box_edit"></div>
            <div class="box_edit_small"></div>
        </div>
    </div>
-->