<?php
abstract class SR_Elevator extends SR_Tower
{
	#############
	### Const ###
	#############
	const UP_FLOORS = 22;
	const DOWN_FLOORS = 8;
	const MAX_FLOORS = 31;
	const ALL_BITS = 0x7FFFFFFF;
	const FLOOR_BITS = 0x007FFFFF;
	const CELLAR_BITS = 0x7F800000;
	const PARTERE_BITS = 0x00000001;
	
	############
	### Bits ###
	############
	const FLOOR_PARTERE = 0x00000001;
	const FLOOR_02 = 0x00000002;
/*	const FLOOR_03 = 0x00000004;
	const FLOOR_04 = 0x00000008;
	const FLOOR_05 = 0x00000010;
	const FLOOR_06 = 0x00000020;
	const FLOOR_07 = 0x00000040;
	const FLOOR_08 = 0x00000080;
	const FLOOR_09 = 0x00000100;
	const FLOOR_10 = 0x00000200;
	const FLOOR_11 = 0x00000400;
	const FLOOR_12 = 0x00000800;
	const FLOOR_13 = 0x00001000;
	const FLOOR_14 = 0x00002000;
	const FLOOR_15 = 0x00004000;
	const FLOOR_16 = 0x00008000;
	const FLOOR_17 = 0x00010000;
	const FLOOR_18 = 0x00020000;
	const FLOOR_19 = 0x00040000;
	const FLOOR_20 = 0x00080000;
	const FLOOR_21 = 0x00100000;
	const FLOOR_22 = 0x00200000;
*/	const FLOOR_23 = 0x00400000;
	const FLOOR_C1 = 0x00800000;
/*	const FLOOR_C2 = 0x01000000;
	const FLOOR_C3 = 0x02000000;
	const FLOOR_C4 = 0x04000000;
	const FLOOR_C5 = 0x08000000;
	const FLOOR_C6 = 0x10000000;
	const FLOOR_C7 = 0x20000000;
*/	const FLOOR_C8 = 0x40000000;
//	const FLOOR_BROKE = 0x80000000;

	################
	### Elevator ###
	################
	public function getElevatorTime() { return 30; }
	public function getElevatorMaxKG() { return 250; }
	public function getElevatorDefaultFlags() { return self::PARTERE_BITS; }
	public abstract function getElevatorCity();
	
	################
	### Location ###
	################
	public function isPVP() { return false; }
	public function getFoundPercentage() { return 100.0; }
	public function getEnterText(SR_Player $player) { return sprintf('You enter the %s. A sign reads: "MAX %s KG".', $this->getName(), $this->getElevatorMaxKG()); }
	public function getFoundText(SR_Player $player) { return 'You found an elevator.'; }
	public function getHelpText(SR_Player $player) { return 'In elevators you can use #up, #down and #floor.'; }
	public function getCommands(SR_Player $player) { return array('up','down','floor'); }
	
	#############
	### Flags ###
	#############
	public function getElevatorKey()
	{
		return 'SL_ELEV_'.$this->getElevatorCity();#.'_'.$this->getShortName();
	}
	
	public function getElevatorFlags(SR_Player $player)
	{
		return SR_PlayerVar::getVal($player, $this->getElevatorKey(), $this->getElevatorDefaultFlags());
	}
	
	public function setElevatorFlagsDefault(SR_Party $party)
	{
		return $this->setElevatorFlagsParty($party, $this->getElevatorDefaultFlags(), true);
	}
	
	public function setElevatorFlagsParty(SR_Party $party, $floors=self::ALL_BITS, $bool=false)
	{
		foreach ($party->getMembers() as $member)
		{
			if (false === $this->setElevatorFlags($member, $floors, $bool))
			{
				return false;
			}
		}
		return true;
	}
	
	public function setElevatorFlags(SR_Player $player, $bits, $bool=true)
	{
		$old = $this->getElevatorFlags($player);
		$new = $bool ? $old | $bits : $old & (~$bits);
		return SR_PlayerVar::setVal($player, $this->getElevatorKey(), $new);
	}
	
	##############
	### Floors ###
	##############
	private function getElevatorFloorN($n)
	{
		$cityname = $this->getElevatorCityNameN($n);
		
		if (false === ($city = Shadowrun4::getCity($cityname)))
		{
			return false;
		}
		
		return $city->getLocation($cityname.'_'.$this->getShortName());
	}
	
	private function getElevatorCityNameN($n)
	{
		$c = $this->getElevatorCity();
		if ($n === 0)
		{
			return $c;
		}
		elseif ($n < 0)
		{
			return $c.'C'.abs($n);
		}
		else
		{
			return sprintf('%s%02d', $c, $n+1);
		}
	}
	
	private function getElevatorN()
	{
		$c = $this->getElevatorCity();
		$floor = Common::regex("/^{$c}([C0-9]*)_/", $this->getName());
		if ($floor === '')
		{
			return 0;
		}
		elseif ($floor{0} === 'C')
		{
			return -intval(substr($floor, 1), 10);
		}
		else
		{
			return intval($floor, 10)-1;
		}
	}
	
