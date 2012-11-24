<?php
final class Vegas_Tuna extends SR_TalkingNPC
{
	public function getName() { return 'Tuna'; }
	public function getNPCPlayerName() { return 'Tuna'; }
	
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
?>