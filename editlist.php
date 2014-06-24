<?php

//TBS
include_once('tbs_class.php');
include_once('funclib.php');
include_once('inc/auth_incl.php');
  $TBS = new clsTinyButStrong('{,}');
if (isset($_GET["projectDir"])) {
	$_SESSION["projectDir"] = $_GET["projectDir"];
}
function writeShopMasterFile ($rowArray, $excludeArray, $fileName) {
	global $uploadsDir;


	$file["path"] = $uploadsDir . "/" . $_SESSION["projectDir"] . "/final/";
	$file["name"] = $fileName;


    if (!$handle = fopen($file["path"].$file["name"], 'w')) {
         echo "Cannot open file ($filename)";
         exit;
    }

	$header = "Artikel;WGR;WGR_Text;Bontext_German;Bontext_english;origin_country_code;origin_country_ISOCODE;origin_country_tarif_no;purchase_price;sale_price;quantity;0;1;2;3;4;5;6;7;8;9;magyar_cikkcsoportnev;magyar_cikknev;magyar_rovidnev;magyar_beszar;magyar_fogyar;afa";
	if (fwrite($handle, $header . "\r\n") === FALSE) {
		echo "Cannot write to file ($filename)";
		exit;
	}

	foreach ($rowArray as $row) {
		if (isset($row["origId"])) {
			$origId = $row["origId"];
		}else{
			$origId = 'new';
		}

		unset($row["origId"]);
		if ($origId == "new" || !in_array($origId, $excludeArray)) {
//			echo join(";", $row) . "<br>\r\n";
			$row[8] = str_replace(".", ",", $row[8]);
			$row[9] = str_replace(".", ",", $row[9]);
			if (fwrite($handle, join(";", $row) . "\r\n") === FALSE) {
				echo "Cannot write to file ($filename)";
				exit;
			}
		}else{
			echo "DELETED: " . join(";", $row) . "<br>\r\n";
		}
    }

    fclose($handle);
	chmod($file["path"].$file["name"], 0777);
	return $file;
}


if (isset($_POST["itemData"])) {
	writeShopMasterFile ($_POST["itemData"], $_POST["delRow"], $_POST["fileName"]);
//	echo "file " . $_POST["fileName"] . " written </br>";
}



function genFileRows (&$TBS) {
	$content = "";
	$projectDir = $_SESSION["projectDir"];
	global $uploadsDir;
	$fileList = getFilesByExtension($uploadsDir . "/" .	$projectDir . "/final");
	foreach ($fileList["csv"] as $file) {
		$TBS->LoadTemplate('editlist_filerow.html', false);
		$TBS->MergeField('projectdir', $projectDir); 
		$TBS->MergeField('filename', $file); 
		$TBS->MergeField('dllink', "/uploads/" .	$projectDir . "/final/" . $file); 
		$TBS->Show(TBS_NOTHING);
		$content .= $TBS->Source;
	}
	$TBS->LoadTemplate('editlist_ziprow.html', false);
	$TBS->MergeField('projectdir', $projectDir); 
	$TBS->MergeField('filename', $fileList["zip"][0]); 
	$TBS->MergeField('dllink', "/uploads/" .	$projectDir . "/final/" . $fileList["zip"][0]); 
	$TBS->Show(TBS_NOTHING);
	$content .= $TBS->Source;
	return $content;
}


if (isset($_POST["redoZip"])) {

	$zip = new ZipArchive();
	$zipPath = $uploadsDir . "/" . $_SESSION["projectDir"] . "/final/";
	$zipName = "final_" .  $_SESSION["projectDir"] . ".zip";
	unlink($zipPath . $zipName);
	if ($zip->open($zipPath . $zipName, ZIPARCHIVE::CREATE) === true) {
		$writtenFileArray = getFilesByExtension($zipPath);
		foreach ($writtenFileArray["csv"] as $file) {
			$zip->addFile($zipPath.$file, $file);
		}
		$zip->close();
		chmod($zipPath . $zipName, 0777);
	}
}


$fileRows = genFileRows($TBS);

//output 
$TBS->LoadTemplate('editlist_main.html', false);
$TBS->MergeField('projectname', $_SESSION["projectDir"]); 
$TBS->MergeField('eurrate', readEurRate ()); 
$TBS->MergeField('content', $fileRows); 
$TBS->Show();

?>