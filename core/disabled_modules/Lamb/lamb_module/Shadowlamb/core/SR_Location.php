<?php
require_once 'location/SR_Subway.php';
require_once 'location/SR_Tower.php';
require_once 'location/SR_Exit.php';
require_once 'location/SR_Store.php';
require_once 'location/SR_Bank.php';
require_once 'location/SR_Blacksmith.php';
require_once 'location/SR_Hospital.php';
require_once 'location/SR_Hotel.php';
require_once 'location/SR_School.php';
require_once 'location/SR_SecondHandStore.php';

/**
 * The base location class.
 * @author gizmore
 */
abstract class SR_Location
{
	public static $LOCATION_COUNT = 0;
	
	private $name;
	
	public function __construct($name) { $this->name = $name; }
	public function getAbstractClassName() { return __CLASS__; }
	public function getName() { return $this->name; }
	public function getShortName() { return Common::substrFrom($this->name, '_', $this->name); }
	public function getLangfileName() { return $this->getName(); }
	public function getNPCS(SR_Player $player) { return array(); }
	public function getRealNPCS() { return array(); }
	public function getComputers() { return array(); }
	public function getCommands(SR_Player $player) { return array(); }
	public function getFoundPercentage() { return 0.00; }
	public function getFoundText(SR_Player $player) { return $player->lang('stub_found', array($this->getName())); }
	public function getEnterText(SR_Player $player) { return $player->lang('stub_enter', array($this->getName())); }
	public function getHelpText(SR_Player $player) { return $this->getHelpTextNPCs($player); }
//	public function getFoundText(SR_Player $player) { return sprintf('You found %s. There is no description yet.', $this->getName()); }
// 	public function getEnterText(SR_Player $player) { return sprintf('You enter the %s. There is no text yet.', $this->getName()); }
// 	public function getHelpText(SR_Player $player) { return false; }
	public function isPVP() { return false; }
	public function getCity() { return Common::substrUntil($this->getName(), '_'); }
	public function getCityClass() { return Shadowrun4::getCity($this->getCity()); }
	public function hasATM() { return !$this->getCityClass()->isDungeon(); }
	public function onCityEnter(SR_Party $party) { $this->onCleanComputers($party); }
	public function onCityExit(SR_Party $party) {}
	public function onEnterLocation(SR_Party $party) {}
	public function onLeaveLocation(SR_Party $party) {}
	public function isHijackable() { return true; }
	public function getAreaSize() { return 16; }
	public function isEnterAllowed(SR_Player $player) { return true; }
	public function isExitAllowed(SR_Player $player) { return true; }
	public function isEnterAllowedParty(SR_Party $party) { foreach ($party->getMembers() as $m) { if (!($this->isEnterAllowed($m))) return false; } return true; }
	public function isExitAllowedParty(SR_Party $party) { foreach ($party->getMembers() as $m) { if (!($this->isExitAllowed($m))) return false; } return true; }
	public function getLeaderCommands(SR_Player $player) { return $this->isExitAllowedParty($player->getParty()) ? array('hunt','exit','goto','explore') : array(); }
	public function getOpenHour() { return 0; }
	public function getOpenMin() { return 0; } 
	public function getOpenHours() { return 24; }
	public function getOpenMins() { return 0; }
	public function checkOpenTimes(SR_Player $player)
	{
		$realtime = Shadowrun4::getRealTime();
		$hours = explode(':', date('h:i:s', $realtime));
		$h = $hours[0]; $i = $hours[1]; $s = $hours[2];
		
		$hs = $this->getOpenHour();
		$he = $hs + $this->getOpenHours();
		$ms = $this->getOpenMin();
		$me = $ms + $this->getOpenMins();
		
		$start = $hs * 60 + $ms;
		$end = $he * 60 + $me + $start;
		$now = $h * 60 + $i;
		
		if ( ($now >= $start) && ($now <= $end) )
		{
			return true;
		}
		
		$hs = sprintf('%02d', $hs); $he = sprintf('%02d', $he);
		$ms = sprintf('%02d', $ms); $me = sprintf('%02d', $me);
		
		$player->msg('1190', array($this->getName(), $h, $i, $hs, $ms, $he, $me));
		return false;
	}
	
	############
	### Lang ###
	############
	public function displayName(SR_Player $player)
	{
		return $this->getName();
		
		# Overriden by location?
// 		if ($this->hasLang('name'))
// 		{
// 			return $this->lang($player, 'name');
// 		}

// 		# Default classname
// 		$key = strtolower($this->getAbstractClassname());
// 		if (Shadowrun4::hasLang($key))
// 		{
// 			return Shadowrun4::langPlayer($player, $key);
// 		}
		
// 		# Nothing at all :O
// 		return $this->getName();
	}
	
	public function hasLang($key)
	{
		return Shadowlang::hasLangLocation($this, $key);
	}
	
