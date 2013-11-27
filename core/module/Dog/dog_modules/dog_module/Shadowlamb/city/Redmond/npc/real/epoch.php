<?php
class Redmond_epoch extends SR_RealNPC
{
	public function getExtensions()
	{
		return SR_AIExtension::merge(parent::getExtensions(), array(
			'chatter' => array(),
		));
	}	
}
