<?php
final class GWF_Website
{
	############
	### Init ###
	############
	public static function init($server_root)
	{
		header('Content-Type: text/html; charset=UTF-8');
		if (!GWF_Session::start()) { return false; } # Not installed
		GWF_Language::init();
		GWF_HTML::init();
		GWF_Debug::setBasedir($server_root);
		$user = GWF_Session::getUser();
		$username = $user === false ? false : $user->getVar('user_name');
		GWF_Log::init($username, true, $server_root.'/protected/logs');
	}
	
	#################
	### Birthdate ###
	#################
	public static function getBirthdate() { return GWF_Settings::getSetting('gwf_site_birthdate', date('Ymd')); }
	
	######################
	### Default Output ###
	######################
	private static $OUTPUT = '';
	public static function addDefaultOutput($html) { self::$OUTPUT .= $html; }
	public static function getDefaultOutput() { return self::$OUTPUT; }
	
	##################
	### Page Title ###
	##################
	private static $PAGE_TITLE = GWF_SITENAME;
	public static function setPageTitle($text) { self::$PAGE_TITLE = $text; }
	private static $PAGE_TITLE_PRE = '';
	public static function setPageTitlePre($text) { self::$PAGE_TITLE_PRE = $text; }
	private static $PAGE_TITLE_AFTER = '';
	public static function setPageTitleAfter($text) { self::$PAGE_TITLE_AFTER = $text; }
	public static function displayPageTitle() { return htmlspecialchars(self::$PAGE_TITLE_PRE.self::$PAGE_TITLE.self::$PAGE_TITLE_AFTER); }
	
	#################
	### Meta Tags ###
	#################
	private static $META_TAGS;
	public static function setMetaTags($s)
	{
		self::$META_TAGS = $s;
	}
	public static function addMetaTags($s)
	{
		self::$META_TAGS .= $s;
	}
	
	##################
	### Meta Descr ###
	##################
	private static $META_DESCR;
	public static function setMetaDescr($s)
	{
		self::$META_DESCR = $s;
	}
	
	public static function addMetaDescr($s)
	{
		self::$META_DESCR .= $s;
	}
	
	#################
	### Redirects ###
	#################
//	public static function redirectHome() { self::redirect(GWF_WEB_ROOT.GWF_DEFAULT_URL); }
//	public static function redirectMeta($url, $seconds) { header(sprintf('refresh: %d;url=%s', $seconds, $url)); }
	public static function redirect($url) { header(sprintf('Location: %s', $url)); }
//	public static function redirectBack()
//	{
//		if (false === ($url = GWF_Session::getLastURL())) {
//			$url = GWF_WEB_ROOT.GWF_DEFAULT_URL;
//		}
//		self::redirect($url);
//	}

	#############
	### Feeds ###
	#############
	private static $FEEDS = array();
	public static function addFeed($url, $title)
	{
		self::$FEEDS[] = func_get_args();
	}
	
	public static function displayFeeds()
	{
		$back = '';
		foreach (self::$FEEDS as $data)
		{
			list($href, $title) = array_map('htmlspecialchars', $data);
			$back .= sprintf('<link rel="alternate" type="application/rss+xml" title="%s" href="%s" />', $title, $href);
		}
		return $back;
	}

	####################
	### Display Page ###
	####################
	public static function displayPage($page, $timings)
	{
//		if (false === ($user = GWF_Session::getUser())) {
//			$user = GWF_Guest::getGuest();
//		}
//		
		$tVars = array(
//			'user' => $user,
			'head' => self::getHTMLHead(),
			'body' => self::getHTMLBody($page, $timings),
		);
		
		return GWF_Template::templateMain('html.tpl', $tVars);
	}
	
	public static function getHTMLHead()
	{
		$tVars = array(
			'page_title' => self::displayPageTitle(),
			'language' => GWF_Language::getCurrentISO(),
			'meta_tags' => self::$META_TAGS,
			'meta_descr' => self::$META_DESCR,
			'favicon' => GWF_WEB_ROOT.'favicon.ico',
			'feeds' => self::displayFeeds(),
			'root' => GWF_WEB_ROOT,
			'js' => self::displayJavascripts(),
			'css' => self::displayCSS(),
		);
		return GWF_Template::templateMain('html_head.tpl', $tVars);
	}
	
	public static function getHTMLBody($page, $timings)
	{
		$tVars = array(
			'page' => $page,
			'timings' => $timings,
			'user' => GWF_User::getStaticOrGuest(),
		);
		return GWF_Template::templateMain('html_body.tpl', $tVars);
	}
	
	###########
	### CSS ###
	###########
	private static $CSS = array();
	public static function addCSS($path)
	{
		if (in_array($path, self::$CSS, true)) {
			return true;
		}
		self::$CSS[] = $path;
		return true;
	}

	public static function displayCSS($html = false)
	{
		$back = '';
		$xhtml = ($html ? '>' : ' />');
		foreach (self::$CSS as $file)
		{
			$back .= sprintf('<link rel="stylesheet" type="text/css" href="%s"' . $html, $file);
		}
		return $back;
	}

	##################
	### Javascript ###
	##################
	private static $javascripts = array();
	public static function addJavascript($path)
	{
		if (in_array($path, self::$javascripts, true)) {
			return true;
		}
		self::$javascripts[] = $path;
		return true;
	}

	public static function displayJavascripts()
	{
		$back = '';
		foreach (self::$javascripts as $js)
		{
			$back .= sprintf('<script type="text/javascript" src="%s"></script>', htmlspecialchars($js));
		}
		return $back.self::displayJavascriptInline();
	}
	
	private static $javascript_inline = '';
	public static function addJavascriptInline($script_html)
	{
		self::$javascript_inline .= $script_html;
	}
	public static function displayJavascriptInline()
	{
		$inline_defines = sprintf('var GWF_WEB_ROOT = \'%s\'; var GWF_DOMAIN = \'%s\';'.PHP_EOL, GWF_WEB_ROOT, GWF_DOMAIN);
		return sprintf('<script type="text/javascript">%s</script>', $inline_defines.self::$javascript_inline);
	}
	
	public static function includeJQuery()
	{
		self::addJavascript(GWF_WEB_ROOT.'js/jquery-1.4.2.min.js');
	}
	
}
?>
