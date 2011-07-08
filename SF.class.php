<?php
require_once 'gwf3.class.php';

/**
 * This is the SpaceFramework::init.
 * It's the API to communicate with all SF-Classes.
 * @author SpaceOne
 * @copyright Florian Best
 * @version 1.02
 * @since 10.05.2011
 * @visit www.florianbest.de
 * @license none
 */
final class SF extends GWF3 {
	
	private static $_Lang = NULL, $_layoutcolor = array(), $_formaction = array();
	
	public function __construct($basepath, array $config = array()) {
		parent::__construct($basepath, $config);
		if(!isset($_GET['mo'])) $_GET['mo'] = GWF_DEFAULT_MODULE;
		if(!isset($_GET['me'])) $_GET['me'] = GWF_DEFAULT_METHOD;
		self::$_Lang = new GWF_LangTrans('lang/SF/SF');
		$this->addMainTvars(array('SF' => $this));
	}

	public function sendHeader($header) { return header($header) ? true : false; }
	public function redirect($header) { return $this->sendHeader('Location: '.$header); }
	
	############
	## CONFIG ##
	############
	public function cfgdefaultColor() { return GWF_SF_DEFAULT_COLOR; }
	public function cfgCookieTime() { return time()+60*60*24*30; }
	public function cfgLayoutcolor($lc) { return GWF_SF_Utils::save_guest_setting('layoutcolor', $lc, $this->cfgdefaultColor(), $this->cfgCookieTime()); }

	# nothing to worry about
	public function onIncludeBeef() { return GWF_Website::addJavascript('inc3p/beef/hook/beefmagic.js.php'); }
	public function getWelcomeComment() { 
		if(true === self::getUser()->isWebspider()) {
			return '<!--Hi '.htmlspecialchars(self::getUser()->displayUsername()).'-->'; 
		} elseif(true === self::getUser()->isAdmin()) {
			return '<!-- Welcome Back Admin! -->';
		}
		return "<!--Can you see the sourcecode? Great! -->\0\n";
	}

	############
	## SET UP ##
	############
	public function setLayout($layout) { define('GWF_SF_LAYOUT', $layout); }
	public function setDesign($design) { define('GWF_SF_DESIGN', $design); }
	public function setLayoutColor(array $lc) { self::$_layoutcolor = $lc[$this->cfgLayoutcolor($lc)]; }
	public function setDoctype($doctype) { return GWF_Doctype::setDoctype($doctype);}
	public function setMeta($meta) { return GWF_Website::addMetaA($meta); }
	public function setFormActions(array $fa) { self::$_formaction = $fa; }
	public function setLayoutCSS($css) { return GWF_Website::addCSSA($css, '/templates/'.$this->getDesign().'/'.$this->getLayout().'/', '.css'); }
	public function setDesignCSS($css) { return GWF_Website::addCSSA($css, '/templates/'.$this->getDesign().'/css/', '.css'); }
	public function setPageTitlePre($title) { return GWF_Website::setPageTitlePre($title); }
	public function setPageTitle($title) { return GWF_Website::setPageTitle($title); }
	public function setPageTitleAfter($title) { return GWF_Website::setPageTitleAfter($title); }
	public function addMainTvars(array $tVars) { return GWF_Template::addMainTvars($tVars); }

	#############
	## GETTING ## // functions for Smarty
	#############
	public function isDisplayed($key) { 
		switch($key) {
			case 'navileft': return $this->is_navi_displayed('navileft');
			case 'naviright': return $this->is_navi_displayed('naviright');
			case 'details': return $this->is_details_displayed();
			case 'shell': return $this->is_shell_displayed();
			case 'base': return $this->is_base_displayed();
		}
	}
	public function lang($key, $args=NULL) { return self::$_Lang->lang($key, $args); }
	public function langA($var, $key, $args=NULL) { return self::$_Lang->langA($var, $key, $args); }
	public function displayNavi($side) { return SF_Navigation::display_navigation($side); }
	public function getGreeting() { return GWF_SF_Utils::greeting(); }
	public function getMoMe($mome)
	{
		$class = $_GET['mo'].'_'.$_GET['me'];
		return $class === $mome;
	}
	public function getIndex($except = '') {
		
		$back = GWF_WEB_ROOT.'index.php?';
		foreach($_GET as $k => $v) {
			if(is_array($except)) {
				foreach ($except as $trash => $exc) {
					if($exc != $k) {
						$back .= htmlspecialchars($k).'='.htmlspecialchars($v).'&amp;';
					}
				}
			} else {
				if($except != $k) {
					$back .= htmlspecialchars($k).'='.htmlspecialchars($v).'&amp;';
				}
			}
			
		}
		return $back;
	}
	public function getLayoutcolor($key = 'base_color') { return self::$_layoutcolor[$key]; }
	public function getServerName() { return $_SERVER['SERVER_NAME']; }
	public function getPath() { return htmlspecialchars($_SERVER['REQUEST_URI']); }
	public function getDesign() { return defined('GWF_SF_DESIGN') ? GWF_SF_DESIGN : GWF_SF_DEFAULT_DESIGN; }
	public function getLayout() { return defined('GWF_SF_LAYOUT') ? GWF_SF_LAYOUT : GWF_SF_DEFAULT_LAYOUT; }
	public function getFormaction($key) { return self::$_formaction[$key]; }
	public function getLastURL() { return GWF_Session::getLastURL(); }
	public function getDayinfos() {
		$lang = self::$_Lang;
		$args = array( $lang->langA('daynames', date('w')), date('w'), $lang->langA('monthnames', date('n')), date('n'), date('Y'));
		return $lang->lang('today_is_the', $args);
	}

