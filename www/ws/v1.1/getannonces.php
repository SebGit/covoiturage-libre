<?php
if (
	!isset($_GET['ville_depart']) or empty($_GET['ville_depart']) or
	!isset($_GET['ville_arrivee']) or empty($_GET['ville_arrivee']) or
	!isset($_GET['date']) or /*empty($_GET['date']) or*/
	!isset($_GET['type']) or empty($_GET['type']) or
	!isset($_GET['rayon_depart']) or empty($_GET['rayon_depart']) or
	!isset($_GET['rayon_arrivee']) or empty($_GET['rayon_arrivee']) or
	!isset($_GET['tri']) or empty($_GET['tri']) or
	!isset($_GET['page']) /*or
	!isset($_GET['index_debut']) or empty($_GET['index_debut']) or
	!isset($_GET['index_fin']) or empty($_GET['index_fin'])*/
	) {
	die();
}

//verif page num
$page = 1;
if (filter_var($_GET['page'], FILTER_VALIDATE_INT)) {
	$page = $_GET['page'];
}
//
require_once('../../Connections/bddcovoiturette.php');
mysql_select_db($database_bddcovoiturette, $bddcovoiturette);

$vdep	= mysql_real_escape_string(stripslashes($_GET['ville_depart']));
$varr	= mysql_real_escape_string(stripslashes($_GET['ville_arrivee']));
$date	= mysql_real_escape_string(stripslashes($_GET['date']));
$type	= mysql_real_escape_string(stripslashes($_GET['type']));
$rdep	= mysql_real_escape_string(stripslashes($_GET['rayon_depart']));
$rarr	= mysql_real_escape_string(stripslashes($_GET['rayon_arrivee']));
$tri	= mysql_real_escape_string(stripslashes($_GET['tri']));
//$ideb	= mysql_real_escape_string(stripslashes($_GET['index_debut']));
//$ifin	= mysql_real_escape_string(stripslashes($_GET['index_fin']));


/* *** */
// latlong villes
$query = "SELECT longitude, latitude FROM `villes_ws` WHERE commune = '" . $vdep . "'";
$RSville = mysqli_query($bddcovoiturette ,$query) or die(mysql_error());
$row_RSville = mysql_fetch_assoc($RSville);
$vdep_long	= $row_RSville['longitude'];
$vdep_lat	= $row_RSville['latitude'];
mysql_free_result($RSville);

//

$query = "SELECT longitude, latitude FROM `villes_ws` WHERE commune = '" . $varr . "'";
$RSville = mysqli_query($bddcovoiturette ,$query) or die(mysql_error());
$row_RSville = mysql_fetch_assoc($RSville);
$varr_long	= $row_RSville['longitude'];
$varr_lat	= $row_RSville['latitude'];
mysql_free_result($RSville);
// /latlong villes

// rayon

// /rayon

// depart
$formuledep1 = "(6366*acos(cos(radians($vdep_lat))*cos(radians(`DEPART_LAT`))*cos(radians(`DEPART_LON`) -radians($vdep_long))+sin(radians($vdep_lat))*sin(radians(`DEPART_LAT`)))) AS DEP1";

$formuledep2 = "(6366*acos(cos(radians($vdep_lat))*cos(radians(`ETAPE1_LAT`))*cos(radians(`ETAPE1_LON`) -radians($vdep_long))+sin(radians($vdep_lat))*sin(radians(`ETAPE1_LAT`)))) AS DEP2";

$formuledep3 = "(6366*acos(cos(radians($vdep_lat))*cos(radians(`ETAPE2_LAT`))*cos(radians(`ETAPE2_LON`) -radians($vdep_long))+sin(radians($vdep_lat))*sin(radians(`ETAPE2_LAT`)))) AS DEP3";

$formuledep4 = "(6366*acos(cos(radians($vdep_lat))*cos(radians(`ETAPE3_LAT`))*cos(radians(`ETAPE3_LON`) -radians($vdep_long))+sin(radians($vdep_lat))*sin(radians(`ETAPE3_LAT`)))) AS DEP4";

