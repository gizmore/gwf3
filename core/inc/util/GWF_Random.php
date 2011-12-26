<?php
final class GWF_Random
{
	public static function arrayItem(array $array)
	{
		return $array[array_rand($array, 1)];
	}

	const TOKEN_LEN = 16;
	const ALPHAUP = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	const ALPHALOW = 'abcdefghijklmnopqrstuvwxyz';
	const HEXLOWER = 'abcdef0123456789';
	const HEXUPPER = 'ABCDEF0123456789';
	const ALPHANUMLOW = 'abcdefghijklmnopqrstuvwxyz0123456789';
	const ALPHANUMUPLOW = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	const ALPHANUMUPLOWSPECIAL = '!"\'_.,%&/()=<>;:#+-*~@abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	/**
	 * Generate a randomkey from a charset. A bit slow but should be random.
	 * @param $len int
	 * @param $alpha string or true
	 * @return string
	 */
	public static function randomKey($len=self::TOKEN_LEN, $alpha=self::ALPHANUMUPLOW)
	{
		$alphalen = strlen($alpha) - 1;
		$key = '';
		for($i = 0; $i < $len; $i++)
		{
			$key .= $alpha[rand(0, $alphalen)];
		}
		return $key;
	}
}
?>