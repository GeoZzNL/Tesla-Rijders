<div class="font3"><?php echo $fetcht['galleryn']; ?></div>
    <div class="gallery" align="center">
<?php
    global $imagequery;
    
    $firstimg = $handler->query('SELECT * FROM images LIMIT 1');
    $firstfetch = $firstimg->fetch(PDO::FETCH_ASSOC);
    
    if($imagequery->rowCount()){
        $i = 0;
        
            echo"<div class='thumbnails'>";
        while($fetchimage = $imagequery->fetch(PDO::FETCH_ASSOC)){
            echo"
                <img src='pages/img/" . $fetchimage['imagen'] . "' onmouseover='preview.src=i" . $i . ".src' id='i" . $i . "' name='i" . $i . "' />
            ";
            
            $i++;
        }
            echo"</div>";
        echo"
    	 <div class='preview' align='center'>
    		 <img name='preview' src='pages/img/" . $firstfetch['imagen'] . "' alt=''/>
    	 </div>
      </div>";
    }
    else{
        echo'Er zijn nog geen afbeeldingen in de galerij';
    }
?>