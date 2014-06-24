<?php

//TBS
include_once('tbs_class.php');
include_once('funclib.php');
include_once('inc/auth_incl.php');
  $TBS = new clsTinyButStrong('{,}');


function completeShopArrays (&$masterShopArray, $formData) {
	if (isset($formData["newItemRowId"])) {
		foreach ($formData["newItemRowId"] as $rowId) {
			foreach ($masterShopArray as $shopArrayKey => $shopArray) {
				if (isset($shopArray[$rowId])) {
					foreach ($shopArray[$rowId] as $rowKey => $row) {
						$masterShopArray[$shopArrayKey][$rowId][$rowKey][26] = strtoupper($formData["groupname"][$rowId]);
						$masterShopArray[$shopArrayKey][$rowId][$rowKey][27] = $formData["longname"][$rowId];
						$masterShopArray[$shopArrayKey][$rowId][$rowKey][28] = $formData["shortname"][$rowId];
						$masterShopArray[$shopArrayKey][$rowId][$rowKey][29] = str_replace("." , ",", $formData["beszar"][$rowId]);
						$masterShopArray[$shopArrayKey][$rowId][$rowKey][30] = $formData["fogyar"][$rowId];
						$masterShopArray[$shopArrayKey][$rowId][$rowKey][31] = $formData["afa"][$rowId];
					}
				}
			}
		}
	}
}

function makeHOArray (&$masterShopArray, $formData) {
	$HOArray = "";
	if (isset($formData["newItemRowId"])) {
		foreach ($formData["newItemRowId"] as $rowId) {
			foreach ($masterShopArray as $shopArrayKey => $shopArray) {
				if (isset($shopArray[$rowId])) {
					$HOArray[] = $masterShopArray[$shopArrayKey][$rowId][0];
					break;
				}
			}
		}
	}
	return $HOArray;
}

function writeShopMasterFile ($shopMasterDeliveryBlock, $shopId) {
	global $uploadsDir;


	$file["path"] = $uploadsDir . "/" . $_SESSION["projectDir"] . "/final/";
	$file["name"] = $shopId . "deli_" . $_SESSION["projectDir"] . ".csv";


    if (!$handle = fopen($file["path"].$file["name"], 'w')) {
         echo "Cannot open file ($filename)";
         exit;
    }

	$header = "Artikel;WGR;WGR_Text;Bontext_German;Bontext_english;origin_country_code;origin_country_ISOCODE;origin_country_tarif_no;purchase_price;sale_price;quantity;0;1;2;3;4;5;6;7;8;9;magyar_cikkcsoportnev;magyar_cikknev;magyar_rovidnev;magyar_beszar;magyar_fogyar;afa";
	if (fwrite($handle, $header . "\r\n") === FALSE) {
		echo "Cannot write to file ($filename)";
		exit;
	}

	foreach ($shopMasterDeliveryBlock as $masterIdBlock) {
		foreach ($masterIdBlock as $masterIdRow) {
			if (fwrite($handle, join(";", $masterIdRow) . "\r\n") === FALSE) {
				echo "Cannot write to file ($filename)";
				exit;
			}
		}
    }

    fclose($handle);
	chmod($file["path"].$file["name"], 0777);
	return $file;
}

function writeHOUploadFile ($HOArray) {
	global $uploadsDir;

	$file["path"] = $uploadsDir . "/" . $_SESSION["projectDir"] . "/final/";
	$file["name"] =  "totaldeli_" . $_SESSION["projectDir"] . ".csv";


    if (!$handle = fopen($file["path"].$file["name"], 'w')) {
         echo "Cannot open file ($filename)";
         exit;
    }

	$header = "Artikel;WGR;WGR_Text;Bontext_German;Bontext_english;origin_country_code;origin_country_ISOCODE;origin_country_tarif_no;purchase_price;sale_price;quantity;0;1;2;3;4;5;6;7;8;9;magyar_cikkcsoportnev;magyar_cikknev;magyar_rovidnev;magyar_beszar;magyar_fogyar;afa";
	if (fwrite($handle, $header . "\r\n") === FALSE) {
		echo "Cannot write to file ($filename)";
		exit;
	}

	foreach ($HOArray as $HORow) {
		if (fwrite($handle, join(";", $HORow) . "\r\n") === FALSE) {
			echo "Cannot write to file ($filename)";
			exit;
		}
    }

    fclose($handle);
	chmod($file["path"].$file["name"], 0777);
	return $file;
}


function writeFormData ($formData) {
	global $uploadsDir;
	$handler = fopen($uploadsDir . "/" . $_SESSION["projectDir"] . "/formdata.ser", "w");
	fwrite ( $handler , serialize($formData));
	fclose($handler);
}

function genFileRows ($fileArray, &$TBS) {
	$content = "";
	global $shopArray, $uploadsDir;
	$shopArray["HO"] = "HO";
	$shopArray["zip"] = "ZIP";
	foreach ($fileArray as $key => $value) {
		$TBS->LoadTemplate('download_filerow.html');
		$filePath = "/uploads/" . $_SESSION["projectDir"] . "/final/";
		$list = array("shopname"=>$shopArray[$key], "projectname"=>$_SESSION["projectDir"], "filepath"=>$filePath, "filename"=>$value["name"]);
		if ($shopArray[$key] == "HO" || $shopArray[$key] == "ZIP") {
			$list["operation"] = "";
		}else{
			$list["operation"] = "edit";
		}
		$TBS->MergeField('filedata', $list); 
		$TBS->Show(TBS_NOTHING);
		$content .= $TBS->Source;
	}
	return $content;
}


//write form data into shop master files
completeShopArrays ($_SESSION["shopMasterDeliveryArray"], $_POST);

//create HO upload file
$HOArray = makeHOArray ($_SESSION["shopMasterDeliveryArray"], $_POST);


//create final dir and write shop master files
$res = @mkdir($uploadsDir . "/" . $_SESSION["projectDir"] . "/final" , 0777);
foreach ($_SESSION["shopMasterDeliveryArray"] as $shopId => $shopMasterDeliveryBlock) {
	$writtenFileArray[$shopId] = writeShopMasterFile ($shopMasterDeliveryBlock, $shopId);
}

//write HO upload file
$writtenFileArray["HO"] = writeHOUploadFile ($HOArray);



$zip = new ZipArchive();
$zipPath = $uploadsDir . "/" . $_SESSION["projectDir"] . "/final/";
$zipName = "final_" .  $_SESSION["projectDir"] . ".zip";
if ($zip->open($zipPath . $zipName, ZIPARCHIVE::CREATE) === true) {
	foreach ($writtenFileArray as $file) {
		$zip->addFile($file["path"].$file["name"], $file["name"]);
	}
	$zip->close();
	chmod($zipPath . $zipName, 0777);
	$writtenFileArray["zip"] = Array ("path"=>$zipPath, "name"=>$zipName);
}



writeFormData($_POST);

$content = genFileRows ($writtenFileArray, $TBS);
$TBS->LoadTemplate('download.html', false);
$TBS->MergeField('filerows', $content); 
$TBS->Show();

?>