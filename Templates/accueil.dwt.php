<?php require_once('../Connections/bddcovoiturette.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- TemplateBeginEditable name="doctitle" -->
<title>Covoiturage-libre.fr - Le site du covoiturage libre et gratuit !</title>
<!-- TemplateEndEditable -->
<link href="../css/covoiturage-libre.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery-ui2.js"></script>
<script type="text/javascript" src="../js/jquery.ui.datepicker-fr.js"></script>
<link rel="stylesheet" type="text/css" href="../css/smoothness/jquery-ui-1.8.16.custom.css"/>
<?php include('../include/include.php');?>
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
</head>

<body>
<div id="conteneur">


	<div id="header">
    <a href="../index.php" id="lienhome"></a>
    <?php include('../include/facebook.php');?>
	<!-- TemplateBeginEditable name="headersite" -->
    
    <div id="recherche">
    <h2>Trouver votre covoiturage</h2>
    <form id="form1" method="post" action="../recherche.php">
  <table width="100%" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td>Ville de d&eacute;part</td>
            <td>Ville d'arriv&eacute;e</td>
            <td>Date</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><label for="DEPART"></label>
              <input type="text" name="DEPART" id="DEPART" /></td>
            <td><label for="ARRIVEE"></label>
            <input type="text" name="ARRIVEE" id="ARRIVEE" /></td>
            <td><label for="DATE_PARCOURS"></label>
            <input type="text" name="DATE_PARCOURS" id="DATE_PARCOURS" /></td>
            <td><input type="submit" name="button" id="button" value="Rechercher" /></td>
            <td>&nbsp;</td>
          </tr>
      </table>
      </form>
    </div>
    <!-- TemplateEndEditable --></div>
    
    <div id="contenu">
	<!-- TemplateBeginEditable name="contenu" -->contenu<!-- TemplateEndEditable -->
  </div>
  
  <?php include('../include/droite.php');?>
    
    <div id="footer">
    <?php include('../include-footer.php'); ?></div>

</div>
</body>
</html>
