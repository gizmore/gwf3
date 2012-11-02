<?php
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
	
	public static function bold($s) { return "\X02{$b}\X02"; }
	
	public static function color($s, $fg, $bg=NULL)
	{
		if ($bg !== NULL)
		{
			return "\X03{$fg},{$bg}{$s}\X03";
		}
		else
		{
			return "\X03{$fg}{$s}\X03";
		}
	}
}
?>