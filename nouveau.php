<?php
// anti-CSRF token
require_once("ScriptLibrary/form_functions.php");

session_start();

if (isset($_POST) && !empty($_POST)) {
	if (!isset($_POST['srctoken']) || !isset($_SESSION['cvtoken'])) {
		header("Location: interdit.php");
		die();
	}
	if ($_POST['srctoken'] !== $_SESSION['cvtoken']) {
		header("Location: interdit.php");
		die();
	}
}

$myToken = getToken(); 
/**/

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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
		
	$heure=$_POST['HEURE_H'].':'.$_POST['HEURE_M'];
	$date=explode('-',$_POST['DATE_PARCOURS']);
	$datefin=$date[2].'-'.$date[1].'-'.$date[0];
	
	$cars="AZERTYUIPQSDFGHJKLMWXCVBNabcdefghijklmnopqrstuvwxyz0123456789";
		$wlong=strlen($cars);
		$wpas="";
		$wpas2="";
		$wpas3="";
		$taille=25;

		srand((double)microtime()*1000000);

		for($i=0;$i<$taille;$i++){
     		 $wpos=rand(0,$wlong-1);
      		 $wpas=$wpas.substr($cars,$wpos,1);
		}
		for($i=0;$i<$taille;$i++){
     		 $wpos2=rand(0,$wlong-1);
      		 $wpas2=$wpas2.substr($cars,$wpos2,1);
		}
		for($i=0;$i<$taille;$i++){
     		 $wpos3=rand(0,$wlong-1);
      		 $wpas3=$wpas3.substr($cars,$wpos3,1);
		}
		
		if((!isset($_POST['DEPART_LAT']))||($_POST['DEPART_LAT']=='')||($_POST['DEPART_LAT']==NULL)){
			header('location:erreur.php');
			die();
		}
		
		$ip=$_SERVER['REMOTE_ADDR'];
	
  $insertSQL = sprintf("INSERT INTO trajets (
  							TYPE, DEPART, DEPART_LAT, DEPART_LON, ARRIVEE, ARRIVEE_LAT, ARRIVEE_LON, DATE_PARCOURS, HEURE, PLACES, CONFORT, COMMENTAIRES, PRIX,
							ETAPE1, ETAPE1_LAT, ETAPE1_LON, PRIX1, ETAPE2, ETAPE2_LAT, ETAPE2_LON, PRIX2, ETAPE3, ETAPE3_LAT, ETAPE3_LON, PRIX3,
							CIVILITE, NOM, AGE, EMAIL, TELEPHONE, CODE_CREATION, CODE_MODIFICATION, CODE_SUPPRESSION, IP_CREATION
							)
							 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['TYPE'], "text"),
                       GetSQLValueString($_POST['DEPART'], "text"),
					   GetSQLValueString($_POST['DEPART_LAT'], "text"),
					   GetSQLValueString($_POST['DEPART_LON'], "text"),
                       GetSQLValueString($_POST['ARRIVEE'], "text"),
					   GetSQLValueString($_POST['ARRIVEE_LAT'], "text"),
					   GetSQLValueString($_POST['ARRIVEE_LON'], "text"),
                       GetSQLValueString($datefin, "date"),
					   GetSQLValueString($heure, "text"),
                       GetSQLValueString($_POST['PLACES'], "int"),
					   GetSQLValueString($_POST['CONFORT'], "text"),
                       GetSQLValueString($_POST['COMMENTAIRES'], "text"),
                       GetSQLValueString($_POST['PRIX'], "int"),
                       GetSQLValueString($_POST['ETAPE1'], "text"),
					   GetSQLValueString($_POST['ETAPE1_LAT'], "text"),
					   GetSQLValueString($_POST['ETAPE1_LON'], "text"),
                       GetSQLValueString($_POST['PRIX1'], "int"),
                       GetSQLValueString($_POST['ETAPE2'], "text"),
					   GetSQLValueString($_POST['ETAPE2_LAT'], "text"),
					   GetSQLValueString($_POST['ETAPE2_LON'], "text"),
                       GetSQLValueString($_POST['PRIX2'], "int"),
                       GetSQLValueString($_POST['ETAPE3'], "text"),
					   GetSQLValueString($_POST['ETAPE3_LAT'], "text"),
					   GetSQLValueString($_POST['ETAPE3_LON'], "text"),
                       GetSQLValueString($_POST['PRIX3'], "int"),
                       GetSQLValueString($_POST['CIVILITE'], "text"),
                       GetSQLValueString($_POST['NOM'], "text"),
					   GetSQLValueString($_POST['AGE'], "text"),
                       GetSQLValueString($_POST['EMAIL'], "text"),
                       GetSQLValueString($_POST['TELEPHONE'], "text"),
					   GetSQLValueString($wpas, "text"),
					   GetSQLValueString($wpas2, "text"),
					   GetSQLValueString($wpas3, "text"),
					   GetSQLValueString($ip, "text"));
  if (preg_match("/\bjavascript\b/i", $insertSQL)) {
     	header('location:erreur.php');
		die();
		}
  if (preg_match("/\byopmail\b/i", $insertSQL)) {
     	header('location:erreur.php');
		die();
		}
  if (preg_match("/\bmailinator\b/i", $insertSQL)) {
     	header('location:erreur.php');
		die();
		}
  if (preg_match("/\bscript\b/i", $insertSQL)) {
     	header('location:erreur.php');
		die();
		}
  if (preg_match("/\bhref\b/i", $insertSQL)) {
     	header('location:erreur.php');
		die();
		}


  mysql_select_db($database_bddcovoiturette, $bddcovoiturette);
  $Result1 = mysql_query($insertSQL, $bddcovoiturette) or die(mysql_error());

  $insertGoTo = "confirmation.php?c=".$wpas;
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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
  directionsDisplay.setPanel(document.getElementById('map_infos'));

 }

