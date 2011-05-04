<?php
final class Redmond_Bank extends SR_Bank
{
	public function getFoundPercentage() { return 100.00; }
	public function getTransactionPrice() { return 20; }
	public function getFoundText() { return sprintf('You found the Redmond Bank. All transactions are done with slot machines.', $this->getName()); }
	public function getEnterText(SR_Player $player) { return 'You enter the Redmond bank. You see a customer at one of the counters. There are 2 security officers.'; }
}
?>