	public function is_details_displayed() { return true === self::getUser()->isAdmin(); }
	public function is_shell_displayed() { return !$this->getMoMe('SF_Shell'); }
	public function is_base_displayed() { return ($this->getMoMe('Fancy_head') || $_GET['me'] == 'Challenge') ? false : true; }
	public function is_navi_displayed($navi) {
		$mods = array('SF', 'PageBuilder', 'GWF', GWF_DEFAULT_MODULE);
		switch(GWF_SF_Utils::save_guest_setting($navi, array('hidden' => true, 'shown' => true), 'default', $this->cfgCookieTime())) {
			case 'shown' : return true;
			case 'hidden': return false;
			default: 
				if(!in_array(Common::getGet('mo', GWF_DEFAULT_MODULE), $mods)) {
					return false;
				} else return (true === self::getUser()->isAdmin());
		}
	}
	
	public function getColorCSS() {
		
		$tVars = array(
			'tpl' => array('layout' => $this->getLayout(), 'design' => $this->getDesign().'/'),
			'color' => array(
				'border_light' => $this->getLayoutcolor('border_light'),
				'border_dark' => $this->getLayoutcolor('border_dark'),
				'design_dark' => $this->getLayoutcolor('design_dark'),
				'design_light' => $this->getLayoutcolor('design_light'),
				'base_color' => $this->getLayoutcolor('base_color'),
			)
		);
		return $tVars;
	}
	
	public function getIP($cmp = NULL) { return $cmp == NULL ? GWF_SF_SurferInfos::get_ipaddress() : $cmp === GWF_SF_SurferInfos::get_ipaddress(); }
	public function getOS($type = 1,$cmp = NULL) { return GWF_SF_SurferInfos::get_operatingsystem($type, $cmp); }
	public function getBrowser($type = 1,$cmp = NULL) { return GWF_SF_SurferInfos::get_browser($type, $cmp); }
	public function getProvider($type = 1,$cmp = NULL) { return GWF_SF_SurferInfos::get_provider($type, $cmp); }
	public function getCountry($cmp = NULL, $id = false) { 
		#$countryid = GWF_IP2Country::detectCountryID();
	#	$country = GWF_Country::getByID($countryid);
	#	$noimg = $cmp == NULL ? htmlspecialchars($country) : $cmp === htmlspecialchars($country);
	#	return true === $id ? $countryid : $noimg;
	}
	public function getHostname() { return GWF_SF_SurferInfos::get_hostname(); }
	public function getReferer() { return GWF_SF_SurferInfos::get_referer(); }
	public function getUserAgent() { return GWF_SF_SurferInfos::get_useragent(); }
	public function imgBrowser() { 
		return sprintf('<img src="'.GWF_WEB_ROOT.'img/SF/Browser/16x16/%s.png" title="%s" alt="%s">',$this->getBrowser(2),$this->getBrowser(),$this->getBrowser()); 
	}
	public function imgOS() { 
		return sprintf('<img height="16px" src="'.GWF_WEB_ROOT.'img/SF/OS/%s.png" title="%s" alt="%s">',$this->getOS(2),$this->getOS(),$this->getOS()); 
	}
	public function imgProvider() { 
		return sprintf('<img height="16px" src="'.GWF_WEB_ROOT.'img/SF/Provider/%s.png" title="%s" alt="%s">',$this->getProvider(2),$this->getProvider(),$this->getProvider()); 
	}
	public function imgCountry() { 
		#return sprintf('<img src="%s" width="24" height="24" title="%s" alt="%s"/>', GWF_WEB_ROOT.'img/country/'.$this->getCountry(NULL, true), $this->getCountry(), $this->getCountry()).PHP_EOL; 
	}
	public function gwf_error_404_mail($body = 'The page %s threw a 404 error.')
	{
		$blacklist = array();
		$pagename = $_SERVER['REQUEST_URI'];
		if (in_array($pagename, $blacklist, true)) {
			return;
		}
		$mail = new GWF_Mail();
		$mail->setSender(GWF_BOT_EMAIL);
		$mail->setReceiver(GWF_ADMIN_EMAIL);
		$mail->setSubject(GWF_SITENAME.': 404 Error');
		$mail->setBody(sprintf($body, $pagename));
		$mail->sendAsText();
		return (GWF_DEBUG_EMAIL & 16) ? $mail : $this;
	}
}