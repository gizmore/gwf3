<?php
final class Vegas_Ugah extends SR_RealNPC
{
	public function getName() { return 'Ugah'; }
	public function getNPCPlayerName() { return 'Ugah'; }
	
	public function getNPCEquipment()
	{
		return array(
			'mount' => 'Razor1911_of_lock:5',
		);
	}
	
	public function getNPCMountInventory()
	{
		return array('100xCigar');
	}
}
