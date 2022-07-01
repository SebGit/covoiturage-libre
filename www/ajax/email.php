<?php
// anti-CSRF token
session_start();

if (isset($_POST) && !empty($_POST)) {
	if (!isset($_POST['token']) || !isset($_SESSION['cvtokenm'])) {
		echo 1;
		die();
	}
	if ($_POST['token'] !== $_SESSION['cvtokenm']) {
		echo 1;
		die();
	}
}

require_once("../ScriptLibrary/form_functions.php");
$myToken = getTokenM(); 

require_once('../Connections/bddcovoiturette.php');
require_once('../ScriptLibrary/class.phpmailer.php');

if (!function_exists("GetSQLValueString")) {
	function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
	{
	  if (PHP_VERSION < 6) {
		$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
	  }
	
	  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
	  return $theValue;
	}
}

if (isset($_POST['c'])) {

$colname_RSannonce = $_POST['c'];
mysql_select_db($database_bddcovoiturette, $bddcovoiturette);
$query_RSannonce = sprintf("SELECT *, date_format(trajets.DATE_PARCOURS, '%%d/%%m/%%Y') as DATE_FR FROM trajets WHERE CODE_CREATION = '%s'", GetSQLValueString($colname_RSannonce, "text"));
$RSannonce = mysqli_query($bddcovoiturette ,$query_RSannonce) or die(mysql_error());
$row_RSannonce = mysql_fetch_assoc($RSannonce);
$totalRows_RSannonce = mysql_num_rows($RSannonce);

switch($_POST['dep']){
	case 'pri':
		$depart = $row_RSannonce['DEPART'];
		break;
	
	case 'eta1':
		$depart = $row_RSannonce['ETAPE1'];
		break;
	
	case 'eta2':
		$depart = $row_RSannonce['ETAPE2'];
		break;
	
	case 'eta3':
		$depart = $row_RSannonce['ETAPE3'];
		break;
}
switch($_POST['arr']){
	case 'pri':
		$arrivee = $row_RSannonce['ARRIVEE'];
		break;
	
	case 'eta1':
		$arrivee = $row_RSannonce['ETAPE1'];
		break;
	
	case 'eta2':
		$arrivee = $row_RSannonce['ETAPE2'];
		break;
	
	case 'eta3':
		$arrivee = $row_RSannonce['ETAPE3'];
		break;
}
// lien annonce
$lien_annonce = "http://www.covoiturage-libre.fr/detail.php?c=" . $colname_RSannonce . "&p=" . $_POST['arr'] . "&depart=" . $_POST['dep'];
//

$to			= $row_RSannonce['EMAIL'];
$from		= GetSQLValueString($_POST['email'], "text");
$from_name	= GetSQLValueString($_POST['nom'], "text");
$objet		= "Covoiturage-libre.fr - Nouveau message";
	
$message = '
<html>
	<body>
		<table width="750" border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td width="260" valign="top"><img src="http://www.covoiturage-libre.fr/images/logo-email.jpg" alt="" width="250" height="200" /></td>
		<td valign="top">
			<font face="arial" size="2" color="#444444">
			<p>Trajet <strong>'.$depart.'</strong> -> <strong>'.$arrivee.'</strong>, le '.$row_RSannonce['DATE_FR'].'</p>
			
			<p>Un message vous a �t� envoy� de la part de ' . utf8_decode($from_name) .' ('.$from.') : </p>
			'.nl2br(utf8_decode($_POST['msg'])).
			'
			<p><a href="' . $lien_annonce . '"><font color="#83BE54">Revoir votre annonce.</font></a></p>
			</font>
		</td>
		</tr>
		</table>
	</body>
</html>';

$mail = new PHPMailer();
$mail->From = $from;
$mail->FromName = $from_name;
$mail->Subject =$objet;
$mail->AddAddress($to);
$mail->MsgHTML($message);
if ($mail->Send()) {
	$erreur = $myToken;
} else {
	$erreur = 1;
}

mysql_free_result($RSannonce);

echo $erreur;
}
?>