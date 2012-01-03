<?php
define('SLAYRADIO_SECRET', 'Mother!Fucken!Kiwi.Bastard-Paradroid_001');
define('KWED_ORG_SECRET', '');
function slayradio_cross_login_hash($userid)
{
	$paddy = SLAYRADIO_SECRET; # We rely on a shared secret
	$plain = "$paddy.$userid..$paddy..$userid.$paddy";
	$hash = hash('sha512', $plain); # And a secret algo
	return substr($hash, 2, 64);
}
?>