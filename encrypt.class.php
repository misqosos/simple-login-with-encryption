<?php
// $enc = new Encrypt();
// $enc->decryptPass("banana", $enc->encryptPass("banana"));
class Encrypt {
    
    public function __construct(){}

    function encryptFile(){
        $symbols = file_get_contents("symbols.txt");
        $symbolsForRand = file_get_contents("symbols.txt");
        $encryptionFile = "";
        while (strlen($symbols)) { 
            $chars = "";
            for ($j=0; $j < rand(9, 12); $j++) { 
                $randomChar = $symbolsForRand[rand(0, strlen($symbolsForRand)-1)];
                $chars.=$randomChar;
            }
            $randIndex = rand(0, strlen($symbols)-1);
            $encryptionFile.=$chars.$symbols[$randIndex];
            strlen($symbols) == 1 ? $encryptionFile.=$symbols[0].$chars : "";
            $symbols = str_replace($symbols[$randIndex], "", $symbols);
        }
        file_put_contents("result.txt", $encryptionFile);
        return file_get_contents("result.txt");
    }

    function encryptPass($pass){
        $encFile = $this->encryptFile();
        $lenEnc = file_get_contents("lengthsSymbols.txt");
        $startLen = rand(0,20);
        $encPass = $lenEnc[$startLen] . substr($encFile, rand(0, strlen($encFile)-$startLen), $startLen);
        $symbols = file_get_contents("symbols.txt");

        array_map(
            function ($currentChar) use(&$encPass, $symbols, $encFile) {
                $encChar = substr($encFile, rand(0, strlen($encFile)-15), rand(5,15)); 
                $charPos = strpos($symbols, $currentChar);
                $encPass .= strlen(strlen($encChar)).strlen($encChar).$encChar.strlen($charPos).$charPos;
            }
        ,str_split($pass));

        $endLen = rand(0,20);
        $encPass .= substr($encFile, rand(0, strlen($encFile)-$endLen), $endLen) . $lenEnc[$endLen];
        
        return $encPass;
    }

    function decryptPass($encPass){
        $lenEnc = str_split(file_get_contents("lengthsSymbols.txt"));

        $startStr = $encPass[0];
        $endStr = $encPass[strlen($encPass)-1];
        $encPass = substr($encPass, 1, strlen($encPass)-2);

        $startLen = array_search($startStr, $lenEnc);
        $endLen = array_search($endStr, $lenEnc);

        $encPass = substr($encPass, $startLen, strlen($encPass)-$startLen-$endLen);

        $symbols = file_get_contents("symbols.txt");
        $decPass = "";

        while (strlen($encPass) > 0) { 
            $encCharLenNumAmount = $encPass[0];
            $encCharLen = substr($encPass, 1, $encCharLenNumAmount);
            $encChar = substr($encPass, $encCharLenNumAmount+1, $encCharLen);
            $symbolIndexNumAmount = substr($encPass, $encCharLenNumAmount+$encCharLen+1, 1);
            $symbolIndex = substr($encPass, 1+$encCharLenNumAmount+$encCharLen+1, $symbolIndexNumAmount);
            $decPass .= $symbols[$symbolIndex];
            $strToTrim = $encCharLenNumAmount . $encCharLen . $encChar . $symbolIndexNumAmount . $symbolIndex;
            $encPass = substr($encPass, strlen($strToTrim), strlen($encPass)-strlen($strToTrim));
        }
        
        return $decPass;
    }
}

?>