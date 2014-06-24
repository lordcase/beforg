<?php

//TBS
include_once('tbs_class.php');
include_once('funclib.php');
include_once('inc/auth_incl.php');
  $TBS = new clsTinyButStrong('{,}');

  $shopMasterDeliveryArray = Array();
  $newItemsArray = Array();
  $oldItemsIdArray = Array();
  $sortexIdArray = Array();
  $sortexIdListArray = Array();
  $sortexNameFirstArray = Array();


//file copy function
function copyFiles ($userFA, $projectDir) {
	if (!isset($userFA["error"][0])) {
		foreach ($userFA as $k => $v) {
			$userFileArray[$k][0] = $v;
		}
		
	} else {
		$userFileArray = $userFA;
	}
	global $uploadsDir;
	foreach ($userFileArray["error"] as $key => $error) {
		if ($error == UPLOAD_ERR_OK) {
			if ($userFileArray["type"][$key] != "text/csv") {
				die("rossz fájlformátum(".$userFileArray["name"][$key].")!");
// preprint($userFileArray);
			}
			$tmp_name = $userFileArray["tmp_name"][$key];
			$name = $names[] = $userFileArray["name"][$key];
			move_uploaded_file($tmp_name, "$uploadsDir/".$_SESSION["projectDir"]."/$name");
		}else if ($error != 4){
			die ("<br>error<br>");
		}
	}
	return $names;
}



// shop delivery file parser function
function parseDeliveryFile ($fileArray, $shopId, &$newItemsArray, &$oldItemsIdArray, &$sortexIdListArray, &$shopMasterDeliveryArray, $sortexIdArray){
	global $uploadsDir, $delivIdColName, $eurRate, $aaa, $destShopArray;
	if (($handle = fopen("$uploadsDir/" . $_SESSION["projectDir"] . "/" . $fileArray["name"], "r")) !== FALSE) {
		$data = fgetcsv($handle, 1000, ";");
		foreach($data as $colNumber => $colName) {
			if ($colName == $delivIdColName) {
				$idColNumber = $colNumber;
				break;
			}
		}
		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
			if (substr($data[$idColNumber], 0, 4) != "9999") {
				if (!in_array($data[$idColNumber], $sortexIdListArray)) {
					$newItemsArray[$data[$idColNumber]] = $data;
				}else{
					$oldItemsIdArray[$data[$idColNumber]] = $data;
				}

				$destShopArray[$data[$idColNumber]][$shopId] =  $destShopArray[$data[$idColNumber]][$shopId] + $data[13];
				unset($data[0]);
				unset($data[1]);
				unset($data[2]);
				unset($data[14]);
				unset($data[15]);
				$data[18] = "";
				$data[19] = "";
				$data[20] = "";
				$data[21] = "";
				$data[22] = "";
				$data[23] = "";
				$data[24] = "";
				$data[25] = "";
				if (isset($sortexIdArray[$data[$idColNumber]])) {
					$data[26] = $sortexIdArray[$data[$idColNumber]][25];
					$data[27] = $sortexIdArray[$data[$idColNumber]][26];
					$data[28] = $sortexIdArray[$data[$idColNumber]][27];
					$data[29] = str_replace("." , ",", str_replace("," , ".", $data[11]) * $eurRate);
					$data[30] = $sortexIdArray[$data[$idColNumber]][29];
					$data[31] = $sortexIdArray[$data[$idColNumber]][30];
				}
				$shopMasterDeliveryArray[$shopId][$data[$idColNumber]][] = $data; 
			}
		}
		fclose($handle);
	}
}




