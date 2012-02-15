<script type="text/javascript">
$(function() {
		$( "#DATE_PARCOURS" ).datepicker({minDate: 0, maxDate: "+2M", dateFormat: 'dd-mm-yy'});
});
function disableAutocomplete(elementId)
{
	var e = document.getElementById(elementId);
	if(e != null)
	{
		e.setAttribute("autocomplete", "off"); 
	}
}

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-6285179-8']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

