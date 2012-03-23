<?php require_once('Connections/bddcovoiturette.php'); ?>
<?php
// anti-CSRF token
require_once("ScriptLibrary/form_functions.php");

session_start();

$myToken	= getTokenM();
$myToken2	= getTokenMRCF();

// pour retourner sur la page de result
if (isset($_SESSION['postdata']['srctoken']) and !empty($_SESSION['postdata']['srctoken'])) {
	$_SESSION['cvtoken'] = $_SESSION['postdata']['srctoken'];
}
/**/

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
if (isset($_GET['c'])) {
  $colname_RStrajet = $_GET['c'];
}
mysql_select_db($database_bddcovoiturette, $bddcovoiturette);
$query_RStrajet = sprintf("SELECT * FROM trajets WHERE CODE_CREATION = %s", GetSQLValueString($colname_RStrajet, "text"));
$RStrajet = mysql_query($query_RStrajet, $bddcovoiturette) or die(mysql_error());
$row_RStrajet = mysql_fetch_assoc($RStrajet);
$totalRows_RStrajet = mysql_num_rows($RStrajet);

$arrivee=$row_RStrajet['ARRIVEE'];
$prix=$row_RStrajet['PRIX'];

if($_GET['p']=='eta1'){
	$arrivee=$row_RStrajet['ETAPE1'];
	$prix=$row_RStrajet['PRIX1'];
}
if($_GET['p']=='eta2'){
	$arrivee=$row_RStrajet['ETAPE2'];
	$prix=$row_RStrajet['PRIX2'];
}
if($_GET['p']=='eta3'){
	$arrivee=$row_RStrajet['ETAPE3'];
	$prix=$row_RStrajet['PRIX3'];
}
if($_GET['depart']=='pri'){
	$prix=$prix; 
}
if($_GET['depart']=='eta1'){
	$prix=$prix-$row_RStrajet['PRIX1'];
}
if($_GET['depart']=='eta2'){
	$prix=$prix-$row_RStrajet['PRIX2'];
}
if($_GET['depart']=='eta3'){
	$prix=$prix-$row_RStrajet['PRIX3'];
 }

