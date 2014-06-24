<?php

include_once('../funclib.php');

function preprint($s, $return=false) { 
    $x = "<pre>"; 
    $x .= print_r($s, 1); 
    $x .= "</pre>"; 
    if ($return) return $x; 
    else print $x; 
} 


preprint($_FILES);
preprint($_POST);
//phpinfo();
/*
$uploaddir = realpath('./') . '/';
$uploadfile = $uploaddir . basename($_FILES['file_contents']['name']);
echo '<pre>';
	if (move_uploaded_file($_FILES['file_contents']['tmp_name'], $uploadfile)) {
	    echo "File is valid, and was successfully uploaded.\n";
	} else {
	    echo "Possible file upload attack!\n";
	}
	echo 'Here is some more debugging info:';
	print_r($_FILES);
	echo "\n<hr />\n";
	print_r($_POST);
print "</pr" . "e>\n";
*/
?>