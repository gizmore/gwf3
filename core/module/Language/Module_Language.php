<?php
final class Module_Language extends GWF_Module
{
	public function getVersion() { return 1.02; }
	public function getAdminSectionURL() { return $this->getMethodURL('EditFiles'); }
//	public function getDefaultPriority() { return 1; }
//	public function getDefaultAutoLoad() { return true; }
	public function getClasses() { return array('GWF_LangFile'); }
	public function onLoadLanguage() { return $this->loadLanguage('lang/lang'); }
	public function onInstall($dropTable)
	{
		require_once 'InstallLanguages.php';
		return InstallLanguages::onInstall($this, $dropTable);
	}
	
	public function setLanguage($iso)
	{
		if (false === ($lang = GWF_Language::getByISO($iso))) {
			return false;
		}
		GWF_Language::setCurrentLanguage($lang);
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
