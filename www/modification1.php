<?php
// anti-CSRF token
session_start();

/**/
if (isset($_POST) && !empty($_POST)) {
	if(isset($_POST['CODE'])){
		if (!isset($_POST['srctoken']) || !isset($_SESSION['cvtoken'])) {
			header("Location: interdit.php");
			die();
		}
		if ($_POST['srctoken'] !== $_SESSION['cvtoken']) {
			header("Location: interdit.php");
			die();
		}
		$cryptinstall="crypt/cryptographp.fct.php";
		require($cryptinstall); 
		if (!chk_crypt($_POST['CODE']) )  {
			header("Location: interdit.php");
			die();
		}
	}
}
?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	
	$heure=$_POST['HEURE_H'].':'.$_POST['HEURE_M'];
	$date=explode('-',$_POST['DATE_PARCOURS']);
	$datefin=$date[2].'-'.$date[1].'-'.$date[0];
	
	if((!isset($_POST['DEPART']))||($_POST['DEPART']=='')||($_POST['DEPART']==NULL)){
			header('location:erreur.php');
			die();
		}
	
	
  $updateSQL = sprintf("UPDATE trajets SET TYPE=%s, DEPART=%s, DEPART_LAT=%s, DEPART_LON=%s, ARRIVEE_LAT=%s, ARRIVEE_LON=%s, ARRIVEE=%s, DATE_PARCOURS=%s, HEURE=%s, PLACES=%s, CONFORT=%s, COMMENTAIRES=%s, PRIX=%s, ETAPE1=%s, ETAPE1_LAT=%s, ETAPE1_LON=%s, PRIX1=%s, ETAPE2=%s, ETAPE2_LAT=%s, ETAPE2_LON=%s, PRIX2=%s, ETAPE3=%s, ETAPE3_LAT=%s, ETAPE3_LON=%s, PRIX3=%s, CIVILITE=%s, NOM=%s, AGE=%s, TELEPHONE=%s WHERE CODE_MODIFICATION=%s",
                       GetSQLValueString($_POST['TYPE'], "text"),
                       GetSQLValueString($_POST['DEPART'], "text"),
                       GetSQLValueString($_POST['DEPART_LAT'], "double"),
                       GetSQLValueString($_POST['DEPART_LON'], "double"),
                       GetSQLValueString($_POST['ARRIVEE_LAT'], "double"),
                       GetSQLValueString($_POST['ARRIVEE_LON'], "double"),
                       GetSQLValueString($_POST['ARRIVEE'], "text"),
                       GetSQLValueString($datefin, "date"),
					   GetSQLValueString($heure, "text"),
                       GetSQLValueString($_POST['PLACES'], "int"),
                       GetSQLValueString($_POST['CONFORT'], "text"),
                       GetSQLValueString($_POST['COMMENTAIRES'], "text"),
                       GetSQLValueString($_POST['PRIX'], "int"),
                       GetSQLValueString($_POST['ETAPE1'], "text"),
                       GetSQLValueString($_POST['ETAPE1_LAT'], "double"),
                       GetSQLValueString($_POST['ETAPE1_LON'], "double"),
                       GetSQLValueString($_POST['PRIX1'], "int"),
                       GetSQLValueString($_POST['ETAPE2'], "text"),
                       GetSQLValueString($_POST['ETAPE2_LAT'], "double"),
                       GetSQLValueString($_POST['ETAPE2_LON'], "double"),
                       GetSQLValueString($_POST['PRIX2'], "int"),
                       GetSQLValueString($_POST['ETAPE3'], "text"),
                       GetSQLValueString($_POST['ETAPE3_LAT'], "double"),
                       GetSQLValueString($_POST['ETAPE3_LON'], "double"),
                       GetSQLValueString($_POST['PRIX3'], "int"),
                       GetSQLValueString($_POST['CIVILITE'], "text"),
                       GetSQLValueString($_POST['NOM'], "text"),
					   GetSQLValueString($_POST['AGE'], "text"),
                       GetSQLValueString($_POST['TELEPHONE'], "text"),
                       GetSQLValueString($_POST['c'], "text"));
  if ((preg_match("/\bjavascript\b/i", $updateSQL))||(preg_match("/\byopmail\b/i", $updateSQL))||(preg_match("/\bmailinator\b/i", $updateSQL))||(preg_match("/\bscript\b/i", $updateSQL))||(preg_match("/\bhref\b/i", $updateSQL))) {
	  header('location:modification-erreur.php');
	  die();
		}

  mysqli_select_db($bddcovoiturette , $database_bddcovoiturette);
  $Result1 = mysqli_query($bddcovoiturette ,$updateSQL) or die(mysqli_error($bddcovoiturette));

  $updateGoTo = "modification-ok.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$date=Date("Y-m-d");

