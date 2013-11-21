<?php
final class Vegas_Millionaire extends SR_RealNPC
{
	public function getExtensions() {
		return array(
			'talker' => array(),
			'interval' => array(10, array($this, 'ai_give_millions')),
		);
	}

	public function ai_shouter()
	{
		if (false !== ($player = $this->getRandomPlayer('humans')))
		{
			$this->giveMillions($player);
		}
	}
	
	private function giveMillions(SR_Player $player)
	{
		$this->say($player, 'here');
		$this->giveny($player, 15);
	}

	public function getRandomPlayer($only='all')
	{
		$back = array();
		foreach (Shadowrun4::getPlayers() as $player)
		{
			$player instanceof SR_Player;
			if ($player->isHuman() && $only !== 'npc')
			{
				$back[] = $player;
			}
			elseif ($player->isNPC() && $only !== 'human')
			{
				$back[] = $player;
			}
		}
	}

}
