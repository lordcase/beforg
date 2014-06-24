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
include_once('inc/auth_incl.php');

function parseCsv () {
	if (($handle = fopen("crm/crm_full.csv", "r")) !== FALSE) {
		$data = fgetcsv($handle, 1000, ";");
		$users[0] = array($data[0], $data[1], $data[2], $data[3], $data[4], "mobil", "email", "2012 szezon db", "2012 szezon ertek", "2013 szezon elott db", "2013 szezon elott ertek", "2013 szezon db", "2013 szezon ertek");
		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
			if (isset($users[$data[0]])) {
				$countc++;
			}
			$users[$data[0]][0] = $data[0];
			$users[$data[0]][1] = $data[1];
			$users[$data[0]][2] = $data[2];
			$users[$data[0]][3] = $data[3];
			$users[$data[0]][4] = $data[4];
			$users[$data[0]]["mobil"] = "";
			$users[$data[0]]["email"] = "";
			$users[$data[0]]["2012szezonno"] = "0";
			$users[$data[0]]["2012szezonvalue"] = "0";
			$users[$data[0]]["2013szezonno"] = "0";
			$users[$data[0]]["2013szezonvalue"] = "0";
			$users[$data[0]]["minusz2013szezonno"] = "0";
			$users[$data[0]]["minusz2013szezonvalue"] = "0";
			$counta++;
			
		}
		echo $counta . " " . $countc . " ";
	}else{
		echo "shit";
	}
	if (($handle = fopen("crm/crm_users.csv", "r")) !== FALSE) {
		$data = fgetcsv($handle, 1000, ";");
		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
			if (isset($users[$data[15]])) {
				$users[$data[15]]["mobil"] = $data[6];
				$users[$data[15]]["email"] = $data[7];
				$countb++;
			}			
		}
		echo $countb;
	}else{
		echo "shit";
	}

	return $users;
}

function getPurchases ($ppl) {
	if (($handle = fopen("crm/crm_tavaly.csv", "r")) !== FALSE) {
		$data = fgetcsv($handle, 1000, ";");
		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
			if (isset($ppl[$data[0]])) {
				$ppl[$data[0]]["2012szezonno"]++;
				$ppl[$data[0]]["2012szezonvalue"]+= $data[13] * $data[15];
			}
		}
	}

	if (($handle = fopen("crm/crm_2013_season.csv", "r")) !== FALSE) {
		$data = fgetcsv($handle, 1000, ";");
		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
			if (isset($ppl[$data[0]])) {
				$ppl[$data[0]]["2013szezonno"]++;
				$ppl[$data[0]]["2013szezonvalue"]+= $data[13] * $data[15];
			}
		}
	}else {die("jaj");}

	if (($handle = fopen("crm/crm_2013_janszept.csv", "r")) !== FALSE) {
		$data = fgetcsv($handle, 1000, ";");
		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
			if (isset($ppl[$data[0]])) {
				$ppl[$data[0]]["minusz2013szezonno"]++;
				$ppl[$data[0]]["minusz2013szezonvalue"]+= $data[13] * $data[15];
			}
		}
	}

	return $ppl;
}

//file copy function



$ppl = parseCsv();
$results = getPurchases($ppl);
//preprint($results);
foreach($results as $value) {
	echo join(";", $value) . "<br />";
}


?>

 </body>
</html>
