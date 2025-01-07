<?php


// function countUniqueCharsInString($str){
    //     $passArr = str_split( $str );
    //     $charsInPass = array_unique( $passArr );
    //     $mapChars = array();

    //     array_map(function($el) use($str, &$mapChars) { 
    //         $mapChars[$el] = substr_count($str, $el); 
    //     }, $charsInPass);
    // }



    // $rest = substr($encFile, $j+1, strlen($encFile)-$j+1);
    // if(isset($usedIndexes[$currentChar])) {
    //     if (in_array($j, $usedIndexes[$currentChar]) && str_contains($rest, $currentChar)) {
    //         continue;
    //     }
    // }
    // if (strlen($rest) > 7) {
    //     $encChar = substr($encFile, $j+1, rand(5,8));   
    // } else {
    //     $encFile.=substr($encFile, rand(5,10), 8);
    //     $encChar = substr($encFile, $j+1, rand(5,8));
    // }
    // $usedIndexes[$currentChar][] = $j;
    // if (array_count_values($usedIndexes[$currentChar])[$j] > 1) {
    //     $usedIndexes[$currentChar] = array();
    // }

    // for ($j=0; $j < strlen($encFile); $j++) { 
    //     if ($pass[$i] == $encFile[$j]) {
    //         $currentChar = $encFile[$j];
    //         $encChar = substr($encFile, rand(0, strlen($encFile)-8), rand(5,8)); 

    //         $charPos = strpos($symbols, $currentChar);
    //         $encPass .= strlen($encChar).$encChar.strlen($charPos).$charPos;
    //         $encCharLengths.=strlen($encChar);
    //         echo $currentChar . " = " . $encChar."<br>";
    //         break;
    //     }
    // }

?>