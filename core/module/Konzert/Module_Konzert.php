<?php
final class Module_Konzert extends GWF_Module
{
	public function getVersion() { return 1.00; }
	
	public function onInstall($dropTable) { require_once 'Konzert_Install.php'; return Konzert_Install::onInstall($this, $dropTable); }

	public function getClasses() { return array('Konzert_Termin'); }
	
	public function onLoadLanguage() { return $this->loadLanguage('lang/konzert'); }
	
	public function getDefaultAutoLoad() { return true; }
	
	public function getAdminSectionURL() { return $this->getMethodURL('AdminTermine'); }
	
	public function onStartup()
	{
		$this->onLoadLanguage();
		GWF_Website::addJavascript(GWF_WEB_ROOT.'tpl/konz/js/konzert.js?v=5');
		GWF_Website::addJavascriptOnload('initKonzert();');
		GWF_Website::setMetaTags($this->lang('meta_tags'));
		GWF_Website::setMetaDescr($this->lang('meta_descr'));
	}
	
	private $href_next = '';
	
	public function getNextPageLink()
	{
		if ($this->href_next === '')
		{
			return '';
		}
		return sprintf('<div id="next_page"><a href="%s">%s</a></div>', $this->href_next, $this->lang('more'));
	}
	
	public function setNextHREF($href)
	{
		$this->href_next = $href;
	}
}
?>