$colname_RStrajet = "-1";
if (isset($_POST['CODEM'])) {
  $colname_RStrajet = $_POST['CODEM'];
}
$colname_RStrajet2 = "-1";
if (isset($_POST['EMAIL'])) {
  $colname_RStrajet2 = $_POST['EMAIL'];
}
mysqli_select_db($bddcovoiturette , $database_bddcovoiturette);
$query_RStrajet = sprintf("SELECT * FROM trajets WHERE CODE_MODIFICATION = %s AND EMAIL = %s AND DATE_PARCOURS>='".$date."' AND STATUT='Valide'",
 GetSQLValueString($colname_RStrajet, "text"), GetSQLValueString($colname_RStrajet2, "text"));
$RStrajet = mysqli_query($bddcovoiturette ,$query_RStrajet) or die(mysqli_error($bddcovoiturette));
$row_RStrajet = mysqli_fetch_assoc($RStrajet);
$totalRows_RStrajet = mysqli_num_rows($RStrajet);

if($totalRows_RStrajet!==1){
	header('location:modification-erreur.php');
	die();
}

$heure=explode(':',$row_RStrajet['HEURE']);
$heure_h=$heure[0];
$heure_m=$heure[1];
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
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
 var map;
 var directionsDisplay;
 var directionsService = new google.maps.DirectionsService();

 function initialize() {
  var latlng = new google.maps.LatLng(46.7, 2.5);
  var myOptions = {
   zoom: 6,
   center: latlng,
   mapTypeId: google.maps.MapTypeId.ROADMAP
  };

  map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);
  directionsDisplay = new google.maps.DirectionsRenderer();
  directionsDisplay.setMap(map);
  directionsDisplay.setPanel(document.getElementById('displayinfo_canvas'));

 }

 function showItineraire(){
  directionsService.route({
   origin: document.getElementById('DEPART').value,
   destination: document.getElementById('ARRIVEE').value,
   unitSystem: google.maps.DirectionsUnitSystem.METRIC,
   travelMode: google.maps.DirectionsTravelMode.DRIVING
  }, function(result, status){
   if (status == google.maps.DirectionsStatus.OK){
    directionsDisplay.setDirections(result);
   } else {
    alert('Le calcul d\'itinÈraire a ÈchouÈ.');
   }
  });
 }
 
 function depart(){
	var ville=$('#DEPART').val();
	var chiffre = ville.length;
	ville = encodeURI(ville);
	var pays = encodeURI($('input[name=PAYS_DEPART]:checked').val());
	if(chiffre>=3){
		$('#liste_depart').load('ajax/depart_flag.php?COMMUNE='+ville + '&PAYS=' + pays);
		$('#liste_depart').show();
	}
	else {
		$('#liste_depart').hide();
	}
 }
 function arrivee(){
	var ville=$('#ARRIVEE').val();
	var chiffre = ville.length;
	ville = encodeURI(ville);
	var pays = encodeURI($('input[name=PAYS_ARRIVEE]:checked').val());
	if(chiffre>=3){
		$('#liste_arrivee').load('ajax/arrivee.php?COMMUNE='+ville + '&PAYS=' + pays);
		$('#liste_arrivee').show();
	}
	else {
		$('#liste_arrivee').hide();
	}
 }
 function etape1(){
	var ville=$('#ETAPE1').val();
	var chiffre = ville.length;
	ville = encodeURI(ville);
	var pays = encodeURI($('input[name=PAYS_ETAPE1]:checked').val());
	if(chiffre>=3){
		$('#ETAPE1').addClass('wait');
		$('#liste_etape1').load('ajax/etape1.php?COMMUNE='+ville + '&PAYS=' + pays);
		$('#liste_etape1').show();
	}
	else {
		$('#liste_etape1').hide();
		$('#ETAPE1').removeClass('wait');
	}
 }
 function etape2(){
	var ville=$('#ETAPE2').val();
	var chiffre = ville.length;
	ville = encodeURI(ville);
	var pays = encodeURI($('input[name=PAYS_ETAPE2]:checked').val());
	if(chiffre>=3){
		$('#ETAPE2').addClass('wait');
		$('#liste_etape2').load('ajax/etape2.php?COMMUNE='+ville + '&PAYS=' + pays);
		$('#liste_etape2').show();
	}
	else {
		$('#liste_etape2').hide();
		$('#ETAPE2').removeClass('wait');
	}
 }
 function etape3(){
	var ville=$('#ETAPE3').val();
	var chiffre = ville.length;
	ville = encodeURI(ville);
	var pays = encodeURI($('input[name=ETAPE3]:checked').val());
	if(chiffre>=3){
		$('#ETAPE3').addClass('wait');
		$('#liste_etape3').load('ajax/etape3.php?COMMUNE='+ville + '&PAYS=' + pays);
		$('#liste_etape3').show();
	}
	else {
		$('#liste_etape3').hide();
		$('#ETAPE3').removeClass('wait');
	}
 }
 
 function blank(){$('#DEPART').val('');$('#DEPART').removeClass('check');}
 function blank2(){$('#ARRIVEE').val('');$('#ARRIVEE').removeClass('check');}
 function blank3(){$('#ETAPE1').val('');$('#ETAPE1').removeClass('check');}
 function blank4(){$('#ETAPE2').val('');$('#ETAPE2').removeClass('check');}
 function blank5(){$('#ETAPE3').val('');$('#ETAPE3').removeClass('check');}
 function conducteur(){
	 if(document.form1.TYPE[0].checked==true){
		 $('.conducteur').show();
	 }
	 else {
		 $('.conducteur').hide();
	 }
 }
 
