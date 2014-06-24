<?php
    session_start(); // starting session
    // checking if user is not authenticated
    
    if (!isset($_SESSION["strName"]) || md5("buti") != $_SESSION["hashPassword"])
    {
        // redirecting user to the login page
       header("Location: crmlogin.php");
// 	       exit;
    }


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