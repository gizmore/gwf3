<?php
class SR_RealPunk extends SR_RealAliveNPC
{
	public function getExtensions()
	{
		return SR_AIExtension::merge(parent::getExtensions(), array(
			'lazyass',
		));
	}
}
