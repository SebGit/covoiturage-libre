<?php
header('HTTP/1.0 403 Forbidden');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Covoiturage-libre.fr - Le site du covoiturage libre et gratuit !</title>
<link href="css/covoiturage-libre.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="conteneur">
	<div id="header">
	    <a href="index.php" id="lienhome"></a>

	<hr style="visibility:hidden;clear:both" />
	</div>
    
	<div id="contenu">
		<h1>Interdit !</h1>
		<p>&nbsp;</p>
		<p>L'acc&egrave;s &agrave; cette ressource est interdit dans ces conditions.</p>
		<p>&nbsp;</p>
	</div>
    
    <div id="footer">
    <?php include('include-footer.php'); ?>
    </div>
</div>
</body>
</html>
