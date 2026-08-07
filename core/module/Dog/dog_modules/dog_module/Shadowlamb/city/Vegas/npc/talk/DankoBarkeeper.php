<?php
final class Vegas_DankoBarkeeper extends SR_TalkingNPC
{
	public function getName() { return $this->langNPC('name'); }
	
	public function getNPCQuests(SR_Player $player) { return array('Vegas_Voices'); }
}
?>
