<?php require_once('Connections/bddcovoiturette.php'); ?>
<?php require_once('ScriptLibrary/class.phpmailer.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

if (isset($_GET['c'])) {
  $colname_RSannonce = $_GET['c'];
}
mysql_select_db($database_bddcovoiturette, $bddcovoiturette);
$query_RSannonce = sprintf("SELECT * FROM trajets WHERE CODE_CREATION = %s", GetSQLValueString($colname_RSannonce, "text"));
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

$objet = "[A CONSERVER] Confirmation de votre annonce";
	
$message = '
	<html>
	 <body>
	  <table width="750" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="260" valign="top"><img src="http://www.covoiturage-libre.fr/images/logo-email.jpg" alt="" width="250" height="200" /></td>
    <td valign="top">
    <font face="arial" size="2" color="#444444"><p>Bonjour,</p>
    <p>Votre annonce a bien &eacute;t&eacute; enregistr&eacute;e.</p>
	<p>'.$row_RSannonce['DEPART'].'&rarr;'.$row_RSannonce['ARRIVEE'].', le '.$datefr.' - '.substr($row_RSannonce['HEURE'], 0, 5).'</p>
    <p>Cependant, pour <strong>valider</strong> d&eacute;finitivement votre annonce et la publier sur le site, veuillez cliquer sur le lien ci-dessous.<br />
      <a href="http://www.covoiturage-libre.fr/validation.php?c='.$row_RSannonce['CODE_CREATION'].'"><font color="#7fbe53">http://www.covoiturage-libre.fr/validation.php?c='.$row_RSannonce['CODE_CREATION'].'</font></a></p>
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
	

	
$mail=new phpmailer();
$mail->From = $from;
$mail->FromName = $from_name;
$mail->Subject =$objet;
$mail->AddAddress($to);
$mail->MsgHTML($message);
	
if($mail->Send()){
	$erreur = "Votre message a bien été envoyé à l'administrateur du site.";
} else {
	$erreur = "problem !";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/principal.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Covoiturage-libre.fr - Le site du covoiturage libre et gratuit !</title>
<!-- InstanceEndEditable -->
<link href="css/covoiturage-libre.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-ui2.js"></script>
<script type="text/javascript" src="js/jquery.ui.datepicker-fr.js"></script>
<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.8.16.custom.css"/>
<?php include('include/include.php');?>
<!-- InstanceBeginEditable name="head" -->
<style type="text/css">
.droite {
	float:right;
	width:300px;
	margin-left:20px;
}
.bouton {
	background-color:#ef792f;
	-moz-border-radius: 10px;
	-webkit-border-radius: 10px;
	border-radius: 10px;
	border:none;
	padding:10px;
	height:20px;
	line-height:20px;
	color:#fff !important;
	font-size:15px;
	font-weight:bold;
	text-decoration:none;
	margin-top:10px;
	display:block;
}
</style>
<!-- InstanceEndEditable -->
</head>

<body>
<div id="conteneur">


	<div id="header">
    <a href="index.php" id="lienhome"></a>
    <?php include('include/facebook.php');?>
	<!-- InstanceBeginEditable name="headersite" --><!-- InstanceEndEditable --></div>
    
    <div id="contenu">
	<!-- InstanceBeginEditable name="contenu" -->
	<h1>Nouveau trajet </h1>
	<p>&nbsp;</p>
    <div class="droite">
      <h3>Raccourcis pratiques</h3>
      <p>Pour dupliquer l'annonce que vous venez d'enregistrer, cliquez sur le bouton ci-dessous. Le formulaire sera alors pr&eacute;-rempli &agrave; l'identique, sauf pour la date du trajet.</p>
      <p><a href="<?=$lien_dup?>" class="bouton">&gt; Dupliquer votre annonce</a></p>
      <p>&nbsp;</p>
      <p>Pour proposer le trajet retour de votre annonce, cliquez sur le bouton ci-dessous. Le formulaire  sera pr&eacute;-rempli automatiquement, les villes de d&eacute;part et d'arriv&eacute;e seront invers&eacute;es (ainsi que vos &eacute;ventuelles &eacute;tapes). </p>
      <p><a href="<?=$lien_ret?>" class="bouton">&gt; Proposer le trajet retour</a></p>
    </div>
	<h2>Merci !</h2>
	<p>&nbsp;</p>
	<p>Votre annonce a bien &eacute;t&eacute; enregistr&eacute;e. </p>
	<p>Cependant, pour valider d&eacute;finitivement votre annonce (et votre adresse email), <strong>veuillez cliquer sur le lien fourni dans l'email de confirmation qui vient de vous &ecirc;tre envoy&eacute;</strong>, sous 24 heures.	</p>
	<p>Sans r&eacute;ponse de votre part dans ce d&eacute;lai, votre annonce sera automatiquement supprim&eacute;e.</p>
	<p>&nbsp;</p>
<p>L'&eacute;quipe d'organisation.</p>
	<!-- InstanceEndEditable -->
  </div>
    
    <div id="footer">
    <?php include('include-footer.php'); ?></div>

</div>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($RSannonce);
?>
