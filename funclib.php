<?php

//Functions library

//read EUR rate from file
function readEurRate () {
	global $uploadsDir;
	return file_get_contents("$uploadsDir/" . $_SESSION["projectDir"] . "/eurrate.txt");
}

// store serialized file list function
function writeFileList($fileList, $uploadsDir, $projectDir) {
	$handler = fopen($uploadsDir . "/" . $projectDir . "/filelist.txt", "w");
	fwrite ( $handler , serialize($fileList));
	fclose($handler);
}

// read and unserialize file list function
function readFileList($uploadsDir, $projectDir) {
	return unserialize(file_get_contents("$uploadsDir/" . $projectDir . "/filelist.txt"));
}

// directory tree collector
function getDirTree($dir,$p=true) {
	$d = dir($dir);$x=array();
	while (false !== ($r = $d->read())) {
		if($r!="."&&$r!=".."&&(($p==false&&is_dir($dir.$r))||$p==true)) {
			$x[$r] = (is_dir($dir.$r)?array():(is_file($dir.$r)?true:false));
		}
	}
	return $x;
}

// 
function getFilesByExtension($dir) {
	$d = dir($dir);
	$sortedFileList = array();
	while (false !== ($r = $d->read())) {
		if($r!="."&&$r!="..") {
			$ext = substr(strrchr($r, "."), 1);
			$sortedFileList[$ext][] = $r;
		}
	}
	return $sortedFileList;
}
function sortUpperLowerWords ($string) {
	$wordsArr = explode (" ", $string);
	foreach ($wordsArr as $word) {
		if ($flag != "f" && strtoupper($word) == $word && $word != " " && strlen($word)>1) {
			$sortedWords["upper"][] = $word;
		} else {
			$sortedWords["lower"][] = $word;
			$flag = "f";
		}
	}
	return $sortedWords;
}
?>