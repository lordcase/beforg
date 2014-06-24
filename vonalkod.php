<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> Vonalkód generátor </title>
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 

 </head>

 <body>

<form method="GET" action="vonalkod.php" id="dataform">

Azonosító:<br />
<input type="text" name="id"><br />
Jelszó:<br />
<input type="password" name="pass"><br />
<br />
<input type="submit" value="Elküld">
</form>
<br /><br />
<?php

function ean13_check_digit($digits){
//first change digits to a string so that we can access individual numbers
$digits =(string)$digits;
// 1. Add the values of the digits in the even-numbered positions: 2, 4, 6, etc.
$even_sum = $digits{1} + $digits{3} + $digits{5} + $digits{7} + $digits{9} + $digits{11};
// 2. Multiply this result by 3.
$even_sum_three = $even_sum * 3;
// 3. Add the values of the digits in the odd-numbered positions: 1, 3, 5, etc.
$odd_sum = $digits{0} + $digits{2} + $digits{4} + $digits{6} + $digits{8} + $digits{10};
// 4. Sum the results of steps 2 and 3.
$total_sum = $even_sum_three + $odd_sum;
// 5. The check character is the smallest number which, when added to the result in step 4,  produces a multiple of 10.
$next_ten = (ceil($total_sum/10))*10;
$check_digit = $next_ten - $total_sum;
return $digits . $check_digit;
}

function changePass ($pass) {
	$pass =(string)$pass;
	for ($i = 0; $i<6;$i++) {
		if ($pass{$i} > 1) {
			$pass{$i} = $pass{$i} - 2;
		}else{
			$pass{$i} = $pass{$i} + 8;
		}
	}
	return $pass;
	
}

if (isset($_GET["id"])) {
	echo "Az elkészült vonalkód:<br /><a href='http://www.barcoderobot.com/ean-13/" . ean13_check_digit("20" . $_GET["id"] . changePass($_GET["pass"])) . "'>" . ean13_check_digit("201" . $_GET["id"] . changePass($_GET["pass"])) 
	."</a>";

}

?>


 </body>
</html>

