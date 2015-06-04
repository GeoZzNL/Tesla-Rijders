<?php
    if(isset($_GET['del'])){
        $id = makeFriendlyFix($_GET['del']);
        $imagequeryfixed = $handler->query("SELECT * FROM hiddenimages WHERE id = '$id'");
        $fetchimage = $imagequeryfixed->fetch(PDO::FETCH_ASSOC);
        $delimage = "DELETE FROM hiddenimages WHERE id = :id";
        
        $imagedo = $handler->prepare($delimage);
        
        try{
            unlink('../pages/hiddenimg/' . $fetchimage['imagen']);
            
            $imagedo->execute(array(
                ':id' => $id
            ));
            
            header("refresh:1;url=index.php?p=cms&do=edit&edit=deleteimage");
        }
        catch(PDOException $e){
            echo'<div class="font4">Something went wrong, please try again.</div>';
        }
    }
    else{
?>
<div class="font3">Hidden gallery</div>
    <div class="boxer" style="width: 50%;">
        <div class="box-row">
            <div class="box_edit">Thumbnail</div>
            <div class="box_edit">url</div>
            <div class="box_edit">Delete</div>
    </div>
<?php
    $imagequery     = $handler->query("SELECT * FROM hiddenimages");
    
    $i = 0;

    while($fetchimage = $imagequery->fetch(PDO::FETCH_ASSOC)){
        if($i % 2 == 0){
            $color = '#f3f3f3';
        }
        else{
            $color = '#ffffff';
        }
        
        echo"
            <div class='box-row' style='background: $color'>
                <div class='box_edit'><div class='marginpx'><img src='../pages/hiddenimg/" . $fetchimage['imagen'] . "' style='width: 128px; height: 100px;' title='" . $fetchimage['imagedesc'] . "' alt='" . $fetchimage['imagedesc'] . "'/></div></div>
                <div class='box_edit'><input type='text' value='" . $website_url . "pages/hiddenimg/" . $fetchimage['imagen'] . "' onFocus='this.select()' /></div>
                <div class='box_edit'><a href='index.php?p=cms&do=gallery&del=" . $fetchimage['id'] . "'>Delete</a></div>
            </div>
        ";
        
        $i++;
    }
?>
    </div>
<?php
    }
?>