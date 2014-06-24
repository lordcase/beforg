<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title>UPDATE</title>
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
 </head>

<?php

die();

include_once('../funclib.php');
$minStock = 3;
$apiKeyButlers = "KBj1tXNbRPHB0eYt3WJ";
$target_url = "http://shopline.hu/serviceapi/1.0/stockupdate/upload";
//$target_url = 'http://beforg.butlers.hu/shopline/posttest.php';
 

function preprint($s, $return=false) { 
    $x = "<pre>"; 
    $x .= print_r($s, 1); 
    $x .= "</pre>"; 
    if ($return) return $x; 
    else print $x; 
} 

function readIdList ($source){
	if (($handle = fopen($source, "r")) !== FALSE) {
		$data = fgetcsv($handle, 1000, ";");
		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
			$idList[] = $data[0];
		}
		fclose($handle);
		return $idList;
	}
}


function parseFile ($source, $idList, $minStock){
	if (($handle = fopen($source, "r")) !== FALSE) {
		$data = fgetcsv($handle, 1000, ";");
		$purchasePrice = "";
		$specSalesPrice = "";
		$specPurchasePrice = "";
		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
			if (in_array($data[0], $idList)) {
				if ($data[5] >= $minStock) {
					$status = 0;
				} else {
					$status = 2;
				}
				$salesPrice = iconv("ISO-8859-1", "UTF-8", $data[2]);
				$workArray = array(iconv("ISO-8859-1", "UTF-8", $data[0]), $status, $salesPrice, $purchasePrice, $specSalesPrice, $specPurchasePrice);
				$itemData[] = join(';', $workArray);
			}
		}
		fclose($handle);
//		preprint($itemData);
		return $itemData;
	} else {die("error");
		
	}
}

function writeFile ($data) {

	$file["path"] = "upload/";
	$file["name"] =  time() . ".csv";


    if (!$handle = fopen($file["path"].$file["name"], 'w')) {
         echo "Cannot open file ($filename)";
         exit;
    }


	foreach ($data as $row) {
		if (fwrite($handle, iconv("ISO-8859-1", "UTF-8",$row) . "\r\n") === FALSE) {
			echo "Cannot write to file ($filename)";
			exit;
		}
    }

    fclose($handle);
	chmod($file["path"].$file["name"], 0777);
	return $file;
}




$idList = readIdList("idlist.csv");
$itemData = parseFile ("upload/webshop_export_888.csv", $idList, $minStock);
$uploadFile = writeFile($itemData);



    $ch = curl_init();
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_URL, $target_url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
	$postdata = array(
		"statusupdate" => "@/".realpath($uploadFile["path"].$uploadFile["name"]).";type=text/csv",
		"key" => $apiKeyButlers,
		"partial" => 0
		);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
	$result=curl_exec ($ch);
	curl_close ($ch);






?>