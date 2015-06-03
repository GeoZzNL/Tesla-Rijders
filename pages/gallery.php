<div class="font3"><?php echo $fetcht['galleryn']; ?></div>
            <div class="boxer">
                <div class="box-row">
<?php
    global $imagequery;
    while($fetchimage = $imagequery->fetch(PDO::FETCH_ASSOC)){
        echo"
                    <div class='box_gallery'><img src='pages/img/" . $fetchimage['imagen'] . "' class='fancybox' style='width: 128px; max-height: 100%;' title='" . $fetchimage['imagedesc'] . "' alt='" . $fetchimage['imagedesc'] . "'/></div>
        ";
    }
?>
                </div>
            </div>