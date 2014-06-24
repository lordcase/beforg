<?php
include_once('funclib.php');
include_once('inc/auth_incl.php');

echo "vvv";

$dir = $_GET["mDir"];

$dh = opendir($dir);

while (($file = readdir($dh)) !== false) {
	$filelist[] = $file;
}

closedir($dh);



$ii = 1;
foreach ($filelist as $filename) {
	while (($handle = fopen("$dir/" . $filename, "r")) !== FALSE) {
		$data = fgetcsv($handle, 1000, ";");
		$article[$data[3]] = join (";", $data);
		echo $article[$data[3]] . "<br>";
		print_r($data);
		if ($ii++ == 20) {
			die("argh");
		}
	}
	fclose($handle);
}

//$fp = fopen('merge/result.csv', 'w');
//fclose($fp);


?>