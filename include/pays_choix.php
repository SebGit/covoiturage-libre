<div style="position:relative;display:inline;">
<a href="#" class="pays_" id="pays_<?=$pays_desc?>">Pays : <span id="pays_<?=$pays_desc?>_nom" class=""></span></a>
<table id="flags_table_<?=$pays_desc?>" class="flags_table" width="auto" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td align="center" valign="middle">
      <input type="radio" name="PAYS_<?=strtoupper($pays_desc)?>" value="DE" id="PAYS_<?=strtoupper($pays_desc)?>_0" /><br />
      <label for="PAYS_<?=strtoupper($pays_desc)?>_0"><img src="images/flags/flag-allemagne.jpg" width="20" height="13" alt="Allemagne" /></label>
      </td>
    <td align="center" valign="middle">
      <input type="radio" name="PAYS_<?=strtoupper($pays_desc)?>" value="BE" id="PAYS_<?=strtoupper($pays_desc)?>_1" /><br />
      <label for="PAYS_<?=strtoupper($pays_desc)?>_1"><img src="images/flags/flag-belgique.jpg" width="20" height="13" alt="Belgique" /></label>
      </td>
    <td align="center" valign="middle">
    <input name="PAYS_<?=strtoupper($pays_desc)?>" type="radio" id="PAYS_<?=strtoupper($pays_desc)?>_3" value="FR" checked /><br />
    <label for="PAYS_<?=strtoupper($pays_desc)?>_3"><img src="images/flags/flag-france.jpg" width="20" height="13" alt="France" /></label>
        </td>
    <td align="center" valign="middle">
    <input type="radio" name="PAYS_<?=strtoupper($pays_desc)?>" value="IT" id="PAYS_<?=strtoupper($pays_desc)?>_4" /><br />
    <label for="PAYS_<?=strtoupper($pays_desc)?>_4"><img src="images/flags/flag-italie.jpg" width="20" height="13" alt="Italie" /></label>
    </td>
    <td align="center" valign="middle">
    <input type="radio" name="PAYS_<?=strtoupper($pays_desc)?>" value="CH" id="PAYS_<?=strtoupper($pays_desc)?>_7" /><br />
    <label for="PAYS_<?=strtoupper($pays_desc)?>_7"><img src="images/flags/flag-suisse.jpg" width="20" height="13" alt="Suisse" /></label>
    </td>
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
	$('#flags_table_<?=$pays_desc?> input').click(function(){
		var pays  = $(this).val();
		$('#flags_table_<?=$pays_desc?>').fadeToggle('slow');
		//$('#pays_<?=$pays_desc?>_nom').html(pays);
		var classe = $('#pays_<?=$pays_desc?>_nom').attr('class');
		$('#pays_<?=$pays_desc?>_nom').removeClass(classe);
		$('#pays_<?=$pays_desc?>_nom').addClass(pays);
	});
});

function flagclose(){
		$('.flags_table[id!=flags_table_<?=$pays_desc?>]').fadeOut('slow');
}
/* ]]> */
</script> 