$(document).ready(function(){
	initialize();
	disableAutocomplete('DEPART');
	 disableAutocomplete('ARRIVEE');
	 disableAutocomplete('DATE_PARCOURS');
	 disableAutocomplete('ETAPE1');
	 disableAutocomplete('ETAPE2');
	 disableAutocomplete('ETAPE3');
	 conducteur();
});


 function CHECK()
{
	sujetoption = -1
	for (i=0; i<document.form1.TYPE.length; i++)
	{
		if(document.form1.TYPE[i].checked){sujetoption = i}
	}
	if (sujetoption == -1){alert("Veuillez indiquer si vous Ítes conducteur ou passager s'il vous plaÓt");return false;}
else
	if(document.form1.DEPART.value=='')
	{alert('Veuillez prÈciser un lieu de dÈpart s\'il vous plaÓt');document.form1.DEPART.focus();return false;}
else
	if(document.form1.DEPART_LAT.value=='')
	{alert('Veuillez prÈciser un lieu de dÈpart dans la liste de suggestions s\'il vous plaÓt');document.form1.DEPART.focus();return false;}
else
	if(document.form1.ARRIVEE.value=='')
	{alert('Veuillez prÈciser un lieu d\'arrivÈe s\'il vous plaÓt');document.form1.ARRIVEE.focus();return false;}
else
	if(document.form1.ARRIVEE_LAT.value=='')
	{alert('Veuillez prÈciser un lieu d\'arrivÈe dans la liste de suggestions s\'il vous plaÓt');document.form1.ARRIVEE.focus();return false;}
else
	if(document.form1.DATE_PARCOURS.value=='')
	{alert('Veuillez prÈciser la date de votre trajet s\'il vous plaÓt');document.form1.DATE_PARCOURS.focus();return false;}
else
	if((document.form1.TYPE[0].checked)&&(document.form1.PLACES.value==''))
	{alert('Veuillez prÈciser le nombre de places disponibles s\'il vous plaÓt');document.form1.PLACES.focus();return false;}
else 
	sujetoption = -1
	for (i=0; i<document.form1.CONFORT.length; i++)
	{
		if(document.form1.CONFORT[i].checked){sujetoption = i}
	}
	if ((document.form1.TYPE[0].checked)&&(sujetoption == -1)){alert("Veuillez indiquer le niveau de confort de votre vÈhicule s'il vous plaÓt");return false;}
else
	if((document.form1.TYPE[0].checked)&&(document.form1.PRIX.value==''))
	{alert('Veuillez prÈciser le prix du trajet s\'il vous plaÓt');document.form1.PRIX.focus();return false;}
else
	if((document.form1.ETAPE1.value!=='')&&(document.form1.ETAPE1_LAT.value==''))
	{alert('Veuillez prÈciser une premiËre Ètape dans la liste de suggestions s\'il vous plaÓt');document.form1.ETAPE1.focus();return false;}
else
	if((document.form1.ETAPE2.value!=='')&&(document.form1.ETAPE2_LAT.value==''))
	{alert('Veuillez prÈciser une seconde Ètape dans la liste de suggestions s\'il vous plaÓt');document.form1.ETAPE2.focus();return false;}
else
	if((document.form1.ETAPE3.value!=='')&&(document.form1.ETAPE3_LAT.value==''))
	{alert('Veuillez prÈciser une troisiËme Ètape dans la liste de suggestions s\'il vous plaÓt');document.form1.ETAPE3.focus();return false;}
else
	sujetoption = -1
	for (i=0; i<document.form1.CIVILITE.length; i++)
	{
		if(document.form1.CIVILITE[i].checked){sujetoption = i}
	}
	if (sujetoption == -1){alert("Veuillez indiquer si vous Ítes un homme ou une femme s'il vous plaÓt");return false;}
else
	if(document.form1.NOM.value=='')
	{alert('Veuillez prÈciser votre nom / pseudo s\'il vous plaÓt');document.form1.NOM.focus();return false;}
else
	if(document.form1.EMAIL.value=='')
	{alert('Veuillez prÈciser votre adresse e-mail s\'il vous plaÓt');document.form1.EMAIL.focus();return false;}
else
	var illegal = new RegExp("[\(\),;:!?<>\$‡Á&È˘Ë‚ÍÓ\*\^\'\"]+","g");
	var legal = new RegExp("^\\w[\\w\-\_\.]*\\w@\\w[\\w\-\_\.]*\\w\\.\\w{2,4}$");
	var c=document.form1.EMAIL.value;
	if((illegal.test(c)==true)||(legal.test(c)!=true)){alert("L'adresse e-mail qui a ÈtÈ saisie est incorrecte");return false;}
return true
}
</script>
<style type="text/css">
.conducteur {
	
}
</style>
<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.4.css"/>
<script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	
	$("a.iframe").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	200, 
		'speedOut'		:	200, 
		'overlayShow'	:	true
	});
	
});
</script>
<!-- InstanceEndEditable -->
</head>

