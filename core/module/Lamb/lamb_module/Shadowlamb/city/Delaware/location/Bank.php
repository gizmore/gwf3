<?php
final class Delaware_Bank extends SR_Bank
{
	public function getFoundPercentage() { return 80.00; }
	public function getTransactionPrice() { return 60; }
// 	public function getFoundText(SR_Player $player) { return sprintf('You found the Bank in Delaware.'); }
// 	public function getEnterText(SR_Player $player) { return 'You enter the bank. You see a customer at one of the counters. There are 2 security officers.'; }
}
?>