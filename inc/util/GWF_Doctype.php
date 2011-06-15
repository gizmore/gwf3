<?php
final class GWF_Doctype
{
	private static $_Doctype = NULL;
	public static function getDoctype() { 
		if(self::$_Doctype === NULL) {
			self::setDoctype(GWF_DEFAULT_DOCTYPE);
		}	
		return self::$_Doctype; 
	}
	public static function setDoctype($doctype) {
	
		switch($doctype) {
			case 'html4' : self::$_Doctype = self::html4(); break;
			case 'html4strict' : self::$_Doctype = self::html4strict(); break;
			case 'html5' : self::$_Doctype = self::html5(); break;
			case 'xhtml' : self::$_Doctype = self::xhtml(); break;
			case 'xhtmlstrict' : self::$_Doctype = self::xhtmlstrict(); break;
		}
		return true;
	}
	
	public static function html4()
	{
		return 
			'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"'.PHP_EOL.
			'"http://www.w3.org/TR/html4/loose.dtd">'.PHP_EOL;
	}

	public static function html4strict()
	{
		return
			'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"'.PHP_EOL.
			'"http://www.w3.org/TR/html4/strict.dtd">'.PHP_EOL;
	}

	public static function xhtml()
	{
		return
			'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"'.PHP_EOL.
			'"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'.PHP_EOL;
	}

	public static function xhtmlstrict()
	{
		return
			'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"'.PHP_EOL.
			'"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'.PHP_EOL;
	}

	public static function html5()
	{
		return '<!DOCTYPE html>'.PHP_EOL;
	}
}
?>