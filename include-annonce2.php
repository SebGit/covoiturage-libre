<?php 
//vérification insert javascript avant affichage
 $phrase=$row_RSparcours['NOM'].$row_RSparcours['DEPART'].$row_RSparcours['ARRIVEE'].$row_RSparcours['ETAPE1'].$row_RSparcours['ETAPE2'].$row_RSparcours['ETAPE3'].$row_RSparcours['TELEPHONE'].$row_RSparcours['COMMENTAIRES'];

if ((preg_match("/\bjavascript\b/i", $phrase))||(preg_match("/\bscript\b/i", $phrase))||(preg_match("/\bhref\b/i", $phrase))) {
	
		}
//si verif okay, affichage de l'annonce
else {
?>
<table width="100%" border="0" cellpadding="4" cellspacing="0" class="annonce">
	    <tr>
	      <td width="300">
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="100" rowspan="4" align="left"><div class="picto"><img src="images/<?php echo htmlspecialchars($row_RSparcours['TYPE']); ?>-<?php echo htmlspecialchars($row_RSparcours['CIVILITE']); ?>.jpg" alt="" width="60" height="60" /><span class="legende"><?php echo htmlspecialchars($row_RSparcours['TYPE']); ?></span></div></td>
              <td width="50"><strong>Nom :</strong></td>
              <td><?php echo htmlspecialchars($row_RSparcours['NOM']); ?></td>
            </tr>
            <?php if($row_RSparcours['TYPE']=='Conducteur'){?>
            <tr>
              <td><strong>Dispo : </strong></td>
              <td class="dispo<?php echo htmlspecialchars($row_RSparcours['PLACES']); ?>"><strong><?php echo htmlspecialchars($row_RSparcours['PLACES']); ?></strong> place(s)</td>
              </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td width="60"><strong>Confort :</strong></td>
              <td><img src="images/confort/<?php echo htmlspecialchars($row_RSparcours['CONFORT']); ?>.gif" alt="<?php echo htmlspecialchars($row_RSparcours['CONFORT']); ?>" /></td>
              </tr>
              <?php } else { ?>
		    <?php } ?>
          </table></td>
	      <td width="450"><?php 
		  //calcul de la ville d'arrivée ou d'étape la plus proche de la recherche
		  //valeurs par défaut
		  $destination=$row_RSparcours['ARRIVEE'];
		  $depart=$row_RSparcours['DEPART'];
		  $prix=$row_RSparcours['PRIX'];
		  $lien='pri';
		  $liendep='pri';
		  
		  //etude de la ville de départ
			  if($row_RSparcours['DEPARTMIN']==$row_RSparcours['DEP2']){
				  $depart=$row_RSparcours['ETAPE1'];
				  $liendep='eta1';
			  }
			  if($row_RSparcours['DEPARTMIN']==$row_RSparcours['DEP3']){
				  $depart=$row_RSparcours['ETAPE2'];
				  $liendep='eta2';
			  }
			  if($row_RSparcours['DEPARTMIN']==$row_RSparcours['DEP4']){
				  $depart=$row_RSparcours['ETAPE3'];
				  $liendep='eta3';
			  }
			  if($row_RSparcours['DEPARTMIN']==$row_RSparcours['DEP1']){
				$depart=$row_RSparcours['DEPART'];
				$liendep='pri';
			  }
		  //fin de la sélection de la ville de départ
		  
		  //si ville d'arrivée fournie dans le moteur de recherche, comparaison...
		  if($_POST['ARRIVEE']!==''){
		  $arr1=$row_RSparcours['ARR1'];
		  $arr2=$row_RSparcours['ARR2'];
		  $arr3=$row_RSparcours['ARR3'];
		  $arr4=$row_RSparcours['ARR4'];
			  if($row_RSparcours['ARRIVEEMIN']==$row_RSparcours['ARR2']){
				  $destination=$row_RSparcours['ETAPE1'];
				  $prix=$row_RSparcours['PRIX1'];
				  $lien='eta1';
			  }
			  if($row_RSparcours['ARRIVEEMIN']==$row_RSparcours['ARR3']){
				  $destination=$row_RSparcours['ETAPE2'];
				  $prix=$row_RSparcours['PRIX2'];
				  $lien='eta2';
			  }
			  if($row_RSparcours['ARRIVEEMIN']==$row_RSparcours['ARR4']){
				  $destination=$row_RSparcours['ETAPE3'];
				  $prix=$row_RSparcours['PRIX3'];
				  $lien='eta3';
			  }
			  if($row_RSparcours['ARRIVEEMIN']==$row_RSparcours['ARR1']){
				$destination=$row_RSparcours['ARRIVEE'];
				$prix=$row_RSparcours['PRIX'];
				$lien='pri';
			  }
		  }
		  //fin du calcul de la ville d'arrivée ou d'étape la plus proche de la recherche
		  
		  //calcul du prix à afficher
		  if($liendep=='pri'){
			 $prix=$prix; 
		  }
		  if($liendep=='eta1'){
			 $prix=$prix-$row_RSparcours['PRIX1'];
		  }
		  if($liendep=='eta2'){
			 $prix=$prix-$row_RSparcours['PRIX2'];
		  }
		  if($liendep=='eta3'){
			 $prix=$prix-$row_RSparcours['PRIX3'];
		  }
		  ?>
          <p><?php echo htmlspecialchars($depart); ?> &rarr; <?php echo htmlspecialchars($destination); ?></p>
	        <p class="gros2"><?php $sqldate = $row_RSparcours['DATE_PARCOURS'];
			
			(preg_match("/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/", $sqldate, $regs));
			$jour = array("Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi"); 
		$mois = array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
		$datefr = $jour[date("w",mktime(0, 0, 0, $regs[2], $regs[3], $regs[1]))];
		$datefr .= " ".date("d",mktime(0, 0, 0, $regs[2], $regs[3], $regs[1]));
		$datefr .= " ".$mois[date("n",mktime(0, 0, 0, $regs[2], $regs[3], $regs[1]))];
		$datefr .= " ".date("Y",mktime(0, 0, 0, $regs[2], $regs[3], $regs[1])); 
		echo $datefr.' - '.substr($row_RSparcours['HEURE'], 0, 5);?> <?php if($liendep!=='pri'){ echo '<em style="font-size:14px;font-weight:normal;"> au d&eacute;part de '.$row_RSparcours['DEPART'].'</em>';} ?></p>
	        <p><a href="detail.php?c=<?php echo $row_RSparcours['CODE_CREATION']; ?>&p=<?php echo $lien; ?>&depart=<?php echo $liendep; ?>" class="lienannonce">&gt; lire l'annonce</a></p></td>
	      <td align="center" class="vert"><?php if($row_RSparcours['TYPE']=='Conducteur'){ echo '<span class="gros"><strong>'.htmlspecialchars($prix).' &euro;</strong></span><br />
          par ';}?>passager</td>
        </tr>
      </table><?php } ?>