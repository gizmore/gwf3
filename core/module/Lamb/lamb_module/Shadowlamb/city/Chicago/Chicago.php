<?php
final class Chicago extends SR_City
{
	public function getImportNPCS()
	{
		return
			array(
				'Redmond_OrkLeader','Redmond_Ueberpunk',

				'Seattle_Cop','Seattle_BlackOp',
				'Seattle_Ninja','Seattle_TrollDecker','Seattle_Samurai','Seattle_Shaolin','Seattle_Headhunter',
					
				'Delaware_Goblin','Delaware_Ork','Delaware_Troll',
				'Delaware_Hipster','Delaware_Goth','Delaware_Emo',
				'Delaware_Assassin', 'Delaware_Commando', 'Delaware_Headhunter', 'Delaware_Killer',

				'Prison_GrayOp',
			);
			
	}
	public function getArriveText() { return 'You arrive in Chicago. After the racewars only slums are left.'; }
	public function getMinLevel() { return 21; }
	public function getSquareKM() { return 12; }
	public function onEvents(SR_Party $party)
	{
		$this->onEventWallet($party);
		return false;
	}
	
	public function getRespawnLocation(SR_Player $player)
	{
		if ( ($player->getNuyen() > 300) && ($player->hasKnowledge('places', 'Chicago_Hotel')) )
		{
			return 'Chicago_Hotel';
		}
		else
		{
			return Shadowrun4::getCity('Delaware')->getRespawnLocation($player);
		}
	}
	
	public function onEventWallet(SR_Party $party)
	{
		foreach ($party->getMembers() as $member)
		{
			$member instanceof SR_Player;
			if ($member->isHuman())
			{
				$percent = 0.05;
				$luck = $member->get('luck');
				$percent += $luck / 200;
				if (Shadowfunc::dicePercent($percent))
				{
					$nuyen = rand(10, 60);
					$member->message(sprintf('You found a wallet with %s in it.', Shadowfunc::displayNuyen($nuyen)));
					$member->giveNuyen($nuyen);
				}
			}
		}
	}
}
?>