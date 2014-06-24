<?php
//TBS
include_once('tbs_class.php');
include_once('funclib.php');
include_once('inc/crm_auth_inc.php');
  $TBS = new clsTinyButStrong('{,}');
?>  
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title>UPDATE</title>
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <meta http-equiv="Content-Type" content="text/html; charset=ISO 8859-2" /> 
  <meta http-equiv="refresh" content="600">
 </head>

 <body>
<?php

	if (($handle = fopen("crm/crm_purchases.csv", "r")) !== FALSE) {
		$data = fgetcsv($handle, 1000, ";");
		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
			$purchases[$data[0]][$data[1]] = $data;
		}
	}else{
		echo "shit";
	}

	$link = mysql_connect('db01.ruffnet.local', 'c560beforg', 'PwD0UM6oVZYn') or die('Could not connect: ' . mysql_error());
	mysql_select_db('c560beforg') or die('Could not select database');
	if (isset($_GET["orderby"])) {
		$orderBy = $_GET["orderby"];
	}else{
		$orderBy = "edited";
	}
	$query = 'SELECT * FROM crm_xmas WHERE status="FELHASZNALVA" order by ' . $orderBy;
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());
?>		
					No;ID;Név;Kártyaszám;%;Státusz;Szegmens;Idöpont;Bolt;db;Pontok;Költés;TRID<br />

<?php
	while ($line = mysql_fetch_array($result, MYSQL_ASSOC)){
		$purchase = array_shift($purchases[$line["cardno"]]);
		$totalPurchase += $purchase[4];
		echo ++$counter.";".join(";", $line).";".count($purchases[$line["cardno"]]).";".$purchase[2].";".$purchase[4].";".$purchase[1]."<br />";
	}
	



mysql_close($link);

?>