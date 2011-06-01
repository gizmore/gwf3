<?php
final class Quest_Seattle_GJohnson1 extends SR_Quest
{
	public function getQuestName() { return 'TheContractor'; }
	public function getQuestDescription() { return sprintf('Kill %s/%s TrollDeckers and return to Mr.Johnson in the Deckers Pub.', $this->getAmount(), $this->getNeededAmount()); }
	
}
?>