<body>
<div id="conteneur">


	<div id="header">
    <a href="index.php" id="lienhome"></a>
    <?php include('include/facebook.php');?>
	<!-- InstanceBeginEditable name="headersite" --> 
    
    
    <!-- InstanceEndEditable --></div>
    
    <div id="contenu">
	<!-- InstanceBeginEditable name="contenu" -->
    <h1>Modifier votre trajet    </h1>
    <div id="map_canvas">
    </div>
    <form action="<?php echo $editFormAction; ?>" name="form1" id="form1" method="POST" onsubmit="return CHECK()">
      <table width="500" border="0" cellpadding="3" cellspacing="0">
        <tr>
          <td colspan="2"><h2>Le parcours</h2></td>
        </tr>
        <tr>
          <td style="width:150px;">Je suis <span class="dispo1">*</span></td>
          <td><input <?php if (!(strcmp($row_RStrajet['TYPE'],"Conducteur"))) {echo "checked=\"checked\"";} ?> type="radio" name="TYPE" value="Conducteur" id="TYPE_0" onclick="conducteur()" />
            Conducteur
            <input <?php if (!(strcmp($row_RStrajet['TYPE'],"Passager"))) {echo "checked=\"checked\"";} ?> type="radio" name="TYPE" value="Passager" id="TYPE_1" onclick="conducteur()" />
            Passager</td>
        </tr>
        <tr>
          <td>Ville de d&eacute;part <span class="dispo1">*</span> <?php $pays_desc = 'depart'; require("include/pays_choix.php"); ?>
          </td>
          <td id="focusdepart">
          <input name="DEPART" type="text" id="DEPART" onfocus="blank()" onkeyup="depart()" value="<?php echo $row_RStrajet['DEPART']; ?>" size="25" class="check"/><div id="liste_depart"></div>
          <input type="hidden" name="DEPART_LAT" id="DEPART_LAT" value="<?php echo $row_RStrajet['DEPART_LAT']; ?>" />
          <input type="hidden" name="DEPART_LON" id="DEPART_LON" value="<?php echo $row_RStrajet['DEPART_LON']; ?>" /></td>
        </tr>
        <tr>
          <td>Ville d'arriv&eacute;e <span class="dispo1">*</span> <?php $pays_desc = 'arrivee'; require("include/pays_choix.php"); ?>
          </td>
          <td>
          <input name="ARRIVEE" type="text" id="ARRIVEE" onfocus="blank2()" onkeyup="arrivee()" value="<?php echo $row_RStrajet['ARRIVEE']; ?>" size="25" class="check"/><div id="liste_arrivee"></div>
          <input type="hidden" name="ARRIVEE_LAT" id="ARRIVEE_LAT" value="<?php echo $row_RStrajet['ARRIVEE_LAT']; ?>" />
          <input type="hidden" name="ARRIVEE_LON" id="ARRIVEE_LON" value="<?php echo $row_RStrajet['ARRIVEE_LON']; ?>" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><a href="#" onclick="showItineraire()">&gt; V&eacute;rifier le parcours sur la carte</a></td>
        </tr>
        <tr>
          <td>Date du parcours <span class="dispo1">*</span></td>
          <td><label for="DATE_PARCOURS"></label>
          <input name="DATE_PARCOURS" type="text" id="DATE_PARCOURS" value="<?php $date=explode('-',$row_RStrajet['DATE_PARCOURS']);
	$datefin=$date[2].'-'.$date[1].'-'.$date[0]; echo $datefin; ?>" size="10" maxlength="10" readonly="readonly" /></td>
        </tr>
        <tr>
          <td>Heure de d&eacute;part <span class="dispo1">*</span></td>
          <td><label for="HEURE"></label>
            <label for="HEURE_H"></label>
            <select name="HEURE_H" id="HEURE_H">
              <option value="00" <?php if (!(strcmp('00', $heure_h))) {echo "selected=\"selected\"";} ?>>00</option>
              <option value="01" <?php if (!(strcmp('01', $heure_h))) {echo "selected=\"selected\"";} ?>>01</option>
              <option value="02" <?php if (!(strcmp('02', $heure_h))) {echo "selected=\"selected\"";} ?>>02</option>
              <option value="03" <?php if (!(strcmp('03', $heure_h))) {echo "selected=\"selected\"";} ?>>03</option>
              <option value="04" <?php if (!(strcmp('04', $heure_h))) {echo "selected=\"selected\"";} ?>>04</option>
              <option value="05" <?php if (!(strcmp('05', $heure_h))) {echo "selected=\"selected\"";} ?>>05</option>
              <option value="06" <?php if (!(strcmp('06', $heure_h))) {echo "selected=\"selected\"";} ?>>06</option>
              <option value="07" <?php if (!(strcmp('07', $heure_h))) {echo "selected=\"selected\"";} ?>>07</option>
              <option value="08" <?php if (!(strcmp('08', $heure_h))) {echo "selected=\"selected\"";} ?>>08</option>
              <option value="09" <?php if (!(strcmp('09', $heure_h))) {echo "selected=\"selected\"";} ?>>09</option>
              <option value="10" <?php if (!(strcmp('10', $heure_h))) {echo "selected=\"selected\"";} ?>>10</option>
              <option value="11" <?php if (!(strcmp('11', $heure_h))) {echo "selected=\"selected\"";} ?>>11</option>
              <option value="12" <?php if (!(strcmp('12', $heure_h))) {echo "selected=\"selected\"";} ?>>12</option>
