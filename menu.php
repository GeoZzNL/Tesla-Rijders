<div class="font3">Menu</div>
<div class="menu_div">
<ul>
	<?php
        $getp   = $handler->query("SELECT * FROM pages WHERE phidden = ''");
        
        while($fetchp = $getp->fetch()){
            echo"<li><a href='index.php?p=" . $fetchp['ptitle'] . "'>" . $fetchp['pname'] . "</a></li>";
        }
        if($fetcht['gallery'] == 'true'){
            echo"<li><a href='index.php?p=gallery'>" . $fetcht['galleryn'] . "</a></li>";
        }
    ?>
</ul>
</div>