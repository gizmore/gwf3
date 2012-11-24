<?php
require_once 'SR_Quest.php';
/**
 * Generic Quest functions for "bring multiple items at once" quests.
 * Probably also nice for single item bringers.
 * @author gizmore
 */
abstract class SR_QuestMultiItem extends SR_Quest
{
	/**
	 * Return the needed items for this quest.
	 * @example return array($itemname=>$amt, ...);
	 */
	public abstract function getQuestDataItems(SR_Player $player);
	### Overrides
	public function onQuestMIGiven($npc, SR_Player $player) {}
	public function onQuestMIMore($npc, SR_Player $player) {}
	public function onQuestMISolved($npc, SR_Player $player) {}
	
	/**
	 * Get quest data from abstract getter.
	 * @see SR_Quest::getQuestData()
	 * @return array
	 */
	public function getQuestData()
	{
		$data = parent::getQuestData();
		if (count($data) === 0)
		{
			$data = array();
			foreach ($this->getQuestDataItems($this->getPlayer()) as $itemname => $need)
			{
				$data[$itemname] = 0;
			}
		}
		return $data;
	}
	
	/**
	 * Get a description tring from item stats.
	 * The args replaced in format are %1$s, %2$d for 1st itenmane, amt, iname, amt, ...
	 * @param string $format
	 * @return string
	 */
	public function getQuestDescriptionMI($format)
	{
		$va = array($this->getQuestDescriptionStats());
		$data = $this->getQuestData();
		foreach ($data as $itemname => $need)
		{
			$va[] = $itemname;
			$va[] = $need;
		}
		return vsprintf($format, $va);
	}
	
	/**
	 * Get simple stat string in arg 0.
	 * @return string
	 */
	public function getQuestDescriptionStats()
	{
		$va = array();
		$data = $this->getQuestData();
		$out = array();
		foreach ($this->getQuestDataItems($this->getPlayer()) as $itemname => $amt)
		{
			$out[] = sprintf("%d/%d %s", $data[$itemname], $amt, $itemname);
		}
		return GWF_Array::implodeHuman($out);
	}
	
	/**
	 * A more generic implementation of checkQuest.
	 * @see SR_Quest::checkQuest()
	 * @return boolen
	 */
	public function checkQuest(SR_NPC $npc, SR_Player $player)
	{
		$have = $this->getQuestData();
		$need = $this->getQuestDataItems($player);
		
		# Give the shizzle
		$given = 0;
		$need_total = 0;
		$have_total = 0;
		foreach ($need as $itemname => $amt)
		{
			$hbe = $have[$itemname]; # before
			$hav = $this->giveQuesties($player, $npc, $itemname, $have[$itemname], $amt); # after
			$have[$itemname] = $hav;
			$need[$itemname] = $amt - $hav;
			$given += $hav - $hbe;
			$need_total += $amt;
			$have_total += $hav;
		}
	
		# Save on change.
		if ($given > 0)
		{
			$this->onQuestMIGiven($npc, $player); # Callback
			$this->saveQuestData($have);
		}
	
		# Solved?
		if ($have_total >= $need_total)
		{
			$this->onQuestMISolved($npc, $player); # Callback
			$this->onSolve($player);
		}
		else
		{
			$this->onQuestMIMore($npc, $player); # Callback
		}
		
		return true;
	}
}
?>
