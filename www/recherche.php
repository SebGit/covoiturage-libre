<?php
/**/
// -- sanitize inputs -- //
// total rows
if (isset($_GET['totalRows_rs']) && !empty($_GET['totalRows_rs'])) {
	if (!filter_var($_GET['totalRows_rs'], FILTER_VALIDATE_INT)) {
		header("Location: interdit.php");
		die;
	}
}

// date
if (isset($_POST['DATE_PARCOURS']) && !empty($_POST['DATE_PARCOURS'])) {
	
	$Temp = explode("-", $_POST['DATE_PARCOURS']);

	if (!isset($Temp[0]) or !isset($Temp[1]) or !isset($Temp[2])) {
		header("Location: interdit.php");
		die();
	}

	$Temp[0] = strlen(intval($Temp[0])) == 1 ? "0" . intval($Temp[0]) : intval($Temp[0]);
	$Temp[1] = strlen(intval($Temp[1])) == 1 ? "0" . intval($Temp[1]) : intval($Temp[1]);
	$Temp[2] = intval($Temp[2]);
	$temp = implode("-", $Temp);

	if (strcmp($temp, $_POST['DATE_PARCOURS']) !== 0) {
		header("Location: interdit.php");
		die();
	}
	
}

// tri
if (isset($_POST['TRI']) && !empty($_POST['TRI'])) {

	if (strlen($_POST['TRI']) > 11) {
		header("Location: interdit.php");
		die();
	}

	$TriList = array("DATE HEURE", "PRIX ASC", "PRIX DESC", "PLACES ASC", "PLACES DESC");
	if (!in_array(strval($_POST['TRI']), $TriList)) {
		header("Location: interdit.php");
		die();
	}

}
// -- /sanitize inputs -- //

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

require_once('Connections/bddcovoiturette.php');

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

// session pour garder les données du POST

if (isset($_POST) && !empty($_POST)) {
	$_SESSION['postdata'] = $_POST;
	header("Location: recherche.php");
	die();
} elseif (isset($_SESSION['postdata'])) {
	$_POST = $_SESSION['postdata'];
}
//

$requete	= '';
$requete2	= '';

$departkm	= 60;
$arriveekm	= 60;

if(isset($_POST['DEPART_KM'])){
	$departkm=$_POST['DEPART_KM'];
}
if(isset($_POST['ARRIVEE_KM'])){
	$arriveekm=$_POST['ARRIVEE_KM'];
}

$colname_RStrajets = "-1";
if (isset($_POST['DEPART'])) {
  $colname_RStrajets = $_POST['DEPART'];
}
$depart_lat = GetSQLValueString($_POST['DEPART_LAT'], "double");
$depart_lon = GetSQLValueString($_POST['DEPART_LON'], "double");

//préparation de la recherche sur la ville de départ	
$formuledep1="(6366*acos(cos(radians($depart_lat))*cos(radians(`DEPART_LAT`))*cos(radians(`DEPART_LON`) -radians($depart_lon))+sin(radians($depart_lat))*sin(radians(`DEPART_LAT`)))) AS DEP1";

$formuledep2="(6366*acos(cos(radians($depart_lat))*cos(radians(`ETAPE1_LAT`))*cos(radians(`ETAPE1_LON`) -radians($depart_lon))+sin(radians($depart_lat))*sin(radians(`ETAPE1_LAT`)))) AS DEP2";

$formuledep3="(6366*acos(cos(radians($depart_lat))*cos(radians(`ETAPE2_LAT`))*cos(radians(`ETAPE2_LON`) -radians($depart_lon))+sin(radians($depart_lat))*sin(radians(`ETAPE2_LAT`)))) AS DEP3";

$formuledep4="(6366*acos(cos(radians($depart_lat))*cos(radians(`ETAPE3_LAT`))*cos(radians(`ETAPE3_LON`) -radians($depart_lon))+sin(radians($depart_lat))*sin(radians(`ETAPE3_LAT`)))) AS DEP4";

$formuledepsql=$formuledep1.','.$formuledep2.','.$formuledep3.','.$formuledep4;

$requetedep="(DEP1<='".$departkm."' OR DEP2<='".$departkm."' OR DEP3<='".$departkm."' OR DEP4<='".$departkm."')";

