<?php
final class Item_Stimpatch extends SR_HealItem
{
	public function getItemLevel() { return 8; }
	public function getItemDescription() { return 'A small and fast painkiller. Excellent for combat.'; }
	public function getItemWeight() { return 150; }
	public function getItemUseTime(){ return 10; }
	public function getItemPrice() { return 950; }
	public function getItemDropChance() { return 50; }
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
		$mingain = 40 + $bio*8;
		$maxgain = 140 + $bio*14;
		$gain = round(rand($mingain, $maxgain) / 10, 2);
		$gained = $target->healHP($gain);
		
		$message = sprintf(' %s.', Shadowfunc::displayHPGain($oldhp, $gained, $maxhp));
		$this->announceUsage($player, $target, $message);
		return true;
	}
}
?>