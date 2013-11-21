<?php
final class Quest_Redmond_Peninsula extends SR_QuestMultiItem
{
	public function getQuestDescription() { return $this->lang('descr', array($this->getAmount(), $this->getNeededAmount())); }
	public function getQuestDataItems(SR_Player $player) { return array('Pen' => 1); }
	public function getRewardNuyen() { return 200; }
	public function getRewardXP() { return 3; }
} 
