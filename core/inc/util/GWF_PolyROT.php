<?php
/**
 * Implementation of a polyalphabetic rot cipher.
 * @author gizmore
 */
final class GWF_PolyROT
{
	const CHARSET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	
	public static function encrypt($message, $key)
	{
		$charset = self::CHARSET;
		$message = trim(strtoupper($message));
		$key = trim(strtoupper($key));
		if (!self::checkArgs($message, $key))
		{
			return false;
		}
		
		$back = '';
		$len = strlen($message);
		$klen = strlen($key);
		$clen = strlen($charset);
		for ($i = 0; $i < $len; $i++)
		{
			if ($message[$i] === ' ')
			{
				$back .= ' ';
				continue;
			}
			
			$j = strpos($charset, $message[$i]);
			$k = strpos($charset, $key[$i%$klen]);
			$back .= $charset[($j+$k)%$clen]; 
		}
		return $back;
	}

	public static function decrypt($message, $key)
	{
		$charset = self::CHARSET;
		$message = trim(strtoupper($message));
		$key = trim(strtoupper($key));
		if (false === self::checkArgs($message, $key))
		{
			return false;
		}
		
		$back = '';
		$len = strlen($message);
		$klen = strlen($key);
		$clen = strlen(self::CHARSET);
		for ($i = 0; $i < $len; $i++)
		{
			if ($message[$i] === ' ')
			{
				$back .= ' ';
				continue;
			}
			$j = strpos($charset, $message[$i]);
			$k = strpos($charset, $key[$i%$klen]);
			$j -= $k;
			while ($j < 0)
			{
				$j += $clen;
			}
			$back .= $charset[$j]; 
		}
		return $back;
	}
	
	private static function checkArgs($message, $key)
	{
		if ($key === '')
		{
			return false;
		}
		
		if (!preg_match('/^[A-Z ]+$/D', $message))
		{
			echo "ERRMSG";
			return false;
		}

		if (!preg_match('/^[A-Z]+$/D', $key))
		{
			echo "ERRKEY: $key\n";
			return false;
		}
		
		return true;
	}
}
?>