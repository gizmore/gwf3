<?php
final class GWF_Doctype
{
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
		return '<!DOCTYPE html>';
	}
}
?>