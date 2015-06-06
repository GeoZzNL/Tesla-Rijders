<div class="font3">Voeg een beheerder toe</div>
<table>
    <form method="post">
        <tr>
            <td><label for="username">Gebruikersnaam:</label></td>
            <td><input type="text" name="username" required /></td>
        </tr>
        <tr>
            <td><label for="email">E-mail address:</label></td>
            <td><input type="email" name="email" required /></td>
        </tr>
        <tr>
            <td><label for="password">Password:</label></td>
            <td><input type="password" name="password" required /></td>
        </tr>
        <tr>
            <td><label for="passwordconf">Wachtwoord herhalen:</label></td>
            <td><input type="password" name="passwordconf" required /></td>
        </tr>
        <tr>
            <td><label>Verstuur</label></td>
            <td><input type="submit" value="Verstuur" /></td>
        </tr>
    </form>
</table>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        echo register($handler);
    }
?>