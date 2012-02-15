<?php require_once('Connections/bddcovoiturette.php'); ?>
<?php require_once('ScriptLibrary/class.phpmailer.php'); ?>
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

if (isset($_GET['c'])) {
  $colname_RSannonce = $_GET['c'];
}
mysql_select_db($database_bddcovoiturette, $bddcovoiturette);
$query_RSannonce = sprintf("SELECT * FROM trajets WHERE CODE_CREATION = %s", GetSQLValueString($colname_RSannonce, "text"));
$RSannonce = mysql_query($query_RSannonce, $bddcovoiturette) or die(mysql_error());
$row_RSannonce = mysql_fetch_assoc($RSannonce);
$totalRows_RSannonce = mysql_num_rows($RSannonce);


	$to = $row_RSannonce['EMAIL'];
	$from = GetSQLValueString($_POST['EMAIL'], "text");
	$from_name = GetSQLValueString($_POST['NOM'], "text");
	
	$objet = "Covoiturage-libre.fr - Nouveau message";
	
	$message = '
	<html>
	 <body>
	  <table width="750" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="260" valign="top"><img src="http://www.covoiturage-libre.fr/images/logo-email.jpg" alt="" width="250" height="200" /></td>
    <td valign="top">
    <font face="arial" size="2" color="#444444"><p>Un message vous a été envoyé de la part de '.$from_name.' ('.$from.') : </p>
	'.nl2br($_POST['MESSAGE']).'</font></td>
  </tr>
</table>
	 </body>
	</html>';
	

	
	$mail=new phpmailer();
	$mail->From = $from;
	$mail->FromName = $from_name;
	$mail->Subject =$objet;
	$mail->AddAddress($to);
	$mail->MsgHTML($message);
	
	if($mail->Send()){
		$erreur = "Votre message a bien été envoyé à l'administrateur du site.";
	} else {
		$erreur = "problem !";
	}

mysql_free_result($RSannonce);
?>