<?php
require_once("signup.class.php");
require_once("encrypt.class.php");

class Login {

    public function __construct() {}

    function access($user, $pass) {
        $passFromDb = $this->decPass($this->getPassFromDb($user));
        if ($passFromDb == $pass) {
            return true;
        }
        return false;
    }

    function login($user, $pass){
        $signup = new Signup();
        if (!$signup->userExists($user)) {
            echo "user doesnt exist <br>";
            return;
        };
        $access = $this->access($user, $pass);
        $passFromDb = $this->getPassFromDb($user);
        if ($access) {
            setcookie($user, $passFromDb, time() + 3600, "/");
            header('Location: /signedIn.php?user='.$user);
            return;
        }
        echo "incorrect password";
    }

    function cookiePass ($user){
        if (isset($_COOKIE[$user])) {
            $login = new Login();
            $pass = $this->decPass($_COOKIE[$user]);
            return $login->access($user, $pass);
        }
        return false;
    }

    function decPass($pass) {
        $encrypt = new Encrypt();
        return $encrypt->decryptPass($pass);
    }

    function encPass($pass) {
        $encrypt = new Encrypt();
        return $encrypt->encryptPass($pass);
    }

    function getPassFromDb ($user) {
        $passFromDb = "";
        $dbh = new PDO("mysql:host=localhost", 'root', '');
        for ($i=0; $i < 3; $i++) { 
            $sql =
            "
            SELECT password FROM login".$user.$i.".credentials;
            ";
            $result = $dbh->prepare($sql);
            $result->execute();
            $passPart = $result->fetch(PDO::FETCH_ASSOC);
            !$passPart ?: $passFromDb .= $passPart["password"];
        }
        return $passFromDb;
    }
}

?>