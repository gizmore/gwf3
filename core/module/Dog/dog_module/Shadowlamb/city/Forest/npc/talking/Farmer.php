<?php
final class Forest_Farmer extends SR_TalkingNPC
{
	public function getName() { return $this->langNPC('name'); }
	public function getNPCQuests(SR_Player $player) { return array('Seattle_Farmer'); }
}
?>
