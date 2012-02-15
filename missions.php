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
	<h1>Missions b&eacute;n&eacute;voles</h1>
	<h2>Covoiturage-libre.fr a besoin de vous !</h2>
	<p>Aidez-nous &agrave; d&eacute;velopper et am&eacute;liorer ce site. Vous trouverez ci-dessous une liste de &quot;missions&quot; pour lesquelles nous aimerions beaucoup profiter de votre aide.</p>
	<p>Pour toute information compl&eacute;mentaire, ou pour renvoyer vos r&eacute;ponses, <a href="mailto:bug@covoiturage-libre.fr">bug@covoiturage-libre.fr</a></p>
	<p>Egalement, <strong>un immense merci &agrave; tous</strong> (informaticiens et non-informaticiens) pour vos messages de soutien et votre aide dans le d&eacute;veloppement et pour la diffusion<br />
    de ce site :-)</p>
	<p><strong>Nicolas RAYNAUD</strong><br />
	  Webmaster de covoiturage-libre.fr
	</p>
	<p>&nbsp;</p>
	<h3>&gt; Mission 1 : R&eacute;cup&eacute;ration des informations Google Maps</h3>
	<p>Lors du d&eacute;p&ocirc;t d'une annonce, vous pouvez visualiser votre parcours sur une carte de Google. Nous aimerions agr&eacute;menter cette carte en fournissant &eacute;galement la distance parcourue, le temps de parcours estim&eacute;, ainsi que le montant (approximatif) du carburant utilis&eacute; (le co&ucirc;t des p&eacute;ages n'est malheureusement pas fourni par Google Maps).</p>
	<p>A aujourd'hui, nous savons r&eacute;cup&eacute;rer l'int&eacute;gralit&eacute; des informations d'un itin&eacute;raire. Ci dessous, le lien vers une copie de la page de d&eacute;pot d'annonce, avec r&eacute;cup&eacute;ration des informations compl&egrave;tes. Pour tester la page en cours, cr&eacute;ez un trajet factice et cliquez sur &quot;visualiser le parcours sur la carte&quot; (n'h&eacute;sitez pas &agrave; mettre des &eacute;tapes).</p>
	<p><a href="nouveau2.php">Copie de la page de d&eacute;p&ocirc;t d'annonces, affichant l'int&eacute;gralit&eacute; des infos fournies par Google Maps</a> (le formulaire n'est pas enregistr&eacute;, aucun script PHP n'est pr&eacute;sent).</p>
	<p> Mais nous ne souhaitons pas afficher toutes les informations,  juste les distances parcourues (entre le point de d&eacute;part, les &eacute;ventuelles &eacute;tapes, et le point d'arriv&eacute;e), les temps de trajet et la consommation (approximative) du carburant. Il faut donc &quot;filtrer/parser&quot; les r&eacute;sultats renvoy&eacute;s par Google Maps (<a href="http://code.google.com/intl/fr/apis/maps/documentation/javascript/reference.html#DirectionsRenderer" target="_blank">lien vers la doc</a>)</p>
	<p>Pour cela, nous recherchons donc un &quot;sp&eacute;cialiste&quot; de javascript pour nous aider &agrave; am&eacute;liorer notre fonction existante et r&eacute;cup&eacute;rer ainsi ces informations sp&eacute;cifiques. A noter que le code javascript utilis&eacute; pour Google Maps est pr&eacute;sent sur les lignes de code 17 &agrave; 58 de la page de d&eacute;mo.</p>
	<p>&nbsp;</p>
	<h3>&gt; Mission 2 : Liste des communes des pays frontaliers de la France depuis geonames.org</h3>
	<p>Afin de pouvoir proposer des annonces sur des trajets internationaux, nous avons besoin de la liste compl&egrave;te  des communes des pays suivants :</p>
	<ul>
	  <li>	  <s><strong>Belgique</strong> - 580 communes environ</s> <strong class="dispo2">liste fournie par Nicolas R. et valid&eacute;e</strong></li>
	  <li><strong><s>Allemagne</s></strong><s> - 13000 communes environ</s> <span class="dispo2"><strong>liste fournie par Ben L. et valid&eacute;e</strong></span></li>
	  <li><strong><s>Suisse</s></strong><s> - 2600 communes environ</s> <strong class="dispo2">liste fournie par Pierre PLR. et valid&eacute;e</strong></li>
	  <li><strong><s>Italie</s></strong><s> - 8000 communes environ liste</s> <strong class="dispo2">fournie par Thibaud M. / Gatien C. et valid&eacute;e</strong></li>
	  <li><strong>Pays</strong> <strong>Bas</strong> - 430 communes environ<strong class="dispo1"> fournie par Pierre PLR et en cours de v&eacute;rification</strong></li>
	  <li><strong>Luxembourg</strong> - 110 communes environ <strong class="dispo1">fournie par Pierre PLR et en cours de v&eacute;rification</strong></li>
	  <li><strong>Espagne</strong> - 8100 communes environ<strong class="dispo1"> fournie par Thibaud M. et en cours de v&eacute;rification</strong></li>
	</ul>
	<p>Chaque liste doit &ecirc;tre fournie au format excel (ou open office, ou encore csv), et doit contenir obligatoirement les colonnes suivantes (&quot;COMMUNE&quot;, &quot;CODE POSTAL&quot;, &quot;LATITUDE&quot;, &quot;LONGITUDE&quot;). A noter que les latitudes et longitudes doivent &ecirc;tre renseign&eacute;es au format d&eacute;cimal. Ci-dessous un exemple :</p>
	<table width="50%" border="0" cellpadding="3" cellspacing="0" style="border:1px solid #666">
	  <tr>
	    <td><strong>COMMUNE</strong></td>
	    <td><strong>CODE POSTAL</strong></td>
	    <td><strong>LATITUDE</strong></td>
	    <td><strong>LONGITUDE</strong></td>
      </tr>
	  <tr>
	    <td>LANMEUR</td>
	    <td>29620</td>
	    <td>48.648056</td>
	    <td>-3.714167</td>
      </tr>
    </table>
	<p>&nbsp;</p>
	<p><span class="dispo1"><strong>! important !</strong> Les listes fournies par vos soins doivent &ecirc;tre imp&eacute;rativement &quot;nettoy&eacute;es&quot; afin de s'approcher du nombre &quot;r&eacute;el&quot; de communes donn&eacute;.</span></p>
    <p class="dispo1">Utiliser les listes de &quot;<strong>codes postaux</strong>&quot; (cf. <a href="http://download.geonames.org/export/zip/" target="_blank">ce lien</a>) sur geonames.org pour r&eacute;cup&eacute;rer une premi&egrave;re liste des communes. Ensuite, enlever les nombreux &quot;doublons&quot; pour qu'au final, il ne reste qu'un seul code postal possible pour chaque ville (ex : Bruxelles, il ne doit rester que le code postal 1000. On supprime tous les autres codes postaux correspondant aux &quot;arrondissements&quot; et &quot;agglom&eacute;rations&quot; de cette ville).</p>
	<p>&nbsp;</p>
	<h3>&gt; Mission 3 : constitution d'une &eacute;quipe de d&eacute;veloppeurs pour le d&eacute;veloppement, la s&eacute;curisation et la maintenance de ce site</h3>
	<p>Avis &agrave; celles et ceux qui veulent participer au d&eacute;veloppement technique du site de se faire connaitre aupr&egrave;s de Nicolas RAYNAUD - Certain(e)s d'entre vous l'ont d&eacute;j&agrave; fait ;-)</p>
	<p>Nous souhaitons  mettre en place un espace d'&eacute;change (un forum ?) pour cette &eacute;quipe afin de faciliter les &eacute;changes. Quelqu'un pourrait-il (ou elle) se charger de d&eacute;velopper une telle plateforme ? (elle sera ensuite h&eacute;berg&eacute;e sur le serveur de covoiturage-libre.fr, &agrave; moins que vous ayez une solution plus pertinente &agrave; proposer).</p>
	<p>Merci de me contacter (Nicolas RAYNAUD)  sur <a href="mailto:bug@covoiturage-libre.fr">bug@covoiturage-libre.fr</a></p>
	<p>&nbsp;</p>
	<h3>&gt; Mission 4 : cr&eacute;er une application mobile sous Android et Iphone</h3>
    <p>J'ai personnellement commenc&eacute; &agrave; travailler sur l'application sous Android, mais un renfort sur ce point serait plus que b&eacute;n&eacute;fique ! </p>
    <p>Egalement, n'&eacute;tant pas utilisateur des p&eacute;riph&eacute;riques d'Apple, et n'ayant aucune connaissance dans le d&eacute;veloppement d'applications sous iOS, je serai ravi de collaborer avec l'un ou l'une d'entre vous &agrave; la cr&eacute;ation d'une application pour cette plateforme.</p>
    <p>Comme pour les autres missions, merci de me contacter sur <a href="mailto:bug@covoiturage-libre.fr"></a><a href="mailto:bug@covoiturage-libre.fr">bug@covoiturage-libre.fr</a></p>
    <p>&nbsp;</p>
	<!-- InstanceEndEditable -->
</div>
    
    <div id="footer">
    <?php include('include-footer.php'); ?></div>

</div>
</body>
<!-- InstanceEnd --></html>
