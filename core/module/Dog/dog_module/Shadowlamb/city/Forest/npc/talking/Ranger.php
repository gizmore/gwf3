<?php
final class Forest_Ranger extends SR_TalkingNPC
{
	public function getName() { return $this->langNPC('name'); }
	
	public function getNPCQuests(SR_Player $player) { return array('Seattle_Ranger'); }
}
?>
