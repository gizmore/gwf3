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
	 * @todo Move to other file.
	 * @param string $glue
	 * @param array $pieces
	 * @return string
	 */
	public static function implode($glue, $pieces)
	{
		foreach($pieces as $r_pieces)
		{
			if (is_array($r_pieces)) {
				$retVal[] = self::implode($glue, $r_pieces);
			}
			else {
				$retVal[] = $r_pieces;
			}
		}
		return implode($glue, $retVal);
	}

	/**
	 * Implode an array like humans would do:
	 * Example: 1, 2, 3 and last
	 * @todo Move to other file. Make it recursive?
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
			return $array[0];
		}
		if ($and === NULL) { $and = GWF_HTML::lang('and'); }
		$last = array_pop($array);
		return implode(', ', $array)." {$and} {$last}";
	}
}
?>