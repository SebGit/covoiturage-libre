<?php 
 $cryptinstall="crypt/cryptographp.fct.php";
 include $cryptinstall;  
?>
<?php 
require_once('Connections/bddcovoiturette.php'); ?>
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

$colname_RStrajet = "-1";
if (isset($_GET['supp'])) {
  $colname_RStrajet = $_GET['supp'];
} else {
	header('location:maintenance.php');
	die();
}
$colname_RStrajet2 = "-1";
if (isset($_POST['EMAIL'])) {
  $colname_RStrajet2 = $_POST['EMAIL'];
}
mysql_select_db($database_bddcovoiturette, $bddcovoiturette);
$query_RStrajet = sprintf("SELECT * FROM trajets WHERE CODE_SUPPRESSION = %s AND EMAIL = %s", GetSQLValueString($colname_RStrajet, "date"), GetSQLValueString($colname_RStrajet2, "text"));
$RStrajet = mysql_query($query_RStrajet, $bddcovoiturette) or die(mysql_error());
$row_RStrajet = mysql_fetch_assoc($RStrajet);
$totalRows_RStrajet = mysql_num_rows($RStrajet);

	if(isset($_POST['CODE'])){
		if ( chk_crypt($_POST['CODE']) ) $code_result_ok = true;
		else $code_result_ok = false;
		
		$ip=$_SERVER['REMOTE_ADDR'];
	
		if ( $code_result_ok === true ) {
			
			if($totalRows_RStrajet==1){
			mysql_select_db($database_bddcovoiturette, $bddcovoiturette);
			$query_RSupdate = sprintf("UPDATE trajets SET STATUT='Supprime', IP_SUPPRESSION='".$ip."' WHERE CODE_SUPPRESSION = %s AND EMAIL = %s", GetSQLValueString($colname_RStrajet, "date"), GetSQLValueString($colname_RStrajet2, "text"));
			$RSupdate = mysql_query($query_RSupdate, $bddcovoiturette) or die(mysql_error());
			
			$texte="<h2>Annonce supprim&eacute;ee !</h2>
		<p>Votre annonce a bien &eacute;t&eacute; supprim&eacute;ee. Elle n'est plus disponible sur notre site.</p>
		<p>L'&eacute;quipe de covoiturage-libre.fr</p>";}
			else {
			$texte="<h2>Echec !</h2>
		<p>Votre annonce n'a p&ucirc; &ecirc;tre supprim&eacute;ee. </p>";}
		}
	}
	
	else {
		$texte='';
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
	<h1>Suppression</h1>
    <?php if($texte==''){?>
	<p>Pour supprimer votre annonce, veuillez confirmer votre adresse email et saisir le code indiqu&eacute; ci-dessous :</p>
	<form id="form1" method="post" action="">
	  <table width="60%" border="0" cellpadding="3" cellspacing="0">
	    <tr>
	      <td><strong>Votre email</strong></td>
	      <td><label for="EMAIL"></label>
          <input name="EMAIL" type="text" id="EMAIL" size="35" value="<?php if(isset($_POST['EMAIL'])){ echo $_POST['EMAIL']; }?>" /></td>
        </tr>
	    <tr>
	      <td><strong>Code de s&eacute;curit&eacute;</strong></td>
	      <td><?php dsp_crypt(0,1); ?></td>
        </tr>
	    <tr>
	      <td>Merci de recopier le code affich&eacute; ci-dessus </td>
	      <td><input name="CODE" type="text" id="CODE" size="10" />
            <?php if ( isset($code_result_ok) and $code_result_ok === false ) : ?>
            <a name="code_nok" id="code_nok"></a><em style="color:red;font-weight:bold;">code non reconnu</em>
          <?php endif; ?></td>
        </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td>&nbsp;</td>
        </tr>
	    <tr>
	      <td>&nbsp;</td>
	      <td><input type="submit" name="button" id="button" value="Supprimer votre annonce" /></td>
        </tr>
      </table>
    </form>
    <?php } else { echo $texte;} ?>
	<p>&nbsp;</p>
	<!-- InstanceEndEditable -->
</div>
    
    <div id="footer">
    <?php include('include-footer.php'); ?></div>

</div>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($RStrajet);
?>