$formuledepsql = $formuledep1 . ',' . $formuledep2 . ',' . $formuledep3 . ',' . $formuledep4;

$requetedep = "(DEP1<='" . $rdep . "' OR DEP2<='" . $rdep . "' OR DEP3<='" . $rdep . "' OR DEP4<='" . $rdep."')";
// /depart

// arrivée
$formulearr1 = "(6366*acos(cos(radians($varr_lat))*cos(radians(`ARRIVEE_LAT`))*cos(radians(`ARRIVEE_LON`) -radians($varr_long))+sin(radians($varr_lat))*sin(radians(`ARRIVEE_LAT`)))) AS ARR1";
	
$formulearr2 = "(6366*acos(cos(radians($varr_lat))*cos(radians(`ETAPE1_LAT`))*cos(radians(`ETAPE1_LON`) -radians($varr_long))+sin(radians($varr_lat))*sin(radians(`ETAPE1_LAT`)))) AS ARR2";
	
$formulearr3  ="(6366*acos(cos(radians($varr_lat))*cos(radians(`ETAPE2_LAT`))*cos(radians(`ETAPE2_LON`) -radians($varr_long))+sin(radians($varr_lat))*sin(radians(`ETAPE2_LAT`)))) AS ARR3";
	
$formulearr4 = "(6366*acos(cos(radians($varr_lat))*cos(radians(`ETAPE3_LAT`))*cos(radians(`ETAPE3_LON`) -radians($varr_long))+sin(radians($varr_lat))*sin(radians(`ETAPE3_LAT`)))) AS ARR4";
	
$formulearrsql = ',' . $formulearr1 . ',' . $formulearr2 . ',' . $formulearr3 . ',' . $formulearr4;
	
$requetearr="AND (ARR1<='" . $rarr . "' OR ARR2<='" . $rarr . "' OR ARR3<='" . $rarr . "' OR ARR4<='" . $rarr ."')";
// /arrivée
/* *** */

// date
if (!empty($_GET['date'])) {
	$date = substr($date, 0, 4) . "-" . substr($date, 4, 2) . "-" . substr($date, 6, 2);
	$date = " AND DATE_PARCOURS = '" . $date . "' ";
}
// /date

// type
if ($type == 'c') {
	$type = "AND TYPE = 'Conducteur'";
} elseif ($type == 'p') {
	$type = "AND TYPE = 'Passager'";
} else {
	$type = '';
}
// /type

// tri
if ($tri == 'pc') {
	$tri = 'PRIX ASC';
} elseif ($tri == 'pd') {
	$tri = 'PRIX DESC';
} elseif ($tri == 'nbpc') {
	$tri = 'PLACES ASC';
} elseif ($tri == 'nbpd') {
	$tri = 'PLACES DESC';
} else {
	$tri = 'DATE_PARCOURS ASC, HEURE ASC';
}
// /tri

// req finale
$query_RSparcours = "
	SELECT
		*,
		IF(((DEPARTMIN=DEP4)AND(ARRIVEEMIN!=ARR1)),1,0) AS VERIF1,
		IF(((DEPARTMIN=DEP3)AND((ARRIVEEMIN!=ARR1) OR (ARRIVEEMIN!=ARR4))),1,0) AS VERIF2,
		IF(((DEPARTMIN=DEP2)AND(ARRIVEEMIN=ARR2)),1,0) AS VERIF3
	FROM
		(
			SELECT
				*,
				LEAST(DEP1, IFNULL(DEP2,5000),
				IFNULL(DEP3, 5000),
				IFNULL(DEP4, 5000)) AS DEPARTMIN,
				LEAST(ARR1, IFNULL(ARR2,5000), IFNULL(ARR3,5000),
				IFNULL(ARR4, 5000)) AS ARRIVEEMIN
			FROM
				(
					SELECT
						*,
						" . $formuledepsql
						  . $formulearrsql .
						"
					FROM
						trajets_ws
					WHERE
						STATUT = 'Valide' "
						. $date
						. $type
						. "
					HAVING "
						. $requetedep
						. " "
						. $requetearr
						. "
					ORDER BY " . $tri . "
				) AS t1
		) AS t2
	HAVING
		VERIF1 = 0 AND VERIF2 = 0 AND VERIF3 = 0
	 ";

