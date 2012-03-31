<?php
/**
 * possible doctypes
 * @author spaceone
 */
final class GWF_Doctype
{
	const HTML4 = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\"\n\"http://www.w3.org/TR/html4/loose.dtd\">\n";
	const HTML4STRICT = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01//EN\"\n\"http://www.w3.org/TR/html4/strict.dtd\">\n";
	const HTML5 = "<!DOCTYPE html>\n";
	const XHTML = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"\n\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
	const XHTMLSTRICT = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"\n\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n";

	public static function getDoctype($doctype)
	{
		switch($doctype)
		{
			case 'html4' : return self::HTML4; break;
			case 'html4strict' : return self::HTML4STRICT; break;
			case 'html5' : return self::HTML5; break;
			case 'xhtml' : return self::XHTML; break;
			case 'xhtmlstrict' : return self::XHTMLSTRICT; break;
			default: return self::HTML5; break;
		}
	}
}


