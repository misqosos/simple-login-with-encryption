
<?php
require_once("encrypt.class.php");

class Signup {

    public function __construct() {}

    function signup($user, $pass){
        if ($this->userExists($user)) { 
            echo "user already exists";
            return; 
        };
        $pass = $this->encPass($pass);
        $dbh = new PDO("mysql:host=localhost", 'root', '');
        $sqlAffection = $dbh->exec($this->createDb($user));
    
        $encArr = str_split($pass, ceil(strlen($pass)/3));
        if (count($encArr) > 3) {
            $encArr[2] = $encArr[2] . $encArr[3];
            array_pop($encArr);
        };
    
        $sql = "";

        for ($i=0; $i < count($encArr); $i++) { 
            $sql.="INSERT INTO login".$user.$i.".credentials VALUES ('".$encArr[$i]."');";
        }
        
        $insert = $dbh->exec($sql);
    
        echo $user." has account";
    }

    function updatePass($user, $pass){
        $pass = $this->encPass($pass);
        setcookie($user, $pass, time() + 3600, "/");
        $dbh = new PDO("mysql:host=localhost", 'root', '');
    
        $encArr = str_split($pass, ceil(strlen($pass)/3));
        if (count($encArr) > 3) {
            $encArr[2] = $encArr[2] . $encArr[3];
            array_pop($encArr);
        };
    
        $sql = "";
    
        for ($i=0; $i < 3; $i++) { 
            $sql .="TRUNCATE login".$user.$i.".credentials;";
        }
        for ($i=0; $i < count($encArr); $i++) { 
            $sql.="INSERT INTO login".$user.$i.".credentials VALUES ('".$encArr[$i]."');";
        }
        
        $insert = $dbh->exec($sql);
    
        echo "password updated";
    }
    
    function createDb ($dbname) {
        return
        "
        CREATE DATABASE IF NOT EXISTS login".$dbname."0;
        CREATE DATABASE IF NOT EXISTS login".$dbname."1;
        CREATE DATABASE IF NOT EXISTS login".$dbname."2;
        CREATE TABLE IF NOT EXISTS login".$dbname."0.credentials (
            password VARCHAR(1000)
        );
        CREATE TABLE IF NOT EXISTS login".$dbname."1.credentials (
            password VARCHAR(1000)
        );
        CREATE TABLE IF NOT EXISTS login".$dbname."2.credentials (
            password VARCHAR(1000)
        );
    
        ";
    }

    function userExists ($user) {
        $conn = new PDO("mysql:host=localhost", 'root', '');
        $stmt = $conn->prepare("SELECT `SCHEMA_NAME` FROM `information_schema`.`SCHEMATA`;");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $userFound = false;
        array_map(
            function($element) use($user, &$userFound) {
                if($userFound){return;}
                if (substr($element["SCHEMA_NAME"], 5, strlen($user)) == $user) {
                    $userFound = true;
                }
            }, $rows);
        return $userFound;
    }

    function encPass($pass) {
        $encrypt = new Encrypt();
        return $encrypt->encryptPass($pass);
    }
}

?>