function showItineraire() {
   waypts = new Array();
   
   var etape1	= $('#ETAPE1').val();
   var etape1p	= etape1 + ', ' + $('input[name=PAYS_ETAPE1]:checked').val()
   var etape2	= $('#ETAPE2').val();
   var etape2p	= etape2 + ', ' + $('input[name=PAYS_ETAPE2]:checked').val()
   var etape3	= $('#ETAPE3').val();
   var etape3p	= etape3 + ', ' + $('input[name=PAYS_ETAPE3]:checked').val()
   
   if(etape1!==''){waypts.push({location:etape1p,stopover:true})};
   if(etape2!==''){waypts.push({location:etape2p,stopover:true})};
   if(etape3!==''){waypts.push({location:etape3p,stopover:true})};
   
	var myorigin	= $('#DEPART').val();
	var mydest		= $('#ARRIVEE').val();

	directionsService.route({
		origin:		myorigin,
		destination:	mydest,
   waypoints: waypts,
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
 
function init() {
	key_count_global = 0;
	document.getElementById("DEPART").onkeyup = function() {key_count_global++;setTimeout("depart("+key_count_global+")", 600);}
}
function init2() {
	key_count_global = 0;
	document.getElementById("ARRIVEE").onkeyup = function() {key_count_global++;setTimeout("arrivee("+key_count_global+")", 600);}
}
function init3() {
	key_count_global = 0;
	document.getElementById("ETAPE1").onkeyup = function() {key_count_global++;setTimeout("etape1("+key_count_global+")", 600);}
}
function init4() {
	key_count_global = 0;
	document.getElementById("ETAPE2").onkeyup = function() {key_count_global++;setTimeout("etape2("+key_count_global+")", 600);}
}
function init5() {
	key_count_global = 0;
	document.getElementById("ETAPE3").onkeyup = function() {key_count_global++;setTimeout("etape3("+key_count_global+")", 600);}
}
$(document).ready(init);
$(document).ready(init2);
$(document).ready(init3);
$(document).ready(init4);
$(document).ready(init5);


function depart(key_count) {
	if (key_count == key_count_global) {
		var ville	= $('#DEPART').val();
		var chiffre	= ville.length;
		var pays	= encodeURI($('input[name=PAYS_DEPART]:checked').val());
		ville		= encodeURI(ville);
		if (chiffre>=3) {
			$('#DEPART').addClass('wait');
        	$('#liste_depart').load('ajax/depart_flag.php?COMMUNE=' + ville + '&PAYS=' + pays);
			$('#liste_depart').show();
		} else {
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
	var pays	= encodeURI($('input[name=PAYS_ARRIVEE]:checked').val());
	if(chiffre>=3){
		$('#ARRIVEE').addClass('wait');
		$('#liste_arrivee').load('ajax/arrivee_flag.php?COMMUNE='+ville2+ '&PAYS=' + pays);
		$('#liste_arrivee').show();
	}
	else {
		$('#liste_arrivee').hide();
	}
	}
 }
 
 function etape1(key_count){
	 if(key_count == key_count_global) {
	var ville=$('#ETAPE1').val();
	var ville2=encodeURI(ville);
	var chiffre=$('#ETAPE1').val().length;
	var pays	= encodeURI($('input[name=PAYS_ETAPE1]:checked').val());
	if(chiffre>=3){
		$('#ETAPE1').addClass('wait');
		$('#liste_etape1').load('ajax/etape1_flag.php?COMMUNE='+ville2 + '&PAYS=' + pays);
		$('#liste_etape1').show();
	}
	else {
		$('#liste_etape1').hide();
		$('#ETAPE1').removeClass('wait');
	}}
 }
 function etape2(key_count){
	 if(key_count == key_count_global) {
	var ville=$('#ETAPE2').val();
	var ville2=encodeURI(ville);
	var chiffre=$('#ETAPE2').val().length;
	var pays	= encodeURI($('input[name=PAYS_ETAPE2]:checked').val());
	if(chiffre>=3){
		$('#ETAPE2').addClass('wait');
		$('#liste_etape2').load('ajax/etape2_flag.php?COMMUNE='+ville2 + '&PAYS=' + pays);
		$('#liste_etape2').show();
	}
	else {
		$('#liste_etape2').hide();
		$('#ETAPE2').removeClass('wait');
	}}
 }
 function etape3(key_count){
	 if(key_count == key_count_global) {
	var ville=$('#ETAPE3').val();
	var ville2=encodeURI(ville);
	var chiffre=$('#ETAPE3').val().length;
	var pays	= encodeURI($('input[name=PAYS_ETAPE3]:checked').val());
	if(chiffre>=3){
		$('#ETAPE3').addClass('wait');
		$('#liste_etape3').load('ajax/etape3_flag.php?COMMUNE='+ville2 + '&PAYS=' + pays);
		$('#liste_etape3').show();
	}
	else {
		$('#liste_etape3').hide();
		$('#ETAPE3').removeClass('wait');
	}}
 }
 
 function blank(){$('#DEPART').val('');$('#DEPART_LAT').val('');$('#DEPART_LON').val('');$('#DEPART').removeClass('check');}
 function blank2(){$('#ARRIVEE').val('');$('#ARRIVEE_LAT').val('');$('#ARRIVEE_LON').val('');$('#ARRIVEE').removeClass('check');}
 function blank3(){$('#ETAPE1').val('');$('#ETAPE1_LAT').val('');$('#ETAPE1_LON').val('');$('#ETAPE1').removeClass('check');}
 function blank4(){$('#ETAPE2').val('');$('#ETAPE2_LAT').val('');$('#ETAPE2_LON').val('');$('#ETAPE2').removeClass('check');}
 function blank5(){$('#ETAPE3').val('');$('#ETAPE3_LAT').val('');$('#ETAPE3_LON').val('');$('#ETAPE3').removeClass('check');}
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
	if((document.form1.TYPE[0].checked)&&(document.form1.ETAPE1.value!=='')&&(document.form1.ETAPE1_LAT.value==''))
	{alert('Veuillez prÈciser une premiËre Ètape dans la liste de suggestions s\'il vous plaÓt');document.form1.ETAPE1.focus();return false;}
else
	if((document.form1.TYPE[0].checked)&&(document.form1.ETAPE1.value!=='')&&(document.form1.PRIX1.value==''))
	{alert('Veuillez prÈciser le prix de la premiËre Ètape s\'il vous plaÓt');document.form1.PRIX1.focus();return false;}
else
	if((document.form1.TYPE[0].checked)&&(document.form1.ETAPE2.value!=='')&&(document.form1.ETAPE2_LAT.value==''))
	{alert('Veuillez prÈciser une seconde Ètape dans la liste de suggestions s\'il vous plaÓt');document.form1.ETAPE2.focus();return false;}
else
	if((document.form1.TYPE[0].checked)&&(document.form1.ETAPE2.value!=='')&&(document.form1.PRIX2.value==''))
	{alert('Veuillez prÈciser le prix de la seconde Ètape s\'il vous plaÓt');document.form1.PRIX2.focus();return false;}
else
	if((document.form1.TYPE[0].checked)&&(document.form1.ETAPE3.value!=='')&&(document.form1.ETAPE3_LAT.value==''))
	{alert('Veuillez prÈciser une troisiËme Ètape dans la liste de suggestions s\'il vous plaÓt');document.form1.ETAPE3.focus();return false;}
else
	if((document.form1.TYPE[0].checked)&&(document.form1.ETAPE3.value!=='')&&(document.form1.PRIX3.value==''))
	{alert('Veuillez prÈciser le prix de la troisiËme Ètape s\'il vous plaÓt');document.form1.PRIX3.focus();return false;}
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
    <a href="index.php">&lt; retour &agrave; la page d'accueil</a>
    <h1>Nouveau trajet    </h1>
    <div id="map_canvas">
    </div>
    <form name="form1" id="form1" method="POST" action="<?php echo $editFormAction; ?>" onsubmit="return CHECK()">
      <table width="570" border="0" cellpadding="3" cellspacing="0">
        <tr>
          <td colspan="2"><h2>Le parcours</h2></td>
        </tr>
        <tr>
          <td style="width:190px;">Je suis <span class="dispo1">*</span></td>
          <td><input type="radio" name="TYPE" value="Conducteur" id="TYPE_0" onclick="conducteur()" />
            <label for="TYPE_0">Conducteur</label>
            <input type="radio" name="TYPE" value="Passager" id="TYPE_1" onclick="conducteur()" />
            <label for="TYPE_1">Passager</label></td>
        </tr>
        <tr>
          <td>Ville de d&eacute;part <span class="dispo1">*</span>
          <?php $pays_desc = 'depart'; require("include/pays_choix.php"); ?>
          </td>
          <td id="focusdepart">
          <input name="DEPART" type="text" id="DEPART" size="25" onkeyup="depart()" onfocus="blank()" /><div id="liste_depart"></div>
          <input type="hidden" name="DEPART_LAT" id="DEPART_LAT" value="" />
          <input type="hidden" name="DEPART_LON" id="DEPART_LON" value="" />
          <input type="hidden" name="GERARD" id="GERARD" /> <a href="manque-une-ville.html" class="iframe">&gt; il manque une ville ?</a></td>
        </tr>
        <tr>
          <td>Ville d'arriv&eacute;e <span class="dispo1">*</span>
          	<?php $pays_desc = 'arrivee'; require("include/pays_choix.php"); ?>
          </td>
          <td>
          <input name="ARRIVEE" type="text" id="ARRIVEE" size="25" onkeyup="arrivee()" onfocus="blank2()" /><div id="liste_arrivee"></div>
          <input type="hidden" name="ARRIVEE_LAT" id="ARRIVEE_LAT" value="" />
          <input type="hidden" name="ARRIVEE_LON" id="ARRIVEE_LON" value="" />
          <input type="hidden" name="HARRY" id="HARRY" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><a href="#" onclick="showItineraire()">&gt; V&eacute;rifier le parcours sur la carte</a></td>
        </tr>
        <tr>
          <td>Date du parcours <span class="dispo1">*</span></td>
          <td><label for="DATE_PARCOURS"></label>
          <input name="DATE_PARCOURS" type="text" id="DATE_PARCOURS" size="10" maxlength="10" readonly="readonly" /></td>
        </tr>
        <tr>
          <td>Heure de d&eacute;part <span class="dispo1">*</span></td>
          <td><label for="HEURE"></label>
            <label for="HEURE_H"></label>
            <select name="HEURE_H" id="HEURE_H">
              <option value="00">00</option>
              <option value="01">01</option>
              <option value="02">02</option>
              <option value="03">03</option>
              <option value="04">04</option>
              <option value="05">05</option>
              <option value="06">06</option>
              <option value="07">07</option>
              <option value="08">08</option>
              <option value="09">09</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12" selected="selected">12</option>
              <option value="13">13</option>
              <option value="14">14</option>
              <option value="15">15</option>
              <option value="16">16</option>
              <option value="17">17</option>
              <option value="18">18</option>
              <option value="19">19</option>
              <option value="20">20</option>
              <option value="21">21</option>
              <option value="22">22</option>
              <option value="23">23</option>
          </select>
            hh 
            <label for="HEURE_M"></label>
            <select name="HEURE_M" id="HEURE_M">
              <option value="00">00</option>
              <option value="05">05</option>
              <option value="10">10</option>
              <option value="15">15</option>
              <option value="20">20</option>
              <option value="25">25</option>
              <option value="30">30</option>
              <option value="35">35</option>
              <option value="40">40</option>
              <option value="45">45</option>
              <option value="50">50</option>
              <option value="55">55</option>
            </select> 
            minutes</td>
        </tr>
        <tr class="conducteur">
          <td>Nombre de place(s) <br />
          disponible(s) <span class="dispo1">*</span></td>
          <td><label for="PLACES"></label>
            <select name="PLACES" id="PLACES">
            <option value=""></option>
			  <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
</select></td>
        </tr>
        <tr class="conducteur">
          <td>Confort du v&eacute;hicule <span class="dispo1">*</span></td>
          <td><input type="radio" name="CONFORT" value="Basique" id="CONFORT_0" />
Basique
<input type="radio" name="CONFORT" value="Normal" id="CONFORT_1" />
Normal
<input type="radio" name="CONFORT" value="Confortable" id="CONFORT_2" />
Confortable
<input type="radio" name="CONFORT" value="Luxe" id="CONFORT_3" />
Luxe</td>
        </tr>
        <tr class="conducteur">
          <td>Prix par personne <span class="dispo1">*</span></td>
          <td>
            
            <input name="PRIX" type="text" id="PRIX" size="3" maxlength="3" />
&euro; <a href="infos-assurance.html" class="iframe" style="margin-left:40px;">&gt; ne cherchez pas &agrave; faire de b&eacute;n&eacute;fices</a></td>
        </tr>
         <tr class="conducteur">
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr class="conducteur">
          <td colspan="2"><h2>Etapes &eacute;ventuelles (facultatif)</h2>
          <p>Les &eacute;tapes sont utilis&eacute;es pour faire resortir votre parcours dans le moteur de recherche sur les villes ci-dessous. Cela suppose &eacute;videmment que vous puissiez y d&eacute;poser/prendre des passagers.</p>
          <p><a href="fonctionnement-etapes.html" class="iframe">&gt; En savoir plus sur le fonctionnement des &eacute;tapes</a></p></td>
        </tr>
        <tr class="conducteur">
          <td colspan="2"><table width="100%" border="0" cellpadding="3" cellspacing="0">
              <tr>
              <td>&nbsp;</td>
              <td>Ville</td>
              <td align="center">Prix du trajet depuis la ville de <strong id="villeetape">d&eacute;part</strong></td>
              </tr>
            <tr>
              <td width="187">Etape1
              	 <?php $pays_desc = 'etape1'; require("include/pays_choix.php"); ?>
              </td>
              <td>
                <input name="ETAPE1" type="text" id="ETAPE1" size="25" onkeyup="etape1()" onfocus="blank3()" /><div id="liste_etape1"></div>
                <input type="hidden" name="ETAPE1_LAT" id="ETAPE1_LAT" value="" />
                <input type="hidden" name="ETAPE1_LON" id="ETAPE1_LON" value="" /></td>
              <td align="center"><input name="PRIX1" type="text" id="PRIX1" size="3" maxlength="3" value="" /> 
                &euro;</td>
            </tr>
            <tr>
              <td>Etape2
              	 <?php $pays_desc = 'etape2'; require("include/pays_choix.php"); ?>
              </td>
              <td>
                <input name="ETAPE2" type="text" id="ETAPE2" size="25" onkeyup="etape2()" onfocus="blank4()" /><div id="liste_etape2"></div><input type="hidden" name="ETAPE2_LAT" id="ETAPE2_LAT" value="" />
                <input type="hidden" name="ETAPE2_LON" id="ETAPE2_LON" value="" />
              </td>
              <td align="center"><input name="PRIX2" type="text" id="PRIX2" size="3" maxlength="3" value="" /> 
                &euro;</td>
            </tr>
            <tr>
              <td>Etape3
              	 <?php $pays_desc = 'etape3'; require("include/pays_choix.php"); ?>
              </td>
              <td>
                <input name="ETAPE3" type="text" id="ETAPE3" size="25" onkeyup="etape3()" onfocus="blank5()" /><div id="liste_etape3"></div><input type="hidden" name="ETAPE3_LAT" id="ETAPE3_LAT" value="" />
                <input type="hidden" name="ETAPE3_LON" id="ETAPE3_LON" value="" />
                </td>
              <td align="center"><input name="PRIX3" type="text" id="PRIX3" size="3" maxlength="3" value="" /> 
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
          <textarea name="COMMENTAIRES" id="COMMENTAIRES" cols="45" rows="5"></textarea></td>
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
          <td><input type="radio" name="CIVILITE" value="homme" id="CIVILITE_0" />
un homme
  <input type="radio" name="CIVILITE" value="femme" id="CIVILITE_1" />
une femme</td>
        </tr>
        <tr>
          <td>Votre nom/pseudo<span class="dispo1">*</span></td>
          <td><label for="NOM"></label>
          <input type="text" name="NOM" id="NOM" /></td>
        </tr>
        <tr>
          <td>Votre &acirc;ge <em>(facultatif)</em></td>
          <td><label for="AGE"></label>
          <input name="AGE" type="text" id="AGE" size="3" maxlength="3" /> 
          ans</td>
        </tr>
        <tr>
          <td>Votre t&eacute;l&eacute;phone portable</td>
          <td><label for="TELEPHONE"></label>
          <input type="text" name="TELEPHONE" id="TELEPHONE" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>Votre num&eacute;ro de portable sera affich&eacute; tel quel. Si vous ne souhaitez pas laisser votre portable sur le site, ne remplissez pas ce champs</td>
        </tr>
        <tr>
          <td>Votre email <span class="dispo1">*</span></td>
          <td><label for="EMAIL"></label>
          <input type="text" name="EMAIL" id="EMAIL" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>Obligatoire et valide. Un message de confirmation vous y sera envoy&eacute;.</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input type="submit" name="button" id="button" value="Enregistrer mon annonce" /></td>
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="form1" />
      <input id="srctoken" name="srctoken" type="hidden" value="<?php echo $myToken ?>" />
    </form>
    <p>&nbsp;</p>
    <!-- InstanceEndEditable -->
  </div>
    
    <div id="footer">
    <?php include('include-footer.php'); ?></div>

</div>
</body>
<!-- InstanceEnd --></html>
