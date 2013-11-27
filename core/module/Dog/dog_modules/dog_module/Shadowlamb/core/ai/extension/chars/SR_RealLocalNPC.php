<?php
class SR_RealLocalNPC extends SR_RealNPC
{
	public function isKillProtected() { return true; }
	
	public function getExtensions()
	{
		return SR_AIExtension::merge(parent::getExtensions(), array(
			'giveback',
		));
	}
}
