<?php

final class Module_PoolTool extends GWF_Module
{
	private static $instance;
	/**
	 * @return Module_PoolTool
	 */
	public static function getInstance() { return self::$instance; }
	
	##################
	### GWF_Module ###
	##################
	public function getPrice() { return 3123123123.666; }
	public function onLoadLanguage() { return $this->loadLanguage('lang/pt'); }
	public function getClasses() { return array('PT_IP'); }
	public function getDefaultAutoLoad() { return true; }
	public function onStartup()
	{
		require_once 'PT.php';
		require_once 'PT_Menu.php';
		self::$instance = $this;
		$this->onLoadLanguage();
//		GWF_Website::setPageTitlePre('PoolTool');
		GWF_Website::setMetaTags($this->lang('mt_about'));
		GWF_Website::setMetaDescr($this->lang('md_about'));
	}
	public function onInstall($dropTable)
	{
		return GWF_ModuleLoader::installVars($this, array(
			'ptmpw' => array('TheChosenPass', 'text', '0', '32'),
		));
	}
	public function cfgPass() { return $this->getModuleVar('ptmpw', 'TheChosenPass'); }
}

?>