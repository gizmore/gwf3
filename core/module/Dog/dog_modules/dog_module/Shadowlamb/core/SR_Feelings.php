<?php
/**
 * Manage hunger and thirst.
 * @author gizmore
 *
 */
final class SR_Feelings
{
	const HUNGER_TIMER = 600; // Timer interval seconds
	const REAL_SECONDS_PER_TICK = 6; // Realism seconds
	const DAMAGE_STARTING = 1000; // 10%
	private static $DAMAGES = array(
		'food' => array('5980', 2.0),
		'water' => array('5981', 4.0),
		'sleepy' => array('5982', 3.0),
// 		'cold' => array('5983', 1.5),
// 		'stomach' => array(NULL, 1.0),
	);
	
	public static function isFeelingFine(SR_Player $player) { return (!(self::isHungry($player) || self::isThirsty($player) || self::isSleepy($player) || self::isCold($player))); }
	public static function isHungry(SR_Player $player) { return $player->getBase('food') < self::DAMAGE_STARTING; }
	public static function isThirsty(SR_Player $player) { return $player->getBase('water') < self::DAMAGE_STARTING; }
	public static function isSleepy(SR_Player $player) { return false; }
	public static function isCold(SR_Player $player) { return false; }
	
	/**
	 * Determine how fat you are.
	 */
	public static function getRealBMI(SR_Player $player)
	{
		// 80000 / 180 = 400
		// 450 is more fat
// 		echo "BMI: {$player->getBase('bmi')} / HGT: {$player->getBase('height')}\n";
		return round($player->getBase('bmi') / $player->getBase('height'));
	}
	
	public static function consume(SR_Player $player, SR_Consumable $item)
	{
		self::increaseFood($player, $item->getCalories());
		self::increaseWater($player, $item->getWater());
		self::increaseStomach($player, $item->getLitres());
	}
	
	public static function beforeAction(SR_Player $player)
	{
		$busy = 0;
		if ($busy === 0)
		{
			$busy += self::puke($player);
		}
		if ($busy === 0)
		{
// 			$busy += self::fallAsleep($player);
		}

		return $busy;
	}
	private static function puke(SR_Player $player)
	{
		if ($player->getBase('stomach') > 15000)
		{
			return rand(250, 300);
		}
		return 0;
	}
	
	public static function sleep(SR_Player $player)
	{
		$dayperc = self::getElapsedB(1) / GWF_Time::ONE_DAY;
		self::digestSleep($player, -$dayperc);
		$player->modify();
	}
	
	private static function getElapsed() { return self::getElapsedB(self::HUNGER_TIMER); }
	private static function getElapsedB($seconds) { return $seconds * self::REAL_SECONDS_PER_TICK; }
	public static function timer(SR_Player $player)
	{
		if (!$player->isSleeping())
		{
			// Digest everything.
			self::digest($player);
			$player->modify();
			
			// Kill player
			self::damages($player);
		}
	}
	
	private static function digest(SR_Player $player)
	{
		$elapsed = self::getElapsed();
		$dayperc = $elapsed / GWF_Time::ONE_DAY;
		self::digestStomach($player, $dayperc);
		self::digestFood($player, $dayperc);
		self::digestWater($player, $dayperc);
		self::digestSleep($player, $dayperc);
	}
	
	###############
	### STOMACH ###
	###############
	private static function digestStomach(SR_Player $player, $dayperc)
	{
		$digest = round(self::getMaxStomach($player) * $dayperc);
		self::increaseStomach($player, -$digest);
	}
	
	private static function getStomach(SR_Player $player)
	{
		return self::getMaxStomach($player) * $player->getBase('stomach') / 10000;
	}
	
	private static function getMaxStomach(SR_Player $player)
	{
		// around 3000-5000 millilitres
		return self::getRealBMI($player) * 10;
	}
	
	private static function clampStomach($stomach)
	{
		return Common::clamp(round($stomach), 0, 20000);
	}
	
