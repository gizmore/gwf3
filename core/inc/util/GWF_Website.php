<?php
/**
 * 
 * @author spaceone, gizmore
 */
final class GWF_Website
{
	private static $_page_title = GWF_SITENAME;
	private static $_page_title_pre = '';
	private static $_page_title_post = '';

	private static $_feeds = array();
	private static $_meta = array();
	private static $_css = array();

	private static $_inline_css = '';
	private static $_output = '';
	private static $xhtml = "/>\n\t";

	private static $_javascripts = array();
	private static $_javascript_inline = '';
	private static $_javascript_onload = '';

	public static function init()
	{
		if(isset($_GET['plain']))
		{
			self::plaintext();
		}
		else
		{
			header('Content-Type: text/html; charset=UTF-8');
		}
		GWF_Language::init();
		GWF_HTML::init();

		self::$xhtml = (self::isHTML() ? '>' : ' />') . "\n\t";
	}

	public static function plaintext() { header('Content-Type: text/plain; charset=UTF-8'); }
	public static function isHTML() { return false === strpos(GWF_DEFAULT_DOCTYPE, 'xhtml'); }
	public static function getBirthdate() { return GWF_Settings::getSetting('gwf_site_birthdate', date('Ymd')); } //TODO: move to other file

	public static function redirect($url) { header('Location: ' . $url); }
	public static function redirectMeta($url, $seconds) { header(sprintf('refresh: %d; url=%s', $seconds, $url)); }
	public static function redirectBack()
	{
		if (false === ($url = GWF_Session::getLastURL()))
		{
			$url = GWF_WEB_ROOT.GWF_DEFAULT_URL; //@deprecated
		}
		else
		{
			$url = GWF_WEB_ROOT.ltrim($url, '/');
		}
		self::redirect($url);
	}

	public static function addDefaultOutput($html) { self::$_output .= $html; }
	public static function addJavascriptInline($script_html) { self::$_javascript_inline .= $script_html;} # Raw JavaScript
	public static function addJavascriptOnload($script_html) { self::$_javascript_onload .= $script_html; }
	public static function addInlineCSS($css) { self::$_inline_css .= $css; }
	public static function addMetaDescr($s) { self::$_meta_descr['description'] .= $s; }
	public static function addMetaTags($s) { self::$_meta_tags['keywords'] .= $s; }
	public static function addFeed($url, $title) { self::$_feeds[] = func_get_args(); }

	public static function setMetaTags($s) { self::$_meta_tags['keywords'] = $s; }
	public static function setMetaDescr($s) { self::$_meta_descr['description'] = $s; }
	public static function setPageTitle($title) { self::$_page_title = $title; }
	public static function setPageTitlePre($title) { self::$_page_title_pre = $title; }
	public static function setPageTitleAfter($title) { self::$_page_title_post = $title; }

	public static function addMetaA(array $metaA)
	{
		foreach($metaA as $meta)
		{
			self::addMeta($meta);
		}
	}
	public static function addCSSA(array $paths, $pre='', $after='')
	{
		foreach($paths as $path)
		{
			self::addCSS($pre.$path.$after);
		}
	}

	/**
	 * @param $meta = array($name, $content, $http-equiv(?));
	 * @param $overwrite overwrite key if exist?
	 * @return boolean false if metakey was not overwritten, otherwise true
	 * @todo possible without key but same functionality?
	 */
	public static function addMeta(array $meta, $overwrite=false)
	{
		if((false === $overwrite) && (isset(self::$_meta[$meta[0]]) === true))
		{
			return false;
		}
		self::$_meta[$meta[0]] = $meta;
		return true;
	}

	public static function addCSS($path, $rel='stylesheet', $media=false)
	{
		if (is_array($path)) {
			if (in_array($path, self::$_css, true)) { 
				return; 
			}
			self::$_css[] = $path;
		} else {
			if (in_array(array($path, $rel, $media), self::$_css, true)) {
				return;
			}
			self::$_css[] = array($path, $rel, $media);
		}
	}

	public static function addJavascript($path)
	{
		if (false === in_array($path, self::$_javascripts, true))
		{
			self::$_javascripts[] = $path;
		}
	}

	public static function getDefaultOutput() { return self::$_output; }
	public static function displayPageTitle() { return htmlspecialchars(self::$_page_title_pre.self::$_page_title.self::$_page_title_post); }
	
	public static function displayMETA()
	{
		$back = '';
		foreach (self::$_meta as $meta)
		{
			$eq = ($meta[2] ? 'http-equiv' : 'name');
			$back .= sprintf('<meta %s="%s" content="%s"%s', $eq, $meta[0], $meta[1], self::$xhtml);
		}
		return $back;
	}

	public static function displayCSS()
	{
		$back = '';
		foreach (self::$_css as $css)
		{
			$back .= sprintf('<link rel="%s" type="text/css" href="%s"%s', $css[1], $css[0], self::$xhtml);
		}
		if('' !== self::$_inline_css)
		{
			$back .= sprintf("\n\t<style><!--\n\t%s\n\t--></style>", self::$_inline_css);
		}
		return $back;
	}

	public static function displayJavascripts()
	{
		$back = '';
		foreach (self::$_javascripts as $js)
		{
			$back .= sprintf('<script type="text/javascript" src="%s"></script>', htmlspecialchars($js));
		}
		return $back.self::displayJavascriptInline();
	}
	
	### Raw javascript ###
	public static function displayJavascriptInline()
	{
		$inline_defines = sprintf('var GWF_WEB_ROOT = \'%s\'; var GWF_DOMAIN = \'%s\';'.PHP_EOL, GWF_WEB_ROOT, GWF_DOMAIN);
		return sprintf('<script type="text/javascript">%s</script>', $inline_defines.self::$_javascript_inline.self::displayJavascriptOnload());
	}

	### JQuery onload ###
	private static function displayJavascriptOnload()
	{
		return self::$_javascript_onload ? sprintf('; $(document).ready(function(){ %s; });', self::$_javascript_onload) : '';
	}

	public static function displayFeeds()
	{
		$back = '';
		foreach (self::$_feeds as $data)
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
			'meta' => self::displayMETA(),
			'favicon' => GWF_WEB_ROOT.'favicon.ico',
			'feeds' => self::displayFeeds(),
			'root' => GWF_WEB_ROOT,
			'js' => self::displayJavascripts(),
			'css' => self::displayCSS(),
		);
		GWF_Template::addMainTvars(array('errors' => GWF_HTML::displayErrors(), 'messages' => GWF_HTML::displayMessages()));
		
		return GWF_Doctype::getDoctype() . GWF_Template::templateMain('html_head.tpl', $tVars) . PHP_EOL;
	}
	
	public static function getHTMLbody_head($path='tpl/%DESIGN%/', $tVars=NULL)
	{
		return GWF_Template::templateMain('html_body.tpl', $tVars);
	}
	
	public static function getHTMLbody_foot($path='tpl/%DESIGN%/', $tVars=array())
	{
		return GWF_Template::templateMain('html_foot.tpl', $tVars);
	}
	
	public static function getPagehead($path='tpl/%DESIGN%/')
	{
		return self::getHTMLHead() . self::getHTMLbody_head($path);
	}
	
	public static function getHTMLBody($page, $path='tpl/%DESIGN%/')
	{
		return self::getHTMLbody_head($path) . $page . self::getHTMLbody_foot($path);
	}
	
	public static function displayPage($page)
	{
		return self::getHTMLHead() . self::getHTMLBody($page) . PHP_EOL.'</html>';
	}
}
?>
