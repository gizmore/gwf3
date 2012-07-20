<?php
/**
 * Numeric helper class.
 * [+] Base conversion
 * [+] Factorization
 * [+] Digit sums
 * @author gizmore
 * @since GWF3
 */
final class GWF_Numeric
{
	#######################
	### Base Conversion ###
	#######################
	private static $inCharset = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ+-";
	private static $outCharset = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ+-";

	public static function baseConvert($number, $inBase, $outBase)
	{
		// backward compatibility
		return self::baseConvertChar(self::baseConvertInt($number, $inBase), $outBase);
	}

	/**
	 * Convert a string into number with outputBase
	 * Charset is in self::$inCharset
	 */
	public static function baseConvertInt($number, $inBase)
	{
		if (!is_string($number))
		{
			return "Error number is not string: $number";
		}

		$len = strlen($number);
		$value = "0";
		$powy = 0;

		for ($i = 0; $i < $len; $i++)
		{
			$char = $number[$len - $i - 1];
			if (false === ($inDigit = self::digitToDec($char, self::$inCharset)))
			{
				return "Unknown digit '$char' in charset.";
			}
			$add = bcpow("$inBase", "$powy");
			$add = bcmul("$inDigit", $add);
			$powy++;
			$value = bcadd($value, $add);
		}
		return $value;
	}

	/**
	 * Convert an number into string
	 * Charset is in self::$outCharset
	 * @param string $value a number as string
	 */
	public static function baseConvertChar($value, $outBase)
	{
	//	$len = strlen($value);
		$back = '';
		while ($value != '0')
		{
			$outNumber = bcmod($value, "$outBase");
			$back = self::decToDigit($outNumber, self::$outCharset).$back;
			$value = bcdiv($value, "$outBase");
		}

		return $back;
	}

	/**
	 * @return int
	 */
	private static function digitToDec($char, $charset)
	{
		return strpos("$charset", "$char");
	}

	private static function decToDigit($dec, $charset)
	{
		return $charset[((int)$dec)];
	}

	public static function setInputCharset($charset)
	{
		if (!is_string($charset) || strlen($charset) < 2)
		{
			echo "Numeric: Invalid charset";
			exit(1);
			return;
		}

		self::$inCharset = $charset;
	}

	public static function getInputCharset()
	{
		return self::$inCharset;
	}

	public static function setOutputCharset($charset)
	{
		if (!is_string($charset) || strlen($charset) < 2)
		{
			echo "Numeric: Invalid charset";
			exit(1);
			return;
		}
		self::$outCharset = $charset;
	}

	public static function getOutputCharset()
	{
		return self::$outCharset;
	}

	public static function setDefaultCharsets()
	{
		self::$inCharset = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ+-";
		self::$outCharset = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ+-";
	}

	#####################
	### Factorization ###
	#####################
	/**
	 *
	 * @param int $n
	 * @return array
	 */
	public static function factorize($n)
	{
		$back = array(); 
		while ($n != 1)
		{
			for ($i = 2; $i <= $n; $i++)
			{
				if ( ($n % $i) === 0 )
				{
					$n /= $i;
					$back[] = $i;
					break;
				}
			}
		}
		return $back;
	}

	#################
	### Digit sum ###
	#################
	/**
	 * @param int $n
	 * @return int
	 */
	public static function digitSum($n)
	{
		$sum = 0;
		$n = (string)$n;
		$len = strlen($n);
		for ($i = 0; $i < $len; $i++)
		{
			$sum += (int)$n{$i};
		}
		return $sum;
	}
}