$colname_RStrajets2 = "-1";
if (isset($_POST['ARRIVEE'])) {
  $colname_RStrajets2 = $_POST['ARRIVEE'];
}

$order = 'DATE_PARCOURS ASC, HEURE ASC';
if (isset($_POST['TRI']) && $_POST['TRI'] !== 'DATE HEURE') {
	$order=$_POST['TRI'];
}

//préparation de la recherche si une ville d'arrivée est renseignée
if ($_POST['ARRIVEE'] !== '') {
	$arrivee_lat = GetSQLValueString($_POST['ARRIVEE_LAT'], "double");
	$arrivee_lon = GetSQLValueString($_POST['ARRIVEE_LON'], "double");
	
	$formulearr1="(6366*acos(cos(radians($arrivee_lat))*cos(radians(`ARRIVEE_LAT`))*cos(radians(`ARRIVEE_LON`) -radians($arrivee_lon))+sin(radians($arrivee_lat))*sin(radians(`ARRIVEE_LAT`)))) AS ARR1";
	
	$formulearr2="(6366*acos(cos(radians($arrivee_lat))*cos(radians(`ETAPE1_LAT`))*cos(radians(`ETAPE1_LON`) -radians($arrivee_lon))+sin(radians($arrivee_lat))*sin(radians(`ETAPE1_LAT`)))) AS ARR2";
	
	$formulearr3="(6366*acos(cos(radians($arrivee_lat))*cos(radians(`ETAPE2_LAT`))*cos(radians(`ETAPE2_LON`) -radians($arrivee_lon))+sin(radians($arrivee_lat))*sin(radians(`ETAPE2_LAT`)))) AS ARR3";
	
	$formulearr4="(6366*acos(cos(radians($arrivee_lat))*cos(radians(`ETAPE3_LAT`))*cos(radians(`ETAPE3_LON`) -radians($arrivee_lon))+sin(radians($arrivee_lat))*sin(radians(`ETAPE3_LAT`)))) AS ARR4";
	
	$formulearrsql=','.$formulearr1.','.$formulearr2.','.$formulearr3.','.$formulearr4;
	
	$requetearr="AND (ARR1<='".$arriveekm."' OR ARR2<='".$arriveekm."' OR ARR3<='".$arriveekm."' OR ARR4<='".$arriveekm."')";
	$class='class="check"';
}

//recherche pour conducteur et/ou passager
$type = "";
if (isset($_POST['TYPE']) && $_POST['TYPE'] !== 'All') {
	$type = " AND TYPE='" . $_POST['TYPE'] . "'";
}//fin de recherche pour conducteur et/ou passager

//recherche par date de parcours (si renseigné)
//initialisation de la variable pour la requête de dreamweaver
$colname_RStrajets3 = "-1";
if (isset($_POST['DATE_PARCOURS'])) {
  $colname_RStrajets3 = $_POST['DATE_PARCOURS'];
}
//préparation de la variable si recherche sur une date
if ($_POST['DATE_PARCOURS'] !== '') {
	$date = explode('-', $_POST['DATE_PARCOURS']);
	$colname_RStrajets3 = $date[2] . '-' . $date[1] . '-' . $date[0];
	$requete = 'AND DATE_PARCOURS = %s';
}
//préparation de la variable si aucune recherche de date
if ($_POST['DATE_PARCOURS']=='') {
	$requete="AND DATE_PARCOURS>=curdate()";
}

