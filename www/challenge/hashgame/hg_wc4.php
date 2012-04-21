<?php
define('HASHGAME_SALT_WC4', 'zomgsalt4');

function hashgame_wc4_salt($len = 4)
{
	$alpha = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	$max = strlen($alpha)-1;
	$back = '';
	for ($i = 0; $i < $len; $i++)
	{
		$back .= $alpha{rand(0, $max)};
	}
	return $back;
}

function hashgame_wc4($password)
{
	$salt = hashgame_wc4_salt(4); // Generate random salt.
	return hash('sha1', HASHGAME_SALT_WC4.$password.$salt.HASHGAME_SALT_WC4, false).$salt;
}

# PS: If you like the algo, you can grab the whole src from /inc/util/Common.php
# All the GWF/WC4 stuff is free as in beer ;)
?>