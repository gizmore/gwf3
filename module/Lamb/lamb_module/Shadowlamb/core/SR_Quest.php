<?php
class SR_Quest extends GDO
{
	# Options
	const ACCEPTED = 0x001;
	const REJECTED = 0x002;
	const DONE = 0x010;
	const FAILED = 0x020;
	const ABORTED = 0x040;
	const STATUS_BITS = 0x0FF;
	const PARTY_QUEST = 0x100;

	public static $QUEST_FLAGS = array(
		'accepted' => array(self::STATUS_BITS, self::ACCEPTED),
		'rejected' => array(self::REJECTED, self::REJECTED),
		'done' => array(self::DONE, self::DONE),
		'failed' => array(self::FAILED, self::FAILED),
		'aborted' => array(self::ABORTED, self::ABORTED),
	);
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'sr4_quest'; }
	public function getOptionsName() { return 'sr4qu_options'; }
	public function getColumnDefines()
	{
		return array(
			'sr4qu_uid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'sr4qu_name' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S|GDO::PRIMARY_KEY, GDO::NOT_NULL, 255),
			'sr4qu_eta' => array(GDO::UINT, 0),
			'sr4qu_date' => array(GDO::UINT, GDO::NOT_NULL),
			'sr4qu_amount' => array(GDO::UINT, 0),
			'sr4qu_data' => array(GDO::TEXT|GDO::ASCII|GDO::CASE_S),
			'sr4qu_options' => array(GDO::UINT, 0),	
		);
	}
	
	#############
	### Quest ###
	#############
	public function checkQuest(SR_NPC $npc, SR_Player $player) {}
	
	public function getName() { return $this->getVar('sr4qu_name'); }
	public function getAmount() { return $this->getVar('sr4qu_amount'); }
	public function getNeededAmount() { return 0; }
	public function onQuestSolve(SR_Player $player) {}
	public function getQuestName() { return $this->getName(); }
	public function getQuestDescription() { return 'QUEST DESCRIPTION'; }
	public function isDone(SR_Player $player) { return $this->isOptionEnabled(self::DONE); }
	public function isInQuest(SR_Player $player) { return (!$this->isDone($player)) && ($this->isAccepted($player)); }
	public function isAccepted(SR_Player $player) { return $this->isOptionEnabled(self::ACCEPTED); }
	public function isDeclined(SR_Player $player) { return $this->isOptionEnabled(self::REJECTED); }
	public function accept(SR_Player $player)
	{
		if ($this->isAccepted($player)) {
			return true;
		}
		$this->saveOption(self::ACCEPTED, true);
		$player->message(sprintf('You got a new quest: %s.', $this->getQuestName()));
	}
	
	public function decline(SR_Player $player)
	{
		if ($this->getOptions() !== 0) {
			return false;
		}
		$this->saveOption(self::REJECTED, true);
		$player->message(sprintf('You declined the quest "%s". (forever)', $this->getQuestName()));
	}
	
	public function onSolve(SR_Player $player)
	{
		$this->saveOption(self::DONE, true);
		$this->onQuestSolve($player);
		$player->message(sprintf('You have completed a quest: %s.', $this->getQuestName()));
	}
	
	public function giveAmount(SR_Player $player, $by=1)
	{
		if (false === ($this->increase('sr4qu_amount', $by))) {
			return false;
		}
		if ($this->getAmount() >= $this->getNeededAmount()) {
			$this->onSolve($player);
		}
		return true;
	}
	
	public function displayQuest()
	{
		return sprintf('"%s": %s', $this->getQuestName(), $this->getQuestDescription());
	}

	##############
	### Static ###
	##############
	/**
	 * Get a quest.
	 * @param $player
	 * @param $name
	 * @return SR_Quest
	 */
	public static function getQuest(SR_Player $player, $name)
	{
		$uid = $player->getID();
		require_once Lamb::DIR.'lamb_module/Shadowlamb/quest/'.$name.'.php';
		$ename = self::escape($name);
		if (false === ($data = self::table(__CLASS__)->selectFirst('*', "sr4qu_uid=$uid AND sr4qu_name='$ename'"))) {
			return self::createQuest($player, $name);
		}

		$classname = 'Quest_'.$name;
		$quest = new $classname($data);
		return $quest;
	}
	
	public static function getByID(SR_Player $player, $section, $id)
	{
		if (!isset(self::$QUEST_FLAGS[$section])) {
			return false;
		}
		$uid = $player->getID();
		$bits_in = self::$QUEST_FLAGS[$section][0];
		$bits_out = self::$QUEST_FLAGS[$section][1];
		$table = self::table(__CLASS__);
		
		if ($id < 1) {
			return false;
		}
		
		if (false === ($row = $table->selectFirst('*', "sr4qu_uid=$uid AND sr4qu_options&$bits_in=$bits_out", 'sr4qu_date ASC', NULL, GDO::ARRAY_A, $id-1))) {
			return false;
		}
		$name = $row['sr4qu_name'];
		$classname = 'Quest_'.$name;
		require_once Lamb::DIR.'lamb_module/Shadowlamb/quest/'.$name.'.php';
		$quest = new $classname($row);
		return $quest;
	}
	
	public static function getQuests(SR_Player $player, $section)
	{
		if (!isset(self::$QUEST_FLAGS[$section])) {
			return false;
		}
		$bits_in = self::$QUEST_FLAGS[$section][0];
		$bits_out = self::$QUEST_FLAGS[$section][1];
		$uid = $player->getID();
		$table = self::table(__CLASS__);
		if (false === ($result = $table->select('*', "sr4qu_uid=$uid AND sr4qu_options&$bits_in=$bits_out", 'sr4qu_date ASC'))) {
			return false;
		}
		$back = array();
		while (false !== ($row = $table->fetch($result, GDO::ARRAY_A)))
		{
			$questname = $row['sr4qu_name'];
			$classname = 'Quest_'.$questname;
			require_once Lamb::DIR.'lamb_module/Shadowlamb/quest/'.$questname.'.php';
			$quest = new $classname($row); 
			$back[] = $quest;
		}
		$table->free($result);
		return $back;
	}
	
	private static function createQuest(SR_Player $player, $name)
	{
		$classname = 'Quest_'.$name;
		$quest = new $classname(array(
			'sr4qu_uid' => $player->getID(),
			'sr4qu_name' => $name,
			'sr4qu_eta' => 0,	
			'sr4qu_date' => Shadowrun4::getTime(),
			'sr4qu_amount' => 0,
			'sr4qu_data' => NULL,
			'sr4qu_options' => 0,	
		));
		if (false === ($quest->replace())) {
			return false;
		}
		return $quest;
	}
	
	public function getQuestData()
	{
		if (NULL === ($data = $this->getVar('sr4qu_data'))) {
			return array();
		}
		return unserialize($data);
	}

	public function saveQuestData($data)
	{
		if ($data === NULL) {
			$s = NULL;
		} else {
			$s = serialize($data);
		}
		return $this->saveVar('sr4qu_data', $s);
	}

	public function giveQuesties(SR_Player $player, SR_NPC $npc, $itemname, $have, $need)
	{
		$left = $need - $have;
		$give = 0;
		
		while ($left > 0)
		{
			if (false === ($item = $player->getInvItemByName($itemname))) {
				break;
			}
			$possible = Common::clamp($item->getAmount(), 0, $left);
			$item->useAmount($player, $possible);
			$give += $possible;
			$left -= $possible;
			$have += $possible;
		}
		
		if ($give > 0)
		{
			$player->message(sprintf('You hand %d %s(s) to %s.', $give, $itemname, $npc->getName()));
		}
		
		return $have;
	}
}
?>
