<?php
class Redmond_dloser extends SR_RealQuestNPC
{
	public function getName() { return 'dloser'; }
	
	public function getNPCQuests(SR_Player $player) { return array('Redmond_Peninsula', 'Redmond_Pendragon'); }
	
	public function getExtensions()
	{
		return SR_AIExtension::merge(parent::getExtensions(), array(
			'interval' => array(300, array($this, 'brag'))
		));
	}
	
	public function ai_msg_5274(array $args)
	{
		var_dump('GOTOOTOTOTOT', $args);
	}
	
	public function brag()
	{
		$this->ai_say('brag');
	}
}
