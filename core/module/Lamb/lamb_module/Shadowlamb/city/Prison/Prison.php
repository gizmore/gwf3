<?php
final class Prison extends SR_Dungeon
{
	public function getCityLocation() { return 'Delaware_Prison'; }
	public function getArriveText() { return 'You enter the prison.'; }
	public function getImportNPCS() { return array('Seattle_BlackOp'); }
	public function getRespawnLocation(SR_Player $player) { return 'Prison_Block1'; }
	
	public function onCityEnter(SR_Party $party)
	{
		$party->giveKnowledge('places', 'Prison_Registry');
		if ($party->hasNPCClassed('PrisonB2_Malois'))
		{
			$this->setAlert($party, 9000000);
		}
		$party->notice('You can see the registry from here.');
		parent::onCityEnter($party);
	}
	
	public function onCityExit(SR_Party $party)
	{
		parent::onCityExit($party);
		
		if (false !== ($malois = $party->getNPCMemberByClassname('PrisonB2_Malois')))
		{
			$party->notice(sprintf('Malois says: "Thank you so very much ... I will have to be careful now ... I guess i cannot even go shopping in the Chicago_Store now."'));
			if (false !== $party->kickUser($malois))
			{
				$party->setConst('RESCUED_MALOIS', 1);
			}
			$party->notice('"Not so fast!!" , A group of soldiers shout, "You are going nowhere!"');
			$party->notice('Malois flees as you back him up!');
			$party->fight(SR_NPC::createEnemyParty('Prison_GrayOp','Prison_GrayOp','Seattle_BlackOp'));
		}
	}

}
?>
