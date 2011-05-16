<?php
require_once 'location/SR_Subway.php';
require_once 'location/SR_Tower.php';
require_once 'location/SR_Store.php';
require_once 'location/SR_Bank.php';
require_once 'location/SR_Blackmarket.php';
require_once 'location/SR_Blacksmith.php';
require_once 'location/SR_Hospital.php';
require_once 'location/SR_Hotel.php';
require_once 'location/SR_School.php';
require_once 'location/SR_SecondHandStore.php';

abstract class SR_Location
{
	public static $LOCATION_COUNT = 0;
	
	private $name;
	
	public function __construct($name) { $this->name = $name; }
	public function getName() { return $this->name; }
	public function getNPCS(SR_Player $player) { return array(); }
	public function getCommands(SR_Player $player) { return array(); }
	public function getLeaderCommands(SR_Player $player) { return array(); }
	public function getFoundPercentage() { return 100.00; }
	public function getFoundText() { return sprintf('You found %s. There is no description yet.', $this->getName()); }
	public function getEnterText(SR_Player $player) { return false; }
	public function getHelpText(SR_Player $player) { return false; }
	public function isPVP() { return false; }
	
	public function onEnter(SR_Player $player)
	{
		$party = $player->getParty();
		
		$party->pushAction(SR_Party::ACTION_INSIDE, $this->getName());
		
		foreach ($party->getMembers() as $member)
		{
			$member instanceof SR_Player;
			if (false !== ($text = $this->getEnterText($member))) {
				$member->message($text);
			}
			if (false !== ($text = $this->getHelpText($member))) {
				$member->help($text);
			}
		}
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
	
	public function __call($name, $args)
	{
		$player = array_shift($args);
		$npcs = $this->getNPCS($player);
		$word = isset($args[0][0]) ? $args[0][0] : '';
		if (isset($npcs[$name]))
		{
			if (false !== ($npc = Shadowrun4::getNPC($npcs[$name])))
			{
				$npc->onNPCTalkA($player, $word);
			}
		}
	}
	
	### Global say
	public function on_say(SR_Player $player, array $args)
	{
		var_dump($args);
	}
	
}
?>