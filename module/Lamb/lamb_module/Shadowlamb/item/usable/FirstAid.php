<?php
final class Item_FirstAid extends SR_HealItem
{
	public function getItemLevel() { return 2; }
	public function getItemDescription() { return 'A first aid kid to heal friendly players. Sadly does not contain too much of the useful healing tools.'; }
	public function getItemWeight() { return 400; }
	public function getItemUseTime(){ return 50; }
	public function getItemPrice() { return 350; }
	public function isItemFriendly() { return true; }
	
	public function onItemUse(SR_Player $player, array $args)
	{
		if (false === ($target = $this->getFriendlyTarget($player, isset($args[0])?$args[0]:'') )) {
			return $player->message('The target is unknown.');
		}
		$maxhp = $target->get('max_hp');
		$oldhp = $target->getHP();
		if ($oldhp >= $maxhp) {
			return $player->message(sprintf('%s does not need to get healed.', $target->getName()));
		}
		
		$bio = $player->get('biotech');
		$mingain = 50 + $bio*7;
		$maxgain = 120 + $bio*12;
		$gain = round(rand($mingain, $maxgain) / 10, 2);
		$gained = $target->healHP($gain);
		
		$message = sprintf(' %s.', Shadowfunc::displayHPGain($oldhp, $gained, $maxhp));
		$this->announceUsage($player, $target, $message);
		return true;
	}
}
?>