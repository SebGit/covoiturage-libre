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


  mysqli_select_db($bddcovoiturette , $database_bddcovoiturette);
  $Result1 = mysqli_query($bddcovoiturette ,$insertSQL) or die(mysqli_error($bddcovoiturette));

  $insertGoTo = "confirmation.php?c=" . $wpas . "&e=" . urlencode($_POST['EMAIL']);
 /* if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }*/
  header(sprintf("Location: %s", $insertGoTo));
}


// DUPLIQUER / RETOURNER TRAJET

$Heure = array('12', '00');
$pays_js = '';
$comm_duplicate = '';
function checkVal($name, $val = NULL, $type = NULL) {
	global $TrajR;
	$return = '';
	if (isset ($TrajR[$name]))
	{
	    if ($type == 'option') {
		if ($TrajR[$name] == $val) {
			$return = ' selected="selected" ';
		}
	     } elseif (!$val) {
		$return = ' value="' . $TrajR[$name] . '" ';
	     } elseif ($TrajR[$name] == $val) {
		$return = ' checked="checked" ';
	     }
	}
	return $return;
}

if (isset($_GET['c']) && !empty($_GET['c']) && isset($_GET['c2']) && !empty($_GET['c2']) && isset($_GET['a']) && !empty($_GET['a'])) {
	
	if (strlen($_GET['c']) !== 25 || !ctype_alnum($_GET['c'])) {
		header("Location: interdit.php");
		die();
	}
	$Actions = array('r', 'd');
	if (!in_array($_GET['a'], $Actions)) {
		header("Location: interdit.php");
		die();
	}
	
	// get trajet infos
	 mysqli_select_db($bddcovoiturette , $database_bddcovoiturette);
	$query_RStrajet = sprintf("SELECT * FROM trajets WHERE 1 AND CODE_CREATION = %s LIMIT 1", GetSQLValueString($_GET['c'], "text"));
	
	$RStrajet = mysqli_query($bddcovoiturette ,$query_RStrajet) or die(mysqli_error($bddcovoiturette));
	$Traj = mysqli_fetch_assoc($RStrajet);
	mysqli_free_result($RStrajet);
	
	// check email code
	if (strcmp(sha1($Traj['EMAIL'] . "_covoiturette2353"), $_GET['c2']) !== 0) {
		header("Location: interdit.php");
		die();
	}
	
	$Heure = explode(':', $Traj['HEURE']);
	
	$TrajR = $Traj;
	
	!empty($TrajR['ETAPE1']) ? $etape1 = true :  $etape1 = false;
	!empty($TrajR['ETAPE2']) ? $etape2 = true :  $etape2 = false;
	!empty($TrajR['ETAPE3']) ? $etape3 = true :  $etape3 = false;
	
	$TrajR['DATE_PARCOURS'] = '';
	
	if ($_GET['a'] == 'r') {
		$TrajR['DEPART']		= $Traj['ARRIVEE'];
		$TrajR['ARRIVEE']		= $Traj['DEPART'];
		$TrajR['DEPART_LAT']	= $Traj['ARRIVEE_LAT'];
		$TrajR['DEPART_LON']	= $Traj['ARRIVEE_LON'];
		$TrajR['ARRIVEE_LON']	= $Traj['DEPART_LON'];
		$TrajR['ARRIVEE_LAT']	= $Traj['DEPART_LAT'];
		
		if ($etape1 && $etape2 && $etape3) {
			$TrajR['ETAPE1']		= $Traj['ETAPE3'];
			$TrajR['ETAPE3']		= $Traj['ETAPE1'];
			$TrajR['ETAPE1_LAT']	= $Traj['ETAPE3_LAT'];
			$TrajR['ETAPE3_LAT']	= $Traj['ETAPE1_LAT'];
			$TrajR['ETAPE1_LON']	= $Traj['ETAPE3_LON'];
			$TrajR['ETAPE3_LON']	= $Traj['ETAPE1_LON'];
			$TrajR['PRIX1'] = $Traj['PRIX'] - $Traj['PRIX3'];
			$TrajR['PRIX2'] = $TrajR['PRIX1'] + $Traj['PRIX3'] - $Traj['PRIX2'];
			$TrajR['PRIX3'] = $TrajR['PRIX2'] + $Traj['PRIX2'] - $Traj['PRIX1'];
		} elseif ($etape1 && $etape2) {
			$TrajR['ETAPE1']		= $Traj['ETAPE2'];
			$TrajR['ETAPE2']		= $Traj['ETAPE1'];
			$TrajR['ETAPE1_LAT']	= $Traj['ETAPE2_LAT'];
			$TrajR['ETAPE2_LAT']	= $Traj['ETAPE1_LAT'];
			$TrajR['ETAPE1_LON']	= $Traj['ETAPE2_LON'];
			$TrajR['ETAPE2_LON']	= $Traj['ETAPE1_LON'];
			$TrajR['PRIX1'] = $Traj['PRIX'] - $Traj['PRIX2'];
			$TrajR['PRIX2'] = $Traj['PRIX'] - $Traj['PRIX1'];
		} elseif ($etape1) {
			$TrajR['PRIX1'] = $Traj['PRIX'] - $Traj['PRIX1'];
		}
	} elseif ($_GET['a'] == 'd') {
		$comm_duplicate = $Traj['COMMENTAIRES'];
	}
	
	
	$PaysNum = array('BE'=>0, 'DE'=>1, 'ES'=>2, 'FR'=>3, 'IT'=>4, 'LU'=>5, 'CH'=>7);
	
	$Pays = explode(" (", $TrajR['DEPART']);
	$TrajR['DEPART_PAYS'] = substr($Pays[1], 0 ,2);
	$pays_js .= "$('#PAYS_DEPART_" . $PaysNum[$TrajR['DEPART_PAYS']] . "').trigger('click')" . PHP_EOL;
	
	$Pays = explode(" (", $TrajR['ARRIVEE']);
	$TrajR['ARRIVEE_PAYS'] = substr($Pays[1], 0 ,2);
	$pays_js .= "$('#PAYS_ARRIVEE_" . $PaysNum[$TrajR['ARRIVEE_PAYS']] . "').trigger('click')" . PHP_EOL;
	
	if ($etape1) {
		$Pays = explode(" (", $TrajR['ETAPE1']);
		$TrajR['ETAPE1_PAYS'] = substr($Pays[1], 0 ,2);
		$pays_js .= "$('#PAYS_ETAPE1_" . $PaysNum[$TrajR['ETAPE1_PAYS']] . "').trigger('click')" . PHP_EOL;
	}
	
	if ($etape2) {
		$Pays = explode(" (", $TrajR['ETAPE2']);
		$TrajR['ETAPE2_PAYS'] = substr($Pays[1], 0 ,2);
		$pays_js .= "$('#PAYS_ETAPE2_" . $PaysNum[$TrajR['ETAPE2_PAYS']] . "').trigger('click')" . PHP_EOL;	
	}
	
	if ($etape3) {
		$Pays = explode(" (", $TrajR['ETAPE3']);
		$TrajR['ETAPE3_PAYS'] = substr($Pays[1], 0 ,2);
		$pays_js .= "$('#PAYS_ETAPE3_" . $PaysNum[$TrajR['ETAPE3_PAYS']] . "').trigger('click')" . PHP_EOL;
	}

}
//
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
var map,
	directionsDisplay,
	directionsService = new google.maps.DirectionsService();

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
	
	var myorigin_lat	= $('#DEPART_LAT').val();
	var myorigin_lon	= $('#DEPART_LON').val();
	var mydest_lat		= $('#ARRIVEE_LAT').val();
	var mydest_lon		= $('#ARRIVEE_LON').val();
	
	directionsService.route({
		origin:	new google.maps.LatLng(myorigin_lat, myorigin_lon),
		destination: new google.maps.LatLng(mydest_lat, mydest_lon),
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

$(document).ready(function(){
	init();
	init2();
	init3();
	init4();
	init5();
});

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
	if (key_count == key_count_global) {
		var ville	= $('#ARRIVEE').val();
		var ville2	= encodeURI(ville);
		var chiffre	= $('#ARRIVEE').val().length;
		var pays	= encodeURI($('input[name=PAYS_ARRIVEE]:checked').val());
		if (chiffre>=3) {
			$('#ARRIVEE').addClass('wait');
			$('#liste_arrivee').load('ajax/arrivee_flag.php?COMMUNE='+ville2+ '&PAYS=' + pays);
			$('#liste_arrivee').show();
		} else {
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
	} else {
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
          <td><input type="radio" name="TYPE" value="Conducteur" id="TYPE_0" onclick="conducteur()" <?=checkVal('TYPE', 'Conducteur')?> />
            <label for="TYPE_0">Conducteur</label>
            <input type="radio" name="TYPE" value="Passager" id="TYPE_1" onclick="conducteur()"  <?=checkVal('TYPE', 'Passager')?> />
            <label for="TYPE_1">Passager</label></td>
        </tr>
        <tr>
          <td>Ville de d&eacute;part <span class="dispo1">*</span>
          <?php $pays_desc = 'depart'; require("include/pays_choix.php"); ?>
          </td>
          <td id="focusdepart">
          <input name="DEPART" type="text" id="DEPART" size="25" onkeyup="depart()" onfocus="blank()" <?=checkVal('DEPART')?> /><div id="liste_depart"></div>
          <input type="hidden" name="DEPART_LAT" id="DEPART_LAT" <?=checkVal('DEPART_LAT')?> />
          <input type="hidden" name="DEPART_LON" id="DEPART_LON" <?=checkVal('DEPART_LON')?> />
          <input type="hidden" name="GERARD" id="GERARD" /> <a href="manque-une-ville.html" class="iframe">&gt; il manque une ville ?</a></td>
        </tr>
        <tr>
          <td>Ville d'arriv&eacute;e <span class="dispo1">*</span>
          	<?php $pays_desc = 'arrivee'; require("include/pays_choix.php"); ?>
          </td>
          <td>
          <input name="ARRIVEE" type="text" id="ARRIVEE" size="25" onkeyup="arrivee()" onfocus="blank2()" <?=checkVal('ARRIVEE')?> /><div id="liste_arrivee"></div>
          <input type="hidden" name="ARRIVEE_LAT" id="ARRIVEE_LAT" <?=checkVal('ARRIVEE_LAT')?> />
          <input type="hidden" name="ARRIVEE_LON" id="ARRIVEE_LON" <?=checkVal('ARRIVEE_LON')?> />
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
          <td>
			<select name="HEURE_H" id="HEURE_H">
 			<?php
			for ($i=0; $i<24; $i++) {
				if ($i<10) $i = '0'.$i;
				$sel = '';
				if ($i == $Heure[0]) $sel = 'selected="selected"';
				echo '<option value="'.$i.'" '.$sel.'>'.$i.'</option>' . PHP_EOL;
			}
			?>
          </select>
            h 
            <select name="HEURE_M" id="HEURE_M">
             <?php
			for ($i=0; $i<60; $i=$i+5) {
				if ($i<10) $i = '0'.$i;
				$sel = '';
				if ($i == $Heure[1]) $sel = 'selected="selected"';
				echo '<option value="'.$i.'" '.$sel.'>'.$i.'</option>' . PHP_EOL;
			}
			?>
            </select> 
            minutes</td>
        </tr>
        <tr class="conducteur">
          <td>Nombre de place(s) <br />
          disponible(s) <span class="dispo1">*</span></td>
          <td>
          	<select name="PLACES" id="PLACES">
	            <option value=""></option>
            <?php for ($i=1; $i<5; $i++) : ?>
				<option value="<?=$i?>" <?=checkVal('PLACES', $i, 'option')?>><?=$i?></option>
			<?php endfor; ?>
			</select>
		</td>
        </tr>
        <tr class="conducteur">
          <td>Confort du v&eacute;hicule <span class="dispo1">*</span></td>
          <td><input type="radio" name="CONFORT" value="Basique" id="CONFORT_0" <?=checkVal('CONFORT', 'Basique')?> />
            Basique
            <input type="radio" name="CONFORT" value="Normal" id="CONFORT_1"<?=checkVal('CONFORT', 'Normal')?> />
            Normal
            <input type="radio" name="CONFORT" value="Confortable" id="CONFORT_2" <?=checkVal('CONFORT', 'Confortable')?>/>
            Confortable
            <input type="radio" name="CONFORT" value="Luxe" id="CONFORT_3" <?=checkVal('CONFORT', 'Luxe')?>/>
            Luxe</td>
        </tr>
        <tr class="conducteur">
          <td>Prix par personne <span class="dispo1">*</span></td>
          <td>
            
            <input name="PRIX" type="text" id="PRIX" size="3" maxlength="3" <?=checkVal('PRIX')?> />
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
                <input name="ETAPE1" type="text" id="ETAPE1" size="25" onkeyup="etape1()" onfocus="blank3()"  <?=checkVal('ETAPE1')?> /><div id="liste_etape1"></div>
                <input type="hidden" name="ETAPE1_LAT" id="ETAPE1_LAT" <?=checkVal('ETAPE1_LAT')?> />
                <input type="hidden" name="ETAPE1_LON" id="ETAPE1_LON" <?=checkVal('ETAPE1_LON')?> /></td>
              <td align="center"><input name="PRIX1" type="text" id="PRIX1" size="3" maxlength="3"  <?=checkVal('PRIX1')?> /> 
                &euro;</td>
            </tr>
            <tr>
              <td>Etape2
              	 <?php $pays_desc = 'etape2'; require("include/pays_choix.php"); ?>
              </td>
              <td>
                <input name="ETAPE2" type="text" id="ETAPE2" size="25" onkeyup="etape2()" onfocus="blank4()" <?=checkVal('ETAPE2')?> /><div id="liste_etape2"></div>
                <input type="hidden" name="ETAPE2_LAT" id="ETAPE2_LAT" <?=checkVal('ETAPE2_LAT')?> />
                <input type="hidden" name="ETAPE2_LON" id="ETAPE2_LON" <?=checkVal('ETAPE2_LON')?> />
              </td>
              <td align="center"><input name="PRIX2" type="text" id="PRIX2" size="3" maxlength="3"  <?=checkVal('PRIX2')?>/> 
                &euro;</td>
            </tr>
            <tr>
              <td>Etape3
              	 <?php $pays_desc = 'etape3'; require("include/pays_choix.php"); ?>
              </td>
              <td>
                <input name="ETAPE3" type="text" id="ETAPE3" size="25" onkeyup="etape3()" onfocus="blank5()" <?=checkVal('ETAPE3')?> /><div id="liste_etape3"></div>
                <input type="hidden" name="ETAPE3_LAT" id="ETAPE3_LAT" <?=checkVal('ETAPE3_LAT')?> />
                <input type="hidden" name="ETAPE3_LON" id="ETAPE3_LON" <?=checkVal('ETAPE3_LON')?> />
                </td>
              <td align="center"><input name="PRIX3" type="text" id="PRIX3" size="3" maxlength="3" <?=checkVal('PRIX3')?>/> 
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
          <td colspan="2">
          <textarea name="COMMENTAIRES" id="COMMENTAIRES" cols="45" rows="5"><?=$comm_duplicate?></textarea></td>
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
          <td><input type="radio" name="CIVILITE" value="homme" id="CIVILITE_0" <?=checkVal('CIVILITE' , 'homme')?> />
                un homme
                  <input type="radio" name="CIVILITE" value="femme" id="CIVILITE_1" <?=checkVal('CIVILITE', 'femme')?> />
                une femme</td>
        </tr>
        <tr>
          <td>Votre nom/pseudo<span class="dispo1">*</span></td>
          <td><label for="NOM"></label>
          <input type="text" name="NOM" id="NOM"  <?=checkVal('NOM')?>/></td>
        </tr>
        <tr>
          <td>Votre &acirc;ge <em>(facultatif)</em></td>
          <td><label for="AGE"></label>
          <input name="AGE" type="text" id="AGE" size="3" maxlength="3" <?=checkVal('AGE')?> /> 
          ans</td>
        </tr>
        <tr>
          <td>Votre t&eacute;l&eacute;phone portable</td>
          <td><label for="TELEPHONE"></label>
          <input type="text" name="TELEPHONE" id="TELEPHONE"  <?=checkVal('TELEPHONE')?>/></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>Votre num&eacute;ro de portable sera affich&eacute; tel quel. Si vous ne souhaitez pas laisser votre portable sur le site, ne remplissez pas ce champs</td>
        </tr>
        <tr>
          <td>Votre email <span class="dispo1">*</span></td>
          <td><label for="EMAIL"></label>
          <input type="text" name="EMAIL" id="EMAIL" <?=checkVal('EMAIL')?>  /></td>
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
<!-- InstanceEnd -->
<script type="text/javascript">
/* <![CDATA[ */
$(document).ready(function(){
	 <?=$pays_js?>
	 $('.flags_table').hide();
});
/* ]]> */
</script> 
</html>
