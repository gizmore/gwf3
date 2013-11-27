<?php
require_once 'SR_RealLocalNPC.php';
class SR_RealQuestNPC extends SR_RealLocalNPC
{
	public function isKillProtected() { return true; }
	
	public function getExtensions()
	{
		return SR_AIExtension::merge(parent::getExtensions(), array(
			'questgiver',
		));
	}
	
}
