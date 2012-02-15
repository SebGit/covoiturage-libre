<?php
function getToken() {
	$token = sha1(uniqid(mt_rand(), true));
	
	$_SESSION["cvtoken"] = $token;
    $_SESSION["time"]	= time();
    
    return $token;
}
function getTokenM() {
	$token = sha1(uniqid(mt_rand(), true));
	$_SESSION["cvtokenm"] = $token;
    return $token;
}
?>
