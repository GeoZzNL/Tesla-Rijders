<?php
    $query  = $handler->query('SELECT * FROM users');
?>
<div class="font3">Gebruikerslijst</div>
<table class="list">
<tr>
    <td>Id</td>
	<td>Gebruikersnaam</td>
	<td>E-mail</td>
	<td>Delete</td>
</tr>
<?php
    while($fetch = $query->fetch(PDO::FETCH_ASSOC)){
        echo"<tr>
                <td>" . $fetch['id'] . "</td>
            	<td>" . $fetch['username'] . "</td>
            	<td>" . $fetch['email'] . "</td>
            	<td><a href='index.php?p=cms&do=deleteuser&delete=" . $fetch['username'] . "'>Delete " . $fetch['username'] . "</a></td>
            </tr>";
    }
?>
</table>