<?php
require 'top.view.php';

foreach($messages as $message) {
    echo $message;
}

?>

<form action="login.php" method="POST">
    Username: <br />
    <input type="text" name="username"><br />
    Password: <br />
    <input type="password" name="password"><br />
    <input type="submit" name="login" value="Login">
    <input type="submit" name="register" value="Register New User">
</form>

<?php
require 'bottom.view.php';

