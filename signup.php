<?php
    require_once("signup.class.php");
?>

<form action="" method="post">
    Username<input type="text" name="newUser" required><br>
    Password<input type="text" name="newPass" required><br>
    <button type="submit" name="signup">Sign up</button>
</form>

<?php

if(isset($_POST["signup"])) {
    $signup = new Signup();
    $signup->signup($_POST["newUser"], $_POST["newPass"]);
};

?>