// generate new item rows
function genNewItemRows (&$newItemsArray, &$TBS) {
	global $eurRate, $sortexNameFirstArray, $uploadsDir, $destShopArray;
	$content = "";
	$tabIndex = 1;

	//check presubmitted form data
	if (is_file("$uploadsDir/" . $_SESSION["projectDir"] . "/formdata.ser") && is_readable("$uploadsDir/" . $_SESSION["projectDir"] . "/formdata.ser")) {
		$previousFormData = unserialize(file_get_contents("$uploadsDir/" . $_SESSION["projectDir"] . "/formdata.ser"));
	}

	foreach ($newItemsArray as $newItemId => $newItemDataArray) {
		$words = sortUpperLowerWords($newItemDataArray[6]);
		$group = join (" ", $words["upper"]);
		$searchstring = $group . " " . $words["lower"][0];
/*		$group = (strtoupper($words[0] . " " . $words[1]) == $words[0] . " " . $words[1] ? $words[0] . " " . $words[1] : $words[0]);
		$searchstring = (strtoupper($words[0] . " " . $words[1]) == $words[0] . " " . $words[1] ? $words[0] . "+" . $words[1] . "+" . $words[2] : $words[0] . "+" . $words[1] );
*/
	

		$newItemDataArray["h_groupname"] = $group;
		$newItemDataArray["h_name"] = "";
		$newItemDataArray["h_shortname"] = "";
		$newItemDataArray["h_purchase_price"] = str_replace(",", ".", $newItemDataArray[11]) * $eurRate;
		$newItemDataArray["h_sale_price"] = str_replace(",", ".", $newItemDataArray[12]) * $eurRate;
		$newItemDataArray["h_sale_price_readonly"] = str_replace(",", ".", $newItemDataArray[12]) * $eurRate;
		$newItemDataArray["cogs"] = round($newItemDataArray["h_purchase_price"]/($newItemDataArray["h_sale_price"] / 1.27));
		$newItemDataArray["margin"] = round((($newItemDataArray["h_sale_price"] / 1.27 - $newItemDataArray["h_purchase_price"] * 1.2) / ($newItemDataArray["h_sale_price"] / 1.27)) * 100,2);
		$newItemDataArray["afa"] = "27";
		$newItemDataArray["searchstring"] = $searchstring;
		foreach ($destShopArray[$newItemId] as $key => $value) {
			$newItemDataArray["shops"] .= $key . "_" . $value . " ";
		};
//		$newItemDataArray["shops"] = join(" ", $destShopArray[$newItemId]);
		$newItemDataArray["tab1"] = $tabIndex++;
		$newItemDataArray["tab2"] = $tabIndex++;
		$newItemDataArray["tab3"] = $tabIndex++;
		$newItemDataArray["tab4"] = $tabIndex++;
		$newItemDataArray["tab5"] = $tabIndex++;
		if (isset($previousFormData) && in_array($newItemId, $previousFormData["newItemRowId"])) {
//			$newItemDataArray["h_groupname"] = $previousFormData["groupname"][$newItemId];
			$newItemDataArray["h_name"] = $previousFormData["longname"][$newItemId];
			$newItemDataArray["h_shortname"] = $previousFormData["shortname"][$newItemId];
			$newItemDataArray["h_sale_price"] = $previousFormData["fogyar"][$newItemId];
			$newItemDataArray["cogs"] = $previousFormData["cogs"][$newItemId];
			$newItemDataArray["margin"] = $previousFormData["margin"][$newItemId];
			$newItemDataArray["afa"] = $previousFormData["afa"][$newItemId];
		}
		$TBS->LoadTemplate('logic_new_item_row.html');
		$TBS->MergeField('shopdata', $newItemDataArray); 
		$TBS->Show(TBS_NOTHING);
		$content .= $TBS->Source;
	// helper rows
		if (isset($sortexNameFirstArray[strtolower($words["upper"][0])])) {
			if (isset($_GET["helprows"])) {
				$helpRows = $_GET["helprows"];
			} else {
				$helpRows = 2;
			}
			$counter = 1;
			$TBS->LoadTemplate('logic_new_item_help_table_head.html');
			$rowId = $newItemDataArray[3];
			$TBS->MergeField('rowid', $rowId); 
			$TBS->Show(TBS_NOTHING);
			$content .= $TBS->Source;
			$helpItemDataArraySorted = array_reverse($sortexNameFirstArray[strtolower($words["upper"][0])]);
			foreach ($helpItemDataArraySorted as $helpItemDataArray) {
				$TBS->LoadTemplate('logic_new_item_help_row.html');
				$helpItemDataArray["rowid"] = $newItemDataArray[3];
				$TBS->MergeField('helpdata', $helpItemDataArray); 
				$TBS->Show(TBS_NOTHING);
				$content .= $TBS->Source;
				if ($counter++ == $helpRows) {
					break;
				}
			}
			$TBS->LoadTemplate('logic_new_item_help_table_end.html');
			$TBS->Show(TBS_NOTHING);
			$content .= $TBS->Source;
		}
	}
	return $content;
}


