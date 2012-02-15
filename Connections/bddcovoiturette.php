<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_bddcovoiturette = "localhost";
$database_bddcovoiturette = "covoiturette";
$username_bddcovoiturette = "root";
$password_bddcovoiturette = "velorution";
$bddcovoiturette = mysql_pconnect($hostname_bddcovoiturette, $username_bddcovoiturette, $password_bddcovoiturette) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
