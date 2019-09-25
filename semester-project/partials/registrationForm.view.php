<?php

require 'top.view.php';

foreach($messages as $message) {
    echo $message;
}

?>

<form action="login.php" method="POST">
    Username: <br />
    <input type="text" name="username"><br />
    First Name: <br />
    <input type="text" name="firstname"><br />
    Last Name: <br />
    <input type="text" name="lastname"><br />
    Password: <br />
    <input type="password" name="password"><br />
    <input type="password" name="password2"><br />
    <input type="submit" name="signup" value="Register">
</form>

<?php
require 'bottom.view.php';