<?php
final class Delaware_Priest extends SR_TalkingNPC
{
	public function getName() { return 'The priest'; }
	
	public function onNPCTalk(SR_Player $player, $word, array $args)
	{
		switch ($word)
		{
			case 'sins':
				return $this->praySins($player, $args);
			
			case 'hello':
				return $this->reply("Do you want to pray for your \X02sins\X02?");
			
			default:
				return $this->reply('What leads you here, son?');
		}
	}
	
	private function calcPrice(SR_Player $player, $badkarma)
	{
		$price = $badkarma * 1500;
		return Shadowfunc::calcBuyPrice($price, $player);
	}
	
	private function praySins(SR_Player $player, array $args)
	{
		if (0 == ($badkarma = $player->getBase('bad_karma')))
		{
			return $this->reply('You are free from all sins, my son.');
		}
		
		array_shift($args);
		
		$price = $this->calcPrice($player, $badkarma);
		if ( (count($args) === 1) && (strtolower($args[0]) === 'now') )
		{
			return $this->onPraySins($player, $price);
		}

		$dp = Shadowfunc::displayPrice($price);
		return $this->reply("You have {$badkarma} bad karma and it would cost {$dp} to forgive your sins. Type #pray sins now to confirm.");
	}

	private function onPraySins(SR_Player $player, $price)
	{
		$nuyen = $player->getNuyen();
		$dp = Shadowfunc::displayPrice($price);
		$dn = Shadowfunc::displayPrice($nuyen);
		if ($price > $nuyen)
		{
			return $this->reply(sprintf('My son, it would cost %s to forgive your sins, but you have only %s.', $dp, $dn));
		}
		$player->giveNuyen(-$price);
		$dl = Shadowfunc::displayPrice($nuyen-$price);
		$player->message("You pay the price of {$dp} and have {$dl} left.");
		$player->alterField('bad_karma', -1);
		$badkarma = $player->getBase('bad_karma');
		return $this->reply("Thank you my son. You now have only {$badkarma} bad karma left.");
	}
}
?>