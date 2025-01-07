<?php
require_once("login.class.php");

if(isset($_POST["logReq"])) {
    $login = new Login();
    $login->login($_POST["user"], $_POST["pass"]);
};

?>

<form action="" method="post">
    Username<input type="text" name="user" required><br>
    Password<input type="text" name="pass" required><br>
    <button type="submit" name="logReq">Login</button>
</form>
