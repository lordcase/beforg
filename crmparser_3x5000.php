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




 <body>


<?php

$customers = array (
2020002031282,
2020002035365,
2020002061791,
2020002114077,
2020002127916,
2020002137731,
2020002142834,
2020002154288,
2020002186654,
2020002225551,
2020002260408,
2020002263133,
2020002269791,
2020002298029,
2020002305871,
2020002311728,
2020002318178,
2020002332778,
2020002335137,
2020002371661,
2020002378585,
2020002379766,
2020002382162,
2020002385385,
2020002415327,
2020002417642,
2020002418564,
2020002469702,
2020002474782,
2020002474843,
2020002474898,
2020002492106,
2020002493363,
2020002493738,
2020002497958
);

if (($handle = fopen("crm/crm_3x5000.csv", "r")) !== FALSE) {
	$data = fgetcsv($handle, 1000, ";");
	while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
		if (in_array($data[0],$customers)) {
			echo join(";", $data) . "<br />";
			$custsum[$data[0]] += $data[13] * $data[15];
		}
	}
}else{
	echo "shit";
}
fclose($handler);
foreach ($custsum as $key => $value) {
	echo $key . ";" . $value . ";" . round($value*"0.1") . "<br />";
}






?>

 </body>
</html>
