<?php
require_once 'BAIM.php';
//require_once 'BAIM_MC.php';

final class Module_BAIM extends GWF_Module
{
	private static $instance;
	/**
	 * @return Module_BAIM
	 */
	public static function getInstance() { return self::$instance; }

	##################
	### GWF_Module ###
	##################
	public function getClasses() { return array('BAIM_MC'); }
	public function getVersion() { return 1.00; }
	public function getDefaultAutoLoad() { return true; }
	public function onLoadLanguage() { return $this->loadLanguage('lang/baim'); }
	public function onInstall($dropTable) { require_once 'Baim_Install.php'; Baim_Install::onInstall($this, $dropTable); }
	public function getAdminSectionURL() { return $this->getMethodURL('Admin'); }
	public function onStartup()
	{
		self::$instance = $this;
		$this->onLoadLanguage();
		$this->onInclude();
		GWF_Website::addMetaTags(','.$this->lang('mt_main'));
		GWF_Website::addMetaDescr(' '.$this->lang('md_main'));
	}
	
	public function onAddHooks()
	{
		GWF_Hook::add(GWF_Hook::DOWNLOAD, array(__CLASS__, 'hookDownload'));
	}
	
	public function hookDownload(GWF_User $user, array $args) { $this->onInclude(); require_once GWF_CORE_PATH.'module/BAIM/Baim_Hook_Dl.php'; Baim_Hook_Dl::hook($user, $args[0]); }
}

?>