	private function getElevatorNFromArg(SR_Player $player, $arg)
	{
		if ( ($arg{0}==='E') || ($arg{0}==='e') || ($arg==='0') )
		{
			return 0;
		}
		$multi = 1;
		if ( ($arg{0}==='C') || ($arg{0}==='c') || ($arg{0}==='-') )
		{
			$arg = substr($arg, 1);
			$multi = -1;
		}
		if (!is_numeric($arg))
		{
			return false;
		}
		return $multi * (intval($arg, 10)-1);
	}
	
	private function hasElevatorPermN(SR_Player $player, $n)
	{
		return $this->hasElevatorPermBit($player, $this->getElevatorBitN($player, $n));
	}
	
	private function hasElevatorPermBit(SR_Player $player, $bit)
	{
		$bits = $this->getElevatorFlags($player);
		return ($bits & $bit) === $bit;
	}
	
	private function getElevatorBitN(SR_Player $player, $n)
	{
		return $n < 0 ? self::FLOOR_C1 << (abs($n) - 1) : pow(2, $n);
	}
	
	private function getElevatorButtonFromN($n)
	{
		if ($n == 0)
		{
			return 'E';
		}
		elseif ($n > 0)
		{
			return sprintf('%02d', $n+1);
		}
		else
		{
			return sprintf('C%01d', abs($n));
		}
	}
	
	###############
	### Elevate ###
	###############
	private function onElevate(SR_Player $player, $n=0, $btn='up')
	{
		if (false === ($floor = $this->getElevatorFloorN($n)))
		{
			$player->message('This floor does not exist.');
			return false;
		}
		if (false === $this->hasElevatorPermN($player, $n))
		{
			$player->message('Somehow the elevator is blocking this floor for you.');
			return false;
		}
		
		if ($floor->getName() === $this->getName())
		{
			$player->message('You push the button but you are on the very same floor already.');
			return false;
		}

		$eta = $this->getElevatorTime();
		if (false === ($this->teleport($player, $floor->getName(), $eta)))
		{
			$player->message('Error!');
			return false;
		}
		
		$message = 'Your party pushes the '.$btn.' button and the elevator starts to move. '.Shadowfunc::displayETA($eta);
		return $player->getParty()->notice($message);
	}
	
	################
	### Commands ###
	################
	/**
	 * Move the party one floor up.
	 * @param SR_Player $player
	 * @param array $args
	 * @return true|false
	 */
	public function on_up(SR_Player $player, array $args)
	{
		return $this->onElevate($player, $this->getElevatorN()+1, 'up');
	}
	
	/**
	 * Move the party one floor down.
	 * @param SR_Player $player
	 * @param array $args
	 * @return true|false
	 */
	public function on_down(SR_Player $player, array $args)
	{
		return $this->onElevate($player, $this->getElevatorN()-1, 'down');
	}
	
	/**
	 * Move the party to a specific floor.
	 * @param SR_Player $player
	 * @param array $args
	 * @return true|false
	 */
	public function on_floor(SR_Player $player, array $args)
	{
		if (count($args) === 0)
		{
			return $this->on_floors($player, $args);
		}
		elseif (count($args) === 1)
		{
			$n = $this->getElevatorNFromArg($player, $args[0]);
			return $this->onElevate($player, $n, $this->getElevatorButtonFromN($n));
		}
		else
		{
			$player->message(Shadowhelp::getHelp($player, 'floor'));
		}
	}
	
	/**
	 * Show current and available floors.
	 * @param SR_Player $player
	 * @param array $args
	 * @return true|false
	 */
	public function on_floors(SR_Player $player, array $args)
	{
		$b = chr(2);
		$bot = Shadowrap::instance($player);
		
		$out = '';
		
		# Cellars
		$i = 8;
		$bit = self::FLOOR_C8;
		while ($bit >= self::FLOOR_C1)
		{
			if ($this->hasElevatorPermBit($player, $bit))
			{
				$out .= sprintf(", {$b}C%d{$b}", $i);
			}
			$bit >>= 1;
			$i--;
		}
		# Partere
		if ($this->hasElevatorPermBit($player, self::FLOOR_PARTERE))
		{
			$out .= ", {$b}E{$b}";
		}
		# Upper floors
		$i = 2;
		$bit = self::FLOOR_02;
		while ($bit <= self::FLOOR_23)
		{
			if ($this->hasElevatorPermBit($player, $bit))
			{
				$out .= sprintf(", {$b}%02d{$b}", $i);
			}
			$bit <<= 1;
			$i++;
		}
		
		$out = $out === '' ? '' : substr($out, 2);
		$message = sprintf('You are on %s floor %s. Accessible floors: %s.', $this->getElevatorCity(), $this->getElevatorButtonFromN($this->getElevatorN()), $out);
		return $bot->reply($message);
	}
}
?>