<?php
//TBS
include_once('tbs_class.php');
include_once('funclib.php');
include_once('inc/crm_auth_inc.php');
  $TBS = new clsTinyButStrong('{,}');
?>  
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title>UPDATE</title>
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <meta http-equiv="Content-Type" content="text/html; charset=ISO 8859-2" /> 
  <meta http-equiv="refresh" content="600">
  <style type="text/css">
  .buttonsub {
     
    /*Step 2: Basic Button Styles*/
    display: block;
    height: 100px;
    width: 350px;
    background: #34696f;
    border: 2px solid rgba(33, 68, 72, 0.59);
     
    /*Step 3: Text Styles*/
    color: rgba(0, 0, 0, 0.55);
    text-align: center;
    font: bold 3.2em/100px "Helvetica Neue", Arial, Helvetica, Geneva, sans-serif;
     
    /*Step 4: Fancy CSS3 Styles*/
     
     
    text-shadow: 0 2px 2px rgba(255, 255, 255, 0.2);
     
}
 
/*Step 3: Link Styling*/
a.buttonsub {
    text-decoration: none;
}

a.buttonsub:hover {
    background: #3d7a80;
    background: -webkit-linear-gradient(top, #3d7a80, #2f5f63);
    background: -moz-linear-gradient(top, #3d7a80, #2f5f63);
    background: -o-linear-gradient(top, #3d7a80, #2f5f63);
    background: -ms-linear-gradient(top, #3d7a80, #2f5f63);
    background: linear-gradient(top, #3d7a80, #2f5f63);
}
  .buttoncanc {
     
    /*Step 2: Basic Button Styles*/
    display: block;
    height: 60px;
    width: 250px;
    background: #f54646;
    border: 2px solid rgba(33, 68, 72, 0.59);
     
    /*Step 3: Text Styles*/
    color: rgba(0, 0, 0, 0.55);
    text-align: center;
    font: bold 1.0em/60px "Helvetica Neue", Arial, Helvetica, Geneva, sans-serif;
     
    /*Step 4: Fancy CSS3 Styles*/
     
     
    text-shadow: 0 2px 2px rgba(255, 255, 255, 0.2);
     
}
 
/*Step 3: Link Styling*/
a.buttoncanc {
    text-decoration: none;
}

a.buttoncanc:hover {
    background: #fb1345;
    background: -webkit-linear-gradient(top, #fb1345, #9f1120);
    background: -moz-linear-gradient(top, #fb1345, #9f1120);
    background: -o-linear-gradient(top, #fb1345, #9f1120);
    background: -ms-linear-gradient(top, #fb1345, #9f1120);
    background: linear-gradient(top, #fb1345, #9f1120);
}
</style>
 </head>

 <body>
<?php
if (isset($_GET["showres"])) {

	if (($handle = fopen("crm/crm_purchases.csv", "r")) !== FALSE) {
		$data = fgetcsv($handle, 1000, ";");
		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
			$purchases[$data[0]][$data[1]] = $data;
		}
	}else{
		echo "shit";
	}

	$link = mysql_connect('db01.ruffnet.local', 'c560beforg', 'PwD0UM6oVZYn') or die('Could not connect: ' . mysql_error());
	mysql_select_db('c560beforg') or die('Could not select database');
	if (isset($_GET["orderby"])) {
		$orderBy = $_GET["orderby"];
	}else{
		$orderBy = "edited";
	}
	$query = 'SELECT * FROM crm_xmas WHERE status="FELHASZNALVA" order by ' . $orderBy;
	$result = mysql_query($query) or die('Query failed: ' . mysql_error());
?>		
				<table border="0"><tr><td>
					<table border="1"><tr><td>No</td><td>ID</td><td>Név</td><td>Kártyaszám</td><td></td><td>%</td><td>Státusz</td><td>Szegmens</td><td></td>
					<td><a href="crm.php?showres=1&orderby=edited">Idöpont</a></td>
					<td><a href="crm.php?showres=1&orderby=extra">Bolt</a></td><td>db</td><td>Pontok</td>
					<td>Költés</td><td>TRID</td></tr>

<?php
	while ($line = mysql_fetch_array($result, MYSQL_ASSOC)){
		$category[$line["segment"]]++;
		$shop[$line["extra"]]++;
		$purchase = array_shift($purchases[$line["cardno"]]);
		$totalPurchase += $purchase[4];
		echo "<tr><td>".++$counter."</td><td>".join("</td><td>", $line)."</td><td>".count($purchases[$line["cardno"]])."</td><td>".$purchase[2]."</td><td>".$purchase[4]."</td><td>".$purchase[1]."</td></tr>";
	}
	
	?>		
				</table></td><td valign="top">
				<table border=1>

<?php
echo "<tr><td colspan='2'>Kategória bontás:</td></tr>";
foreach ($category as $key=>$value) {
	echo "<tr><td>".$key."</td><td>".$value."</td></tr>";
}
echo "</table><br /><br />";
echo "<table border=1>";
echo "<tr><td colspan='2'>Bolti bontás:</td></tr>";
foreach ($shop as $key=>$value) {
	echo "<tr><td>".$key."</td><td>".$value."</td></tr>";
}
echo "</table><br /><br />";
echo "Totál vásárlások: " . $totalPurchase . " Ft";
echo "<br /><br /><a href='#alja'>UGRÁS AZ ALJÁRA</a></td></tr><tr><td><a name='alja'> </a></td><td><a href='#top'>UGRÁS A TETEJÉRE</a></td></tr></table>";
die();	
}


if (isset($_GET["cardno"])) {
	
	$link = mysql_connect('db01.ruffnet.local', 'c560beforg', 'PwD0UM6oVZYn') or die('Could not connect: ' . mysql_error());
	mysql_select_db('c560beforg') or die('Could not select database');
	
	if (!isset($_GET["newstatus"])) {
	
		$query = 'SELECT * FROM crm_xmas WHERE cardno="' . $_GET['cardno'] . '"';
		$result = mysql_query($query) or die('Query failed: ' . mysql_error());
		$line = mysql_fetch_array($result, MYSQL_ASSOC);
?>		
				<table border="1">
					<tr>
						<td bgcolor="#bbbbbb">Azonosító:</td>
						<td><?php echo $line["id"]?></td>
						<td rowspan="3" bgcolor="#ff7777"><font size='15'>Engedmény:</font></td>
						<td rowspan="3" bgcolor="#ff7777"><font size='15'><?php echo $line["reward"]?></font></td>
					</tr>
					<tr>
						<td bgcolor="#bbbbbb">Név:</td>
						<td><?php echo $line["name"]?></td>
					</tr>
					<tr>
						<td bgcolor="#bbbbbb">Kártyaszám:</td>
						<td><?php echo $line["cardno"]?></td>
					</tr>
					<tr>
						<td bgcolor="#bbbbbb">Státusz:</td>
						<td><?php echo $line["status"]?></td>
						<td rowspan="5" bgcolor="#ffdddd"></td>
						<td rowspan="5" bgcolor="#ffdddd"><?php echo $line["akcio"]?></td>
					</tr>
					<tr>
						<td bgcolor="#bbbbbb">Szegmens:</td>
						<td><?php echo $line["segment"]?></td>
					</tr>
					<tr>
						<td bgcolor="#bbbbbb">Megjegyzés:</td>
						<td><?php echo $line["comment"]?></td>
					</tr>
					<tr>
						<td bgcolor="#bbbbbb">Módosítva:</td>
						<td><?php echo $line["edited"]?></td>
					</tr>
					<tr>
						<td bgcolor="#bbbbbb">Bolt:</td>
						<td><?php echo $line["extra"]?></td>
					</tr>
				</table>
				<form enctype="multipart/form-data" action="crm.php" method="GET" id="mainform">
				<br />
				<br />
				<br />
				<br />
				<div align="center">
<?php
		if ($line["status"] != "FELHASZNÁLVA") {
?>
				<input type="hidden" name="cardno" value="<?php echo $_GET['cardno'];?>" /> 
				Megjegyzés: <input type="text" name="comment" size="20" />
				<br />
				<br />
				<input type="hidden" name="newstatus" value="FELHASZNÁLVA" /> 
				<a href="#" onclick="document.getElementById('mainform').submit();return false;" class="buttonsub" id="used">Felhasználva</a>
<!--				<input type="submit" value="FELHASZNÁLVA" / id="used">-->
				<br />
				<br />
				<br />
				<a href="crm.php" class="buttoncanc">Mégsem, Új beolvasás</a>
				<br />
				<a href="crmlogout.php">Kijelentkezés</a>
				<br />

				<br />
				
<?php
		} else {
			echo "<font color='#ff0000' size='20'>FELHASZNÁLVA!!!!</font><br /><br /><br />";
			echo '<a href="crm.php">Új beolvasás</a><br /><a href="crmlogout.php">Kijelentkezés</a>';
		}
?>
				</div>
				<script>
				document.getElementById('used').focus();
				</script>

<?php
		die();
	}else{
		$query = 'UPDATE crm_xmas SET status = "' . $_GET['newstatus'] . '", comment ="' . $_GET['comment'] . '", extra="' . $_SESSION["strName"] . '" WHERE cardno="' . $_GET['cardno'] . '"';
		$result = mysql_query($query) or die('Query failed: ' . mysql_error());
		echo "ADATOK FELÍRVA";
	}
	
} 
?>	

				<form enctype="multipart/form-data" action="crm.php" method="GET" onsubmit="return validateForm ();">
				<br />
				<br />
				<br />
				<br />
				<div align="center">
				Hüségkártya száma:
						<input type="text" name="cardno" size="20" id="cardno" />
						<input type="submit" value="Keres" />
				</div>
				<script>
				document.getElementById('cardno').focus();
				</script>
<?php





mysql_close($link);

?>