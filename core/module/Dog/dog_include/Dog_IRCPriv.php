<?php
final class Dog_IRCPriv
{
	const REGBIT = 0x01;
	const LOGBIT = 0x02;
	const HOSTBIT = 0x400;
	
	public static $NAMEMAP    = array('public', 'regged',     'logged',     'voice', 'halfop', 'operator', 'staff', 'admin', 'founder', 'ircop', 'owner', 'responsible');
	public static $CHARMAP    = array('p',      'r',          'l',          'v',     'h',      'o',        's',     'a',     'f',       'i',     'x',     'y');
	public static $SYMBOLMAP  = array(''  ,     ''   ,        '',           '+',     '%',      '@',        ''  ,    '',      '~'  ,     '',      '',      '');
	public static $CSYMBOLMAP = array('',       '',           '',           'v',     'h',      'o',        '',      '',      '',        '',      '',      '');
	public static $BITMAP     = array(0x0000,   self::REGBIT, self::LOGBIT, 0x0004,  0x0008,   0x0010,     0x0020,  0x0040,  0x0080,    0x0100,  0x0200,  self::HOSTBIT);
	
	public static function allBits() { return 0x3ff; } # XXX: THIS FUNCTION SUXX!
	public static function allBitsButOwner() { return 0x1ff; } # XXX: THIS FUNCTION SUXX!
	public static function allChars() { return implode('', self::$CHARMAP); }
	public static function allSymbols() { return implode('', self::$SYMBOLMAP); }
	public static function allChangeableChars() { return str_replace(array('p','r','l','y'), '', self::allChars()); }
	
	public static function filterPrivsToEdit($chars)
	{
		$valid = self::allChangeableChars();
		return preg_replace("/[^$valid]/", '', $chars);
	}
	
	public static function displayChar($char) { return Dog::lang('priv_'.$char); }

	public static function displayBits($bits, $p='p')
	{
		$back = $p;
		foreach (self::$BITMAP as $i => $bit)
		{
			if ($bits & $bit)
			{
				$back .= self::$CHARMAP[$i];
			}
		}
		return $back;
	}
	
	public static function matchSymbols($username)
	{
		$pattern = preg_quote(self::allSymbols());
		$pattern = "/^([$pattern]+)/";
		return Common::regex($pattern, $username);
	}
	
	public static function trimSymbols($channame)
	{
		return ltrim($channame, self::allSymbols());
	}
	
	public static function symbolToChar($symbol, $p='p')
	{
		if ($symbol === '') return $p;
		return (false === ($index = array_search($symbol, self::$SYMBOLMAP))) ? $p : self::$CHARMAP[$index];
	}
	
	public static function symbolsToChar($symbols)
	{
// 		echo "Dog_IRCPriv::symbolsToChar($symbols)\n";
		$chars = 'p';
		foreach (str_split($symbols) as $symbol)
		{
			$chars .= self::symbolToChar($symbol, '');
		}
		return $chars;
	}

	public static function charsToBits($chars)
	{
		$bits = 0;
		foreach (str_split($chars) as $char)
		{
			$bits |= self::charToBit($char);
		}
		return $bits;
	}
	
	public static function charToBit($char)
	{
		return false === ($index = array_search(strtolower($char), self::$CHARMAP)) ? 0 : self::$BITMAP[$index];
	}
	
	public static function getHighestBit($bits)
	{
		if (!$bits)
		{
			return 0;
		}
		$back = 1;
		while ($bits >>= 1)
		{
			$back <<= 1;
		}
		return $back;
	}
	
	public static function bitToBestNamedSymbol($bit)
	{
		$map = array_reverse(self::$CSYMBOLMAP);
		foreach (array_reverse(self::$BITMAP) as $i => $b)
		{
			if ($bit >= $b)
			{
				if ($map[$i] !== '')
				{
					return $map[$i];
				}
			}
		}
		return false;
	}
}
