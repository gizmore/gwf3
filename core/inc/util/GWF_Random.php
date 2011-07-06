<?php
final class GWF_Random
{
	public static function arrayItem(array $array)
	{
		return $array[array_rand($array, 1)];
	}
	
}
?>