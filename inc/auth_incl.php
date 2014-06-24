<?php
    session_start(); // starting session

    // checking if user is not authenticated
    if (!isset($_SESSION["strName"]) || md5("asdf") != $_SESSION["hashPassword"])
    {
        // redirecting user to the login page
        header("Location: login.php");
        exit;
    }
$uploadsDir = '/home/sites/beforg.butlers.hu/webroot/uploads';
$delivIdColName = "Artikel";
$sortexIdColName = "artikel";

$shopArray = Array(
	"ark" => "Árkád",
	"mom" => "MOM",
	"mmt" => "Mammut",
	"crv" => "Corvin",
	"pcs" => "Pécs",
	"arn" => "Aréna",
	"wnd" => "Westend",
	"web" => "Webshop",
	"mbl" => "Butor"
	);

if (!function_exists("preprint")) { 
    function preprint($s, $return=false) { 
        $x = "<pre>"; 
        $x .= print_r($s, 1); 
        $x .= "</pre>"; 
        if ($return) return $x; 
        else print $x; 
    } 
} 

?>