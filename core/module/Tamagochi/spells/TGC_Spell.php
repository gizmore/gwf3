<?php
abstract class TGC_Spell
{
	public $player;
	public $target;
	public $type;
	public $runes;
	public $level;
	public $power;    // %2$s
	public $effect;   // %3$s
	public $duration; // %4$s
	public $mid;
	
	private static $m;
	
	#################
	### Interface ###
	#################
	public abstract function getCodename(); # %1$s SpellName

	public function getMinPower() { return 1; }
	
	public function getCode() { return ''; } # JS Code

	public function canTargetSelf() { return false; }
	public function canTargetOther() { return false; }

	public function beforeCast() {}
	public function afterCast() {}
	
	public function ownMessage() { return self::$m->lang('spell_'.$this->getCodenameLowercase().'_own', array($this->getCodename(), $this->power, $this->effect, $this->duration)); }
	public function meMessage() { return self::$m->lang('spell_'.$this->getCodenameLowercase().'_me', array($this->power, $this->power, $this->effect, $this->duration)); }
	public function otherMessage() { return self::$m->lang('spell_'.$this->getCodenameLowercase().'_other', array($this->power, $this->power, $this->effect, $this->duration)); }
	
	##############
	### Getter ###
	##############
	public function valid() { return $this->runes !== false; }
	public function getSkill() { return $this->type === 'BREW' ? 'priest' : 'wizard'; }
	public function getSpellName() { return implode('', array_slice($this->runes, 1)); }
	public function getCodenameLowercase() { return strtolower($this->getCodename()); }
	
	###############
	### Factory ###
	###############
	public static function factory(TGC_Player $player, TGC_Player $target, $type, $runes, $mid)
	{
		self::$m = Module_Tamagochi::instance();
		
		$runes = explode(',', preg_replace('/[^A-Z,]/', '', $runes));
		$withoutFirst = array_slice($runes, 1);
		$classname = implode('', $withoutFirst);
		$filename = GWF_CORE_PATH."module/Tamagochi/spells/$classname.php";
		if (file_exists($filename) && is_file($filename))
		{
			require_once $filename;
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
		foreach ($runes as $rune)
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
		$len = count(TGC_Const::$RUNES[$row]);
		for ($i = 0; $i < $len; $i++)
		{
			if (TGC_Const::$RUNES[$row][$i] === $rune)
			{
				return $i+1;
			}
		}
		return false;
	}
	
	public function dicePower()
	{
		$this->power = TGC_Logic::dice(1, 20 * $this->level * $this->player->wizardLevel());
		$this->effect = round($this->power / 10.0);
		$this->duration = 10 + $this->power;
	}
	
	#################
	### Cast Dice ###
	#################
	private function failedOfDifficulty()
	{
		$minPower = (int) Common::Clamp($this->getMinPower(), 1);
		$minPower = 20 * $this->level + $minPower;
		echo "LEVEL: $this->level\n";
		echo "POWER: $this->power\n";
		echo "MIN POWER: $minPower\n";
		return $this->power >= $minPower;
	}
	
	private function giveXP($multi=1.0)
	{
		$this->player->giveXP($this->getSkill(), round($this->power * $multi));
	}
	
	############
	### Cast ###
	############
	private function defaultPayload($json, $message=null, $code='')
	{
		return json_encode(array_merge(array(
				'spell' => $this->getSpellName(),
				'player' => $this->player->getName(),
				'target' => $this->target->getName(),
				'runes' => implode(',', $this->runes),
				'level' => $this->level,
				'power' => $this->power,
				'message' => $message,
				'code' => $code,
		), $json));
	}
	
	public function brew()
	{
		$this->player->sendError('ERR_NO_BREW');
	}
	
	public function cast()
	{
		$this->spell();
	}

	public function spell()
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

	public function doCast()
	{
		if ($this->failedOfDifficulty())
		{
			$this->giveXP(0.25);
			$this->player->sendError('ERR_'.$this->type.'_FAILED');
		}
		else
		{
			$this->giveXP(1.00);
			$this->beforeCast();
			$this->executeSpell();
			$this->afterCast();
		}
	}
	

######

	public function executeSpell()
	{
		$this->nothingHappens();
	}
	
	public function nothingHappens()
	{
		if ($this->player === $this->target)
		{
			$this->ownCast($this->getCodename(), self::$m->lang('spell_nothing_own', array($this->getCodename())));
		}
		else
		{
			$this->playerCast($this->getCodename(), self::$m->lang('spell_nothing_me', array($this->getCodename())));
			$this->targetCast($this->getCodename(), self::$m->lang('spell_nothing_other', array($this->getCodename())));
		}
	}
	
	public function executeDefaultCast($json=array())
	{
		if ($this->player === $this->target)
		{
			$this->ownCast($this->getCodename(), $this->ownMessage(), $this->getCode(), $json);
		}
		else
		{
			$this->playerCast($this->getCodename(), $this->meMessage(), '', $json);
			$this->targetCast($this->getCodename(), $this->otherMessage(), $this->getCode(), $json);
		}
	}
	
	public function ownCast($codename, $message=null, $code='', $json=array())
	{
		$payload = $this->defaultPayload($json, $message, $code);
		$this->player->sendCommand($this->type, TGC_Commands::payload($payload, $this->mid));
	
	}
	
	public function playerCast($codename, $message=null, $code='', $json=array())
	{
		return $this->ownCast($codename, $message, $code, $json);
	
	}
	
	public function targetCast($codename, $message=null, $code='', $json=array())
	{
		$payload = $this->defaultPayload($json, $message, $code);
		$this->target->sendCommand($this->type, TGC_Commands::payload($payload, $this->mid));
	
	}
	
}
