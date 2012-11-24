<?php
final class Dog_Lang
{
	private static $LANG;
	
	public static function init()
	{
		self::$LANG = new GWF_LangTrans(DOG_PATH.'dog_lang/dog');
	}
	
	public static function lang($key, $args=NULL)
	{
		return self::langISO(Dog::getLangISO(), $key, $args);
	}
	
	public static function langISO($iso, $key, $args=NULL)
	{
		return self::$LANG->langISO($iso, $key, $args);
	}
	
	public static function getISOCodes()
	{
		return explode(';', GWF_SUPPORTED_LANGS);
	}
}
?>