<option value="13" <?php if (!(strcmp('13', $heure_h))) {echo "selected=\"selected\"";} ?>>13</option>
              <option value="14" <?php if (!(strcmp('14', $heure_h))) {echo "selected=\"selected\"";} ?>>14</option>
              <option value="15" <?php if (!(strcmp('15', $heure_h))) {echo "selected=\"selected\"";} ?>>15</option>
              <option value="16" <?php if (!(strcmp('16', $heure_h))) {echo "selected=\"selected\"";} ?>>16</option>
              <option value="17" <?php if (!(strcmp('17', $heure_h))) {echo "selected=\"selected\"";} ?>>17</option>
<option value="18" <?php if (!(strcmp(18, $heure_h))) {echo "selected=\"selected\"";} ?>>18</option>
              <option value="19" <?php if (!(strcmp('19', $heure_h))) {echo "selected=\"selected\"";} ?>>19</option>
              <option value="20" <?php if (!(strcmp('20', $heure_h))) {echo "selected=\"selected\"";} ?>>20</option>
              <option value="21" <?php if (!(strcmp('21', $heure_h))) {echo "selected=\"selected\"";} ?>>21</option>
              <option value="22" <?php if (!(strcmp('22', $heure_h))) {echo "selected=\"selected\"";} ?>>22</option>
