<?php require_once('Connections/bddcovoiturette.php'); ?>
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
	<!-- InstanceBeginEditable name="headersite" --><!-- InstanceEndEditable --></div>
    
    <div id="contenu">
	<!-- InstanceBeginEditable name="contenu" -->
	<h1>Am&eacute;liorations du site</h1>
	<p>&nbsp;</p>
	<table width="100%" border="0" cellpadding="3" cellspacing="0">
	  <tr valign="top">
	    <td width="50%"><h2 class="dispo1">Un bug sur ce site ?</h2>
	      <p>&nbsp;</p>
        <p>Malgr&eacute; mon soin apport&eacute; &agrave; offrir un site fiable, cela peut arriver. </p>
        <p>Aidez-moi &agrave; am&eacute;liorer ce site en me faisant part des bugs/dysfonctionnements/fautes d'orthographes observ&eacute;s. Pour cela, &eacute;crivez-moi sur <a href="mailto:bug@covoiturage-libre.fr">bug@covoiturage-libre.fr</a></p>
        <p>Je m'efforcerai  de les r&eacute;soudre dans les plus brefs d&eacute;lais.        </p>
        <p>&nbsp;</p>
        <p><strong>Nicolas RAYNAUD</strong><br />
        Cr&eacute;ateur et administrateur de covoiturage-libre.fr</p></td>
	    <td><h2 class="dispo1">Correction des bugs/am&eacute;liorations</h2>
	      <p><strong>Chaque bug corrig&eacute; / am&eacute;lioration  est un pas de plus vers le site parfait !</strong></p>
	      <p>&nbsp;</p>
	      <h3>02/02/2012 - Mise &agrave; jour du site</h3>
	      <p>&gt; <strong>Nouvelle version du site internet.</strong> Nouveau logo, ajout de la page &quot;faire un don&quot;, ajout des pays limitrophes &agrave; la France. Nouvelle home page.</p>
	      <p>&nbsp;</p>
	      <h3>31/01/2012 - Moteur de recherche</h3>
	      <p>&gt; Correction d'un bug d&eacute;couvert sur les trajets inter-&eacute;tape dont la ville de d&eacute;part est la <strong>deuxi&egrave;me &eacute;tape d'un parcours</strong>.</p>
	      <p>&nbsp;</p>
	      <h3>20/01/2012 - S&eacute;curisation du site</h3>
	      <p>&gt; Ajouts de <strong>scripts</strong> pour s&eacute;curiser le site et augmenter sa r&eacute;sistance aux attaques potentielles de hacker.</p>
	      <p>&nbsp;</p>
	      <h3>21/12/2011 - Moteur de recherche</h3>
          <p>&gt; Correction de bug suite &agrave; la mise en ligne du nouveau moteur de recherche. Les recherches sur une ville de d&eacute;part &agrave; une date donn&eacute;e (<strong>sans ville d'arriv&eacute;e</strong>) fonctionne bien dor&eacute;navant. Egalement, la <strong>pagination</strong> a &eacute;t&eacute; adapt&eacute;e quand la recherche ne donne pas de r&eacute;sultats. <br />
          <em>Merci &agrave; Gabriel et Olivier pour leurs retours d'exp&eacute;rience &agrave; ce suje</em>t</p>
          <p>&nbsp;</p>
	      <h3 class="dispo1">20/12/2011 - Envoi de message</h3>
	      <p>&gt; Je viens d'am&eacute;liorer la fonction d'envoi de message pour une annonce. Dor&eacute;navant, quand on re&ccedil;oit un message pour un trajet donn&eacute;, <strong>le trajet en question est pr&eacute;cis&eacute; au tout d&eacute;but du message</strong>. Ainsi, on sait maintenant de quel trajet un visiteur parle quand on nous &eacute;crit.</p>
<p>&nbsp;</p>
	      <h3>14/12/2011 - Moteur de recherche</h3>
	      <p>&gt; Am&eacute;lioration majeure du moteur de recheche : les <strong>&eacute;tapes</strong> d'un parcours sont d&eacute;sormais aussi consid&eacute;r&eacute;es comme des villes de d&eacute;part (et non plus uniquement comme des villes d'arriv&eacute;e).</p>
	      <p>&nbsp;</p>
	      <h3>13/12/2011 - Int&eacute;gration de l'&acirc;ge</h3>
	      <p>&gt; lors de la cr&eacute;ation d'une annonce, possibilit&eacute; de saisir son <strong>&acirc;ge</strong> (facultatif)</p>
	      <p>&nbsp;</p>
	      <h3 class="dispo1">28/11/2011 - Modification d'une annonce</h3>
          <p>&gt; Correction d'un bug sur la modification de l'<strong>heure de d&eacute;part </strong>d'un trajet.</p>
          <p>&nbsp;</p>
	      <h3 class="dispo1">28/11/2011 - Moteur de recherche</h3>
          <p>&gt; Correction d'un bug existant depuis le 24/11 sur le site. <strong>Certaines annonces &eacute;taient exclues des r&eacute;sultats de recherche</strong>, malgr&eacute; leur pertinence. Probl&egrave;me identifi&eacute; et corrig&eacute;.</p>
          <p>&nbsp;</p>