mysql_select_db($database_bddcovoiturette, $bddcovoiturette);
if($_POST['ARRIVEE']!==''){
$query_RSparcours = sprintf("SELECT *, IF(((DEPARTMIN=DEP4)AND(ARRIVEEMIN!=ARR1)),1,0) AS VERIF1, IF(((DEPARTMIN=DEP3)AND((ARRIVEEMIN=ARR2) OR (ARRIVEEMIN=ARR3))),1,0) AS VERIF2, IF(((DEPARTMIN=DEP2)AND(ARRIVEEMIN=ARR2)),1,0) AS VERIF3 FROM (SELECT *, LEAST(DEP1, IFNULL(DEP2,5000), IFNULL(DEP3,5000), IFNULL(DEP4,5000)) AS DEPARTMIN , LEAST(ARR1, IFNULL(ARR2,5000), IFNULL(ARR3,5000), IFNULL(ARR4,5000)) AS ARRIVEEMIN  FROM (SELECT *, ".$formuledepsql.$formulearrsql." FROM trajets WHERE STATUT='Valide' ".$requete.$type." HAVING ".$requetedep." ".$requetearr." ORDER BY ".$order.") AS t1) AS t2
HAVING VERIF1=0 AND VERIF2=0 AND VERIF3=0", GetSQLValueString($colname_RStrajets3, "date"));
} else {
$query_RSparcours = sprintf("SELECT *, ".$formuledepsql." FROM trajets WHERE STATUT='Valide' ".$requete.$type." HAVING ".$requetedep." ORDER BY ".$order."", GetSQLValueString($colname_RStrajets3, "date"));
}

//echo $query_RSparcours;
//$RSparcours = mysql_query($query_RSparcours, $bddcovoiturette) or die(mysql_error());
//$row_RSparcours = mysql_fetch_assoc($RSparcours);
//$totalRow_RSparcours = mysql_num_rows($RSparcours);

// PAGINATION
$currentPage = $_SERVER["PHP_SELF"];// url en cours

$maxRows_rs = 10;// nb de résult par page
$pageNum_rs = 0;// num de page en cours
if (isset($_GET['pageNum_rs'])) {// si num de page dans url, utiliser ce num de page
  $pageNum_rs = $_GET['pageNum_rs'];
}
$startRow_rs = $pageNum_rs * $maxRows_rs; // premier result à afficher, nb page par nb de result par page

$query_rs = $query_RSparcours;// requête utilisée, voir ci-dessus
$query_limit_rs = sprintf("%s LIMIT %d, %d", $query_rs, $startRow_rs, $maxRows_rs);// req + complément de req = pagination
$rs = mysql_query($query_limit_rs, $bddcovoiturette) or die(mysql_error());// lancement de la requête
$row_RSparcours = mysql_fetch_assoc($rs);// nb de result obtenu

if (isset($_GET['totalRows_rs'])) {// si nb total de result dans url
  $totalRows_rs = $_GET['totalRows_rs'];
} else {
  $all_rs = mysql_query($query_rs);// lancement req pour obtenir
  $totalRows_rs = mysql_num_rows($all_rs);// tous les result dans la bdd
}
$totalPages_rs = ceil($totalRows_rs/$maxRows_rs) - 1;// nb total de pages de result = nb total de result dans la bdd / nb de result par page

$queryString_rs = "";// requ utilisée
if (!empty($_SERVER['QUERY_STRING'])) {// si requ en cours
  $params = explode("&", $_SERVER['QUERY_STRING']);// récup param de la requ
  $newParams = array();
  foreach ($params as $param) {// pour chaque param de la requ
    if (stristr($param, "pageNum_rs") == false && 
        stristr($param, "totalRows_rs") == false) {// param de la requ
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {// reconstruction de la l'url
    $queryString_rs = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rs = sprintf("&totalRows_rs=%d%s", $totalRows_rs, $queryString_rs);

// création de du block de numéros de pages
$page_nav = "";
for ($i = 0; $i <= $totalPages_rs; $i++) {
	$aclass = '';
	if ($pageNum_rs == $i) {
		$aclass = " pagenavnumactive";
	}
	$pagelink = sprintf("%s?pageNum_rs=%d%s", $currentPage, $i, $queryString_rs);
	$num = $i + 1;
    $page_nav .= "<a class=\"pagenavnum" . $aclass . "\" href=\"" . $pagelink . "\" >" . $num . "</a>";
}
// /PAGINATION
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

</style>
<script type="text/javascript">

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
	var chiffre=$('#DEPART').val().length;
	var pays = encodeURI($('input[name=PAYS_DEPART]:checked').val());
	if(chiffre>=3){
		$('#DEPART').addClass('wait');
        $('#liste_depart').load('ajax/depart_flag.php?COMMUNE='+ville2 +'&PAYS='+pays);
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
 function blankd(){
	 $('#DATE_PARCOURS').val('');
 }
 
 $(document).ready(function(){
	 disableAutocomplete('DEPART');
	 disableAutocomplete('ARRIVEE');
	 disableAutocomplete('DATE_PARCOURS');
	 
	 $('#criteres').toggle(function(){$('#criteresliste').fadeIn();$('#criteres').addClass('on');},function(){$('#criteresliste').fadeOut();$('#criteres').removeClass('on');});
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
    
	<div id="recherche">
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
	    <tr>
	      <td><h2>Trouver votre covoiturage</h2>
	        <form id="form1" name="form1" method="post" action="recherche.php" onsubmit="return CHECK()">
	          <table width="700" border="0" cellpadding="3" cellspacing="0">
	            <tr>
	              <td>Ville de d&eacute;part
                  	<br /><?php $pays_desc = 'depart'; require("include/pays_choix_recherche.php"); ?>
                  </td>
	              <td>Ville d'arriv&eacute;e
                  	<br /><?php $pays_desc = 'arrivee'; require("include/pays_choix_recherche.php"); ?>
                  </td>
	              <td>Date</td>
	              <td>&nbsp;</td>
                </tr>
	            <tr>
	              <td><input name="DEPART" type="text" id="DEPART" size="25" onkeyup="depart()" value="<?php echo $_POST['DEPART']; ?>" onfocus="blank()" class="check"/>
	                <div id="liste_depart"></div>
	                <input type="hidden" name="DEPART_LAT" id="DEPART_LAT" value="<?php echo $_POST['DEPART_LAT']; ?>" />
	                <input type="hidden" name="DEPART_LON" id="DEPART_LON" value="<?php echo $_POST['DEPART_LON']; ?>" /></td>
	              <td><input name="ARRIVEE" type="text" id="ARRIVEE" size="25" onkeyup="arrivee()" value="<?php echo $_POST['ARRIVEE']; ?>" onfocus="blank2()" class="check"/>
	                <div id="liste_arrivee"></div>
	                <input type="hidden" name="ARRIVEE_LAT" id="ARRIVEE_LAT" value="<?php echo $_POST['ARRIVEE_LAT']; ?>" />
	                <input type="hidden" name="ARRIVEE_LON" id="ARRIVEE_LON" value="<?php echo $_POST['ARRIVEE_LON']; ?>" /></td>
	              <td><label for="DATE_PARCOURS"></label>
	                <input name="DATE_PARCOURS" type="text" id="DATE_PARCOURS" value="<?php echo $_POST['DATE_PARCOURS']; ?>" size="10" readonly="readonly" onclick="blankd()"/></td>
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
	                <option value="All" <?php if (!(strcmp("All", $_POST['TYPE']))) {echo "selected=\"selected\"";} ?>>Conducteur &amp; Passager</option>
	                <option value="Conducteur" <?php if (!(strcmp("Conducteur", $_POST['TYPE']))) {echo "selected=\"selected\"";} ?>>Conducteur uniquement</option>
	                <option value="Passager" <?php if (!(strcmp("Passager", $_POST['TYPE']))) {echo "selected=\"selected\"";} ?>>Passager uniquement</option>
	                </select></td>
                </tr>
	            <tr>
	              <td>Ville de d&eacute;part</td>
	              <td><select name="DEPART_KM" id="DEPART_KM">
	                <option value="60" <?php if (!(strcmp(60, $_POST['DEPART_KM']))) {echo "selected=\"selected\"";} ?>>+/- 60 km</option>
	                <option value="30" <?php if (!(strcmp(30, $_POST['DEPART_KM']))) {echo "selected=\"selected\"";} ?>>+/- 30 km</option>
	                <option value="10" <?php if (!(strcmp(10, $_POST['DEPART_KM']))) {echo "selected=\"selected\"";} ?>>+/- 10 km</option>
	                </select></td>
	              <td>Ville d'arriv&eacute;e</td>
	              <td><select name="ARRIVEE_KM" id="ARRIVEE_KM">
	                <option value="60" <?php if (!(strcmp(60, $_POST['ARRIVEE_KM']))) {echo "selected=\"selected\"";} ?>>+/- 60 km</option>
	                <option value="30" <?php if (!(strcmp(30, $_POST['ARRIVEE_KM']))) {echo "selected=\"selected\"";} ?>>+/- 30 km</option>
	                <option value="10" <?php if (!(strcmp(10, $_POST['ARRIVEE_KM']))) {echo "selected=\"selected\"";} ?>>+/- 10 km</option>
	                </select></td>
                </tr>
	            <tr>
	              <td>Trier par</td>
	              <td colspan="3"><label for="TRI"></label>
	                <select name="TRI" id="TRI">
	                  <option value="DATE HEURE" <?php if (!(strcmp("DATE HEURE", $_POST['TRI']))) {echo "selected=\"selected\"";} ?>>Date &amp; Heure de d&eacute;part</option>
	                  <option value="PRIX ASC" <?php if (!(strcmp("PRIX ASC", $_POST['TRI']))) {echo "selected=\"selected\"";} ?>>Prix croissant</option>
	                  <option value="PRIX DESC" <?php if (!(strcmp("PRIX DESC", $_POST['TRI']))) {echo "selected=\"selected\"";} ?>>Prix d&eacute;croissant</option>
	                  <option value="PLACES ASC" <?php if (!(strcmp("PLACES ASC", $_POST['TRI']))) {echo "selected=\"selected\"";} ?>>Nombre de places croissant</option>
	                  <option value="PLACES DESC" <?php if (!(strcmp("PLACES DESC", $_POST['TRI']))) {echo "selected=\"selected\"";} ?>>Nombre de places d&eacute;croissant</option>
                    </select></td>
                </tr>
              </table>
              <input id="srctoken" name="srctoken" type="hidden" value="<?php echo $myToken ?>" />
            </form>
            </td>
	      <td align="right"><a href="nouveau.php" id="newadd">Publier une annonce</a></td>
        </tr>
      </table>
    </div>
  <!-- InstanceEndEditable --></div>
    
    <div id="contenu">
	<!-- InstanceBeginEditable name="contenu" -->
	<h1>R&eacute;sultats de la recherche : <?php echo $totalRows_rs;?> annonce(s)</h1>
	
	<p class="header_nav">
    <?php if ($totalRows_rs > 1) : ?>
    Annonces <?php echo ($startRow_rs + 1) ?> &agrave; <?php echo min($startRow_rs + $maxRows_rs, $totalRows_rs) ?> sur <?php echo $totalRows_rs ?>
   <?php endif; ?>
    </p>
	
	<?php 
	if($totalRows_rs>0){
		do {
			include('include-annonce2.php');	
		} while ($row_RSparcours = mysql_fetch_assoc($rs));
	} else {
		echo 'Malheureusement, aucune annonce n\'a été trouvée. Essayez sur un autre parcours/date';
	}
	?>
    
    <div id="pagenav">
    	<div id="navgauche">
		<?php if ($startRow_rs > 0) : ?>
            <a href="<?php printf("%s?pageNum_rs=%d%s", $currentPage, 0, $queryString_rs); ?>" class="flecheg"></a>
            <a href="<?php printf("%s?pageNum_rs=%d%s", $currentPage, max(0, $pageNum_rs - 1), $queryString_rs); ?>" class="flecheg2"></a>
        <?php endif; ?> 
        </div>
        <div id="navlink">
        <?php if ($totalPages_rs > 1) : ?>
		<?=$page_nav?>
        <?php endif; ?>
    	</div>
    	<div id="navdroite">
		<?php if ($totalPages_rs != $pageNum_rs and $totalRows_rs > 0) : ?>
    	<a href="<?php printf("%s?pageNum_rs=%d%s", $currentPage, min($totalPages_rs, $pageNum_rs + 1), $queryString_rs); ?>" class="fleched2"></a>
        <a href="<?php printf("%s?pageNum_rs=%d%s", $currentPage, $totalPages_rs, $queryString_rs); ?>" class="fleched"></a>
        <?php endif; ?>
    	</div>
    </div>
	<!-- InstanceEndEditable -->
</div>
    
    <div id="footer">
    <?php include('include-footer.php'); ?></div>

</div>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($rs);
?>
