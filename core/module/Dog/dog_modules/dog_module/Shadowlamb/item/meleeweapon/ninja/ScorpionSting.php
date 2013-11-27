<?php
final class Item_ScorpionSting extends SR_NinjaWeapon
{
	public function getAttackTime() { return 50; }
	public function getItemRange() { return 2.2; }
	public function getItemWeight() { return 0; }
	public function getItemDescription() { return 'Giant sting of a giant scorpion. Seriosly harms and poisons you.'; }
	
	public function isItemLootable() { return false; }
	public function isItemDropable() { return false; }
	public function isItemSellable() { return false; }
	public function isItemTradeable() { return false; }
	public function isItemStattable() { return false; }
	
	public function getItemModifiersA(SR_Player $player)
	{
		return array(
			'attack'  => 12.0,
			'min_dmg' => 4.0,
			'max_dmg' => 18.0,
		);
	}

	/**
	 * Poison the target.
	 * @see SR_Weapon::onDealDamage()
	 */
	public function onDealDamage(SR_Player $player, SR_Player $target, $hits, $damage)
	{
		$biotech = Common::clamp($target->getVar('biotech'), 0, 15);
		$min = 0.10 - $biotech * 0.01;
		$max = 0.30 - $biotech * 0.02;
		$duration = rand(20, 40);
		$per_sec = Shadowfunc::diceFloat($min, $max, 2);
		if ($per_sec > 0)
		{
			$modifiers = array('hp' => $per_sec);
			$target->addEffects(new SR_Effect($duration, $modifiers));
	
			$target->msg('5294', array(sprintf('%.02f', $per_sec), GWF_Time::humanDuration($duration)));
		}
	}
}
?>
