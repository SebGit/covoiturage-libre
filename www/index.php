<?php require_once('Connections/bddcovoiturette.php'); ?>
<?php
// anti-CSRF token
require_once("ScriptLibrary/form_functions.php");

session_start();

$myToken = getToken(); 
//

//code de dreamweaver pour requete mysql
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

$today=Date("Y-m-d");

mysql_select_db($database_bddcovoiturette, $bddcovoiturette);
$query_RSparcours = "SELECT TYPE, CIVILITE, NOM, PLACES, DEPART, ARRIVEE, PRIX, DATE_PARCOURS, CONFORT, CODE_CREATION, HEURE FROM trajets WHERE DATE_PARCOURS>=curdate() AND STATUT='Valide' ORDER BY ID DESC LIMIT 10";
$RSparcours = mysql_query($query_RSparcours, $bddcovoiturette) or die(mysql_error());
$row_RSparcours = mysql_fetch_assoc($RSparcours);
$totalRows_RSparcours = mysql_num_rows($RSparcours);

mysql_select_db($database_bddcovoiturette, $bddcovoiturette);
$query_RSstats = "SELECT COUNT(ID) AS STATS FROM trajets WHERE DATE_PARCOURS>=curdate() AND STATUT='Valide'";
$RSstats = mysql_query($query_RSstats, $bddcovoiturette) or die(mysql_error());
$row_RSstats = mysql_fetch_assoc($RSstats);
$totalRows_RSstats = mysql_num_rows($RSstats);

mysql_select_db($database_bddcovoiturette, $bddcovoiturette);
$query_RStotal = "SELECT COUNT(ID) AS STATS FROM trajets WHERE STATUT='Valide' OR STATUT='Supprime'";
$RStotal = mysql_query($query_RStotal, $bddcovoiturette) or die(mysql_error());
$row_RStotal = mysql_fetch_assoc($RStotal);
$totalRows_RStotal = mysql_num_rows($RStotal);
//fin du code de dreamweaver pour requete mysql

 //calcul du nombre de jours passés depuis la création du site  
	$debut='2011-11-13';
    $tDeb = explode("-", $debut);
    $tFin = explode("-", $today);
    $diff = mktime(0, 0, 0, $tFin[1], $tFin[2], $tFin[0]) -
            mktime(0, 0, 0, $tDeb[1], $tDeb[2], $tDeb[0]);
	$diff=(($diff / 86400)+1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/accueil.dwt.php" codeOutsideHTMLIsLocked="false" -->
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
#compteur {
	position:absolute;
	top:140px;
	font-size:15px;
	left:50%;
	color:#999;
	margin-left:-226px;
}
#compteur strong {
	color:#ef792f;
}
#contenu {
	width:660px;
	margin-top:-10px;
	float:left;
}
</style>
<script type="text/javascript">
////
function init() {
	key_count_global = 0;
	document.getElementById("DEPART").onkeyup = function() {key_count_global++;setTimeout("depart("+key_count_global+")", 600);}
}
function init2() {
	key_count_global = 0;
	document.getElementById("ARRIVEE").onkeyup = function() {key_count_global++;setTimeout("arrivee("+key_count_global+")", 600);}
}
$(document).ready(init);
$(document).ready(init2);


function depart(key_count){
	if(key_count == key_count_global) {
	var ville=$('#DEPART').val();
	var ville2=encodeURI(ville);
	var pays = encodeURI($('input[name=PAYS_DEPART]:checked').val());
	var chiffre=$('#DEPART').val().length;
	if(chiffre>=3){
		$('#DEPART').addClass('wait');
        $('#liste_depart').load('ajax/depart_flag.php?COMMUNE='+ville2+'&PAYS='+pays);
		$('#liste_depart').show();
	}
	else {
		$('#liste_depart').hide();
		$('#DEPART').removeClass('wait');
	}
	}
		
 }

 function arrivee(key_count){
	 if(key_count == key_count_global) {
	var ville=$('#ARRIVEE').val();
	var ville2=encodeURI(ville);
	var chiffre=$('#ARRIVEE').val().length;
	var pays = encodeURI($('input[name=PAYS_ARRIVEE]:checked').val());
	if(chiffre>=3){
		$('#ARRIVEE').addClass('wait');
		$('#liste_arrivee').load('ajax/arrivee_flag.php?COMMUNE='+ville2 +'&PAYS='+pays);
		$('#liste_arrivee').show();
	}
	else {
		$('#liste_arrivee').hide();
	}
	}
 }
 
 function blank(){
	 $('#DEPART').val('');
	 $('#DEPART').removeClass('check');
 }
 function blank2(){
	 $('#ARRIVEE').val('');
	 $('#ARRIVEE').removeClass('check');
 }
 
 $(document).ready(function(){
	 disableAutocomplete('DEPART');
	 disableAutocomplete('ARRIVEE');
	 disableAutocomplete('DATE_PARCOURS');
	 
	 $('#criteres').toggle(function(){$('#criteresliste').fadeIn();$('#criteres').addClass('on');},function(){$('#criteresliste').fadeOut();$('#criteres').removeClass('on');});
	 
	 /* Pour que les drapeaux sélectionnés s'affichent si précédent dans navigateur */
	 var pays1 = encodeURI($('input[name=PAYS_DEPART]:checked').val());
	 var pays2 = encodeURI($('input[name=PAYS_ARRIVEE]:checked').val());
	 $('#pays_depart_nom').addClass(pays1);
	 $('#pays_arrivee_nom').addClass(pays2);
	 /* [FIN] Pour que les drapeaux sélectionnés s'affichent si précédent dans navigateur */
	 

 	});
 
 function CHECK()
{
	if(document.form1.DEPART.value=='')
	{alert('Veuillez préciser un lieu de départ s\'il vous plaît');document.form1.DEPART.focus();return false;}
else
	if(document.form1.DEPART_LAT.value=='')
	{alert('Veuillez préciser un lieu de départ dans la liste de suggestions s\'il vous plaît');document.form1.DEPART.focus();return false;}
else
	if((document.form1.ARRIVEE.value=='')&&(document.form1.DATE_PARCOURS.value==''))
	{alert('Veuillez préciser au moins un lieu d\'arrivée ou une date pour votre trajet s\'il vous plaît');document.form1.ARRIVEE.focus();return false;}
else
	if((document.form1.ARRIVEE.value!=='')&&(document.form1.ARRIVEE_LAT.value==''))
	{alert('Veuillez préciser un lieu d\'arrivée dans la liste de suggestions s\'il vous plaît');document.form1.ARRIVEE.focus();return false;}
return true
}


 </script>
