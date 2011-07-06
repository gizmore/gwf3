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
	public function getName() { return $this->name; }
	public function getShortName() { return Common::substrFrom($this->name, '_', $this->name); }
	public function getNPCS(SR_Player $player) { return array(); }
	public function getComputers() { return array(); }
	public function getCommands(SR_Player $player) { return array(); }
	public function getLeaderCommands(SR_Player $player) { return array(); }
	public function getFoundPercentage() { return 0.00; }
	public function getFoundText(SR_Player $player) { return sprintf('You found %s. There is no description yet.', $this->getName()); }
	public function getEnterText(SR_Player $player) { return sprintf('You enter the %s. There is no text yet.', $this->getName()); }
	public function getHelpText(SR_Player $player) { return false; }
	public function isPVP() { return false; }
	public function getCity() { return Common::substrUntil($this->getName(), '_'); }
	public function getCityClass() { return Shadowrun4::getCity($this->getCity()); }
	public function hasATM() { return !$this->getCityClass()->isDungeon(); }
	public function onCityEnter(SR_Party $party) { $this->onCleanComputers($party); }
	public function isHijackable() { return true; }
	
	/**
	 * We enter the location and are inside after we message the members.
	 * @param SR_Player $player
	 * @return true
	 */
	public function onEnter(SR_Player $player)
	{
		$party = $player->getParty();
		
		# Messages
		foreach ($party->getMembers() as $member)
		{
			$member instanceof SR_Player;
			
			if (false !== ($text = $this->getEnterText($member)))
			{
				$member->message($text);
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
		$player = array_shift($args);
		$npcs = $this->getNPCS($player);
		$word = isset($args[0][0]) ? $args[0][0] : '';
		if (isset($npcs[$name]))
		{
			if (false !== ($npc = Shadowrun4::getNPC($npcs[$name])))
			{
				
				return $npc->onNPCTalkA($player, $word, $args[0]);
			}
		}
		echo "ERROR: Unknown function '$name'.\n";
		return false;
	}
	
	public function onCleanComputers(SR_Party $party)
	{
		foreach ($this->getComputers() as $computer)
		{
			if (false !== ($computer = SR_Computer::getInstance($computer)))
			{
				$computer->onReset($party);
			}
		}
	}
}
?>