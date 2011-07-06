<?php
final class Redmond_SecondHand extends SR_SecondHandStore
{
	public function getNPCS(SR_Player $player) { return array('ttt' => 'Redmond_SecondHandTroll', 'talk' => 'Redmond_SecondHandDwarf'); }
	public function getFoundPercentage() { return 70.00; }
	public function getFoundText(SR_Player $player) { return 'You find a store selling second hand items.'; }
	public function getEnterText(SR_Player $player) { return 'You enter the second hand store. A troll in the corner grunts. The salesman, a small dwarf, greets you.'; }
	public function getHelpText(SR_Player $player) { return 'You can sell statted items to higher prices here. The items that get sold here will stay in the shop.'; }
}
?>