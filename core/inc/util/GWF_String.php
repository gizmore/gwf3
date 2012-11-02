<?php
/**
 * Rarely used string utility.
 * @author gizmore
 * @version 1.0
 * @since 04.Jul.2011
 * 
 */
final class GWF_String
{
	/**
	 * UTF8 strlen.
	 * @param string $str
	 * @return int
	 */
	public static function strlen($str)
	{
		return mb_strlen($str, 'utf8');
	}
	
	public static function remove($str, $chars, $replace='')
	{
		return str_replace(str_split($chars), $replace, $str);
	}

	/**
	 * Check if a character is [a-zA-Z0-9]
	 * @param $c
	 * @return true|false
	 */
	public static function isAlphaNum($c)
	{
		return ( (($c>='a')&&($c<='z')) || (($c>='A')&&($c<='Z')) || (($c>='0')&&($c<='9')) );
	}

	/**
	 * Count the occurance of a string within a string.
	 * @param string $s
	 * @param string $c
	 */
	public static function countChar($s, $c)
	{
		$count = 0;
		$offset = -1;
		while (false !== ($offset = strpos($s, $c, $offset+1)))
		{
			$count++;
		}
		return $count;
	}

	/**
	 * Return the last position of a char, counting backwards from offset.
	 * This function does not work with strings, only with a char as needle.
	 * @param string $s
	 * @param char $c
	 * @param int $offset
	 */
	public static function strrchr($s, $c, $offset=0)
	{
		$len = strlen($s);
		$i = Common::clamp((int)$offset, 0, $len-1);
		while ($i >= 0)
		{
			if ($s{$i} === $c)
			{
				return $i;
			}
			$i--;
		}
		return false;
	}
	
	/**
	 * UTF8 strtolower.
	 * @param string $s
	 * @return string
	 */
	public static function toLower($s)
	{
		return mb_strtolower($s, 'UTF-8');
	}

	/**
	 * UTF8 strtoupper.
	 * @param string $s
	 * @return string
	 */
	public static function toUpper($s)
	{
		return mb_strtoupper($s, 'UTF-8');
	}
}
?>
