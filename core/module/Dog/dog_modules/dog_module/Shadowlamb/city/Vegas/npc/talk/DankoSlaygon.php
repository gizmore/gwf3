<?php
final class Vegas_DankoSlaygon extends SR_TalkingNPC
{
	public function getName() { return $this->langNPC('name'); }
	
	function getNPCQuests(SR_Player $player) { return array('Vegas_Slaygon'); }
}
?>
