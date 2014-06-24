<?php

//TBS
include_once('tbs_class.php');
include_once('funclib.php');
include_once('inc/auth_incl.php');
  $TBS = new clsTinyButStrong('{,}');



// shop master file parser function
function parseShopMasterFile ($fileName, &$TBS){
	global $uploadsDir;
	$rowCount = 0;
	$content = "";
	if (($handle = fopen("$uploadsDir/" . $_SESSION["projectDir"] . "/final/" . $fileName, "r")) !== FALSE) {

		//remove header
		$data = fgetcsv($handle, 1000, ";");
		$TBS->LoadTemplate('edit_itemhead.html', false);
		$TBS->MergeField('itemdata', $data); 
		$TBS->Show(TBS_NOTHING);
		$content .= $TBS->Source;

		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
			$data[8] = str_replace(",", ".", $data[8]);
			$data[9] = str_replace(",", ".", $data[9]);
			$TBS->LoadTemplate('edit_itemrow.html', false);
			$TBS->MergeField('itemdata', $data); 
			$TBS->MergeField('rowcount', $rowCount++); 
			$TBS->Show(TBS_NOTHING);
			$content .= $TBS->Source;
		}
		fclose($handle);
	}
	return $content;
}

$content = parseShopMasterFile ($_GET["fileName"], $TBS);
$TBS->LoadTemplate('edit_main.html', false);
$TBS->MergeField('content', $content); 
$TBS->MergeField('filename', $_GET["fileName"]); 
$TBS->Show();

?>