<option value="23" <?php if (!(strcmp('23', $heure_h))) {echo "selected=\"selected\"";} ?>>23</option>
          </select>
            hh 
            <label for="HEURE_M"></label>
            <select name="HEURE_M" id="HEURE_M">
              <option value="00" <?php if (!(strcmp('00', $heure_m))) {echo "selected=\"selected\"";} ?>>00</option>
              <option value="05" <?php if (!(strcmp('05', $heure_m))) {echo "selected=\"selected\"";} ?>>05</option>
              <option value="10" <?php if (!(strcmp('10', $heure_m))) {echo "selected=\"selected\"";} ?>>10</option>
              <option value="15" <?php if (!(strcmp('15', $heure_m))) {echo "selected=\"selected\"";} ?>>15</option>
              <option value="20" <?php if (!(strcmp('20', $heure_m))) {echo "selected=\"selected\"";} ?>>20</option>
              <option value="25" <?php if (!(strcmp('25', $heure_m))) {echo "selected=\"selected\"";} ?>>25</option>
              <option value="30" <?php if (!(strcmp('30', $heure_m))) {echo "selected=\"selected\"";} ?>>30</option>
              <option value="35" <?php if (!(strcmp('35', $heure_m))) {echo "selected=\"selected\"";} ?>>35</option>
              <option value="40" <?php if (!(strcmp('40', $heure_m))) {echo "selected=\"selected\"";} ?>>40</option>
              <option value="45" <?php if (!(strcmp('45', $heure_m))) {echo "selected=\"selected\"";} ?>>45</option>
              <option value="50" <?php if (!(strcmp('50', $heure_m))) {echo "selected=\"selected\"";} ?>>50</option>
              <option value="55" <?php if (!(strcmp('55', $heure_m))) {echo "selected=\"selected\"";} ?>>55</option>
            </select> 
            minutes</td>
        </tr>
        <tr class="conducteur">
          <td>Nombre de place(s) disponible(s) <span class="dispo1">*</span></td>
          <td><label for="PLACES"></label>
            <select name="PLACES" id="PLACES">
              <option value="0" <?php if (!(strcmp(0, $row_RStrajet['PLACES']))) {echo "selected=\"selected\"";} ?>>0</option>
              <option value="1" <?php if (!(strcmp(1, $row_RStrajet['PLACES']))) {echo "selected=\"selected\"";} ?>>1</option>
              <option value="2" <?php if (!(strcmp(2, $row_RStrajet['PLACES']))) {echo "selected=\"selected\"";} ?>>2</option>
              <option value="3" <?php if (!(strcmp(3, $row_RStrajet['PLACES']))) {echo "selected=\"selected\"";} ?>>3</option>
              <option value="4" <?php if (!(strcmp(4, $row_RStrajet['PLACES']))) {echo "selected=\"selected\"";} ?>>4</option>
