<h3>Change password</h3>
<?php

require_once("login.class.php");
require_once("signup.class.php");

$login = new Login();
$signup = new Signup();

if (isset($_POST["updateReq"])) {
    $signup->updatePass($_GET["user"], $_POST["newPass"]);
}

$canUpdate = false;

if (isset($_POST["checkOld"])) {
    $canUpdate = $login->access($_GET["user"], $_POST["oldPass"]);
    if(!$canUpdate){ echo "incorrect password"; }
}

?>
<?php if ($canUpdate) : ?> 
    <h4>&#10004;</h4>
    <form action="" method="post">
        New password<input type="text" name="newPass" required><br>
        <button type="submit" name="updateReq">Update</button>
    </form>
<?php else : ?>
    <form action="" method="post">
        Old password<input type="text" name="oldPass"><br>
        <button type="submit" name="checkOld">Check</button>
    </form>
<?php endif; ?>

