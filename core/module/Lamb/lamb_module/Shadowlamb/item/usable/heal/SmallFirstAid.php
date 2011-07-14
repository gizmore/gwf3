<?php
final class Item_SmallFirstAid extends SR_Usable
{
	public function getItemLevel() { return 0; }
	public function getItemDescription() { return 'A small first aid kid to heal friendly players. Sadly does not contain too much of the useful healing tools.'; }
	public function getItemWeight() { return 300; }
	public function getItemUseTime(){ return 50; }
	public function getItemPrice() { return 80; }
	public function isItemFriendly() { return true; }
	
	public function onItemUse(SR_Player $player, array $args)
	{
		if (false === ($target = $this->getFriendlyTarget($player, isset($args[0])?$args[0]:'') )) {
			$player->message('The target is unknown.');
			return false;
		}
		$maxhp = $target->get('max_hp');
		$oldhp = $target->getHP();
		if ($oldhp >= $maxhp) {
			$player->message(sprintf('%s does not need to get healed.', $target->getName()));
			return false;
		}
		
		$bio = $player->get('biotech');
		$mingain = 30 + $bio*5;
		$maxgain = 80 + $bio*10;
		$gain = round(rand($mingain, $maxgain)/10, 2);
		$gained = $target->healHP($gain);
		
		$msg = sprintf(' %s.', Shadowfunc::displayHPGain($oldhp, $gained, $maxhp));
		$this->announceUsage($player, $target, $msg);
		return true;
	}
	
}
?>