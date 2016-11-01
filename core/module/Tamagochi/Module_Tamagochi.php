<?php
require_once 'util/TGC_AvatarNames.php';
require_once 'util/TGC_Combat.php';
require_once 'util/TGC_Const.php';
require_once 'util/TGC_Global.php';
require_once 'util/TGC_Logic.php';

final class Module_Tamagochi extends GWF_Module
{
	public function getVersion() { return 1.01; }
	public function getDefaultPriority() { return 60; }
	public function getDefaultAutoLoad() { return true; }
	public function getClasses() { return array('TGC_Avatar', 'TGC_Player', 'TGC_PlayerAvatar'); }
	public function onLoadLanguage() { return $this->loadLanguage('lang/tamagochi'); }
	public function onInstall($dropTable) { require_once 'TGC_Install.php'; return TGC_Install::onInstall($this, $dropTable); }
	
	public function cfgMaxAvatars() { return $this->getModuleVarInt('max_avatars', 3); }
	public function cfgMaxAvatarSize() { return $this->getModuleVarInt('max_avatar_size', 2048); }
	public function cfgMapsApiKey() { return 'AIzaSyBrEK28--B1PaUlvpHXB-4MzQlUjNPBez0'; $this->getModuleVar('maps_api_key', ''); }
}
