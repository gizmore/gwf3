<?php
/**
 * PHP callback helpers.
 * @author gizmore
 * @since 22.Nov.2013
 */
final class GWF_Callback
{
	/**
	 * Check if a variable is a valid parameter for call_user_func().
	 * @param mixed $callback - The parameter to check.
	 * @param boolean $null_is_true - Optional, Indicate if null should return true.
	 * @return boolean
	 */
	public static function isCallback($callback, $null_is_true=false, $unknown_is_true=false)
	{
		if ($callback === null)
		{
			return $null_is_true;
		}
		elseif (is_string($callback))
		{
			return function_exists($callback) ? true : $unknown_is_true;
		}
		elseif ( (!is_array($callback)) || (count($callback) !== 2) )
		{
			return false;
		}
		elseif (method_exists($callback[0], $callback[1]))
		{
			return true;
		}
		else
		{
			return $unknown_is_true;
		}
	}
	
	/**
	 * return human readable callback name.
	 * @param mixed $callback
	 * @return string
	 */
	public static function printCallback($callback)
	{
		$exists = self::isCallback($callback) ? '' : 'unknown ';
		if (is_string($callback))
		{
			return "{$exists}function $callback()";
		}
		elseif ( (is_array($callback)) && (count($callback)===2) && (is_string($callback[1])) )
		{
			if (is_object($callback[0]))
			{
				$classname = get_class($callback[0]);
				return "{$exists}method {$classname}->{$callback[1]}";
			}
			elseif (is_string($callback[0]))
			{
				return "{$exists}method {$callback[0]}::{$callback[1]}";
			}
		}
		return 'Not a valid callback: '.print_r($callback, true);
	}
}
