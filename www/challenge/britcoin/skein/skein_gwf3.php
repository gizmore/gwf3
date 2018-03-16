<?php

# For testing, if you are too lazy to compile real skein
if (!function_exists('skein_hash_hex'))
{
	function skein_hash_hex($string)
	{
		return sha1($string);
	}
}

final class GWF_Skein
{
	public static function hashString($string)
	{
		return strtoupper(skein_hash_hex($string));
	}
}
