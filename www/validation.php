<?php require_once('Connections/bddcovoiturette.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($bddcovoiturette, $theValue) : mysqli_escape_string($bddcovoiturette, $theValue);

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

$colname_RStrajet = "-1";
if (isset($_GET['c'])) {
  $colname_RStrajet = $_GET['c'];
}
mysqli_select_db($bddcovoiturette , $database_bddcovoiturette);
$query_RStrajet = sprintf("SELECT * FROM trajets WHERE CODE_CREATION = %s", GetSQLValueString($colname_RStrajet, "date"));
$RStrajet = mysqli_query($bddcovoiturette ,$query_RStrajet) or die(mysqli_error($bddcovoiturette));
$row_RStrajet = mysqli_fetch_assoc($RStrajet);
$totalRows_RStrajet = mysqli_num_rows($RStrajet);

if($totalRows_RStrajet==1){
	mysqli_select_db($bddcovoiturette , $database_bddcovoiturette);
	$query_RSupdate = sprintf("UPDATE trajets SET STATUT='Valide' WHERE CODE_CREATION = %s", GetSQLValueString($colname_RStrajet, "date"));
	$RSupdate = mysqli_query($bddcovoiturette ,$query_RSupdate) or die(mysqli_error($bddcovoiturette));
	
	$texte="<h2>Annonce valid&eacute;e !</h2>
<p>Votre annonce a bien &eacute;t&eacute; valid&eacute;e. Elle est d&egrave;s &agrave; pr&eacute;sent disponible sur notre site.</p>
<p>Vous pouvez la visualiser en <a href=\"detail.php?c=".$row_RStrajet['CODE_CREATION']."&p=pri\">cliquant ici</a></p>
<p>L'&eacute;quipe de covoiturage-libre.fr</p>";}
	else {
	$texte="<h2>Echec !</h2>
<p>Votre annonce n'a p&ucirc; &ecirc;tre valid&eacute;e. </p>";}
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
	<h1>Validation</h1>
	<p>&nbsp;</p>
    <?php echo $texte; ?>
	<!-- InstanceEndEditable -->
  </div>
    
    <div id="footer">
    <?php include('include-footer.php'); ?></div>

</div>
</body>
<!-- InstanceEnd --></html>
<?php
mysqli_free_result($RStrajet);
?>
