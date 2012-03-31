<?php
/**
 * Array utility.
 * @author gizmore
 * @since 17.Nov.2011
 */
final class GWF_Array
{
	/**
	 * Convert an array to CSV.
	 * @param array $input
	 * @param string $delimiter
	 * @param string $enclosure
	 * @param string $escape
	 * @return string
	 */
	public static function toCSV($input, $delimiter=',', $enclosure='"', $escape='\\')
	{
		foreach ($input as $key => $value)
		{
			$input[$key] = str_replace($enclosure, $escape.$enclosure, $value);
		}
		return $enclosure.implode($enclosure.$delimiter.$enclosure, $input).$enclosure;
	}

	/**
	 * Recursive implode. Code taken from php.net. Original code by: kromped@yahoo.com
	 * @param string $glue
	 * @param array $pieces
	 * @return string
	 */
	public static function implode($glue, array $pieces, array $retVal=array())
	{
		foreach($pieces as $r_pieces)
		{
			$retVal[] = (true === is_array($r_pieces)) ? '['.self::implode($glue, $r_pieces).']' : $r_pieces;
		}
		return implode($glue, $retVal);
	}

	/**
	 * Implode an array like humans would do:
	 * Example: 1, 2, 3 and last
	 * @todo Make it recursive?
	 * @param array $array
	 * @return string
	 */
	public static function implodeHuman(array $array)
	{
		static $and = NULL;
		$cnt = count($array);
		if ($cnt <= 0) {
			return '';
		}
		elseif ($cnt === 1) {
			return array_pop($array);
		}
		if ($and === NULL) { $and = GWF_HTML::lang('and'); }
		$last = array_pop($array);
		return implode(', ', $array)." {$and} {$last}";
	}

	/**
	 * Swap the positions of an associative array.
	 * @param array $arr
	 * @param mixed $key1
	 * @param mixed $key2
	 */
	public static function swapAssoc(array $array, $key1, $key2)
	{
		$back = array();
		foreach ($array as $key => $value)
		{
			if ($key === $key1)
			{
				$back[$key2] = $array[$key2];
			}
			elseif ($key === $key2)
			{
				$back[$key1] = $array[$key1];
			}
			else
			{
				$back[$key] = $value;
			}
		}
		return $back;
	}
}

