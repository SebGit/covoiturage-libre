<?php require_once('Connections/bddcovoiturette.php'); ?>
<?
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
$colname_RStrajet2 = "-1";
if (isset($_GET['c'])) {
  $colname_RStrajet2 = $_GET['c'];
}
mysql_select_db($database_bddcovoiturette, $bddcovoiturette);
$query_RStrajet2 = sprintf("SELECT * FROM trajets WHERE CODE_CREATION = %s", GetSQLValueString($colname_RStrajet2, "text"));
$RStrajet2 = mysql_query($query_RStrajet2, $bddcovoiturette) or die(mysql_error());
$row_RStrajet2 = mysql_fetch_assoc($RStrajet2);

if(!isset($_GET['c']))
{
exit();
}
header ("Content-type: image/png");
$string = $row_RStrajet2['TELEPHONE'];
$font   = 6;
$width  = ImageFontWidth($font) * strlen($string);
$height = ImageFontHeight($font);
 
$im = @imagecreate ($width,$height);
$background_color = imagecolorallocate ($im, 235, 235, 235); // background
$text_color = imagecolorallocate ($im, 102,102,102);//black text
imagestring ($im, $font, 0, 0,  $string, $text_color);
imagepng ($im);
imagedestroy($im);
mysql_free_result($RStrajet2);
?>