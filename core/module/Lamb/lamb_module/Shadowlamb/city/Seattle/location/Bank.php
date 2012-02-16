<?php
final class Seattle_Bank extends SR_Bank
{
	public function getFoundPercentage() { return 80.00; }
	public function getTransactionPrice() { return 40; }
// 	public function getFoundText(SR_Player $player) { return sprintf('You found the Bank of Seattle.'); }
// 	public function getEnterText(SR_Player $player) { return 'You enter the bank. You see a customer at one of the counters. There are 2 security officers.'; }
}
?>