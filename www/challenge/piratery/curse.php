<?php
/**
 * Piratery curses.
 * Every wrong code of the chest lock (rhum.php) casts a random curse, which replaces the previous one.
 * The curse stays on the chest page until the chest is opened.
 */
final class PirateryCurse
{
	const SESSION_KEY = 'PIRATERY_CURSE';

	public static $CURSES = array('darkness', 'slippery', 'mirror', 'parrot');

	public static function current()
	{
		return GWF_Session::getOrDefault(self::SESSION_KEY, false);
	}

	/**
	 * Cast a random curse, different from the current one.
	 * @return string the curse name
	 */
	public static function cast()
	{
		$curses = array_values(array_diff(self::$CURSES, array(self::current())));
		$curse = $curses[array_rand($curses)];
		GWF_Session::set(self::SESSION_KEY, $curse);
		return $curse;
	}

	public static function lift()
	{
		GWF_Session::remove(self::SESSION_KEY);
	}

	/**
	 * Files of each curse, in challenge/piratery/curse/.
	 * External files only, as the Content-Security-Policy blocks inline scripts and styles.
	 */
	private static $FILES = array(
		'darkness' => array('darkness.css'), # Whole page black on black
		'slippery' => array('slippery.css', 'slippery.js'), # The answer field runs away
		'mirror' => array('mirror.js'), # Mirrored keys: a <-> z, 0 <-> 9
		'parrot' => array('parrot.js'), # Random YAAAR alerts
	);

	/**
	 * Output the CSS / JS of the current curse.
	 */
	public static function render()
	{
		if (false === ($curse = self::current()) || !isset(self::$FILES[$curse]))
		{
			return;
		}
		foreach (self::$FILES[$curse] as $file)
		{
			$href = GWF_WEB_ROOT.'challenge/piratery/curse/'.$file;
			echo substr($file, -4) === '.css'
				? sprintf('<link rel="stylesheet" type="text/css" href="%s" />', $href).PHP_EOL
				: sprintf('<script src="%s"></script>', $href).PHP_EOL;
		}
	}
}
