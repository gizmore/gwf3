<?php
final class GWF_Doctype
{
	const HTML4 = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\"\n\"http://www.w3.org/TR/html4/loose.dtd\">\n";
	const HTML4STRICT = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01//EN\"\n\"http://www.w3.org/TR/html4/strict.dtd\">\n";
	const HTML5 = "<!DOCTYPE html>\n";
	const XHTML = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"\n\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
	const XHTMLSTRICT = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"\n\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n";

	private static $_Doctype = NULL;
	public static function getDoctype() { 
		if(self::$_Doctype === NULL) {
			self::setDoctype(GWF_DEFAULT_DOCTYPE);
		}	
		return self::$_Doctype; 
	}
	public static function setDoctype($doctype) {
	
		switch($doctype) {
			case 'html4' : self::$_Doctype = self::HTML4; break;
			case 'html4strict' : self::$_Doctype = self::HTML4STRICT; break;
			case 'html5' : self::$_Doctype = self::HTML5; break;
			case 'xhtml' : self::$_Doctype = self::XHTML; break;
			case 'xhtmlstrict' : self::$_Doctype = self::XHTMLSTRICT; break;
		}
		return true;
	}
}

?>