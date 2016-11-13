<?php
class TGC_Spell
{
	public $player;
	public $target;
	public $type;
	public $runes;
	public $level;
	public $power;
	public $mid;
	
	public function canTargetSelf() { return false; }
	public function canTargetOther() { return false; }
	public function valid() { return $this->runes !== false; }
	
	public function getSpellName() { return implode('', $this->runes); }
	
	###############
	### Factory ###
	###############
	public static function factory(TGC_Player $player, TGC_Player $target, $type, $runes, $mid)
	{
		$runes = preg_replace($runes, '[^A-Z]', '');
		var_dump($runes);
		$classname = $runes;
		$filename = GWF_CORE_PATH."module/Tamagochi/spells/$classname.php";
		if (file_exists($filename) && is_file($filename))
		{
			require $filename;
			$spell = new $classname($player, $target, $type, $runes, $mid);
			if ($spell->valid())
			{
				return $spell;
			}
			else
			{
				$player->sendError('ERR_UNKNOWN_SPELL');
				return false;
			}
		}
		else
		{
			$player->sendError('ERR_UNKNOWN_SPELL');
			return false;
		}
	}
	
	public function __construct(TGC_Player $player, TGC_Player $target, $type, $runes, $mid)
	{
		$this->player = $player;
		$this->target = $target;
		$this->type = $type;
		$this->runes = $this->parseRunes($runes);
		$this->mid = $mid;
		
		$this->dicePower();
	}
	
	private function parseRunes($runes)
	{
		$back = array();
		$row = 0;
		$runes = '';
		foreach (explode(',', $runes) as $rune)
		{
			if (false === ($level = $this->validRune($rune, $row)))
			{
				return false;
			}
			$back[] = $rune;
			if ($row == 0)
			{
				$this->level = $level;
			}
			$row++;
		}
		return $back;
	}
	
	private function validRune($rune, $row)
	{
		$len = count(TGC_Const::$Runes[$row]);
		for ($i = 0; $i < $len; $i++)
		{
			if (TGC_Const::$Runes[$row][$i] === $rune)
			{
				return $i+1;
			}
		}
		return false;
	}
	
	public function dicePower()
	{
		$this->power = TGC_Logic::dice(1, 20 * $this->level * $this->player->wizardLevel());
	}
	
	############
	### Cast ###
	############
	public function doCast()
	{
		$this->nothingHappens();
	}
	
	public function nothingHappens()
	{
		$payload = $this->defaultPayload(array('FAIL' => true));
		$this->player->sendCommand($this->type, TGC_Commands::payload($payload, $mid));
	}
	
	public function defaultCast($json)
	{
		$payload = $this->defaultPayload($json);
		$this->target->sendCommand($this->type, TGC_Commands::payload($payload, $mid));
		$this->player->sendCommand($this->type, TGC_Commands::payload($payload, $mid));
	}
	
	private function defaultPayload($json)
	{
		return json_encode(array_merge(array(
				'spell' => $this->getSpellName(),
				'player' => $this->player->getName(),
				'target' => $this->target->getName(),
				'runes' => $this->runes,
				'level' => $this->level,
				'power' => $this->power,
		), $json));
	}
	
	public function cast()
	{
		if ($this->target == $this->player)
		{
			if (!$this->canTargetSelf())
			{
				$this->player->sendError('ERR_'.$this->type.'_SELF');
			}
			else
			{
				$this->doCast();
			}
		}
		else
		{
			if (!$this->canTargetOther())
			{
				$this->player->sendError('ERR_'.$this->type.'_OTHER');
			}
			else
			{
				$this->doCast();
			}
		}
	}
	
}
