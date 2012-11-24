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
				return $this->rply('hello');
// 				return $this->reply("Do you want to pray for your \X02sins\X02?");
			
			default:
				return $this->rply('default');
// 				return $this->reply('What leads you here, son?');
		}
	}
	
	private function calcPrice(SR_Player $player, $badkarma)
	{
		$price = ($badkarma+1) * 4000;
		return Shadowfunc::calcBuyPrice($price, $player);
	}
	
	private function praySins(SR_Player $player, array $args)
	{
		if (1 > ($badkarma = $player->getBase('bad_karma')))
		{
			return $this->rply('free');
// 			return $this->reply('You are free from all sins, my son.');
		}
		
		$price = $this->calcPrice($player, $badkarma);
		if ( (count($args) === 1) && (strtolower($args[0]) === 'now') )
		{
			return $this->onPraySins($player, $price);
		}

		$dp = Shadowfunc::displayNuyen($price);
		return $this->rply('have', array($badkarma, $dp));
// 		return $this->reply("You have {$badkarma} bad karma and it would cost {$dp} to forgive your sins. Type '#pray sins now' to confirm.");
	}

	private function onPraySins(SR_Player $player, $price)
	{
		$nuyen = $player->getNuyen();
		$dp = Shadowfunc::displayNuyen($price);
		$dn = Shadowfunc::displayNuyen($nuyen);
		if ($price > $nuyen)
		{
			return $this->rply('cost', array($dp, $dn));
// 			return $this->reply(sprintf('My son, it would cost %s to forgive your sins, but you have only %s.', $dp, $dn));
		}
		$player->giveNuyen(-$price);
		$dl = Shadowfunc::displayNuyen($nuyen-$price);
		$player->message($this->langNPC('pay', array($dp, $dl)));
// 		$player->message("You pay the price of {$dp} and have {$dl} left.");
		$player->alterField('bad_karma', -1);
		$badkarma = $player->getBase('bad_karma');
		return $this->rply('thx', array($badkarma));
// 		return $this->reply("Thank you my son. You now have only {$badkarma} bad karma left.");
	}
}
?>
