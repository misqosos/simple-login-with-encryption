<?php 
require_once("login.class.php");

$login = new Login();
$access = false;
if (isset($_GET["user"])) {
    $access = $login->cookiePass($_GET["user"]);
}

?>
<?php if($access) : ?>


<?php
echo "Welcome, ".$_GET["user"]."! <br>";

include("update.php");    
?>
    

<?php endif; ?>