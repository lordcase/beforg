<?php

include_once('inc/auth_incl.php');
include_once('funclib.php');

$res = @mkdir($uploadsDir . "/" . $_GET["dirname"], 0777);
if ($res == FALSE) {
	echo "0";
}else{
	$eurRate = str_replace(",", ".", $_GET["eurrate"]);
	if (!is_numeric($eurRate)) {
		@rmdir($uploadsDir . "/" . $_GET["dirname"]);
		echo "-1";
	} else {
		$_SESSION["projectDir"] = $_GET["dirname"];
		$handler = fopen($uploadsDir . "/" . $_GET["dirname"] . "/eurrate.txt", "w");
		if (fwrite ( $handler , $eurRate)) {
			fclose($handler);
			echo "1";
		} else {
			@rmdir($uploadsDir . "/" . $_GET["dirname"]);
			echo "-2";
		}
	}
}

?>