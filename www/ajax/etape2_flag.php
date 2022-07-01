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

$colname_RSpays = "-1";
if (isset($_GET['PAYS'])) {
  $colname_RSpays = utf8_decode($_GET['PAYS']);
}

mysql_select_db($database_bddcovoiturette, $bddcovoiturette);
//$query_RSville = sprintf("SELECT * FROM villes WHERE COMMUNE LIKE %s ORDER BY COMMUNE ASC", GetSQLValueString($colname_RSville . "%", "text"));
$query_RSville = sprintf("SELECT * FROM villes WHERE COMMUNE LIKE %s AND PAYS = %s ORDER BY COMMUNE ASC", GetSQLValueString($colname_RSville . "%", "text"),  GetSQLValueString($colname_RSpays, "text"));
$RSville = mysqli_query($bddcovoiturette ,$query_RSville) or die(mysql_error());
$row_RSville = mysql_fetch_assoc($RSville);
$totalRows_RSville = mysql_num_rows($RSville);

/*Tout le code ci-dessus est issu de dreamweaver. La ligne 36 a cependant �t� enrichie avec "utf8_decode" afin de corriger les probl�mes d'accents dans la fonction AJAX.

La ligne 38 a �t� cr��e afin de permettre une saisie de ville avec tiret (les villes sont enregistr�es sans)
*/
?>
  <a href="#" class="close" onClick="closearr()">fermer</a>
  <ul id="ville_etape2">
  <?php if($totalRows_RSville>0){ do { ?>
  <li><a href="#" onclick="go_ville(event)" lat="<?php echo $row_RSville['LATITUDE']; ?>" lon="<?php echo $row_RSville['LONGITUDE']; ?>"><?php echo htmlentities($row_RSville['COMMUNE']); ?> (<?php echo $row_RSville['PAYS'] . " - " . $row_RSville['CPOSTAL']; ?>)</a></li>
  <?php } while ($row_RSville = mysql_fetch_assoc($RSville));} ?>
  </ul>
  <script type="text/javascript">
    /*La fonction ci-dessous sert � pr�venir le comportement des touches du clavier. "Tab" et "Entr�e" valide le premier choix affich�. Les fl�ches sont quant � elles annul�es (elles causaient un plantage de l'ajax)*/
    $("#ETAPE2").keydown(function(event){
			if((event.keyCode==103)||(event.keyCode==105)||(event.keyCode==106)||(event.keyCode==108)){
				event.preventDefault();
			}
			if((event.keyCode==9)||(event.keyCode==13)){
			event.preventDefault(); 
			var villeid=$('#ville_etape2 li a:first-child').html();
			var lat=$('#ville_etape2 li a:first-child').attr('lat');
			var lon=$('#ville_etape2 li a:first-child').attr('lon');
			$('#ETAPE2').val(villeid);
			$('#ETAPE2_LAT').val(lat);
			$('#ETAPE2_LON').val(lon);
			$('#ETAPE2').removeClass('wait');
			$('#ETAPE2').addClass('check');
			$('#liste_etape2').hide();
			$('#ETAPE2').blur();/*�vite certains bugs d'affichage*/
			$('#PRIX2').focus();
			}
		});
				/*La fonction ci-dessous sert � enregistrer dans le formulaire le nom de la ville cliqu�e, et � enregistrer �galement dans les champs cach�s les coordonn�es GPS de Latitute et longitude. Egalement, cette action change la class de l'input afin d'afficher une fl�che verte signifiant que la ville est bien reconnue.*/
  function go_ville(event){
	var villeid=$(event.target || event.srcElement).html();
	var lat=$(event.target || event.srcElement).attr('lat');
	var lon=$(event.target || event.srcElement).attr('lon');
	$('#ETAPE2').val(villeid);
	$('#ETAPE2_LAT').val(lat);
	$('#ETAPE2_LON').val(lon);
	$('#ETAPE2').removeClass('wait');
	$('#ETAPE2').addClass('check');
	$('#liste_etape2').hide();
	$('#ETAPE2').blur();/*�vite certains bugs d'affichage*/
	$('#PRIX2').focus();
  }
  function closearr(){
	$('#liste_etape2').hide();
	$('#ETAPE2').blur();/*�vite certains bugs d'affichage*/
	$('#PRIX2').focus();
  }
  </script>
<?php
mysql_free_result($RSville);
?>
