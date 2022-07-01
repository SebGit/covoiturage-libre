<?php require_once('../Connections/bddcovoiturette.php'); ?>
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

$colname_RSville = "-1";
if (isset($_GET['COMMUNE'])) {
  $colname_RSville = utf8_decode($_GET['COMMUNE']);
}
$colname_RSville=str_replace('-',' ',$colname_RSville);


mysql_select_db($database_bddcovoiturette, $bddcovoiturette);
$query_RSville = sprintf("SELECT * FROM villes WHERE COMMUNE LIKE %s ORDER BY COMMUNE ASC", GetSQLValueString($colname_RSville . "%", "text"));
$RSville = mysqli_query($bddcovoiturette ,$query_RSville) or die(mysql_error());
$row_RSville = mysql_fetch_assoc($RSville);
$totalRows_RSville = mysql_num_rows($RSville);

/*Tout le code ci-dessus est issu de dreamweaver. La ligne 36 a cependant été enrichie avec "utf8_decode" afin de corriger les problèmes d'accents dans la fonction AJAX.

La ligne 38 a été créée afin de permettre une saisie de ville avec tiret (les villes sont enregistrées sans)
*/
?>
  <a href="#" class="close" onClick="closearr()">fermer</a>
  <ul id="ville_etape3">
  <?php do { ?>
  <li><a href="#" onclick="go_ville(event)" lat="<?php echo $row_RSville['LATITUDE']; ?>" lon="<?php echo $row_RSville['LONGITUDE']; ?>"><?php echo htmlentities($row_RSville['COMMUNE']); ?> (<?php echo $row_RSville['DEPARTEMENT']; ?>)</a></li>
  <?php } while ($row_RSville = mysql_fetch_assoc($RSville)); ?>
  </ul>
  <script type="text/javascript">
    /*La fonction ci-dessous sert à prévenir le comportement des touches du clavier. "Tab" et "Entrée" valide le premier choix affiché. Les flèches sont quant à elles annulées (elles causaient un plantage de l'ajax)*/
  $("#ETAPE3").keydown(function(event){
			if((event.keyCode==103)||(event.keyCode==105)||(event.keyCode==106)||(event.keyCode==108)){
				event.preventDefault();
			}
			if((event.keyCode==9)||(event.keyCode==13)){
			event.preventDefault(); 
			var villeid=$('#ville_etape3 li a:first-child').html();
			var lat=$('#ville_etape3 li a:first-child').attr('lat');
			var lon=$('#ville_etape3 li a:first-child').attr('lon');
			$('#ETAPE3').val(villeid);
			$('#ETAPE3_LAT').val(lat);
			$('#ETAPE3_LON').val(lon);
			$('#ETAPE3').removeClass('wait');
			$('#ETAPE3').addClass('check');
			$('#liste_etape3').hide();
			$('#ETAPE3').blur();/*évite certains bugs d'affichage*/
			$('#PRIX3').focus();
			}
		});
		/*La fonction ci-dessous sert à enregistrer dans le formulaire le nom de la ville cliquée, et à enregistrer également dans les champs cachés les coordonnées GPS de Latitute et longitude. Egalement, cette action change la class de l'input afin d'afficher une flèche verte signifiant que la ville est bien reconnue.*/
  function go_ville(event){
	var villeid=$(event.target || event.srcElement).html();
	var lat=$(event.target || event.srcElement).attr('lat');
	var lon=$(event.target || event.srcElement).attr('lon');
	$('#ETAPE3').val(villeid);
	$('#ETAPE3_LAT').val(lat);
	$('#ETAPE3_LON').val(lon);
	$('#ETAPE3').removeClass('wait');
	$('#ETAPE3').addClass('check');
	$('#liste_etape3').hide();
	$('#ETAPE3').blur();/*évite certains bugs d'affichage*/
	$('#PRIX3').focus();
  }
  function closearr(){
	$('#liste_etape3').hide();
	$('#ETAPE3').blur();
	$('#PRIX3').focus();
  }
  </script>
<?php
mysql_free_result($RSville);
?>