// /req finale

//echo $query_RSparcours;

$RSParc = mysqli_query($bddcovoiturette ,$query_RSparcours) or die(mysql_error());
$totalParc = mysql_num_rows($RSParc);
$totalParc2 = 0;
// pagination
if ($totalParc > 0) {
	$npp = 5;// nb annonces par page
	$to = ($page - 1) * $npp;
	$limit = "LIMIT ".$to.", " . $npp;
	$query_RSparcours .= $limit;
	$RSParc = mysqli_query($bddcovoiturette ,$query_RSparcours) or die(mysql_error());
	$totalParc2 = mysql_num_rows($RSParc);
}
// /pagination

$xmlstr = '<?xml version="1.0" encoding="UTF-8"?>';
if ($totalParc2 > 0) {
	$xmlstr .= '<annonces>';
	
	$xmlstr .= '<total>' . $totalParc . '</total>';
	$xmlstr .= '<page>' . $page . '</page>';

	while ($row_RSParc = mysql_fetch_assoc($RSParc)) {
		$comm = $row_RSParc['COMMENTAIRES'];
		if (!empty($comm)) {
			$Remplace = array("<", ">", "&");
			$comm = str_replace($Remplace, '', $comm);
			$comm = utf8_encode($comm);
		}
		foreach($row_RSParc as $key => $val) {
			$row_RSParc[$key] = utf8_encode($val);
		}
		
		$xmlstr .= '<annonce>';

		$xmlstr .= '<type>' . $row_RSParc['TYPE'] . '</type>';
		$xmlstr .= '<genre>' . $row_RSParc['CIVILITE'] . '</genre>';
		$xmlstr .= '<nom>' . $row_RSParc['NOM'] . '</nom>';
		$xmlstr .= '<age>' . $row_RSParc['AGE'] . '</age>';
		$xmlstr .= '<ville_depart>' . $row_RSParc['DEPART'] . '</ville_depart>';
		$xmlstr .= '<ville_etape1>' . $row_RSParc['ETAPE1'] . '</ville_etape1>';
		$xmlstr .= '<ville_etape2>' . $row_RSParc['ETAPE2'] . '</ville_etape2>';
		$xmlstr .= '<ville_etape3>' . $row_RSParc['ETAPE3'] . '</ville_etape3>';
		$xmlstr .= '<ville_arrivee>' . $row_RSParc['ARRIVEE'] . '</ville_arrivee>';
		$xmlstr .= '<date>' . $row_RSParc['DATE_PARCOURS'] . ' ' . $row_RSParc['HEURE'] .'</date>';
		$xmlstr .= '<places>' . $row_RSParc['PLACES'] . '</places>';
		$xmlstr .= '<prix>' . $row_RSParc['PRIX'] . '</prix>';
		$xmlstr .= '<confort_vehicule>' . $row_RSParc['CONFORT'] . '</confort_vehicule>';
		$xmlstr .= '<tel>' . $row_RSParc['TELEPHONE'] . '</tel>';
		$xmlstr .= '<email>' . $row_RSParc['EMAIL'] . '</email>';
		$xmlstr .= '<commentaire>' . $comm . '</commentaire>';
		
		$xmlstr .= '</annonce>';
	}	
	mysql_free_result($RSParc);
	
	$xmlstr .= '</annonces>';
	
	
} else {
	$xmlstr .= '<annonces/>';	
}

header("Content-Type: text/xml");
echo $xmlstr;
?>