<?php
/**
 * 
 * @author spaceone
 * @author gizmore
 */
final class GWF_PB_Rewrites
{
	/**
	 *
	 * @author gizmore
	 * @param type $url
	 * @return type 
	 */
	public static function replaceRewriteURL($url)
	{
		$search = array(   '.',   '*',   '[',   ']',   '?',   '+',   '{',   '}',   '^',   '$');
		$replace = array('\\.', '\\*', '\\[', '\\]', '\\?', '\\+', '\\{', '\\}', '\\^', '\\$');
		return str_replace($search, $replace, $url);
	}

	/**
	 * Tests if the URL exists
	 * @param string $url
	 * @return boolean true if rewriterule matches
	 * @author spaceone
	 */
	public static function matchURL($url)
	{
		$url = self::replaceRewriteURL($url);
		if (false === ($htaccess = self::getHTAccess()))
		{
			return false;
		}

		return 1 === preg_match('#RewriteRule \^'.$url.'(?:/|\$)#', $htaccess); #TODO
	}

	public static function getHTAccess()
	{
		if(false === Common::isFile(GWF_WWW_PATH.'.htaccess'))
		{
			GWF_HTML::error('ERR_FILE_NOT_FOUND', array(GWF_WWW_PATH.'.htaccess')); # TODO
			return false;
		}
		return file_get_contents(GWF_WWW_PATH.'.htaccess');
	}

	/**
	 * Match the whole .htaccess file for RewriteRules
	 * Maybe needet later
	 */
	public static function matchURLs()
	{
//		return preg_match_all('RewriteRule \^(a-z)/.*?$'); #TODO
	}
}
