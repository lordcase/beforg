<?php
//TBS
include_once('tbs_class.php');
include_once('inc/auth_incl.php');
include_once('funclib.php');
  $TBS = new clsTinyButStrong('{,}');


function genShopRows ($shopArray, &$TBS) {
	$content = "";
	foreach ($shopArray as $key => $value) {
		$TBS->LoadTemplate('upload_shoprow.html');
		$list = array("id"=>$key,"name"=>$value);
		$TBS->MergeField('shopdata', $list); 
		$TBS->Show(TBS_NOTHING);
		$content .= $TBS->Source;
	}
	return $content;
}

function genProjectRows ($uploadsDir, &$TBS) {
	$content = "";
	$projectList = getDirTree($uploadsDir . "/");
	foreach ($projectList as $key => $value) {
		if (is_dir($uploadsDir . "/" . $key."/final")) {
			$TBS->LoadTemplate('upload_projecteditlink.html', false);
			$TBS->MergeField('projectdir', $key); 
			$TBS->Show(TBS_NOTHING);
			$sortedProjectList[$key]["edit"] = $TBS->Source;
		}else{
			$sortedProjectList[$key]["edit"] = "";
		}
	}
	krsort($sortedProjectList, SORT_STRING);
	foreach ($sortedProjectList as $key => $value) {
		$projectData["open"] = $key;
		if (is_dir($uploadsDir . "/" . $key."/final")) {
			$TBS->LoadTemplate('upload_projecteditlink.html', false);
			$TBS->MergeField('projectdir', $key); 
			$TBS->Show(TBS_NOTHING);
			$projectData["edit"] = $TBS->Source;
		}else{
			$projectData["edit"] = "";
		}

		$TBS->LoadTemplate('upload_projectrow.html', false);
		$TBS->MergeField('projectdir', $projectData); 
		$TBS->Show(TBS_NOTHING);
		$content .= $TBS->Source;
	}
	return $content;
}
$shopContent = genShopRows ($shopArray, $TBS);
$projectContent = genProjectRows ($uploadsDir, $TBS);
$TBS->LoadTemplate('upload.html', false);
$TBS->MergeField('shoprows', $shopContent); 
$TBS->MergeField('projectrows', $projectContent); 
$TBS->Show();





?>