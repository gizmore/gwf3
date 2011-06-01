<?php
class SR_Rune extends SR_Item
{
	public function displayType() { return 'Rune'; }
	
	public function isItemStackable() { return false; }
	
	const RUNE_MODIFIER = 0;
	const RUNE_LEVEL = 1;
	const RUNE_DROP_CHANCE = 2;
	const RUNE_PRICE = 3;
	const RUNE_FAIL_CHANCE = 4;
	const RUNE_BREAK_CHANCE = 5;
	const RUNE_MIN_MODIFIER = 6;
	const RUNE_MAX_MODIFIER = 7;
	
	const RUNE_PRICELESS = 100000; # Priceless runes! (essence)
	
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
		# LEVEL, DROP_CHANCE, PRICE, FAIL, BREAK
		self::$RUNEDATA['max_hp'] = array('max_hp', 4, 100.00, 200.00, 10.00, 2.00, 0.1, 2.0);
		self::$RUNEDATA['max_mp'] = array('max_mp', 8, 100.00, 250.00, 10.00, 2.00, 0.1, 4.0);
		self::$RUNEDATA['max_weight'] = array('max_weight', 6, 100.00, 300.00, 15.00, 4.00, 10.0, 1000.0);
		self::$RUNEDATA['attack'] = array('attack', 12, 100.00, 750.00, 20.00, 6.00, 0.1, 1.0);
		self::$RUNEDATA['defense'] = array('defense', 16, 100.00, 1000.00, 22.00, 7.00, 0.1, 1.0);
		self::$RUNEDATA['min_dmg'] = array('min_dmg', 24, 50.00, 900.00, 21.00, 6.50, 0.1, 1.0);
		self::$RUNEDATA['max_dmg'] = array('max_dmg', 12, 50.00, 900.00, 21.00, 6.50, 0.1, 1.0);
		self::$RUNEDATA['lock'] = array('max_dmg', 12, 50.00, 900.00, 21.00, 6.50, 0.1, 1.0);
		self::$RUNEDATA['transport'] = array('max_dmg', 12, 50.00, 900.00, 21.00, 6.50, 0.1, 1.0);
		self::$RUNEDATA['max_dmg'] = array('max_dmg', 12, 50.00, 900.00, 21.00, 6.50, 0.1, 1.0);
		self::$RUNEDATA['marm'] = array('marm', 28, 100.00, 1250.00, 24.00, 8.00, 0.1, 1.0);
		self::$RUNEDATA['farm'] = array('farm', 32, 100.00, 1250.00, 24.00, 8.00, 0.1, 1.0);
		
		foreach (SR_Player::$ATTRIBUTE as $a)
		{
			self::$RUNEDATA[$a] = array($a, 8, 100.00, 400.00, 12.00, 4.00, 0.1, 1.0);
		}
		unset(self::$RUNEDATA['essence']);
		
		foreach (SR_Player::$SKILL as $sk)
		{
			self::$RUNEDATA[$sk] = array($sk, 16, 100.00, 600.00, 14.00, 5.00, 0.1, 1.0);
		}
		
		foreach (SR_Spell::getSpells() as $sp => $spell)
		{
			$spell instanceof SR_Spell;
			self::$RUNEDATA[$sp] = array($sp, 12, 100.00, 600.00, 14.00, 5.00, 1, 1);
		}
	}
	
	public static function randModifier(SR_Player $player, $level)
	{
		$total = 0;
		$possible = array();
		$level = (int) $level;
		foreach (self::getRuneData() as $data)
		{
//			if ($level < $data[self::RUNE_LEVEL]) {
//				continue;
//			}
			$l = $data[self::RUNE_LEVEL];
			$l = Common::clamp($level, 0, $l) / $l;
			$dc = round($data[self::RUNE_DROP_CHANCE] * $l * 100);
			if ($dc < 1) {
				continue;
			}
			
			$possible[] = array($data, $dc);
			$total += $dc;
		}
		
		if (count($possible) === 0) {
			return false;
		}
		
		if (false === ($data = Shadowfunc::randomData($possible, $total))) {
			return false;
		}
		
		$l = $data[self::RUNE_LEVEL];
		$l = Common::clamp($level, 0, $l) / $l;
		
		$min = $data[self::RUNE_MIN_MODIFIER]*$l*100;
		$max = $data[self::RUNE_MAX_MODIFIER]*$l*100;
		
		$power = rand($min, $max);
		$power = round($power/100, 1);
		if ($power < 0.1) {
			return false;
		}

		echo "RUNE POWER $min - $max: $power\n";
		
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
			$i *= 1.25;
		}
		return round($result, 2);
	}
	
}
?>