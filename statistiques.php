<?php require_once('Connections/bddcovoiturette.php'); ?>
<?php
if((!isset($_GET['CODE']))&&($_GET['CODE']!=='jeveuxlesstatistiques')){
	header('location:index.php');
	die();
}
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

mysql_select_db($database_bddcovoiturette, $bddcovoiturette);
$query_RSstats = "SELECT COUNT(ID) AS STATS, DATE_CREATION, date_format(DATE_CREATION, '%d/%m/%Y') as DATE_FR FROM `trajets` WHERE STATUT!='En attente' GROUP BY DATE_FR ORDER BY DATE_CREATION DESC";
$RSstats = mysql_query($query_RSstats, $bddcovoiturette) or die(mysql_error());
$row_RSstats = mysql_fetch_assoc($RSstats);
$totalRows_RSstats = mysql_num_rows($RSstats);

mysql_select_db($database_bddcovoiturette, $bddcovoiturette);
$query_RSmax = "SELECT COUNT(ID) AS STATS, DATE_CREATION, date_format(DATE_CREATION, '%d/%m/%Y') as DATE_FR FROM `trajets` WHERE STATUT!='En attente'  GROUP BY DATE_FR ORDER BY STATS DESC LIMIT 1";
$RSmax = mysql_query($query_RSmax, $bddcovoiturette) or die(mysql_error());
$row_RSmax = mysql_fetch_assoc($RSmax);
$totalRows_RSmax = mysql_num_rows($RSmax);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Statistiques</title>
<style type="text/css">
body {
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	color:#666;
}
.barre {
	background-color:#0CF;
	height:20px;
}
.Dimanche, .Samedi {
	background-color:#eee;
}

</style>
</head>

<body>
<p>Annonces par jour</p>
<p>Maximum : <?php echo $row_RSmax['STATS']; ?> - <?php echo $row_RSmax['DATE_FR']; ?><br />
Moyenne : </p>

<table width="100%" border="0" cellpadding="1" cellspacing="0">
  <?php do { 
  $jourpret=explode('/',$row_RSstats['DATE_FR']);
$jour_fr = array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi");
$timestamp = mktime (0, 0, 0, $jourpret[1], $jourpret[0], $jourpret[2]);
$wd = date("w", $timestamp);
$str_dat = $jour_fr[$wd];?>
    <tr class="<?php echo $str_dat; ?>">
      <td width="150"><?php echo $str_dat.' '.$row_RSstats['DATE_FR']; ?></td>
      <td><div class="barre" style="width:<?php echo round(($row_RSstats['STATS']/$row_RSmax['STATS'])*100); ?>%"></div></td>
      <td width="150"><?php echo $row_RSstats['STATS']; ?></td>
    </tr>
    <?php } while ($row_RSstats = mysql_fetch_assoc($RSstats)); ?>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($RSstats);

mysql_free_result($RSmax);
?>
