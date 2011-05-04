<?php

final class Module_Language extends GWF_Module
{
	public function getVersion() { return 1.00; }
	public function getAdminSectionURL() { return $this->getMethodURL('EditFiles'); }
//	public function getDefaultPriority() { return 1; }
//	public function getDefaultAutoLoad() { return true; }
	public function getClasses() { return array('GWF_LangFile'); }
	public function onLoadLanguage() { return $this->loadLanguage('lang/lang'); }
	public function onInstall($dropTable)
	{
		require_once 'module/Language/InstallLanguages.php';
		return InstallLanguages::onInstall($this, $dropTable);
	}
//	public function cfgLangByDomain() { return $this->getModuleVar('lang_by_domain', true); }
	
	public function onStartup()
	{
//		if ($this->cfgLangByDomain())
//		{
//			$domain = $_SERVER['SERVER_NAME'];
//			$dot = substr($domain, 2, 1);
//			if ($dot === '.')
//			{
//				$iso = substr($domain, 0, 2);
//				$this->setLanguage($iso);
//			}
//		}
	}
	
	public function setLanguage($iso)
	{
		if (false === ($lang = GWF_Language::getByISOS($iso))) {
			return false;
		}
		GWF_Language::setBrowserLang($lang);
		return true;
	}
	
	public function getSwitchLangSelect()
	{
		$langs = GWF_Language::getSupportedLanguages();
		$data = array();
		foreach ($langs as $lang)
		{
			$data[] = array($lang->displayName(), $lang->getISO());
		}
		$current_iso = GWF_Language::getCurrentISO();
		$onchange = "window.location=GWF_WEB_ROOT+'lang-to-'+this.value;";
		return GWF_Select::display('switch_lang', $data, $current_iso, $onchange);
	}

	public static function getSwitchLangSelectDomain()
	{
		$langs = GWF_Language::getSupportedLanguages();
		$data = array();
		foreach ($langs as $lang)
		{
			$data[] = array($lang->displayName(), $lang->getISO());
		}
		$current_iso = GWF_Language::getCurrentISO();
		$domain = GWF_DOMAIN;
		$url = htmlspecialchars($_SERVER['REQUEST_URI']);
		$onchange = "window.location='http://'+this.value+'.$domain$url';";
		return GWF_Select::display('switch_lang', $data, $current_iso, $onchange);
	}
}

?>
