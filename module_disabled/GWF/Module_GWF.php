<?php
/**
 * Main Website Stuff. We can also trigger core updates here. 
 * @author gizmore
 */
final class Module_GWF extends GWF_Module
{
	private static $instance;
	private static $pagecount = 0;
	
	/**
	 * @return Module_GWF
	 */
	public static function instance() { return self::$instance; }
	
	##################
	### GWF_Module ###
	##################
	public function getVersion() { return 1.07; }
	public function onInstall($dropTable) { require_once 'GWF_Install.php'; GWF_Install::onInstall($this, $dropTable); }
	public function getAdminSectionURL() { return $this->getMethodURL('Options'); }
//	public function getClasses() { return array('GWF_Pageview'); }
	public function onLoadLanguage() { return $this->loadLanguage('lang/gwf'); }
	public function getDefaultAutoLoad() { return true; }
	public function getDefaultPriority() { return 3; }
	
	##############
	### Config ###
	##############
	public function cfgPagecount() { return self::$pagecount; }
	public function cfgPagecountEnabled() { return $this->getModuleVar('pagecount_on', 0); }
//	public function cfgJavascriptCheck() { return $this->getModuleVar('js_check', true); }
//	public function cfgFallbackSessions() { return $this->getModuleVar('fallback_sess', 1) > 0; }
	public function cfgUserrecordEnabled() { return $this->getModuleVar('userrec', true); }
	public function cfgUserrecordCount() { return (int) $this->getModuleVar('userrecc', 0); }
	public function cfgUserrecordDate() { return GWF_Time::displayDate($this->getModuleVar('userrecd', '00000000000000')); }
	
	###############
	### Startup ###
	###############
	public function onStartup()
	{
//		var_dump('GWF::onStartup()');
		self::$instance = $this;
		
		if ($this->isAjax()) {
			return;
		}
		
//		if ($this->cfgRobotUsers()) {
//			$this->onRobotUsers();
//		}
		
		if ($this->cfgPagecountEnabled())
		{
			$this->increasePageView();
		}
		
		if ($this->cfgUserrecordEnabled())
		{
			$this->checkUserRecord();
		}

		if (false !== ($user = GWF_Session::getUser()))
		{
			$user->saveVar('user_lastactivity', time());
		}

//		GWF_Website::addJavascript(GWF_WEB_ROOT.'js/gwf3.js?v=1');
//		GWF_Website::addJavascript(GWF_WEB_ROOT.'js/jquery-1.4.2.min.js');
		
//		$is_bot = GWF_Browser::isBot();
//		if ($is_bot) {s()
//	{
//
//			return; # have fun;
//		}
//		
//		GWF_Website::addJavascript(GWF_WEB_ROOT.'js/gwf_core.js?v=2');
//		
//		if (!GWF_Session::haveCookies())
//		{
//			if ($this->isMethodSelected('CookieCheck')) {
//				return; # we are running cookie check
//			}
//
//			$current_url = GWF_Session::getLastURL();
//			$level1_url = GWF_WEB_ROOT.'index.php?mo=GWF&me=CookieCheck&level=1&url='.urlencode($current_url);
//			
//			if ($this->cfgJavascriptCheck())
//			{
//				GWF_Website::addJavascriptInline($this->getDetectScript($current_url)); # redirect with js
////				GWF_Website::redirectMeta($level1_url, 1);
//			}
//			else
//			{
//				GWF_Website::redirect($level1_url);
//			}
//			
//			return GWF_HTML::message('Startup', 'Initiating your Session...', false);
//		}
//		elseif (false !== ($user = GWF_Session::getUser()))
//		{
//			$user->saveVar('user_lastactivity', time());
//		}
	}
	
	private function increasePageView($by=1)
	{
//		require_once 'GWF_Pageview.php';
//		GWF_Pageview::increaseTodayView($by);
		self::$pagecount = GWF_Counter::getAndCount('pagecount', $by);
//		$this->saveModuleVar('pagecount', $this->cfgPagecount()+$by);
	}

//	private function getDetectScript($url)
//	{
//		$url = GWF_WEB_ROOT.'index.php?mo=GWF&me=JSEnabled&url='.$url.'&w=\'+screen.width+\'&h=\'+screen.height+\'';
//		return sprintf('window.location = \'%s\'; ', $url);
//	}
	
	private function checkUserRecord()
	{
		$count = GWF_Session::getOnlineCount(true);
		$old = $this->cfgUserrecordCount();
		if ($count > $old)
		{
			$this->saveModuleVar('userrecc', $count);
			$this->saveModuleVar('userrecd', GWF_Time::getDate(GWF_Date::LEN_SECOND));
		}
	}
	
	
	/**
	 * Show SEO lang anchors. Type may be 1 for native name, 2 for english name, 3 for ISO
	 * @param int $type
	 * @param string $connector
	 * @return string
	 */
//	public static function SEOLangAnchors($type=1, $connector='')
//	{
//		$back = '';
//		$langs = GWF_Language::getSupportedLanguages();
//		foreach ($langs as $lang)
//		{
//			$lang instanceof GWF_Language;
//			$iso = $lang->getISO();
//			$domain = GWF_DOMAIN;
//			$url = htmlspecialchars($_SERVER['REQUEST_URI']);
//			$href = sprintf('%s://%s.%s%s', Common::getProtocol(), $iso, $domain, $url);
//			$class = GWF_Language::getCurrentID() === $lang->getID() ? 'sel' : '';
//			$back .= $connector;
//			$back .= GWF_HTML::anchor($href, self::getSEOAnchorText($type, $lang), $class);
//		}
//		return substr($back, strlen($connector));
//	}
//
//	private static function getSEOAnchorText($type, GWF_Language $lang)
//	{
//		switch ($type)
//		{
//			case 1: return $lang->displayName();
//			case 2: return $lang->displayName();
//			case 3: return strtoupper($lang->getISO());
//			default: die('Module_GWF::getSEOAnchorText(): Unknown Type.');
//		}
//	}

	### Robots
	/**
	 * Emulate known Robots as users, make them appear in online list and don't consume sessions.
	 * Enter description here ...
	 */
//	private function onRobotUsers()
//	{
//	}
}

?>
