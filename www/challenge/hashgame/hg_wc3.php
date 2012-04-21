<?php
define('HASHGAME_SALT_WC3', 'zomgsalt');

function hashgame_wc3($plaintext)
{
	return md5(md5($plaintext).HASHGAME_SALT_WC3);
}
?>