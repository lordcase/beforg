<?php
/**
 * Export to PHP Array plugin for PHPMyAdmin
 * @version 0.2b
 */

//
// Database `ashley_neweywebsite`
//
function password($length) {
        $iteration = 0;
        $password = "";
        $randomNumber;
        if($special == undefined){
            $special = false;
        }
        while($iteration < $length){
            $randomNumber = (floor(rand() * 100) % 94) + 33;
            if(!$special){
                if (($randomNumber >=33) && ($randomNumber <=47)) { continue; }
                if (($randomNumber >=58) && ($randomNumber <=64)) { continue; }
                if (($randomNumber >=91) && ($randomNumber <=96)) { continue; }
                if (($randomNumber >=123) && ($randomNumber <=126)) { continue; }
            }
            $iteration++;
            $password .= chr($randomNumber);
        }
        return $password;
}
// `ashley_neweywebsite`.`andev_postmeta`
$andev_postmeta = array(
  array('meta_id' => '9879','post_id' => '690','meta_key' => 'dates_1_date_id','meta_value' => ''),
  array('meta_id' => '10201','post_id' => '708','meta_key' => 'dates_2_date_id','meta_value' => ''),
  array('meta_id' => '10207','post_id' => '708','meta_key' => 'dates_3_date_id','meta_value' => ''),
  array('meta_id' => '10989','post_id' => '753','meta_key' => 'dates_0_date_id','meta_value' => ''),
  array('meta_id' => '10995','post_id' => '753','meta_key' => 'dates_1_date_id','meta_value' => ''),
  array('meta_id' => '11001','post_id' => '753','meta_key' => 'dates_2_date_id','meta_value' => ''),
  array('meta_id' => '11095','post_id' => '761','meta_key' => 'dates_0_date_id','meta_value' => ''),
  array('meta_id' => '11217','post_id' => '768','meta_key' => 'dates_4_date_id','meta_value' => ''),
  array('meta_id' => '11514','post_id' => '777','meta_key' => 'dates_1_date_id','meta_value' => ''),
  array('meta_id' => '11622','post_id' => '787','meta_key' => 'dates_0_date_id','meta_value' => ''),
  array('meta_id' => '11785','post_id' => '796','meta_key' => 'dates_1_date_id','meta_value' => ''),
  array('meta_id' => '11955','post_id' => '816','meta_key' => 'dates_2_date_id','meta_value' => ''),
  array('meta_id' => '12052','post_id' => '822','meta_key' => 'dates_1_date_id','meta_value' => ''),
  array('meta_id' => '12547','post_id' => '854','meta_key' => 'dates_6_date_id','meta_value' => ''),
  array('meta_id' => '12611','post_id' => '861','meta_key' => 'dates_4_date_id','meta_value' => ''),
  array('meta_id' => '12685','post_id' => '859','meta_key' => 'dates_4_date_id','meta_value' => ''),
  array('meta_id' => '13020','post_id' => '871','meta_key' => 'dates_2_date_id','meta_value' => ''),
  array('meta_id' => '13138','post_id' => '879','meta_key' => 'dates_1_date_id','meta_value' => ''),
  array('meta_id' => '13887','post_id' => '927','meta_key' => 'dates_0_date_id','meta_value' => ''),
  array('meta_id' => '13977','post_id' => '931','meta_key' => 'dates_0_date_id','meta_value' => ''),
  array('meta_id' => '15377','post_id' => '690','meta_key' => 'dates_2_date_id','meta_value' => ''),
  array('meta_id' => '15383','post_id' => '690','meta_key' => 'dates_3_date_id','meta_value' => ''),
  array('meta_id' => '15416','post_id' => '708','meta_key' => 'dates_5_date_id','meta_value' => ''),
  array('meta_id' => '15503','post_id' => '761','meta_key' => 'dates_1_date_id','meta_value' => ''),
  array('meta_id' => '15518','post_id' => '768','meta_key' => 'dates_5_date_id','meta_value' => ''),
  array('meta_id' => '15793','post_id' => '1061','meta_key' => 'dates_0_date_id','meta_value' => ''),
  array('meta_id' => '25112','post_id' => '1530','meta_key' => 'dates_0_date_id','meta_value' => ''),
  array('meta_id' => '25160','post_id' => '1531','meta_key' => 'dates_0_date_id','meta_value' => ''),
  array('meta_id' => '25590','post_id' => '1542','meta_key' => 'dates_1_date_id','meta_value' => ''),
  array('meta_id' => '25660','post_id' => '1543','meta_key' => 'dates_2_date_id','meta_value' => ''),
  array('meta_id' => '25832','post_id' => '1546','meta_key' => 'dates_4_date_id','meta_value' => ''),
  array('meta_id' => '25929','post_id' => '1549','meta_key' => 'dates_6_date_id','meta_value' => ''),
  array('meta_id' => '26139','post_id' => '1554','meta_key' => 'dates_1_date_id','meta_value' => ''),
  array('meta_id' => '26211','post_id' => '1555','meta_key' => 'dates_2_date_id','meta_value' => ''),
  array('meta_id' => '26259','post_id' => '1556','meta_key' => 'dates_1_date_id','meta_value' => ''),
  array('meta_id' => '26351','post_id' => '1558','meta_key' => 'dates_1_date_id','meta_value' => ''),
  array('meta_id' => '26493','post_id' => '1560','meta_key' => 'dates_4_date_id','meta_value' => ''),
  array('meta_id' => '26499','post_id' => '1560','meta_key' => 'dates_5_date_id','meta_value' => ''),
  array('meta_id' => '26535','post_id' => '1561','meta_key' => 'dates_0_date_id','meta_value' => ''),
  array('meta_id' => '26541','post_id' => '1561','meta_key' => 'dates_1_date_id','meta_value' => ''),
  array('meta_id' => '26581','post_id' => '1562','meta_key' => 'dates_0_date_id','meta_value' => ''),
  array('meta_id' => '26593','post_id' => '1562','meta_key' => 'dates_2_date_id','meta_value' => ''),
  array('meta_id' => '26599','post_id' => '1562','meta_key' => 'dates_3_date_id','meta_value' => ''),
  array('meta_id' => '26611','post_id' => '1562','meta_key' => 'dates_5_date_id','meta_value' => ''),
  array('meta_id' => '26617','post_id' => '1562','meta_key' => 'dates_6_date_id','meta_value' => ''),
  array('meta_id' => '26623','post_id' => '1562','meta_key' => 'dates_7_date_id','meta_value' => ''),
  array('meta_id' => '26629','post_id' => '1562','meta_key' => 'dates_8_date_id','meta_value' => ''),
  array('meta_id' => '26635','post_id' => '1562','meta_key' => 'dates_9_date_id','meta_value' => ''),
  array('meta_id' => '26997','post_id' => '1569','meta_key' => 'dates_2_date_id','meta_value' => ''),
  array('meta_id' => '27003','post_id' => '1569','meta_key' => 'dates_3_date_id','meta_value' => ''),
  array('meta_id' => '27015','post_id' => '1569','meta_key' => 'dates_5_date_id','meta_value' => ''),
  array('meta_id' => '27143','post_id' => '1572','meta_key' => 'dates_1_date_id','meta_value' => ''),
  array('meta_id' => '27149','post_id' => '1572','meta_key' => 'dates_2_date_id','meta_value' => ''),
  array('meta_id' => '27155','post_id' => '1572','meta_key' => 'dates_3_date_id','meta_value' => ''),
  array('meta_id' => '27183','post_id' => '1573','meta_key' => 'dates_0_date_id','meta_value' => ''),
  array('meta_id' => '33540','post_id' => '1911','meta_key' => 'dates_0_date_id','meta_value' => ''),
  array('meta_id' => '33552','post_id' => '1911','meta_key' => 'dates_2_date_id','meta_value' => ''),
  array('meta_id' => '33558','post_id' => '1911','meta_key' => 'dates_3_date_id','meta_value' => ''),
  array('meta_id' => '33665','post_id' => '1913','meta_key' => 'dates_0_date_id','meta_value' => ''),
  array('meta_id' => '33677','post_id' => '1913','meta_key' => 'dates_2_date_id','meta_value' => ''),
  array('meta_id' => '33683','post_id' => '1913','meta_key' => 'dates_3_date_id','meta_value' => ''),
  array('meta_id' => '33695','post_id' => '1913','meta_key' => 'dates_5_date_id','meta_value' => ''),
  array('meta_id' => '33701','post_id' => '1913','meta_key' => 'dates_6_date_id','meta_value' => ''),
  array('meta_id' => '33743','post_id' => '1916','meta_key' => 'dates_0_date_id','meta_value' => ''),
  array('meta_id' => '33755','post_id' => '1916','meta_key' => 'dates_2_date_id','meta_value' => ''),
  array('meta_id' => '33761','post_id' => '1916','meta_key' => 'dates_3_date_id','meta_value' => ''),
  array('meta_id' => '33773','post_id' => '1916','meta_key' => 'dates_5_date_id','meta_value' => ''),
  array('meta_id' => '33779','post_id' => '1916','meta_key' => 'dates_6_date_id','meta_value' => ''),
  array('meta_id' => '33817','post_id' => '1917','meta_key' => 'dates_0_date_id','meta_value' => ''),
  array('meta_id' => '33823','post_id' => '1917','meta_key' => 'dates_1_date_id','meta_value' => ''),
  array('meta_id' => '33829','post_id' => '1917','meta_key' => 'dates_2_date_id','meta_value' => ''),
  array('meta_id' => '36313','post_id' => '2001','meta_key' => 'dates_2_date_id','meta_value' => ''),
  array('meta_id' => '36343','post_id' => '2001','meta_key' => 'dates_7_date_id','meta_value' => ''),
  array('meta_id' => '36409','post_id' => '1998','meta_key' => 'dates_2_date_id','meta_value' => ''),
  array('meta_id' => '36439','post_id' => '1998','meta_key' => 'dates_7_date_id','meta_value' => ''),
  array('meta_id' => '36931','post_id' => '2011','meta_key' => 'dates_6_date_id','meta_value' => ''),
  array('meta_id' => '46061','post_id' => '2251','meta_key' => 'dates_13_date_id','meta_value' => ''),
  array('meta_id' => '48028','post_id' => '2314','meta_key' => 'dates_3_date_id','meta_value' => ''),
  array('meta_id' => '51939','post_id' => '2477','meta_key' => 'dates_0_date_id','meta_value' => ''),
  array('meta_id' => '52064','post_id' => '2479','meta_key' => 'dates_0_date_id','meta_value' => ''),
  array('meta_id' => '53273','post_id' => '2504','meta_key' => 'dates_4_date_id','meta_value' => ''),
  array('meta_id' => '53398','post_id' => '2506','meta_key' => 'dates_4_date_id','meta_value' => ''),
  array('meta_id' => '54798','post_id' => '2536','meta_key' => 'dates_4_date_id','meta_value' => ''),
  array('meta_id' => '55296','post_id' => '2544','meta_key' => 'dates_0_date_id','meta_value' => ''),
  array('meta_id' => '55415','post_id' => '2552','meta_key' => 'dates_1_date_id','meta_value' => ''),
  array('meta_id' => '55435','post_id' => '2552','meta_key' => 'dates_2_date_id','meta_value' => ''),
  array('meta_id' => '55476','post_id' => '2554','meta_key' => 'dates_1_date_id','meta_value' => ''),
  array('meta_id' => '55482','post_id' => '2554','meta_key' => 'dates_2_date_id','meta_value' => ''),
  array('meta_id' => '58178','post_id' => '2657','meta_key' => 'dates_1_date_id','meta_value' => ''),
  array('meta_id' => '58211','post_id' => '2655','meta_key' => 'dates_1_date_id','meta_value' => ''),
  array('meta_id' => '61657','post_id' => '2814','meta_key' => 'dates_1_date_id','meta_value' => ''),
  array('meta_id' => '61718','post_id' => '2816','meta_key' => 'dates_1_date_id','meta_value' => ''),
  array('meta_id' => '64278','post_id' => '2969','meta_key' => 'dates_2_date_id','meta_value' => ''),
  array('meta_id' => '64867','post_id' => '1911','meta_key' => 'dates_5_date_id','meta_value' => ''),
  array('meta_id' => '64873','post_id' => '1911','meta_key' => 'dates_6_date_id','meta_value' => ''),
  array('meta_id' => '65057','post_id' => '3028','meta_key' => 'dates_0_date_id','meta_value' => ''),
  array('meta_id' => '65111','post_id' => '3026','meta_key' => 'dates_0_date_id','meta_value' => ''),
  array('meta_id' => '65590','post_id' => '3041','meta_key' => 'dates_1_date_id','meta_value' => ''),
  array('meta_id' => '65843','post_id' => '3071','meta_key' => 'dates_1_date_id','meta_value' => ''),
  array('meta_id' => '65904','post_id' => '3072','meta_key' => 'dates_1_date_id','meta_value' => '')
);

foreach ($andev_postmeta as $row) {
	$currPwd = password(25);
	echo 'update andev_postmeta set meta_value="' . $currPwd . '" where meta_id =' . $row["meta_id"] . ';<br />';
}



?>
