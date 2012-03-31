<?php
/**
 * Encrypt with some simple XOR algo.
 * This is not cryptographically safe and designed to be easily broken!
 * @author gizmore
 * @version 1.0
 */
final class GWF_Crypt
{
	public static function encrypt($plaintext, $key)
	{
		return self::decrypt($plaintext, $key);
	}

	public static function decrypt($ciphertext, $key)
	{
		if (0 === ($klen = strlen($key))) {
			die('Error: Invalid key for decryption');
		}
		$back = '';
		$len = strlen($ciphertext);
		$x = 1;
		$k = -1;
		$e = ord('e');
		for ($i = 0; $i < $len; $i++)
		{
			$k += $x;
			if ($k >= $klen) {
				$k = 0;
				$x++;
				if ($x >= $klen) {
					$x = 1;
				}
			}
			$back .= chr(ord($key{$k%$klen}) ^ ord($ciphertext{$i}) ^ $e);
		}
		return $back;
	}
}
