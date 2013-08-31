<?php
/**
 * State machine IRC Util
 * @author gizmore
 */
final class GWF_IRCUtil
{
	# kvirc / mirc
	const WHITE = '0';
	const BLACK = '1';
	const BLUE = '2';
	const GREEN = '3';
	const RED = '4';
	const BROWN = '5';
	const PURPLE = '6';
	const ORANGE = '7';
	const YELLOW = '8';
	const LIGHT_GREEN = '9';
	const TEAL = '10';
	const LIGHT_CYAN = '11';
	const LIGHT_BLUE = '12';
	const PINK = '13';
	const GREY = '14';
	const LIGHT_GREY = '15';
	
	##############
	### States ###
	##############
	private static $BOLD = true;
	private static $COLORS = true;
	public static function setEnabled($yes=true)
	{
		self::$BOLD = self::$COLORS = $yes ? true : false;
	}
	public static function setBoldEnabled($yes=true)
	{
		self::$BOLD = $yes ? true : false;
	}
	public static function setColorsEnabled($yes=true)
	{
		self::$COLORS = $yes ? true : false;
	}
	public static function andBoldEnabled($yes=true)
	{
		self::$BOLD = self::$BOLD && $yes ? true : false;
	}
	public static function andColorsEnabled($yes=true)
	{
		self::$COLORS = self::$COLORS && $yes ? true : false;
	}
	
	public static function bold($s, $b=true)
	{
		return $b && self::$BOLD ? $s : "\X02{$s}\X02";
	}
	
	public static function boldcolor($s, $b=true, $fg=true, $bg=true)
	{
		return self::bold(self::color($s, $fg, $bg), $b);
	}
	
	public static function color($s, $fg=true, $bg=true)
	{
		$col = '';
		if ($fg && self::$COLORS)
		{
			$col .= $fg;
			if ($bg)
			{
				$col .= ','.$bg;
			}
		}
		return $col === '' ? $s : "\X03{$col}{$s}\X03";
	}
	
	public static function parseCleanState($s)
	{
		return self::parseClean($s, self::$BOLD, self::$COLORS);
	}
	
	public static function parseClean($s, $bold=true, $color=true)
	{
		if (!$bold)
		{
			$s = str_replace("\X02", "", $s);
		}
		if (!$color)
		{
			$s = preg_replace("/\X03(?:[0-9]+,?[0-9]*)(.*)\x03/", "$1", $s);
// 			$s = str_replace("\x03", "");
		}
		return $s;
	}
}