</select></td>
        </tr>
        <tr class="conducteur">
          <td>Confort du v&eacute;hicule <span class="dispo1">*</span></td>
          <td><input <?php if (!(strcmp($row_RStrajet['CONFORT'],"Basique"))) {echo "checked=\"checked\"";} ?> type="radio" name="CONFORT" value="Basique" id="CONFORT_0" />
Basique
<input <?php if (!(strcmp($row_RStrajet['CONFORT'],"Normal"))) {echo "checked=\"checked\"";} ?> type="radio" name="CONFORT" value="Normal" id="CONFORT_1" />
Normal
<input <?php if (!(strcmp($row_RStrajet['CONFORT'],"Confortable"))) {echo "checked=\"checked\"";} ?> type="radio" name="CONFORT" value="Confortable" id="CONFORT_2" />
Confortable
<input <?php if (!(strcmp($row_RStrajet['CONFORT'],"Luxe"))) {echo "checked=\"checked\"";} ?> type="radio" name="CONFORT" value="Luxe" id="CONFORT_3" />
Luxe</td>
        </tr>
        <tr class="conducteur">
          <td>Prix par personne <span class="dispo1">*</span></td>
          <td><label for="PRIX"></label>
            <input name="PRIX" type="text" id="PRIX" value="<?php echo $row_RStrajet['PRIX']; ?>" size="3" maxlength="3" />
          &euro;</td>
        </tr>
        <tr class="conducteur">
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr class="conducteur">
          <td colspan="2"><h2>Etapes &eacute;ventuelles (facultatif)</h2>
          <p>Les &eacute;tapes sont utilis&eacute;es pour faire resortir votre parcours dans le moteur de recherche sur les villes ci-dessous. Cela suppose &eacute;videmment que vous poussiez y d&eacute;poser des passagers.</p></td>
        </tr>
        <tr class="conducteur">
          <td colspan="2"><table width="100%" border="0" cellpadding="3" cellspacing="0">
              <tr>
              <td>&nbsp;</td>
              <td>Ville</td>
              <td align="center">Prix du trajet depuis la ville de <strong id="villeetape">d&eacute;part</strong></td>
              </tr>
            <tr>
              <td width="147">Etape1 <?php $pays_desc = 'etape1'; require("include/pays_choix.php"); ?>
              </td>
              <td>
                <input name="ETAPE1" type="text" id="ETAPE1" onfocus="blank3()" onkeyup="etape1()" value="<?php echo $row_RStrajet['ETAPE1']; ?>" size="25" <?php if($row_RStrajet['ETAPE1']!==NULL){echo 'class="check"';}; ?>/><div id="liste_etape1"></div>
                <input type="hidden" name="ETAPE1_LAT" id="ETAPE1_LAT" value="<?php echo $row_RStrajet['ETAPE1_LAT']; ?>" />
                <input type="hidden" name="ETAPE1_LON" id="ETAPE1_LON" value="<?php echo $row_RStrajet['ETAPE1_LON']; ?>" /></td>
              <td align="center"><input name="PRIX1" type="text" id="PRIX1" value="<?php echo $row_RStrajet['PRIX1']; ?>" size="3" maxlength="3" /> 
                &euro;</td>
            </tr>
            <tr>
              <td>Etape2 <?php $pays_desc = 'etape2'; require("include/pays_choix.php"); ?>
              </td>
              <td>
                <input name="ETAPE2" type="text" id="ETAPE2" onfocus="blank4()" onkeyup="etape2()" value="<?php echo $row_RStrajet['ETAPE2']; ?>" size="25" <?php if($row_RStrajet['ETAPE2']!==NULL){echo 'class="check"';}; ?>/><div id="liste_etape2"></div><input type="hidden" name="ETAPE2_LAT" id="ETAPE2_LAT" value="<?php echo $row_RStrajet['ETAPE2_LAT']; ?>" />
                <input type="hidden" name="ETAPE2_LON" id="ETAPE2_LON" value="<?php echo $row_RStrajet['ETAPE2_LON']; ?>" />
              </td>
              <td align="center"><input name="PRIX2" type="text" id="PRIX1" value="<?php echo $row_RStrajet['PRIX2']; ?>" size="3" maxlength="3" /> 
                &euro;</td>
            </tr>
            <tr>
              <td>Etape3 <?php $pays_desc = 'etape3'; require("include/pays_choix.php"); ?>
              </td>
              <td>
                <input name="ETAPE3" type="text" id="ETAPE3" onfocus="blank5()" onkeyup="etape3()" value="<?php echo $row_RStrajet['ETAPE3']; ?>" size="25" <?php if($row_RStrajet['ETAPE3']!==NULL){echo 'class="check"';}; ?>/><div id="liste_etape3"></div><input type="hidden" name="ETAPE3_LAT" id="ETAPE3_LAT" value="<?php echo $row_RStrajet['ETAPE3_LAT']; ?>" />
                <input type="hidden" name="ETAPE3_LON" id="ETAPE3_LON" value="<?php echo $row_RStrajet['ETAPE3_LON']; ?>" />
                </td>
              <td align="center"><input name="PRIX3" type="text" id="PRIX3" value="<?php echo $row_RStrajet['PRIX3']; ?>" size="3" maxlength="3" /> 
                &euro;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><h2>Commentaires (importants)</h2>
          <p>          (d&eacute;tails sur votre parcours, sur le lieu pr&eacute;cis du d&eacute;part, sur  vos attentes, si vous &ecirc;tes fumeur, si vous acceptez les animaux de compagnie, etc.)</p></td>
        </tr>
        <tr>
          <td colspan="2"><label for="COMMENTAIRES"></label>
          <textarea name="COMMENTAIRES" id="COMMENTAIRES" cols="45" rows="5"><?php echo $row_RStrajet['COMMENTAIRES']; ?></textarea></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><h2>Vous</h2></td>
        </tr>
        <tr>
          <td>Vous &ecirc;tes <span class="dispo1">*</span></td>
          <td><input <?php if (!(strcmp($row_RStrajet['CIVILITE'],"homme"))) {echo "checked=\"checked\"";} ?> type="radio" name="CIVILITE" value="homme" id="CIVILITE_0" />
