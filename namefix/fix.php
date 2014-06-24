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
//		preprint($data);
				$sortedWords = sortUpperLowerWords($data[2]);
				$name = explode(" ", $data[1]);
				foreach ($sortedWords["upper"] as $key => $value) {
					if ($value == strtoupper($name[$key])) {
						$name[$key] = $value;
					}else if ($first != "1"){
//						echo $no++ . " " . $data[0] . " " . $value . " - " . $name[$key] . "<br />";
						echo $data[0] . ";" . $data[1] . ";" . $data[2] . "<br />";
						$first = 1;
					}
				}
				$first = 0;
				$newName = join(" ",$name); 
				$itemData[] = array($data[0],$newName);
		}
		fclose($handle);
		return $itemData;
	}
}

function writeFile ($data) {
	global $uploadsDir;


	$file["path"] = "";
	$file["name"] =  time() . ".csv";


    if (!$handle = fopen($file["path"].$file["name"], 'w')) {
         echo "Cannot open file ($filename)";
         exit;
    }

	$header = "cikkszam;Hosszu nev";
	if (fwrite($handle, $header . "\r\n") === FALSE) {
		echo "Cannot write to file ($filename)";
		exit;
	}

	foreach ($data as $row) {
		if (fwrite($handle, join(";", $row) . "\r\n") === FALSE) {
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