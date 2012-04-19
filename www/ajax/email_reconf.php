<?php
// anti-CSRF token
session_start();

if (isset($_POST) && !empty($_POST)) {
	if (!isset($_POST['token']) || !isset($_SESSION['cvtokenmrcf'])) {
		echo 1;
		die();
	}
	if ($_POST['token'] !== $_SESSION['cvtokenmrcf']) {
		echo 1;
		die();
	}
	$cryptinstall="../crypt/cryptographp.fct.php";
	require($cryptinstall); 
	if (!chk_crypt($_POST['code']) )  {
		echo 1;
		die();
	}
}

require_once("../ScriptLibrary/form_functions.php");
$myToken = getTokenMRCF(); 

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
$query_RSannonce = sprintf("SELECT * FROM trajets WHERE CODE_CREATION = '%s'", GetSQLValueString($colname_RSannonce, "text"));
$RSannonce = mysql_query($query_RSannonce, $bddcovoiturette) or die(mysql_error());
$row_RSannonce = mysql_fetch_assoc($RSannonce);
$totalRows_RSannonce = mysql_num_rows($RSannonce);

$sqldate = $row_RSannonce['DATE_PARCOURS'];

(preg_match("/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/", $sqldate, $regs));
$jour = array("Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi"); 
$mois = array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
$datefr = $jour[date("w",mktime(0, 0, 0, $regs[2], $regs[3], $regs[1]))];
$datefr .= " ".date("d",mktime(0, 0, 0, $regs[2], $regs[3], $regs[1]));
$datefr .= " ".$mois[date("n",mktime(0, 0, 0, $regs[2], $regs[3], $regs[1]))];
$datefr .= " ".date("Y",mktime(0, 0, 0, $regs[2], $regs[3], $regs[1])); 

//
$email_code = sha1($row_RSannonce['EMAIL'] . "_covoiturette2353");
$lien_ret = "nouveau.php?c=" . $row_RSannonce['CODE_CREATION'] . "&a=r&c2=" . $email_code;
$lien_dup = "nouveau.php?c=" . $row_RSannonce['CODE_CREATION'] . "&a=d&c2=" . $email_code;
//

$to = $row_RSannonce['EMAIL'];
$from = "no-reply@covoiturage-libre.fr";
$from_name = "Covoiturage Libre";

$objet = "[A CONSERVER] Modification de votre annonce";
	
$message = '
	<html>
	 <body>
	  <table width="750" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="260" valign="top"><img src="http://www.covoiturage-libre.fr/images/logo-email.jpg" alt="" width="250" height="200" /></td>
    <td valign="top">
    <font face="arial" size="2" color="#444444"><p>Bonjour,</p>
    <p>Voici le mail de confirmation de votre annonce.</p>
	<p>'.$row_RSannonce['DEPART'].'&rarr;'.$row_RSannonce['ARRIVEE'].', le '.$datefr.' - '.substr($row_RSannonce['HEURE'], 0, 5).'</p>
    
    <p>&nbsp;</p>
    <p>Pour <strong>modifier votre annonce</strong> (modifier le nombre de places disponibles, ajouter un compl&eacute;ment d\'information, modifier un prix, etc...), utilisez le lien ci-dessous.<br />
      <a href="http://www.covoiturage-libre.fr/modification.php?m='.$row_RSannonce['CODE_MODIFICATION'].'"><font color="#3c609e">http://www.covoiturage-libre.fr/modification.php?m='.$row_RSannonce['CODE_MODIFICATION'].'</font></a></p>
    <p>&nbsp;</p>
<p>Si vous souhaitez <strong>supprimer</strong> d&eacute;finitivement votre annonce de notre site, cliquez sur le lien ci-dessous.<br />
  <a href="http://www.covoiturage-libre.fr/suppression.php?supp='.$row_RSannonce['CODE_SUPPRESSION'].'"><font color="#be3434">http://www.covoiturage-libre.fr/suppression.php?supp='.$row_RSannonce['CODE_SUPPRESSION'].'</font></a></p>
<p>&nbsp;</p>
	<p>Vous pouvez également créer rapidement l\'annonce du trajet retour en cliquant simplement sur le lien ci-dessous.<br />
	  <a href="http://www.covoiturage-libre.fr/'.$lien_ret.'"><font color="#83BE54">http://www.covoiturage-libre.fr/'.$lien_ret.'</font></a></p>
	<p>&nbsp;</p>
	<p>Si vous souhaitez dupliquer cette annonce rapidement, cliquez sur le lien ci-dessous.<br />
	  <a href="http://www.covoiturage-libre.fr/'.$lien_dup.'"><font color="#83BE54">http://www.covoiturage-libre.fr/'.$lien_dup.'</font></a></p>
	<p>&nbsp;</p>
<p>Cordialement,</p>
<p>L\'&eacute;quipe de covoiturage-libre.fr</p></font></td>
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