<?php
final class Vegas_Villa extends SR_Location
{
	public function getNPCS(SR_Player $player) { return array('Vegas_Salvatore', 'Vegas_Skinner', 'Vegas_Lazer'); }
	
	public function onEnter(SR_Player $player)
	{
		$p = $player->getParty();
		
		# We know the mafia :)
		$quest = SR_Quest::getQuest($player, 'HiJack');
		if ($quest->isAccepted($player))
		{
			return parent::onEnter($player);
		}

		# Check how many guards have been killed in total
		$killed = 0;
		foreach ($p->getMembers() as $member)
		{
			$member instanceof SR_Player;
			$killed += SR_PlayerVar::getVal($member, 'mgkills', 0);
		}
		if ($killed >= 6)
		{
			return parent::onEnter($player);
		}
		
		# Guarded!
		foreach ($p->getMembers() as $member)
		{
			$member instanceof SR_Player;
			$member->message($this->lang($member, 'guarded'));
		}
		$guards = array();
		for ($i = 0; $i < 6; $i++)
		{
			$guards[] = 'Vegas_MafiaGuard';
		}
		SR_NPC::createEnemyParty($guards)->fight($p);
		return false;
	}
}
?>
