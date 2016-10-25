<?php
require_once 'util/TGC_AvatarNames.php';
require_once 'util/TGC_Combat.php';
require_once 'util/TGC_Const.php';
require_once 'util/TGC_Global.php';
require_once 'util/TGC_Logic.php';

final class Module_Tamagochi extends GWF_Module
{
	public function getDefaultAutoLoad() { return true; }
	
	public function getClasses() { return array('TGC_Avatar', 'TGC_Player', 'TGC_PlayerAvatar'); }
	
}
