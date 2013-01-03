<?php
class SR_Quest extends GDO
{
	#################
	### Statistic ###
	#################
	private static $QUESTS = array();
	public static function getQuests() { return self::$QUESTS; }
	public static function getTotalQuestCount() { return count(self::$QUESTS); }
	public static function exists($classname) { return isset(self::$QUESTS[$classname]); }
	
	/**
	 * Get a quest without city prefix. Used in #help.
	 * @param string $classname
	 * @return SR_Quest
	 */
	public static function getQuestWithoutCity(SR_Player $player, $classname)
	{
		$classname = '_'.$classname;
		foreach (self::$QUESTS as $cname => $quest)
		{
			if (Common::endsWith($cname, $classname))
			{
				return self::getQuest($player, $cname);
			}
		}
		return false;
	}
	
	############
	### Lang ###
	############
	public function langPlayer(SR_Player $player, $key, $args=NULL)
	{
		return Shadowlang::langQuest($this, $player, $key, $args);
	}
	
	public function lang($key, $args=NULL)
	{
		return $this->langPlayer($this->getPlayer(), $key, $args);
	}
	
	public function msg($key, $args=NULL)
	{
		return $this->getPlayer()->message($this->lang($key, $args));
	}
	
	####################
	### Option flags ###
	####################
	const ACCEPTED = 0x001;
	const REJECTED = 0x002;
	const DONE = 0x010;
	const FAILED = 0x020;
	const ABORTED = 0x040;
	const STATUS_BITS = 0x0FF;
	const PARTY_QUEST = 0x100;
	public static $QUEST_FLAGS = array(
		'open' => array(self::STATUS_BITS, self::ACCEPTED),
		'deny' => array(self::REJECTED, self::REJECTED),
		'done' => array(self::DONE, self::DONE),
		'fail' => array(self::FAILED, self::FAILED),
		'abort' => array(self::ABORTED, self::ABORTED),
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
// 			'sr4qu_time' => array(GDO::UINT, 0),
			'sr4qu_options' => array(GDO::UINT, 0),
		);
	}
	
	#############
	### Quest ###
	#############
	public function getName() { return $this->getVar('sr4qu_name'); }
	public function getTrigger() { return 'shadowrun'; }
	public function getTriggers() { return array(); }
	public function getQuestTriggers() { return array(); }
	public function checkQuest(SR_NPC $npc, SR_Player $player) {}
	public function getTempKey() { return 'SR4QT1_'.$this->getName(); }
	public function getAmount() { return $this->getVar('sr4qu_amount'); }
	public function getAmountPercent() { return round(100*$this->getAmount()/$this->getNeededAmount(), 2); }
	public function saveAmount($amt)
	{
		if (!$this->saveVar('sr4qu_amount', $amt))
		{
			return false;
		}
		
		if ($this->getPlayer()->getLangISO() === 'bot')
		{
			$this->getPlayer()->msg('9003', array($this->getAmountPercent(), $this->getQuestName(), $this->getQuestDescription()));
		}
		
		return true;
	}
	public function increaseAmount($by=1) { return $this->saveAmount($this->getAmount()+$by); }
	public function getNeededAmount() { return 0; }
	public function onQuestSolve(SR_Player $player) {}
	public function getQuestName() { return $this->lang('title'); }
	public function getQuestDescription() { return $this->lang('descr'); }
	public function isDone(SR_Player $player) { return $this->isOptionEnabled(self::DONE); }
	public function isInQuest(SR_Player $player) { return (false === $this->isDone($player)) && (true === $this->isAccepted($player)); }
	public function isAccepted(SR_Player $player) { return $this->isOptionEnabled(self::ACCEPTED); }
	public function isDeclined(SR_Player $player) { return $this->isOptionEnabled(self::REJECTED); }
	public function isFailed(SR_Player $player) { return $this->isOptionEnabled(self::FAILED); }
	public function isUnknown(SR_Player $player) { return $this->getOptions() === 0; }
	public function onNPCQuestTalk(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL) { return $this->onNPCQuestTalkB($npc, $player, $word, $args); }
	public function onAccept(SR_Player $player) {}
	public function displayQuest() { return sprintf('"%s": %s', $this->getQuestName(), $this->getQuestDescription()); }
	public function getPlayer() { return Shadowrun4::getPlayerByPID($this->getPlayerID()); }
	public function getPlayerID() { return $this->getVar('sr4qu_uid'); }
	
	# Citynames for sections
	private $cityname = 'Unknown';
	public function getCityName() { return $this->cityname; }
	public function setCityName($cityname) { $this->cityname = $cityname; }
	
	/**
	 * Accept logic.
	 * @param SR_Player $player
	 */
	public function accept(SR_Player $player)
	{
		if ($this->isAccepted($player))
		{
			$player->message('You already accepted this quest. (Please report to gizmore, should not see me.)');
			return true;
		}
		
		# Insert
		$this->setOption(self::ACCEPTED, true);
// 		$this->setVar('sr4qu_date', Shadowrun4::getTime());
		if (false === $this->replace())
		{
			return false;
		}
		
		# Callback
		$this->onAccept($player); 
		
		# Announce
		$player->msg('5236', array($this->getQuestName(), $this->getCityName(), $this->getQuestDescription()));
// 		$player->message(sprintf('You got a new quest: %s.', $this->getQuestName()));
		return true;
	}
	
	public function decline(SR_Player $player)
	{
		if ($this->getOptions() !== 0)
		{
			$player->message('You already declined this quest. (Please report to gizmore, should not see me.)');
			return true;
		}
		
		# Insert
		$this->setOption(self::REJECTED, true);
// 		$this->setVar('sr4qu_date', Shadowrun4::getTime());
		if (false === $this->replace())
		{
			return false;
		}

		# Announce
		$player->msg('5237', array($this->getQuestName()));
// 		$player->message(sprintf('You declined the "%s" quest, forever.', $this->getQuestName()));
		return true;
	}
	
	public function onSolve(SR_Player $player)
	{
		if (!$this->isInQuest($player))
		{
			$player->message('You did not accept this quest yet (should not happen).');
		}
		
		if (true === $this->isDone($player))
		{
			$player->message('You already solved this quest (should not happen).');
			return true;
		}

		# Update
		if (false === $this->saveOption(self::DONE, true))
		{
			return false;
		}
		if (false === $player->increase('sr4pl_quests_done', 1))
		{
			return false;
		}
		
		# Callback
		$this->onQuestSolve($player);
		
		# Easyrewards
		$this->onReward($player);
		
		# Announce
		$player->modify();
		$player->msg('5238', array($this->getQuestName()));
// 		$player->message(sprintf('You have completed a quest: %s.', $this->getQuestName()));
		return true;
	}
	
	public function getStatusString(SR_Player $player)
	{
		if ( $this->isDone($player) )
		{
			return Shadowrun4::lang('qu_done');
// 			return 'done';
		} else if ( $this->isAccepted($player) )
		{
			return Shadowrun4::lang('qu_open');
		} else if ( $this->isDeclined($player) )
		{
			return Shadowrun4::lang('qu_deny');
// 			return 'deny';
		} else if ( $this->isFailed($player) )
		{
			return Shadowrun4::lang('qu_abort');
// 			return 'fail';
		} else if ( $this->isAborted($player) )
		{
			return Shadowrun4::lang('qu_fail');
// 			return 'abort';
		}

		return 'UNKNOWN_QUEST_STATE';
	}

	##############
	### Static ###
	##############
	/**
	 * Get a quest by filename.
	 * @param $player
	 * @param $name
	 * @return SR_Quest
	 */
	public static function getQuest(SR_Player $player, $name)
	{
		$uid = $player->getID();
		$ename = self::escape($name);
		if (false === ($data = self::table(__CLASS__)->selectFirst('*', "sr4qu_uid=$uid AND sr4qu_name='$ename'")))
		{
			$quest = self::createQuest($player, $name);
		}
		else
		{
			$classname = 'Quest_'.$name;
			$quest = new $classname($data);
			$quest instanceof SR_Quest; # code hint
		}
		$quest->setCityName(self::$QUESTS[$name]->getCityName()); # copy cityname
		return $quest;
	}
	
	/**
	 * Include all quests on init. Dies on error.
	 * @param string $entry
	 * @param string $fullpath
	 * @param string $cyityname
	 */
	public static function includeQuest($entry, $fullpath, $cityname='Unknown')
	{
		# Include
		Dog_Log::debug(sprintf('SR_Quest::includeQuest for city "%s" - "%s"', $cityname, $entry));
		require_once $fullpath;
		# Instance 
		$cname = substr($entry,0,-4);
		$classname = 'Quest_'.$cname;
		$quest = new $classname();
		$quest instanceof SR_Quest;
		$quest->setGDOData(array(
			'sr4qu_uid' => '0',
			'sr4qu_name' => $cname,
			'sr4qu_eta' => '0',
			'sr4qu_date' => '0',
			'sr4qu_amount' => '0',
			'sr4qu_data' => NULL,
			'sr4qu_options' => '0',
		));
		$quest instanceof SR_Quest;
		# Setup
		$quest->setCityName($cityname);
		# Global cache
		self::$QUESTS[$cname] = $quest;
	}
	
	/**
	 * Get a quest by enum.
	 * @param SR_Player $player The current player.
	 * @param string $section Section from constant.
	 * @param int $id The enum ID.
	 */
	public static function getByID(SR_Player $player, $section, $id)
	{
		if (!isset(self::$QUEST_FLAGS[$section]))
		{
			return Dog_Log::error(__METHOD__.': Invalid section!');
		}
		$uid = $player->getID();
		$bits_in = self::$QUEST_FLAGS[$section][0];
		$bits_out = self::$QUEST_FLAGS[$section][1];
		$table = self::table(__CLASS__);
		
		$id = (int)$id;
		if ($id < 1)
		{
			return false;
		}
		if (false === ($row = $table->selectFirst('*', "sr4qu_uid={$uid} AND sr4qu_options&{$bits_in}={$bits_out}", 'sr4qu_date ASC', NULL, GDO::ARRAY_A, $id-1)))
		{
			return false;
		}
		
		$classname = 'Quest_'.$row['sr4qu_name'];
		return new $classname($row);
	}
	
	public static function getQuestsBySection(SR_Player $player, $section)
	{
		if (!isset(self::$QUEST_FLAGS[$section])) {
			return false;
		}
		$bits_in = self::$QUEST_FLAGS[$section][0];
		$bits_out = self::$QUEST_FLAGS[$section][1];
		$uid = $player->getID();
		$table = self::table(__CLASS__);
		if (false === ($result = $table->select('*', "sr4qu_uid=$uid AND sr4qu_3options&$bits_in=$bits_out", 'sr4qu_date ASC'))) {
			return false;
		}
		$back = array();
		while (false !== ($row = $table->fetch($result, GDO::ARRAY_A)))
		{
			$classname = 'Quest_'.$row['sr4qu_name'];
			$quest = new $classname($row); 
			$back[] = $quest;
		}
		$table->free($result);
		return $back;
	}
	
	public static function getAllQuests(SR_Player $player)
	{
		$uid = $player->getID();
		$table = self::table(__CLASS__);
		if (false === ($result = $table->select('*', "sr4qu_uid=$uid", 'sr4qu_date ASC')))
		{
			return false;
		}
		$back = array();
		while (false !== ($row = $table->fetch($result, GDO::ARRAY_A)))
		{
			$classname = 'Quest_'.$row['sr4qu_name'];
			$quest = new $classname($row);
			$quest instanceof SR_Quest;
			$quest->setCityName(self::$QUESTS[$row['sr4qu_name']]->getCityName());
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
		return $quest;
	}
	
	public static function deletePlayer(SR_Player $player)
	{
		return self::table(__CLASS__)->deleteWhere('sr4qu_uid='.$player->getID());
	}
	
	public static function optionsToString($opts)
	{
		$a = array();
		if ( $opts & self::ACCEPTED ) { $a[] = 'ACCEPTED'; }
		if ( $opts & self::REJECTED ) { $a[] = 'REJECTED'; }
		if ( $opts & self::DONE ) { $a[] = 'DONE'; }
		if ( $opts & self::FAILED ) { $a[] = 'FAILED'; }
		if ( $opts & self::ABORTED ) { $a[] = 'ABORTED'; }
		if ( $opts & self::PARTY_QUEST ) { $a[] = 'PARTY_QUEST'; }
		return implode('|',$a);
	}
	
	##################
	### Quest Data ###
	##################
	public function getQuestDataBare()
	{
		return $this->getVar('sr4qu_data');
	}

	public function getQuestData()
	{
		if (NULL === ($data = $this->getVar('sr4qu_data')))
		{
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

	#####################
	### Give Questies ###
	#####################
	/**
	 * Give quest items to an NPC.
	 * @param SR_Player $player
	 * @param SR_NPC $npc
	 * @param string $itemname
	 * @param int $have
	 * @param int $need
	 */
	public function giveQuesties(SR_Player $player, SR_NPC $npc, $itemname, $have, $need, $save_amt=false)
	{
		$left = $need - $have;
		$give = 0;
		
		while ($left > 0)
		{
			if (false === ($item = $player->getInvItem($itemname)))
			{
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
			$player->msg('5239', array($give, $itemname, $npc->getName()));
// 			$player->message(sprintf('You hand %d %s(s) to %s.', $give, $itemname, $npc->getName()));
			
			if ($save_amt === true)
			{
				$this->saveAmount($have);
			}
		}
		
		return $have;
	}
	
	################
	### NPCQuest ###
	################
	public function onNPCQuestTalkB(SR_TalkingNPC $npc, SR_Player $player, $word, array $args=NULL)
	{
		switch ($word)
		{
			case 'confirm':
				return $npc->reply('What do you say, chummer?');
				
			case $this->getTrigger():
				return $npc->reply('Description reply for Quest '.$this->getName());
				
			case 'yes':
				return $npc->reply('Accept reply for Quest '.$this->getName());
				
			case 'no':
				return $npc->reply('Deny reply for Quest '.$this->getName());
		}
		return true;
	}
	
	##############
	### Reward ###
	##############
	public function getRewardXP() { return 0; }
	public function getRewardNuyen() { return 0; }
	public function getRewardItems() { return array(); }
	public function displayRewardNuyen() { return Shadowfunc::displayNuyen($this->getRewardNuyen()); }
	
	public function onReward(SR_Player $player)
	{
		if ($player->getLangISO() === 'bot')
		{
			$player->msg('5240', array($this->getQuestName(), $this->getRewardNuyen(), $this->getRewardXP()));
		}
		
		$nystr = $xpstr = $itemstr = '';
		
		# Ny
		if (0 < ($ny = $this->getRewardNuyen()))
		{
			$player->giveNuyen($ny);
			$nystr = ', '.Shadowfunc::displayNuyen($ny);
		}
		
		# XP
		if (0 < ($xp = $this->getRewardXP()))
		{
			$player->giveXP($xp);
			$xpstr = ', '.$xp.' XP';
		}

		# Items
		$items = $this->getRewardItems();
		$giveitems = array();
		foreach ($items as $itemname)
		{
			if (false !== ($item = SR_Item::createByName($itemname)))
			{
// 				$itemstr .= ', '.$itemname;
				$giveitems[] = $item;
			}
			else
			{
				$player->message(sprintf('Cannot create item: %s. (report to gizmore)', $itemname));
			}
		}
		
		$player->giveItems($giveitems, $player->lang('quest_reward'));
		
		if ($player->getLangISO() !== 'bot')
		{
			$out = $nystr.$xpstr;#.$itemstr;
			if ($out !== '')
			{
				$player->msg('5240', substr($out, 2));
	// 			$player->message(sprintf('You received %s.', substr($out, 2)));
			}
		}
	}
	
	public function sendStatusUpdate(SR_Player $player)
	{
		if ($player->getLangISO() === 'bot')
		{
			$player->msg('9002', array($this->getQuestName(), $this->getQuestDescription()));
		}
	}
}
?>
