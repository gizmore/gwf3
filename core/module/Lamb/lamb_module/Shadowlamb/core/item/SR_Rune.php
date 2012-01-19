<?php
class SR_Rune extends SR_Item
{
	public function displayType() { return 'Rune'; }
	
	public function isItemStackable() { return false; }
	public function getItemDuration() { return 3600*24*120; } # 120 days
	
	const RUNE_MODIFIER = 0;
	const RUNE_MIN_LEVEL = 1;
	const RUNE_MAX_LEVEL = 2;
	const RUNE_DROP_CHANCE = 3;
	const RUNE_PRICE = 4;
	const RUNE_FAIL_CHANCE = 5;
	const RUNE_BREAK_CHANCE = 6;
	const RUNE_MIN_MODIFIER = 7;
	const RUNE_MAX_MODIFIER = 8;
	
	const RUNE_PRICELESS = 0; # Priceless runes! (essence)
	
	################
	### Runedata ###
	################
	private static $RUNEDATA = array();
	public static function getRuneData()
	{
		if (count(self::$RUNEDATA) === 0) {
			self::initRuneData();
		}
		return self::$RUNEDATA;
	}
	private static function initRuneData()
	{
		### NAME TWICE                               min, maxLEVEL, DROP_C,   PRICE, FAIL_C, BRK_C,  MIN,    MAX
//		self::$RUNEDATA['elephants']  = array('elephants',  3, 200,  20.00,  200.00,  30.00, 12.00,   0.2,    4.0);
//		self::$RUNEDATA['orcas']      = array('orcas',      6, 200,  20.00,  200.00,  30.00, 10.00,   0.2,    4.0);
		self::$RUNEDATA['max_hp']     = array('max_hp',     2, 150,  80.00,  200.00,  10.00,  2.00,   0.2,    3.0);
		self::$RUNEDATA['max_mp']     = array('max_mp',     4, 150,  80.00,  250.00,  10.00,  2.00,   0.2,    6.0);
		self::$RUNEDATA['max_weight'] = array('max_weight', 3, 100, 100.00,  300.00,  15.00,  4.00, 100.0, 3000.0);
//		self::$RUNEDATA['attack']     = array('attack',     5, 100,  60.00,  650.00,  20.00,  6.00,   0.2,    2.0);
		self::$RUNEDATA['attack']     = array('attack',     2,  32,  60.00,  250.00,   1.50,  0.50,   0.5,    5.0);
		self::$RUNEDATA['defense']    = array('defense',    6, 150,  50.00,  900.00,  22.00,  7.00,   0.2,    2.0);
//		self::$RUNEDATA['spellatk']   = array('spellatk',  10, 120,  40.00,  750.00,  20.00,  6.00,   0.2,    2.0);
//		self::$RUNEDATA['spelldef']   = array('spelldef',  	6, 160,  30.00, 1000.00,  22.00,  7.00,   0.2,    2.0);
		self::$RUNEDATA['min_dmg']    = array('min_dmg',   12, 120,  10.00,  900.00,  21.00,  6.50,   0.2,    2.0);
		self::$RUNEDATA['max_dmg']    = array('max_dmg',   10, 110,  20.00,  900.00,  21.00,  6.50,   0.2,    2.0);
		self::$RUNEDATA['marm']       = array('marm',      10, 120,   8.00, 1250.00,  24.00,  8.00,   0.2,    2.0);
		self::$RUNEDATA['farm']       = array('farm',      10, 130,   7.00, 1250.00,  24.00,  8.00,   0.2,    2.0);
		# Mount
		self::$RUNEDATA['lock']       = array('lock',      10, 140,  50.00,  800.00,  25.00,  6.50,   0.2,    2.0);
		self::$RUNEDATA['transport']  = array('transport', 10, 120,  50.00,  600.00,  20.00,  6.50,   0.2,    2.0);
		self::$RUNEDATA['tuneup']     = array('tuneup',    10, 100,  50.00,  400.00,  15.00,  6.50,   0.2,    2.0);
		foreach (SR_Player::$ATTRIBUTE as $a)
		{
			self::$RUNEDATA[$a]       = array($a,           6, 100, 100.00,  400.00,  12.00,  4.00,  0.1,    1.0);
		}
		foreach (SR_Player::$SKILL as $sk)
		{
			self::$RUNEDATA[$sk]      = array($sk,         10, 120,  60.00,  600.00,  16.00,  8.00,  0.1,    2.0);
		}
		foreach (SR_Spell::getSpells() as $sp => $spell)
		{
			self::$RUNEDATA[$sp]      = array($sp,         8, 130,  50.00,  800.00,  18.00,  9.00,  0.5,    3.0);
		}
		
		self::$RUNEDATA['essence']    = array('essence',   2000, 2000,   0.00,  500.00,  45.00, 25.00,  0.1,    1.0);
	}
	
