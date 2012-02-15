<?php
//vérification insert javascript avant affichage
 $phrase=$row_RSparcours['NOM'].$row_RSparcours['DEPART'].$row_RSparcours['ARRIVEE'];

if ((preg_match("/\bjavascript\b/i", $phrase))||(preg_match("/\byopmail\b/i", $phrase))||(preg_match("/\bmailinator\b/i", $phrase))||(preg_match("/\bscript\b/i", $phrase))||(preg_match("/\bhref\b/i", $phrase))) {
	
		}
//si verif okay, affichage de l'annonce
else {
?>
<table width="100%" border="0" cellpadding="4" cellspacing="0" class="annonce">
	    <tr>
	      <td width="270">
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="100" rowspan="4" align="left"><div class="picto"><img src="images/<?php echo htmlspecialchars($row_RSparcours['TYPE']); ?>-<?php echo htmlspecialchars($row_RSparcours['CIVILITE']); ?>.jpg" alt="" width="60" height="60" /><span class="legende"><?php echo htmlspecialchars($row_RSparcours['TYPE']); ?></span></div></td>
              <td width="50" height="22"><strong>Nom :</strong></td>
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
	      <td>
          <p><?php echo htmlspecialchars($row_RSparcours['DEPART']); ?> &rarr; <?php echo htmlspecialchars($row_RSparcours['ARRIVEE']); ?></p>
	        <p class="gros2"><?php $sqldate = htmlspecialchars($row_RSparcours['DATE_PARCOURS']);
			
			(preg_match("/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/", $sqldate, $regs));
			$jour = array("Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi"); 
		$mois = array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
		$datefr = $jour[date("w",mktime(0, 0, 0, $regs[2], $regs[3], $regs[1]))];
		$datefr .= " ".date("d",mktime(0, 0, 0, $regs[2], $regs[3], $regs[1]));
		$datefr .= " ".$mois[date("n",mktime(0, 0, 0, $regs[2], $regs[3], $regs[1]))];
		$datefr .= " ".date("Y",mktime(0, 0, 0, $regs[2], $regs[3], $regs[1])); 
		echo $datefr.' - '.substr($row_RSparcours['HEURE'], 0, 5);?></p>
        <a href="detail.php?c=<?php echo $row_RSparcours['CODE_CREATION']; ?>&p=pri&depart=pri" class="lienannonce">&gt; Lire l'annonce</a>
	        </td>
	      <td align="center" class="vert"><?php if($row_RSparcours['TYPE']=='Conducteur'){ echo '<span class="gros"><strong>'.htmlspecialchars($row_RSparcours['PRIX']).' &euro;</strong></span><br />
          par ';}?>passager</td>
        </tr>
      </table><?php } ?>