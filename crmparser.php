<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> Logic - CRM modul </title>
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 

 </head>




 <body onLoad="calcAllLengths();">


<?php

//TBS
include_once('tbs_class.php');
include_once('funclib.php');
include_once('inc/crm_auth_inc.php');

function parseCsv () {
	if (($handle = fopen("crm/crm_cikkelemes.csv", "r")) !== FALSE) {
		$data = fgetcsv($handle, 1000, ";");
		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
			$users[$data[5]]["card"] = $data[0];
			$users[$data[5]]["trid"] = $data[5];
			$users[$data[5]]["got"] += $data[10];
			$users[$data[5]]["spent"] += $data[11];
			$users[$data[5]]["value"] += $data[13]*$data[15];
			$users[$data[5]]["time"] = $data[6];
		}
	}else{
		echo "shit";
	}
	$handler = fopen("crm/crm_purchases.csv", "w");
	foreach ($users as $key => $value) {
		fwrite ( $handler , join(";",$value)."\n");
	}
	fclose($handler);

	return $users;
}
echo "a";





$purchases = parseCsv();
preprint($purchases);

?>

 </body>
</html>