	private static function increaseStomach(SR_Player $player, $ml)
	{
		$ml = self::getStomach($player) + $ml;
		$perc = self::clampStomach($ml / self::getMaxStomach($player) * 10000);
		$player->saveBase('stomach', $perc);
	}
	
	
	############
	### FOOD ###
	############
	private static function digestFood(SR_Player $player, $dayperc)
	{
		$digest = round(self::getMaxFood($player) * $dayperc);
		self::increaseFood($player, -$digest);
	}
	private static function getFood(SR_Player $player)
	{
		return self::getMaxFood($player) * $player->getBase('food') / 10000;
	}
	private static function getMaxFood(SR_Player $player)
	{
		return self::getRealBMI($player) * 5;
	}
	private static function clampFood($food)
	{
		return Common::clamp(round($food), -10000, 20000);
	}
	private static function increaseFood(SR_Player $player, $kcal)
	{
		$kcal += self::getFood($player);
		$perc = self::clampFood($kcal / self::getMaxFood($player) * 10000);
		$player->saveBase('food', $perc);
	}
	
	#############
	### Water ###
	#############
	private static function digestWater(SR_Player $player, $dayperc)
	{
		$digest = round(self::getMaxWater($player) * $dayperc);
		self::increaseWater($player, -$digest);
	}
	private static function getWater(SR_Player $player)
	{
		return self::getMaxWater($player) * $player->getBase('water') / 10000;
	}
	private static function getMaxWater(SR_Player $player)
	{
		return self::getMaxStomach($player);
	}
	private static function clampWater($food)
	{
		return Common::clamp(round($food), -50000, 10000);
	}
	private static function increaseWater(SR_Player $player, $ml)
	{
		$ml += self::getWater($player);
		$perc = self::clampWater($ml / self::getMaxWater($player) * 10000);
		$player->saveBase('water', $perc);
	}
	
	#############
	### Sleep ###
	#############
	private static function digestSleep(SR_Player $player, $dayperc)
	{
		$digest = round(self::getMaxSleep($player) * $dayperc * 0.5);
		self::increaseSleep($player, -$digest);
	}
	private static function getSleep(SR_Player $player)
	{
		return $player->getBase('sleepy');
	}
	private static function getMaxSleep(SR_Player $player)
	{
		return 5000;
	}
	private static function clampSleep($sleep)
	{
		return Common::clamp(round($sleep), -50000, 10000);
	}
	private static function increaseSleep(SR_Player $player, $ml)
	{
		$ml += self::getSleep($player);
		$perc = self::clampSleep($ml / self::getMaxSleep($player) * 10000);
		$player->saveBase('sleepy', $perc);
	}
	
	###############
	### Damages ###
	###############
	private static function damages(SR_Player $player)
	{
		foreach (self::$DAMAGES as $field => $data)
		{
			self::damage($player, $field, $data);
		}
	}
	
	private static function calcDamage(SR_Player $player, $perc, $dmgperc)
	{
		if ($perc < 0)
		{
			$perc = 10000 + abs($perc);
		}
		
		$damage = $player->getMaxHP() * $dmgperc / 100;
		$damage *= $perc / 10000;
		return $damage;
	}
	
	private static function damage(SR_Player $player, $field, array $data)
	{
		$perc = $player->get($field);
// 		echo "$perc% for $field\n";
		if ($perc < self::DAMAGE_STARTING)
		{
			list($msgkey, $dmgperc) = $data;
			$damage = self::calcDamage($player, $perc, $dmgperc);
			$oldhp = $player->getHP();
			$player->healHP(-$damage);
			$gain = $player->getHP() - $oldhp;
			$maxhp = $player->getMaxHP();
			$player->getParty()->ntice($msgkey, array(
				$player->getEnum(),
				$player->displayName(),
				Shadowfunc::displayHPGain($oldhp, $gain, $maxhp)
			));
		}
	}
	
}
