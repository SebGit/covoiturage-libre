<?php 
$cryptinstall="./cryptographp.fct.php";
include $cryptinstall; 
?>


<html>
<?php
  if (chk_crypt($_POST['code'])) 
     echo "<a><font color='#009700'>=> Bravo, vous avez saisi le bon code !</font></a>" ;
     else echo "<a><font color='#FF0000'>=> Erreur, le code est incorrect</font></a>" ;
?>
</html>