	public function lang(SR_Player $player, $key, $args=NULL)
	{
		return Shadowlang::langLocation($this, $player, $key, $args);
	}
	
	public function partyMessage(SR_Player $player, $key, $args=NULL)
	{
		foreach ($player->getParty()->getMembers() as $member)
		{
			$member instanceof SR_Player;
			$member->message($this->lang($member, $key, $args));
		}
	}
	
	public function partyHelpMessage(SR_Player $player, $key, $args=NULL)
	{
		foreach ($player->getParty()->getMembers() as $member)
		{
			$member instanceof SR_Player;
			$member->help($this->lang($member, $key, $args));
		}
	}
	
	/**
	 * We enter the location and are inside after we message the members.
	 * @param SR_Player $player
	 * @return true
	 */
	public function onEnter(SR_Player $player)
	{
#		if (!$this->checkOpenTimes($player))
#		{
#			return false;
#		}
		
		$party = $player->getParty();
		
		# Messages
		foreach ($party->getMembers() as $member)
		{
			$member instanceof SR_Player;
			
			if (false !== ($text = $this->getEnterText($member)))
			{
				$member->msg('5275', array($text,$this->getName()));
			}
			if (false !== ($text = $this->getHelpText($member)))
			{
				$member->help($text);
			}
		}

		# Enter
		$party->pushAction(SR_Party::ACTION_INSIDE, $this->getName());
		
		return true;
	}
	
	public function diceLocate()
	{
		return Shadowfunc::dicePercent($this->getFoundPercentage());
	}
	
	public function getNPCTalkCommands(SR_Player $player)
	{
		return array_keys($this->getNPCS($player));
	}
	
	public function hasTalkCommand(SR_Player $player, $command)
	{
		return array_key_exists($command, $this->getNPCS($player));#  TalkCommands($player));
	}
	
	/**
	 * Magic method. All unknown commands are handled as talk commands.
	 * @param string $name
	 * @param array $args
	 */
	public function __call($name, $args)
	{
		if ($args !== NULL)
		{
			$player = array_shift($args);
			$args = array_shift($args);;
			$npcs = $this->getNPCS($player);
			$word = count($args) > 0 ? array_shift($args) : '';
			if (isset($npcs[$name]))
			{
				if (false !== ($npc = Shadowrun4::getNPC($npcs[$name])))
				{
					return $npc->onNPCTalkA($player, $word, $args);
				}
			}
		}
				
		Lamb_Log::logError("ERROR: Unknown function '$name'.");
		return false;
	}
	
	public function onCleanComputers(SR_Party $party)
	{
		foreach ($this->getComputers() as $computer)
		{
			if (false !== ($computer = SR_Computer::getInstance($computer, $this)))
			{
				$computer->onReset($party);
			}
		}
	}
	
	/**
	 * Validate location code for errors.
	 */
	public function checkLocation()
	{
		if (false === $this->checkLocationNPCs())
		{
			return false;
		}
		
		# Validate lang file
// 		$player = Shadowrun4::getDummyPlayer();
// 		$this->getEnterText($player);
// 		$this->getHelpText($player);
// 		$this->getFoundText($player);
// 		$this->getName();
		
		return true;
	}
	
	/**
	 * Validate if all NPC exist.
	 */
	private function checkLocationNPCs()
	{
		# Dummy player
		$player = Shadowrun4::getDummyPlayer();
		
		# Validate talking NPCs
		foreach ($this->getNPCS($player) as $tt => $classname)
		{
			if (false === ($npc = Shadowrun4::getNPC($classname)))
			{
				die(sprintf('Location %s is missing talking NPC %s.', $this->getName(), $classname));
				return false;
			}
		}
		
		return true;
	}
	
	public function on_exit(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);

		$party = $player->getParty();
		if (false === Shadowcmd::checkMove($party))
		{
			return false;
		}
	
		$party->pushAction(SR_Party::ACTION_OUTSIDE);
		$party->ntice('5020', array($party->getLocation()));
// 		$party->notice(sprintf('You exit the %s.', $party->getLocation()));
		return true;
	}
	
	
	public function getHelpTextNPCs(SR_Player $player)
	{
		$npcs = $this->getNPCS($player);

		# None
		if (count($npcs) === 0)
		{
			return false;
		}
		
		# Single
		if (count($npcs) === 1)
		{
			$cmd = '#'.key($npcs);
			$classname = array_pop($npcs);
			$npc = Shadowrun4::getNPC($classname);
			$npc->setChatPartner($player);
			return ' '.$player->lang('hlp_talking1', array($cmd, $npc->getName()));
		}
		
		# Multiple
		$cmds = array();
		foreach ($npcs as $cmd => $classname)
		{
			$cmds[] = '#'.$cmd;
		}
		return ' '.$player->lang('hlp_talking2', array(GWF_Array::implodeHuman($cmds)));
	}
}
?>