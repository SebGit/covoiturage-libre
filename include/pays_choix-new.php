<div style="position:relative">
(<a href="#" class="pays_" id="pays_<?=$pays_desc?>"> Pays</a> : <span id="pays_<?=$pays_desc?>_nom">FR</span> )
<table id="flags_table_<?=$pays_desc?>" class="flags_table" width="auto" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td align="center" valign="middle">
    	<input type="radio" name="PAYS_<?=strtoupper($pays_desc)?>" value="DE" id="PAYS_<?=strtoupper($pays_desc)?>_0" /></td>
    <td align="center" valign="middle"><label for="PAYS_<?=strtoupper($pays_desc)?>_0"><img src="images/flags/flag-allemagne.jpg" width="20" height="13" alt="Allemagne" /></label></td>
    <td align="center" valign="middle">Allemagne</td>
	</tr>
  <tr>
    <td align="center" valign="middle"><input type="radio" name="PAYS_<?=strtoupper($pays_desc)?>" value="BE" id="PAYS_<?=strtoupper($pays_desc)?>_1" />
      <br />
      <label for="PAYS_<?=strtoupper($pays_desc)?>_1"><img src="images/flags/flag-belgique.jpg" width="20" height="13" alt="Belgique" /></label></td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">Belgique</td>
    </tr>
  <tr>
    <td align="center" valign="middle"><input type="radio" name="PAYS_<?=strtoupper($pays_desc)?>" value="ES" id="PAYS_<?=strtoupper($pays_desc)?>_2" />
      <br />
      <label for="PAYS_<?=strtoupper($pays_desc)?>_2"><img src="images/flags/flag-espagne.jpg" width="20" height="13" alt="Espagne" /></label></td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">Espagne</td>
    </tr>
  <tr>
    <td align="center" valign="middle"><input name="PAYS_<?=strtoupper($pays_desc)?>" type="radio" id="PAYS_<?=strtoupper($pays_desc)?>_3" value="FR" checked="checked" />
      <br />
      <label for="PAYS_<?=strtoupper($pays_desc)?>_3"><img src="images/flags/flag-france.jpg" width="20" height="13" alt="France" /></label></td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">France</td>
    </tr>
  <tr>
    <td align="center" valign="middle"><input type="radio" name="PAYS_<?=strtoupper($pays_desc)?>" value="IT" id="PAYS_<?=strtoupper($pays_desc)?>_4" />
      <br />
      <label for="PAYS_<?=strtoupper($pays_desc)?>_4"><img src="images/flags/flag-italie.jpg" width="20" height="13" alt="Italie" /></label></td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">Italie</td>
    </tr>
  <tr>
    <td align="center" valign="middle"><input type="radio" name="PAYS_<?=strtoupper($pays_desc)?>" value="LU" id="PAYS_<?=strtoupper($pays_desc)?>_5" />
      <br />
      <label for="PAYS_<?=strtoupper($pays_desc)?>_5"><img src="images/flags/flag-luxembourg.jpg" width="20" height="13" alt="Luxembourg" /></label></td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">Luxembourg</td>
    </tr>
  <tr>
    <td align="center" valign="middle"><input type="radio" name="PAYS_<?=strtoupper($pays_desc)?>" value="NL" id="PAYS_<?=strtoupper($pays_desc)?>_6" />
      <br />
      <label for="PAYS_<?=strtoupper($pays_desc)?>_6"><img src="images/flags/flag-p	aysbas.jpg" width="20" height="13" alt="Pays-Bas" /></label></td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">Pays-Bas</td>
    </tr>
  <tr>
    <td align="center" valign="middle"><input type="radio" name="PAYS_<?=strtoupper($pays_desc)?>" value="CH" id="PAYS_<?=strtoupper($pays_desc)?>_7" />
      <br />
      <label for="PAYS_<?=strtoupper($pays_desc)?>_7"><img src="images/flags/flag-suisse.jpg" width="20" height="13" alt="Suisse" /></label></td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">Suisse</td>
    </tr>
</table>
</div>
<script type="text/javascript">
/* <![CDATA[ */
$(document).ready(function() {
	$('a#pays_<?=$pays_desc?>').click(function(event) {
		event.preventDefault();
		$('.flags_table[id!=flags_table_<?=$pays_desc?>]').fadeOut('slow');
		$('#flags_table_<?=$pays_desc?>').fadeToggle('slow');
	});
	$('#flags_table_<?=$pays_desc?> input').change(function(){
		var pays  = $(this).val();
		$('#flags_table_<?=$pays_desc?>').fadeToggle('slow');
		$('#pays_<?=$pays_desc?>_nom').html(pays);
	});
});
/* ]]> */
</script> 