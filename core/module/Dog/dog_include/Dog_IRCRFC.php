<?php
final class Dog_IRCRFC
{
	CONST NICK_LENGTH = 24;
	
	const LETTERS = 'a-z';
	const SPECIAL = '';
	const DIGITS = '0-9';
	const HYPHEN = '-';
	
	/**
	 * Valid IRC Nickname like a12345678
	 * nickname   =  ( letter / special ) *8( letter / digit / special / "-" )
	 * @see http://tools.ietf.org/html/rfc2812#section-2.3.1
	 * @param int $maxlength
	 * @return string
	 */
	public static function nicknamePattern($maxlength=self::NICK_LENGTH)
	{
		$max = min(self::NICK_LENGTH, max(1, intval($maxlength, 10) - 1));
		$l = self::LETTERS; $d = self::DIGITS; $s = self::SPECIAL; $h = self::HYPHEN;
		return "/^[$l$s][$l$s$d$h]{0,$max}$/iD";
	}
	/**
	 * Check if an IRC name is valid
	 * nickname = ( letter / special ) *8( letter / digit / special / "-" )
	 * @see http://tools.ietf.org/html/rfc2812#section-2.3.1
	 * @param string $nickname - The nickname
	 * @param int $maxlength
	 * @return boolean
	 */
	public static function isValidNickname($nickname, $maxlength=self::NICK_LENGTH)
	{
		return preg_match(self::nicknamePattern($maxlength), $nickname) === 1;
	}
}
