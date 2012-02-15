<?php
if (!isset($_GET['debut']) or empty($_GET['debut'])) {
	die();
}

$pays = 'FR';
$Pays = array('FR', 'DE', 'BE', 'IT', 'CH');
if (!empty($_GET['pays']) && in_array($_GET['pays'], $Pays)) {
	$pays = $_GET['pays'];
}

require_once('../../Connections/bddcovoiturette.php');
mysql_select_db($database_bddcovoiturette, $bddcovoiturette);

$ville = mysql_real_escape_string(stripslashes($_GET['debut']));

$query = "SELECT commune as ville, cpostal FROM `villes_ws` WHERE PAYS = '" .$pays . "' AND  commune LIKE '" . $ville . "%' LIMIT 20";
$RSvilles = mysql_query($query, $bddcovoiturette) or die(mysql_error());

$totalVilles = mysql_num_rows($RSvilles);
$xmlstr = '<?xml version="1.0" encoding="UTF-8"?>';
if ($totalVilles > 0) {
	$xmlstr .= '<villes>';
	while ($row_RSvilles = mysql_fetch_assoc($RSvilles)) {
		$xmlstr .= '<ville name="' . utf8_encode($row_RSvilles['ville']) . '" cp="' . utf8_encode($row_RSvilles['cpostal']) . '" />';
	}	
	mysql_free_result($RSvilles);
	
	$xmlstr .= '</villes>';
	
	
} else {
	$xmlstr .= '<villes/>';
}

header("Content-Type: text/xml");
echo $xmlstr;
?>