<?php
final class GWF_Website
{
	####################
	### Content-Type ###
	####################
	public static function plaintext() { header('Content-Type: text/plain'); }
	
	############
	### Init ###
	############
	public static function init($server_root, $blocking=true, $no_session=false)
	{
		header('Content-Type: text/html; charset=UTF-8');
		GWF_Language::init();
		$username = false;
		if (!$no_session)
		{
			if (!GWF_Session::start($blocking))
			{
				return false; # Not installed
			}
			if (false !== ($user = GWF_Session::getUser()))
			{
				$username = $user->getVar('user_name');
			}
		}
		GWF_Log::init($username, true, $server_root.'/protected/logs');
		GWF_HTML::init();
		GWF_Debug::setBasedir($server_root);
	}
	
	public static function isHTML() { return strpos(GWF_DEFAULT_DOCTYPE, 'xhtml') === false; }
	
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
	
	############
	### Meta ###
	############
	private static $META = array();
	/**
	 * @param $meta = array($name, $content, $equiv(?));
	 * @param $aggressive
	 */
	public static function addMeta(array $meta, $aggressive = false)
	{
		if (array_key_exists($meta[0], self::$META) && !$aggressive) {
			return true;
		}
		self::$META[$meta[0]] = $meta;
		return true;
	}
	public static function addMetaA(array $metas)
	{
		foreach($metas as $meta) {
			self::addMeta($meta);
		}
		return true;
	}
	public static function displayMETA($html = false)
	{
		$back = '';
		$xhtml = ($html ? '>' : ' />') . "\n\t";
		foreach (self::$META as $meta)
		{
			$eq = ($meta[2] ? 'http-equiv' : 'name');
			$back .= sprintf('<meta %s="%s" content="%s"%s', $eq, $meta[0], $meta[1], $xhtml);
		}
		return $back;
	}

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
	public static function displayMetaTags() {
		self::addMeta(array('keywords', self::$META_TAGS, false), true);
		return self::$META_TAGS;
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
	public static function displayMetaDescr() {
		self::addMeta(array('description', self::$META_DESCR, false), true);
		return self::$META_DESCR;
	}	
			
	###########
	### CSS ###
	###########
	private static $CSS = array();
	public static function addCSS($path, $rel = 'stylesheet', $media = false)
	{
		if (is_array($path)) {
			if (in_array($path, self::$CSS, true)) { 
				return true; 
			}
			self::$CSS[] = $path;
		} else {
			if (in_array(array($path, $rel, $media), self::$CSS, true)) {
				return true;
			}
			self::$CSS[] = array($path, $rel, $media);
		}
		return true;
	}
	public static function addCSSA(array $paths, $pre = '', $after = '')
	{
		foreach($paths as $path) {
			self::addCSS($pre.$path.$after);
		}
		return true;
	}
	public static function displayCSS($html = false)
	{
		$back = '';
		$xhtml = ($html ? '>' : ' />') . "\n\t";
		foreach (self::$CSS as $css)
		{
			$back .= sprintf('<link rel="%s" type="text/css" href="%s"%s',$css[1], $css[0], $xhtml);
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
	
	#################
	### Redirects ###
	#################
//	public static function redirectHome() { self::redirect(GWF_WEB_ROOT.GWF_DEFAULT_URL); }
//	public static function redirectMeta($url, $seconds) { header(sprintf('refresh: %d;url=%s', $seconds, $url)); }
	public static function redirect($url) { header(sprintf('Location: %s', $url)); }
	public static function redirectBack()
	{
		if (false === ($url = GWF_Session::getLastURL()))
		{
			$url = GWF_WEB_ROOT.GWF_DEFAULT_URL;
		}
		self::redirect($url);
	}

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

	public static function getHTMLHead()
	{
		$tVars = array(
			'page_title' => self::displayPageTitle(),
			'language' => GWF_Language::getCurrentISO(),
			'meta_tags' => self::displayMetaTags(),
			'meta_descr' => self::displayMetaDescr(),
			'meta' => self::displayMETA(self::isHTML()), // important: must be under displayMetaDescr/Tags
			'favicon' => GWF_WEB_ROOT.'favicon.ico',
			'feeds' => self::displayFeeds(),
			'root' => GWF_WEB_ROOT,
			'js' => self::displayJavascripts(),
			'css' => self::displayCSS(self::isHTML()),
		);
		GWF_Template::addMainTvars(array('errors' => GWF_HTML::displayErrors(), 'messages' => GWF_HTML::displayMessages()));
		
		return GWF_Doctype::getDoctype() . GWF_Template::templateMain('html_head.tpl', $tVars);
	}
	
	public static function getHTMLbody_head($path = 'tpl/%DESIGN%/', $tVars = NULL) {
		return GWF_Template::template($path.'html_body.tpl', $tVars);
	}
	
	public static function getHTMLbody_foot($path = 'tpl/%DESIGN%/') {
		$tVars = array(
			'timings' => GWF_DebugInfo::getTimings(),
		);
		return GWF_Template::template($path.'html_foot.tpl', $tVars);
	}
	public static function getPagehead($path = 'tpl/%DESIGN%/') {
		return self::getHTMLHead() . self::getHTMLbody_head($path);
	}
	
	public static function getHTMLBody($page, $path = 'tpl/%DESIGN%/')
	{
		return self::getHTMLbody_head($path) . $page . self::getHTMLbody_foot($path);
	}
	
	public static function displayPage($page)
	{
		return self::getHTMLHead() . self::getHTMLBody($page) . PHP_EOL.'</html>';
	}
}
?>
