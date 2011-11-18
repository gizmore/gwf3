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
}
?>