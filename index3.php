<?php
    include'config.php';
    
    $query = $handler->query('SELECT * FROM team');
    
    $i = 0;
    
        echo'<table>';
    while($fetch = $query->fetch(PDO::FETCH_ASSOC)){
        if($i == 0){
            $color = 'gray';
        }
        else{
            $color = 'lightgray';
        }
        echo'
        <tr style="background: ' . $color . ';">
        	<td>' . $fetch['vnaam'] . '</td>
        	<td>' . $fetch['anaam'] . '</td>
        	<td>' . $fetch['club'] . '</td>
        </tr>';
        
        $i++;
        if($i == 2){
            $i = 0;
        }
    }
?>
        </table>