<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title>FIX</title>
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
 </head>

<?php
include_once('../funclib.php');

function preprint($s, $return=false) { 
    $x = "<pre>"; 
    $x .= print_r($s, 1); 
    $x .= "</pre>"; 
    if ($return) return $x; 
    else print $x; 
} 

function parseFile ($source){
	if (($handle = fopen($source, "r")) !== FALSE) {
		$data = fgetcsv($handle, 1000, ";");
		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
		preprint($data);
			$wordsArr = explode (" ", $data[1]);
			foreach ($wordsArr as $word) {
				if ($flag != "f" && strtoupper($word) == $word && $word != " " && strlen($word)>1) {
					$newRow[$data[0]] .= $word . " ";
				} else {
					break;
				}
			}
		}
		fclose($handle);
		return $newRow;
	}
}

function writeFile ($data) {
	global $uploadsDir;

preprint($data);
	$file["path"] = "";
	$file["name"] =  time() . ".csv";


    if (!$handle = fopen($file["path"].$file["name"], 'w')) {
         echo "Cannot open file ($filename)";
         exit;
    }

	$header = "cikkszam;Csoport nev";
	if (fwrite($handle, $header . "\r\n") === FALSE) {
		echo "Cannot write to file ($filename)";
		exit;
	}

	foreach ($data as $key=>$value) {
		$content = $key . ";" . $value;
		if (fwrite($handle, $content . "\r\n") === FALSE) {
			echo "Cannot write to file ($filename)";
			exit;
		}
    }

    fclose($handle);
	chmod($file["path"].$file["name"], 0777);
	return $file;
}

$itemData = parseFile ("source.csv");

//preprint($itemData);
$result = writeFile($itemData);

//preprint($result);


?>