un homme
  <input <?php if (!(strcmp($row_RStrajet['CIVILITE'],"femme"))) {echo "checked=\"checked\"";} ?> type="radio" name="CIVILITE" value="femme" id="CIVILITE_1" />
une femme</td>
        </tr>
        <tr>
          <td>Votre nom/pseudo<span class="dispo1">*</span></td>
          <td><label for="NOM"></label>
          <input name="NOM" type="text" id="NOM" value="<?php echo $row_RStrajet['NOM']; ?>" /></td>
        </tr>
        <tr>
          <td>Votre &acirc;ge <em>(facultatif)</em></td>
          <td><label for="AGE"></label>
          <input name="AGE" type="text" id="AGE" value="<?php echo $row_RStrajet['AGE']; ?>" size="3" maxlength="3" /> 
          ans</td>
        </tr>
        <tr>
          <td>Votre t&eacute;l&eacute;phone portable</td>
          <td><label for="TELEPHONE"></label>
          <input name="TELEPHONE" type="text" id="TELEPHONE" value="<?php echo $row_RStrajet['TELEPHONE']; ?>" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>Votre num&eacute;ro de portable sera affich&eacute; tel quel. Si vous ne souhaitez pas laisser votre portable sur le site, ne remplissez pas ce champs</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input type="submit" name="button" id="button" value="Enregistrer les modifications" />
          <input type="hidden" name="EMAIL" id="EMAIL" value="<?php echo $row_RStrajet['EMAIL']; ?>" />
           <input type="hidden" name="CODEM" id="CODEM" value="<?php echo $row_RStrajet['CODE_MODIFICATION']; ?>" />
          <input type="hidden" name="c" id="c" value="<?php echo $row_RStrajet['CODE_MODIFICATION']; ?>" /></td>
        </tr>
      </table>
      <input type="hidden" name="MM_update" value="form1" />
    </form>
    <p>&nbsp;</p>
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
