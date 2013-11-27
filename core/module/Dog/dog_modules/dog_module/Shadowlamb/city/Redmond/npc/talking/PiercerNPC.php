<?php
final class Redmond_PiercerNPC extends SR_TalkingNPC
{
	public function getName() { return $this->langNPC('name'); }
	
	public function getNPCQuests(SR_Player $player) { return array('Redmond_OrkRage'); }
}
?>
