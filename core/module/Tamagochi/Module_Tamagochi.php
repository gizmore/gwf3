<?php
require_once 'util/TGC_Combat.php';
require_once 'util/TGC_Const.php';
require_once 'util/TGC_Logic.php';
require_once 'util/TGC_Position.php';

require_once 'TGC_Attack.php';
/**
 * @author gizmore
 * @license properitary
 */
final class Module_Tamagochi extends GWF_Module
{
	private static $instance;
	public static function instance() { return self::$instance; }
	
	public function getVersion() { return 1.02; }
	public function getDefaultPriority() { return 64; }
	public function getDefaultAutoLoad() { return true; }
	public function getClasses() { return array('TGC_Player'); }
	public function onLoadLanguage() { return $this->loadLanguage('lang/tamagochi'); }
	public function onInstall($dropTable) { require_once 'TGC_Install.php'; return TGC_Install::onInstall($this, $dropTable); }
	
	public function cfgMapsApiKey() { return $this->getModuleVar('maps_api_key', ''); }
	public function cfgWebsocketURL() { return sprintf('ws://%s:34543', GWF_DOMAIN); }
	public function cfgWebsocketTLSURL() { return sprintf('wss://%s:61221', GWF_DOMAIN); }
	
	public function onStartup()
	{
		self::$instance = $this;
		$this->onLoadLanguage();
	}

}