	public static function isMountModifier($key)
	{
		return in_array($key, array('lock', 'transport', 'tuneup'), true);
	}
	
	public static function randModifier(SR_Player $player, $level)
	{
		$total = 0;
		$possible = array();
		$level = (int) $level;
		foreach (self::getRuneData() as $data)
		{
			$minlvl = $data[self::RUNE_MIN_LEVEL];
			if ($level < $minlvl)
			{
				continue;
			}
			$maxlvl = $data[self::RUNE_MAX_LEVEL];
			$range = $maxlvl - $minlvl;
			# Percent of level
			$level = Common::clamp($level, 0, $maxlvl);
			$l = $level - $minlvl;
			$l = $l / $range;
			$dc = round($data[self::RUNE_DROP_CHANCE] * $l * 100);
			if ($dc < 1)
			{
				continue;
			}
			
			$possible[] = array($data, $dc);
			$total += $dc;
		}
		
		if (count($possible) === 0)
		{
			return false;
		}
		
		if (false === ($data = Shadowfunc::randomData($possible, $total, 0)))
		{
			return false;
		}
		
		$minlvl = $data[self::RUNE_MIN_LEVEL];
		$maxlvl = $data[self::RUNE_MAX_LEVEL];
		$range = $maxlvl - $minlvl;
		$l = $level - $minlvl;
		$l = $l / $range;
		$min = $data[self::RUNE_MIN_MODIFIER];
		$max = $data[self::RUNE_MAX_MODIFIER];
		$r = $max-$min;
		$max = $r*$l;
		$power = Shadowfunc::diceFloat($min, $min+$max, 2);
		if ($power < 0.01)
		{
			return false;
		}
//		echo "RUNE POWER $min - $max: $power\n";
		return array($data[self::RUNE_MODIFIER] => $power);
	}
	
	public function calcTotalPrice() { return $this->getItemPriceStatted(); }
	public static function calcPrice(array $modifiers) { return self::calcMod($modifiers, self::RUNE_PRICE); }
	public static function calcFailChance(array $modifiers) { return self::calcMod($modifiers, self::RUNE_FAIL_CHANCE); }
	public static function calcBreakChance(array $modifiers) { return self::calcMod($modifiers, self::RUNE_BREAK_CHANCE); }
	private static function calcMod(array $modifiers, $type)
	{
		$runedata = self::getRuneData();
		$result = 0;
		$i = 1.0;
		foreach ($modifiers as $k => $v)
		{
			if ($k === 'max_weight')
			{
				switch ($type)
				{
					case self::RUNE_PRICE:
					case self::RUNE_FAIL_CHANCE:
					case self::RUNE_BREAK_CHANCE:
						$v /= 1000;
						break;
				}
			}
			
			if (!isset($runedata[$k])) {
				$result += self::RUNE_PRICELESS * $v * $i;
			} else {
				$result += $runedata[$k][$type] * $v * $i;
			}
			$i *= 1.50;
		}
		return round($result, 2);
	}
	
	###################
	### Mount Runes ###
	###################
	public function isMixedRune()
	{
		$have_mount = false;
		$have_equip = false;
		foreach ($this->getItemModifiersB() as $k => $v)
		{
			if ($this->isMountModifier($k))
			{
				$have_mount = true;
			}
			else
			{
				$have_equip = true;
			}
		}
		return $have_mount && $have_equip;
	}
	
	public function isMountRune()
	{
		foreach ($this->getItemModifiersB() as $k => $v)
		{
			if ($this->isMountModifier($k))
			{
				return true;
			}
		}
		return false;
	}
	
}
?>