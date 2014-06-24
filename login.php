<?php

//TBS
include_once('tbs_class.php');
  $TBS = new clsTinyButStrong('{,}');

    session_start(); // starting session
	// session variables must be global
    
    // checking if user is not authenticated
    if (!isset($_SESSION["strName"]) || md5("asdf") != $_SESSION["hashPassword"])
    {
        if (isset($_POST["form_username"]))
        {
            $_SESSION["strName"] = $_POST["form_username"];
            $_SESSION["hashPassword"] = md5($_POST["form_password"]);
			session_write_close();
            header("Location: login.php?".SID);
            exit;
        }

			session_write_close();
$TBS->LoadTemplate('login.html');
$TBS->Show();

    }
        
            header("Location: upload.php");
?>