<?php
final class Chicago_Well extends SR_Location
{
	public function getFoundText(SR_Player $player) { return "You found a well in a marketplace. Some people are doing their shopping around here."; }
	public function getFoundPercentage() { return 40; }
	public function getEnterText(SR_Player $player) { return "You approach the well."; }
	public function getHelpText(SR_Player $player) { return "You can use #fill <amt> here to fill EmptyBottles with Water."; }
	public function getCommands(SR_Player $player) { return array('fill'); }
	
	public function on_fill(SR_Player $player, array $args)
	{
		switch(count($args))
		{
			case 0: $amt = 1; break;
			case 1: $amt = (int)$args[0]; break;
			default: return $player->message(Shadowhelp::getHelp($player, 'fill'));
		}
		
		if (false === ($item = ($player->getInvItem('EmptyBottle'))))
		{
			return $player->message('You don\'t have any empty bottles.');
		}
		
		if ($item->getAmount() < $amt)
		{
			return $player->message(sprintf('You only have %d empty bottles.', $item->getAmount()));
		}
		
		if (false === ($item->useAmount($player, $amt)))
		{
			return $player->message('ERROR!');
		}
		
		return $player->giveItems(array(SR_Item::createByName('WaterBottle', $amt)), 'the well');
	}
}
?>