<?php
/**
 * Change a text string to weird utf8 codes, so it looks the same but is not the same data.
 * @author noother
 */
final class GWF_Obfuscate
{
	public static $unicodeLookalikes = array(
		'A' => "\xce\x91", 'B' => "\xce\x92", 'C' => "\xd0\xa1", 'E' => "\xce\x95", 'F' => "\xcf\x9c",
		'H' => "\xce\x97", 'I' => "\xce\x99", 'J' => "\xd0\x88", 'K' => "\xce\x9a", 'M' => "\xce\x9c",
		'N' => "\xce\x9d", 'O' => "\xce\x9f", 'P' => "\xce\xa1", 'S' => "\xd0\x85", 'T' => "\xce\xa4",
		'X' => "\xce\xa7", 'Y' => "\xce\xa5", 'Z' => "\xce\x96",

		'a' => "\xd0\xb0", 'c' => "\xd1\x81", 'e' => "\xd0\xb5", 'i' => "\xd1\x96", 'j' => "\xd1\x98",
		'o' => "\xd0\xbe", 'p' => "\xd1\x80", 's' => "\xd1\x95", 'x' => "\xd1\x85", 'y' => "\xd1\x83"
	);

	public static function obfuscate($string)
	{
		if(false === $s = self::placeUnicode($string))
		{
			$s = self::placeSofthyphen($string);
		}
		return $s;
	}

	private static function placeUnicode($s)
	{
		for($i=0;$i<mb_strlen($s);$i++)
		{
			$char = mb_substr($s, $i, 1);

			if(isset(self::$unicodeLookalikes[$char]))
			{
				return mb_substr($s, 0, $i).self::$unicodeLookalikes[$char].mb_substr($s, $i+1);
			}
		}

		return false;
	}

	private static function placeSofthyphen($s)
	{
		$pos = rand(1, mb_strlen($s)-1);
		return mb_substr($s, 0, $pos)."\xC2\xAD".mb_substr($s, $pos);
	}	
}
