<?php
final class Chicago_Bank extends SR_Bank
{
	public function getFoundPercentage() { return 40.00; }
	public function getTransactionPrice() { return 90; }
// 	public function getFoundText(SR_Player $player) { return sprintf('You found a Bank in Chicago.'); }
// 	public function getEnterText(SR_Player $player) { return 'You enter the bank. You see some customers at the counters. There are quite some security officers.'; }
}
?>