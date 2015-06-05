<?php
$users = $handler->query('SELECT * FROM users');

$fetch = $users->fetchall(PDO::FETCH_COLUMN, 1);

if(!isset($_SESSION['admin']) || !in_array($_SESSION['admin'], $fetch)){
?>
<div class="boxer">
    <form method="post">
        <div class="box-row"><div class="box-cell" style="vertical-align: middle;"><label for="username">Username:</label></div>
        <div class="box-cell"><input type="text" name="username" required /></div></div>
        <div class="box-row"><div class="box-cell" style="vertical-align: middle;"><label for="password">Password:</label></div>
        <div class="box-cell"><input type="password" name="password" required /></div></div>
        <div class="box-row" style="clear: both; float: right;"><div class="box-cell"><input type="submit" name="login" value="Login" /></div></div>
    </form>
    <a href="index.php?p=forgottenpassword">Wachtwoord vergeten?</a>
</div>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['login'])){        
            echo login($handler);
        }
    }
}
else{
    include'cms.php';
}
?>
<?php
if($users->rowCount() < 1){
    if(!isset($_SESSION['admin'])){
?>
    <hr />
    <div class="boxer">
        <form method="post">
            <div class="box-row"><div class="box-cell" style="vertical-align: middle;"><label for="username">Username:</label></div>
            <div class="box-cell"><input type="text" name="username" required /></div></div>
            <div class="box-row"><div class="box-cell" style="vertical-align: middle;"><label for="email">Email:</label></div>
            <div class="box-cell"><input type="email" name="email" required /></div></div>
            <div class="box-row"><div class="box-cell" style="vertical-align: middle;"><label for="password">Password:</label></div>
            <div class="box-cell"><input type="password" name="password" required /></div></div>
            <div class="box-row"><div class="box-cell" style="vertical-align: middle;"><label for="passwordconf">Password confirmation:</label></div>
            <div class="box-cell"><input type="password" name="passwordconf" required /></div></div>
            <div class="box-row" style="clear: both; float: right;"><div class="box-cell"><input type="submit" name="register" value="Register" /></div></div>
        </form>
    </div>
<?php
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['register'])){
                echo register($handler);
            }
        }
    }
}
?>