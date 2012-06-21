<?php
final class Forest_Creek extends SR_Location
{
	const WERE_KEY = 'FOR_CRE_WERE';
	
	public function getFoundPercentage() { return 30; }
	public function getFoundText(SR_Player $player) { return $this->lang($player, 'found'); }
	public function getEnterText(SR_Player $player) { return $this->lang($player, 'enter'); }
	
	public function onEnter(SR_Player $player)
	{
		if (!parent::onEnter($player))
		{
			return false;
		}
		
		$p = $player->getParty();
		
		if (!$p->hasTemp(self::WERE_KEY))
		{
			return true;
		}
		
		$p->setTemp(self::WERE_KEY, '1');
		
		return $this-onWereAttack($player);
	}
	
	public function onCityEnter(SR_Party $party)
	{
		$party->unsetTemp(self::WERE_KEY);
	}
	
	public function onCityExit(SR_Party $party)
	{
		$party->unsetTemp(self::WERE_KEY);
	}
	
	private function onWereAttack(SR_Player $player)
	{
		$p = $player->getParty();
		$mc = $p->getMemberCount();
		$numEnemies = rand(2, 2+$mc+2);
		$numEnemies = Common::clamp($numEnemies, 2, SR_Party::MAX_MEMBERS);
		
		$enemies = array();
		for ($i = 0; $i < $numEnemies; $i++)
		{
			$enemies[] = 'Forest_Werewolf';
		}
		
		return $p->fight(SR_NPC::createEnemyNPC($enemies));
	}
}
?>
