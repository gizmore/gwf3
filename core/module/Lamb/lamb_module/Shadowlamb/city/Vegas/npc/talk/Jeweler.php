<?php
final class Vegas_Jeweler extends SR_TalkingNPC
{
	public function getName() { return $this->langNPC('name'); }
	
	function getNPCQuests(SR_Player $player)
	{
		return array(
			'Vegas_Ringdom',
			'Vegas_DarkBonds',
		);
	}
	
}
?>
