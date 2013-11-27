<?php
class Redmond_Beggar extends SR_RealAliveNPC
{
	public function getExtensions()
	{
		return SR_AIExtension::merge(parent::getExtensions(), array(
			'interval' => array(60, array($this, 'beggar_brabbels')),
		));
	}
	
	public function beggar_brabbels()
	{
		$this->ai_say('I need more money');
	}
}