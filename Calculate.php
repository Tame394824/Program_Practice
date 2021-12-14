<?php

//文字の四則演算を入力し、その結果を計算する
//DEMOページ：http://34.127.11.233/Programe_Practice/Calculate.php


$Formula = $_GET["Formula"];
$InputCheck = "/^[0-9\+\-\*\/\(\)]+$/";
if(preg_match($InputCheck, $Formula)){
    $Number=str_split($Formula);
    $Temp = array();
    $TempCount = 0;
    $Operation = array("+", "-", "*", "/");
    foreach($Number as $Item){
	if($Item == "("){
	    $TempCount++;
	}else if(($Item == ")")){
	    $TempCount--;
	    $Temp[$TempCount] .= Calculation($Temp[$TempCount+1], $Operation);
	    $Temp[$TempCount+1]="";
	}else{
	    $Temp[$TempCount] .= $Item;
	}
    }
    $Answer = Calculation($Temp[0], $Operation);
    echo $Formula."=".$Answer;
}else{
    if(!isset($Formula) || trim($Formula) === ''){
	echo "";
    }else{
	echo "ERROR";
    }
}

function Calculation($Value, $Operation){
    if(count($Operation)<=0){
	return $Value;
    }
    $Op = array_shift($Operation);
    $Number=str_split($Value);
    $Temp = array();
    $TempCount = 0;
    foreach($Number as $Item){
	if($Item == $Op){
	    $Temp[$TempCount] = Calculation($Temp[$TempCount], $Operation);
	    $TempCount ++;
	}else{
	    $Temp[$TempCount] .= $Item;
	}
    }
    $Temp[$TempCount] = Calculation($Temp[$TempCount], $Operation);
    $Cal = array_shift($Temp);
    switch ($Op) {
	case "+":
	    foreach($Temp as $Item){
		$Cal += floatval($Item);
	    }
	    break;
	case "-":
	    foreach($Temp as $Item){
		$Cal -= floatval($Item);
	    }
	    break;
	case "*":
	    foreach($Temp as $Item){
		$Cal *= floatval($Item);
	    }
	    break;
	case "/":
	    foreach($Temp as $Item){
		$Cal /= floatval($Item);
	    }
	    break;
    }
    return $Cal;
}
?>