<!-- InstanceEndEditable -->
</head>

<body>
<div id="conteneur">


	<div id="header">
    <a href="index.php" id="lienhome"></a>
    <?php include('include/facebook.php');?>
	<!-- InstanceBeginEditable name="headersite" -->
    <span id="compteur"><strong><?php echo $row_RStotal['STATS']; ?></strong> annonces publi&eacute;es depuis sa cr&eacute;ation il y a <strong><?php echo $diff; ?></strong> jours!</span>
    <div id="recherche" style="position:relative;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
              <td width="40%"><h2>Trouver votre covoiturage</h2></td>
              <td>(sur <strong><?php echo $row_RSstats['STATS']; ?></strong> parcours &agrave; venir)</td>
              </tr>
          </table>
          <form id="form1" name="form1" method="post" action="recherche.php" onsubmit="return CHECK()">
            <table  width="700" border="0" cellpadding="3" cellspacing="0">
              <tr>
                <td>
                	Ville de d&eacute;part
                	<?php $pays_desc = 'depart'; require("include/pays_choix.php"); ?>
                </td>
                <td>Ville d'arriv&eacute;e
                	<?php $pays_desc = 'arrivee'; require("include/pays_choix.php"); ?>
                </td>
                <td>Date</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><input name="DEPART" type="text" id="DEPART" size="25" onkeyup="depart()" onfocus="blank()"  /><div id="liste_depart"></div>
          <input type="hidden" name="DEPART_LAT" id="DEPART_LAT" value="" />
          <input type="hidden" name="DEPART_LON" id="DEPART_LON" value="" /></td>
                <td><input name="ARRIVEE" type="text" id="ARRIVEE" size="25" onkeyup="arrivee()" onfocus="blank2()" /><div id="liste_arrivee"></div>
          <input type="hidden" name="ARRIVEE_LAT" id="ARRIVEE_LAT" value="" />
          <input type="hidden" name="ARRIVEE_LON" id="ARRIVEE_LON" value="" /></td>
                <td><label for="DATE_PARCOURS"></label>
                  <input name="DATE_PARCOURS" type="text" id="DATE_PARCOURS" size="10" /></td>
                <td><input type="submit" name="button" id="button" value="Rechercher" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><a href="#" id="criteres">Plus de crit&egrave;res</a></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              </table>
        <table width="700" border="0" cellpadding="3" cellspacing="0" id="criteresliste">
	            <tr>
	              <td>Type d'annonce</td>
	              <td colspan="3"><select name="TYPE" id="TYPE">
	                <option value="All">Conducteur &amp; Passager</option>
	                <option value="Conducteur" >Conducteur uniquement</option>
	                <option value="Passager" >Passager uniquement</option>
	                </select></td>
                </tr>
	            <tr>
	              <td>Ville de d&eacute;part</td>
	              <td><select name="DEPART_KM" id="DEPART_KM">
	                <option value="60" >+/- 60 km</option>
	                <option value="30" >+/- 30 km</option>
	                <option value="10" >+/- 10 km</option>
	                </select></td>
	              <td>Ville d'arriv&eacute;e</td>
	              <td><select name="ARRIVEE_KM" id="ARRIVEE_KM">
	                <option value="60" >+/- 60 km</option>
	                <option value="30" >+/- 30 km</option>
	                <option value="10" >+/- 10 km</option>
	                </select></td>
                </tr>
	            <tr>
	              <td>Trier par</td>
	              <td colspan="3"><label for="TRI"></label>
	                <select name="TRI" id="TRI">
	                  <option value="DATE HEURE">Date &amp; Heure de d&eacute;part</option>
	                  <option value="PRIX ASC">Prix croissant</option>
	                  <option value="PRIX DESC">Prix d&eacute;croissant</option>
	                  <option value="PLACES ASC">Nombre de places croissant</option>
	                  <option value="PLACES DESC">Nombre de places d&eacute;croissant</option>
                    </select></td>
                </tr>
              </table>
               <input id="srctoken" name="srctoken" type="hidden" value="<?php echo $myToken ?>" />
              </form></td>
        <td align="right"><a href="nouveau.php" id="newadd">Publier une annonce</a></td>
        </tr>
      </table>
    </div>
    <hr style="visibility:hidden;clear:both;" />
    <!-- InstanceEndEditable --></div>
    
    <div id="contenu">
	<!-- InstanceBeginEditable name="contenu" -->
	<h1>Les 10 derni&egrave;res annonces publi&eacute;es</h1>
	<?php do { include('include-annonce.php'); } while ($row_RSparcours = mysql_fetch_assoc($RSparcours)); ?>
    <!-- InstanceEndEditable -->
  </div>
  
  <?php include('include/droite.php');?>
    
    <div id="footer">
    <?php include('include-footer.php'); ?></div>

</div>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($RSparcours);

mysql_free_result($RSstats);

mysql_free_result($RStotal);
?>