// generate old item rows
function genOldItemRows (&$oldItemsIdArray, &$TBS) {
	$content = "";
	global $sortexIdArray, $eurRate, $destShopArray;
	foreach ($oldItemsIdArray as $oldItemId => $oldItemDelivData) {
		$oldItemDataArray = $sortexIdArray[$oldItemId];
		$oldItemDataArray["purchase_price"] = $oldItemDelivData[11];
		$oldItemDataArray["sale_price"] = $oldItemDelivData[12];
		$oldItemDataArray["h_purchase_price"] = str_replace(",", ".", $oldItemDelivData[11]) * $eurRate;
		$oldItemDataArray["h_sale_price"] = $oldItemDataArray[29];
//		$oldItemDataArray["h_sale_price"] = str_replace(",", ".", $oldItemDelivData[12]) * $eurRate;
		$oldItemDataArray["cogs"] = round($oldItemDataArray["h_purchase_price"] / ($oldItemDataArray["h_sale_price"] / 1.27)*100,2);
//marzs	$oldItemDataArray["margin"] = round((($oldItemDataArray["h_sale_price"] / 1.27 - $oldItemDataArray["h_purchase_price"] * 1.2) / ($oldItemDataArray["h_sale_price"] / 1.27)) * 100, 2);
		foreach ($destShopArray[$oldItemId] as $key => $value) {
			$oldItemDataArray["shops"] .= $key . "_" . $value . " ";
		};

//		$oldItemDataArray["shops"] = join(" ", $destShopArray[$oldItemId]) ;
		$TBS->LoadTemplate('logic_old_item_row.html');
		$TBS->MergeField('rowdata', $oldItemDataArray); 
		$TBS->Show(TBS_NOTHING);
		$marginArray[$oldItemDataArray["cogs"]][] = $TBS->Source;
	}
	krsort ($marginArray);
	foreach ($marginArray as $contentDataArray) {
		foreach ($contentDataArray as $contentData) {
			$content .= $contentData;
		}
	}
	return $content;
}



//read EUR rate


if (!isset($_GET["projectDir"])) {


	//SORTEX copy
	$uploadedFiles["SORTEX"][]["name"] = array_pop(copyFiles($_FILES["sortex"], $_SESSION["projectDir"]));


	//shop files copy
	foreach ($shopArray as $shopId=>$value) {
		$shopFileNames = copyFiles($_FILES["userFile_".$shopId], $_SESSION["projectDir"]);
		if (is_array($shopFileNames)) {
			foreach ($shopFileNames as $shopFileName) {
				$uploadedFiles[$shopId][]["name"] = $shopFileName;
			}
		}
	}

	//write serialized file list
	writeFileList($uploadedFiles, $uploadsDir, $_SESSION["projectDir"]);
} else {
	//read serialized file list
	$uploadedFiles = readFileList($uploadsDir, $_GET["projectDir"]);
	$_SESSION["projectDir"] = $_GET["projectDir"];
}

$eurRate = readEurRate();
$destShopArray = array();



//make SORTEX arrays
if (($handle = fopen("$uploadsDir/" . $_SESSION["projectDir"] . "/" . $uploadedFiles["SORTEX"][0]["name"], "r")) !== FALSE) {
	$data = fgetcsv($handle, 1000, ";");
	foreach($data as $colNumber => $colName) {
		if ($colName == $sortexIdColName) {
			$idColNumber = $colNumber;
			break;
		}
	}
	while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
		$sortexIdArray[$data[$idColNumber]] = $data;
		$sortexIdListArray[] = $data[$idColNumber];
		$words = explode(" ", $data[6]);
		$sortexNameFirstArray[strtolower($words[0])][] = $data; 
	}
	fclose($handle);
}

//make shop & transl arrays
foreach ($uploadedFiles as $shopId => $filesArray) {
	if ($shopId != "SORTEX" && $filesArray[0]["name"] != ""){
		foreach ($filesArray as $delivFile) {
			parseDeliveryFile ($delivFile, $shopId, $newItemsArray, $oldItemsIdArray, $sortexIdListArray, $shopMasterDeliveryArray, $sortexIdArray);
		}
	}
}

$_SESSION["shopMasterDeliveryArray"] = $shopMasterDeliveryArray;
unset($shopMasterDeliveryArray);




//output new items
$newItemRowContent = genNewItemRows ($newItemsArray, $TBS);
$oldItemRowContent = genOldItemRows ($oldItemsIdArray, $TBS);
$TBS->LoadTemplate('logic_main.html', false);
$TBS->MergeField('newitemrows', $newItemRowContent); 
$TBS->MergeField('olditemrows', $oldItemRowContent); 
$TBS->MergeField('eurrate', $eurRate); 
$TBS->Show();




?>