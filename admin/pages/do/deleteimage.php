<?php
    if(isset($_GET['del'])){
        $id = makeFriendlyFix($_GET['del']);
        $imagequeryfixed = $handler->query("SELECT * FROM images WHERE id = '$id'");
        $fetchimage = $imagequeryfixed->fetch(PDO::FETCH_ASSOC);
        $delimage = "DELETE FROM images WHERE id = :id";
        
        $imagedo = $handler->prepare($delimage);
        
        try{
            unlink('../pages/img/' . $fetchimage['imagen']);
                        
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
    <div class="boxer" style="width: 50%;">
        <div class="box-row">
            <div class="box_edit">Thumbnail</div>
            <!--<div class="box_edit">Edit description</div>-->
            <div class="box_edit">Delete</div>
    </div>
<?php
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
                <div class='box_edit'><img src='../pages/img/" . $fetchimage['imagen'] . "' style='width: 50%; height: 10%;' /></div>
                <div class='box_edit'><a href='index.php?p=cms&do=edit&edit=deleteimage&del=" . $fetchimage['id'] . "'>Delete</a></div>
            </div>
        ";
        
        $i++;
    }
?>
    </div>
<?php
    }
?>