<h3 class="dispo1">28/11/2011 - S&eacute;curit&eacute;</h3>
	      <p>&gt; Convertion sur <strong>num&eacute;ro de t&eacute;l&eacute;phone en image</strong> afin d'emp&ecirc;cher les robots de r&eacute;cup&eacute;rer ces informations sur le site.	      </p>
	      <p>&nbsp;</p>
	      <h3 class="dispo1">27/11/2011 - S&eacute;curit&eacute;</h3>
	      <p>&gt; Am&eacute;lioration du code source pour <strong>&eacute;viter les inserts de scripts </strong>dans les annonces. </p>
	      <p>&nbsp;</p>
	      <h3 class="dispo1">24/11/2011 - Moteur de recherche</h3>
	      <p>&gt; Ajout &quot;<strong>plus de crit&egrave;res</strong>&quot; pour affiner sa recherche selon les crit&egrave;res les plus couramment demand&eacute;s.</p>
	      <p>&gt; <strong>Pagination</strong> des r&eacute;sultats (pages de 10 annonces) afin d'acc&eacute;ler l'affichage</p>
	      <p>&nbsp;</p>
	      <h3><span class="dispo1">21/11/2011 - S&eacute;curit&eacute;</span></h3>
	      <p>&gt; Am&eacute;lioration du code source pour<strong> &eacute;viter les inserts de scripts</strong> dans la annonces. </p>
	      <p>&nbsp;</p>
	      <h3 class="dispo1">21/11/2011 - Moteur de recherche</h3>
	      <p>&gt; la <strong>saisie d'une ville</strong> avec un tiret fonctionne dor&eacute;navant (ex : &quot;Saint-Malo&quot; pour &quot;Saint Malo&quot;)</p>
	      <p>&nbsp;</p>
	      <h3 class="dispo1">17/11/2011 - Am&eacute;liorations</h3>
	      <p>&gt; <strong>Moteur de recherche</strong> : Suite &agrave; plusieurs demandes, il est maintenant possible d'effectuer une recherche sur un parcours (d&eacute;part + arriv&eacute;e) sans pr&eacute;ciser de date. Egalement, il est possible de rechercher les trajets depuis une ville de d&eacute;part &agrave; une date donn&eacute;e, sans saisir de destination (d&eacute;part + date du parcours).</p>
	      <p>&gt; <strong>Email de confirmation</strong> : le parcours enregistr&eacute; est int&eacute;gr&eacute; dans l'email de confirmation (envoy&eacute; apr&egrave;s l'ajout d'une annonce). Cela afin de faciliter le travail de mise &agrave; jour de ceux qui publient plusieurs annonces.</p>
	      <p>&nbsp;</p>
	      <h3>17/11/2011 - Formulaire de contact</h3>
	      <p>&gt; Sur une annonce, l'<strong>envoi d'un message</strong> au d&eacute;positaire pouvait parfois ne pas fonctionner. La faille a &eacute;t&eacute; trouv&eacute;e et corrig&eacute;e !<br />
          <em>          (Merci &agrave; Charl&egrave;ne et Simon de m'avoir remont&eacute; ce probl&egrave;me)</em></p>
	      <p>&nbsp;</p>
	      <h3>17/11/2011 - Moteur de recherche</h3>
	      <p>&gt; Bug sur les <strong>accents</strong> dans les villes. Vous pouvez maintenant saisir une ville contenant un ou plusieurs accents (ou autre caract&egrave;re sp&eacute;cial).<br />
          <em>(Merci &agrave; Simon et Pauline de m'avoir signal&eacute; ce probl&egrave;me)</em></p>
	      <p>&nbsp;</p>
	      <h3>16/11/2011 - Moteur de recherche</h3>
          <p>&gt; Affichage de la destination. Bug qui existait sur certaines <strong>recherches &quot;trop&quot; pr&eacute;cises</strong> <br />
          <em>          (Merci &agrave; L&eacute;ah d'avoir signal&eacute; ce probl&egrave;me).</em></p>
          <p>&gt; Am&eacute;lioration du moteur de recherche des villes avec <strong>suppression des tirets</strong> &quot;-&quot; dans les noms de villes comme &quot;Saint-Brieuc&quot;. Ainsi, le moteur de recherche trouve plus facilement les villes demand&eacute;es <br />
          <em>          (&quot;probl&egrave;me&quot; signal&eacute; &agrave; plusieurs reprises par diff&eacute;rents utilisateurs)</em></p>
          <p>&nbsp;</p>
          <h3>15/11/2011 - Calendrier en fran&ccedil;ais</h3>
          <p>&gt; Adaptation du code source pour afficher le <strong>calendrier  en fran&ccedil;ais</strong> plut&ocirc;t qu'en anglais (par d&eacute;faut)</p>
          <p>&nbsp;</p>
          <h3>14/11/2011 - Moteur de recherche</h3>
        <p>&gt; La saisie des villes contenant un &quot;<strong>espace</strong>&quot; dans leur intitul&eacute;, comme par exemple &quot;Le Mans&quot;, est maintenant fonctionnelle.</p></td>
      </tr>
    </table>
	<p>&nbsp;</p>
	<!-- InstanceEndEditable -->
</div>
    
    <div id="footer">
    <?php include('include-footer.php'); ?></div>

</div>
</body>
<!-- InstanceEnd --></html>
