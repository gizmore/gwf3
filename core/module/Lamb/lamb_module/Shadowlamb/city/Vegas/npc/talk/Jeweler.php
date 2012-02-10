<?php
final class Vegas_Jeweler extends SR_TalkingNPC
{
	public function getName() { 'Michael'; }
	
	function getNPCQuests(SR_Player $player)
	{
		return array(
			'Vegas_Ringdom',
		);
	}
	
}
?>