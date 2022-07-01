<?php
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	
	$heure=$_POST['HEURE_H'].':'.$_POST['HEURE_M'];
	$date=explode('-',$_POST['DATE_PARCOURS']);
	$datefin=$date[2].'-'.$date[1].'-'.$date[0];
	
	
  $updateSQL = sprintf("UPDATE trajets SET TYPE=%s, DEPART=%s, DEPART_LAT=%s, DEPART_LON=%s, ARRIVEE_LAT=%s, ARRIVEE_LON=%s, ARRIVEE=%s, DATE_PARCOURS=%s, HEURE=%s, PLACES=%s, CONFORT=%s, COMMENTAIRES=%s, PRIX=%s, ETAPE1=%s, ETAPE1_LAT=%s, ETAPE1_LON=%s, PRIX1=%s, ETAPE2=%s, ETAPE2_LAT=%s, ETAPE2_LON=%s, PRIX2=%s, ETAPE3=%s, ETAPE3_LAT=%s, ETAPE3_LON=%s, PRIX3=%s, CIVILITE=%s, NOM=%s, TELEPHONE=%s WHERE CODE_MODIFICATION=%s",
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
                       GetSQLValueString($_POST['TELEPHONE'], "text"),
                       GetSQLValueString($_POST['c'], "text"));

  mysqli_select_db($bddcovoiturette , $database_bddcovoiturette);
  $Result1 = mysqli_query($bddcovoiturette ,$updateSQL) or die(mysqli_error($bddcovoiturette));

  $updateGoTo = "modification-ok.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$heure=explode(':',$row_RStrajet['HEURE']);
$heure_h=$heure[0];
$heure_m=$heure[1];
?>
<?php include('include/include.php');?>
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
	<!-- InstanceBeginEditable name="headersite" --> 
    
    
    <!-- InstanceEndEditable --></div>
    
    <div id="contenu">
	<!-- InstanceBeginEditable name="contenu" -->
    <h1>Erreur !</h1>
    <p>&nbsp;</p>
    <p><em>Votre trajet n'est plus modifiable (date pass&eacute;e), n'a pas &eacute;t&eacute; valid&eacute;e ou a &eacute;t&eacute; supprim&eacute;e.</em></p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
	<!-- InstanceEndEditable -->
  </div>
    
    <div id="footer">
    <?php include('include-footer.php'); ?></div>

</div>
</body>
<!-- InstanceEnd --></html>