// captcha reconf
$cryptinstall="crypt/cryptographp.fct.php";
include("$cryptinstall");
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
<script type="text/javascript">
$(document).ready(function(){
	
	$('#form1').submit(function(event) {
		event.preventDefault();

		var nom		= $('#NOM').val(),
			email	= $('#EMAIL').val(),
			msg		= $('#MESSAGE').val(),
			c		= $('#c').val(),
			dep		= $('#dep').val(),
			arr		= $('#arr').val(),
			token	= $('#srctoken').val();
		
		if (nom == '') {
			alert('Veuillez préciser votre nom / pseudo s\'il vous plaît');
			$('#NOM').focus();
			return false;
		}
		if (email == '') {
			alert('Veuillez préciser votre adresse e-mail s\'il vous plaît');
			$('#EMAIL').focus();
			return false;
		}
		
		var illegal = new RegExp("[\(\),;:!?<>\$àç&éùèâêî\*\^\'\"]+","g");
		var legal = new RegExp("^\\w[\\w\-\_\.]*\\w@\\w[\\w\-\_\.]*\\w\\.\\w{2,4}$");
		if ((illegal.test(email) == true) || (legal.test(email) != true)) {
			alert("L'adresse e-mail qui a été saisie est incorrecte");
			$('#EMAIL').focus();
			return false;
		}
		
		if (msg == '') {
			alert('Veuillez préciser votre message s\'il vous plaît');
			$('#MESSAGE').focus();
			return false;
		}
		
		var sendmail_div = $('#sendmail_div');
		$(this).hide();
		sendmail_div.show();
		
		$.post(
			"ajax/email.php",
			{
				nom		: nom,
				email	: email,
				msg		: msg,
				c		: c,
				dep		: dep,
				arr		: arr,
				token	: token
			},
			function(data) {
				sendmail_div.hide();
				$('#form1').show();
				if (data != 1) {
					$('#srctoken').val(data);
					alert("Votre message a bien été envoyé.");
				} else {
					alert("Une erreur est survenue lors de l'envoi de votre message.");
				}
			});		
		
	})
	
	$('#form2').submit(function(event) {
		event.preventDefault();

		var email	= $('#EMAIL_RECONF').val(),
			c		= $('#c_reconf').val(),
			code	= $('#CODE_RECONF').val(),
			token	= $('#srctoken_reconf').val();
		
		if (email == '') {
			alert('Veuillez préciser votre adresse e-mail s\'il vous plaît');
			$('#EMAIL_RECONF').focus();
			return false;
		}
		
		var illegal = new RegExp("[\(\),;:!?<>\$àç&éùèâêî\*\^\'\"]+","g");
		var legal = new RegExp("^\\w[\\w\-\_\.]*\\w@\\w[\\w\-\_\.]*\\w\\.\\w{2,4}$");
		if ((illegal.test(email) == true) || (legal.test(email) != true)) {
			alert("L'adresse e-mail qui a été saisie est incorrecte");
			$('#EMAIL_RECONF').focus();
			return false;
		}
		
		var sendmail_div = $('#sendmailreconf_div');
		$(this).hide();
		sendmail_div.show();
		
		$.post(
			"ajax/email_reconf.php",
			{
				email	: email,
				c		: c,
				code	: code,
				token	: token
			},
			function(data) {
				sendmail_div.hide();
				$('#form2').show();
				if (data != 1) {
					$('#srctoken_reconf').val(data);
					alert("Votre mail de confirmation a bien été envoyé.");
				} else {
					alert("Une erreur est survenue lors de l'envoi de votre mail de confirmation.\nMerci de vérifier votre email et/ou le code de sécurité.");
				}
			});		
		
	})
	
	$('#show_reconf').click(function(event){
		event.preventDefault();
		$('#form2').slideToggle('slow');
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
	<!-- InstanceBeginEditable name="headersite" --><!-- InstanceEndEditable --></div>
    
    <div id="contenu">
	<!-- InstanceBeginEditable name="contenu" -->
	<h1>D&eacute;tail du parcours</h1>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr valign="top">
	    <td width="55%" id="detailtrajet" style="padding-right:20px;"><h2>Informations sur le trajet</h2>
	      <p>Jour du trajet : <strong><?php $sqldate = $row_RStrajet['DATE_PARCOURS'];
			
			(preg_match("/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/", $sqldate, $regs));
			$jour = array("Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi"); 
		$mois = array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
		$datefr = $jour[date("w",mktime(0, 0, 0, $regs[2], $regs[3], $regs[1]))];
		$datefr .= " ".date("d",mktime(0, 0, 0, $regs[2], $regs[3], $regs[1]));
		$datefr .= " ".$mois[date("n",mktime(0, 0, 0, $regs[2], $regs[3], $regs[1]))];
		$datefr .= " ".date("Y",mktime(0, 0, 0, $regs[2], $regs[3], $regs[1]));echo $datefr;?></strong><br />
	        Heure de d&eacute;part : 
            <strong><?php  echo substr($row_RStrajet['HEURE'], 0, 5); ?> </strong> <?php if((isset($_GET['depart']))&&($_GET['depart']!=='pri')){ echo '<em>d&eacute;part de '.$row_RStrajet['DEPART'].'</em>';} ?>
            
            <?php if($row_RStrajet['TYPE']=='Conducteur'){ ?></p>
	      <p>	        Place(s) disponible(s) : 
	        <strong class="dispo<?php echo $row_RStrajet['PLACES']; ?>"><?php echo $row_RStrajet['PLACES']; ?></strong><?php } ?>
          </p>
	      <table width="100%" border="0" cellpadding="0" cellspacing="0">
	        <tr>
            <td width="30%" height="20">Ville de d&eacute;part :</td>
            <td <?php if($_GET['depart']=='pri'){echo 'class="selection"';}?>><?php echo $row_RStrajet['DEPART']; ?></td>
            </tr>
            <?php if($row_RStrajet['ETAPE1']!==NULL){?>
	        <tr>
	          <td height="20">Etape 1 :</td>
	          <td <?php if(($_GET['depart']=='eta1')||($_GET['p']=='eta1')){echo 'class="selection"';}?>><?php echo $row_RStrajet['ETAPE1']; ?></td>
            </tr>
            <?php } ?>
            <?php if($row_RStrajet['ETAPE2']!==NULL){?>
	        <tr>
	          <td height="20">Etape 2 :</td>
	          <td <?php if(($_GET['depart']=='eta2')||($_GET['p']=='eta2')){echo 'class="selection"';}?>><?php echo $row_RStrajet['ETAPE2']; ?></td>
            </tr>
            <?php } ?>
            <?php if($row_RStrajet['ETAPE3']!==NULL){?>
	        <tr>
	          <td height="20">Etape 3 : </td>
	          <td <?php if(($_GET['depart']=='eta3')||($_GET['p']=='eta3')){echo 'class="selection"';}?>><?php echo $row_RStrajet['ETAPE3']; ?></td>
            </tr>
            <?php } ?>
	        <tr>
	          <td height="20">Ville d'arriv&eacute;e :</td>
	          <td <?php if($_GET['p']=='pri'){echo 'class="selection"';}?>><?php echo $row_RStrajet['ARRIVEE']; ?></td>
            </tr>
          </table>
        <?php if($row_RStrajet['TYPE']=='Conducteur'){ ?>
        <p>&nbsp;          </p>
        <p>Prix pour le trajet  : <strong class="selection"><?php echo $prix; ?> &euro;  </strong></p>
        <?php } ?>
        <br /><p>Commentaires  :<br />
          <strong><?php echo nl2br($row_RStrajet['COMMENTAIRES']); ?></strong></p>
        <?php if($row_RStrajet['TYPE']=='Conducteur'){ ?><p>Confort de la voiture : <strong><?php echo $row_RStrajet['CONFORT']; ?></strong></p>
        <p>
          <?php } ?>
        </p>
        
        <p>&nbsp;</p>
        <p><a href="#" id="abusif">Signaler une annonce incorrecte <em>(fonction &agrave; venir)</em></a></p>
        <p>&nbsp;</p>
        <p style="font-size:95%">C'est votre annonce et vous souhaitez la <span class="dispo2"><strong>modifier/supprimer</strong></span> ? Utilisez <u>les liens pr&eacute;vus</u> &agrave; ces effets dans l'email de confirmation que vous avez re&ccedil;u lors de la cr&eacute;ation de l'annonce.</p>
        
       
         <p style="font-size:95%">C'est votre  annonce et vous avez perdu <span class="dispo2"><strong>le mail de confirmation</strong></span> ?<br />
          <a href="#" id="show_reconf"> Cliquez ici pour le re&ccedil;evoir &agrave; nouveau.</a>
         </p>
        <form id="form2" action="/" style="font-size:95%; display:none;">
          <table width="99%" border="0" cellspacing="0" cellpadding="5">
            <tr>
              <th width="200" align="left" valign="top" scope="row">Votre email :</th>
              <td align="left" valign="top"><label for="EMAIL_RECONF"></label>
                <input name="EMAIL_RECONF" type="text" id="EMAIL_RECONF" size="35" /></td>
            </tr>
            <tr>
              <th align="left" valign="top" scope="row">Code de s&eacute;curit&eacute; :</th>
              <td align="left" valign="top"><?php dsp_crypt(0,1); ?></td>
            </tr>
            <tr>
              <th align="left" valign="top" scope="row">Merci de recopier le code<br />
                affich&eacute; ci-dessus :</th>
              <td align="left" valign="top">
              <input name="CODE_RECONF" type="text" id="CODE_RECONF" size="10" />
               <?php if ( isset($code_result_ok) and $code_result_ok === false ) : ?>
            <a name="code_nok" id="code_nok"></a><em style="color:red;font-weight:bold;">code non reconnu</em>
          <?php endif; ?>
              </td>
            </tr>
            <tr>
              <th align="left" scope="row">&nbsp;</th>
              <td align="left">
               <input name="c_reconf" type="hidden" id="c_reconf" value="<?php echo $row_RStrajet['CODE_CREATION']; ?>" />
              <input id="srctoken_reconf" name="srctoken_reconf" type="hidden" value="<?php echo $myToken2; ?>" />
              <input type="submit" name="submit" id="submit" value="Envoyer le mail de confirmation" /></td>
            </tr>
          </table>
        </form>
        <div id="sendmailreconf_div" style="display:none; height:90px; padding-top:95px; clear:both; text-align:center;">
         <em> Envoi du mail de confirmation en cours &nbsp;</em><img src="images/ajax-loader.gif" alt="" width="43" height="11" />
         </div>
        <p>&nbsp;</p>
        
        </td>
	    <td><div id="depositaire"><h2>Informations sur le d&eacute;positaire de l'annonce</h2>
	      <div class="picto" style="float:left;margin:0 15px 5px 0"><img src="images/<?php echo $row_RStrajet['TYPE']; ?>-<?php echo $row_RStrajet['CIVILITE']; ?>.jpg" alt="" width="60" height="60" /><span class="legende"><?php echo $row_RStrajet['TYPE']; ?></span></div>
        <p>Nom : <strong><?php echo $row_RStrajet['NOM']; ?></strong><br />
          Age : <strong><?php if($row_RStrajet['AGE']!==NULL){echo $row_RStrajet['AGE'].' ans';} else {echo '<strong><em>non renseigné</em></strong>';} ?></strong>
        </p>
        <p>T&eacute;l&eacute;phone : <?php if($row_RStrajet['TELEPHONE']!==NULL){
			echo '<img src="telephone.php?c='.$_GET['c'].'" border="0">';
		} else {echo '<strong><em>non renseigné</em></strong>';} ?></p>
        <form id="form1" action="/">
          <h3>Envoyer un message &agrave; cette personne</h3>
          <p><strong>Votre nom</strong><br />
            <label for="NOM"></label>
            <input name="NOM" type="text" id="NOM" size="30" />
          </p>
          <p><strong>Votre email</strong><br />
            <label for="EMAIL"></label>
            <input name="EMAIL" type="text" id="EMAIL" size="30" />
          </p>
          <p><strong>Votre message</strong><br />
<textarea name="MESSAGE" id="MESSAGE" cols="45" rows="8"></textarea>
          </p>
          <p>
            <input name="button2" type="submit" class="bouton" id="button2" value="Envoyer"  />
            <input name="c" type="hidden" id="c" value="<?php echo $row_RStrajet['CODE_CREATION']; ?>" />
            <input type="hidden" name="dep" id="dep" value="<?php echo $_GET['depart'];?>" />
            <input type="hidden" name="arr" id="arr" value="<?php echo $_GET['p'];?>" />
           <input id="srctoken" name="srctoken" type="hidden" value="<?php echo $myToken ?>" />

          </p>
      </form>
       <div id="sendmail_div" style="display:none; height:200px; padding-top:121px; clear:both; text-align:center;">
         <em> Envoi du message en cours &nbsp;</em><img src="images/ajax-loader.gif" alt="" width="43" height="11" />
         </div>
      
      </div></td>
      </tr>
    </table>
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
