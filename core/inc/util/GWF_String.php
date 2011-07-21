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
}
?>