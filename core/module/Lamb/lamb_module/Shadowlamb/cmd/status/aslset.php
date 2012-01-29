<?php
require_once 'asl.php';

final class Shadowcmd_aslset extends Shadowcmd_asl
{
	public static function getASLSetHelp(SR_Player $player) { return Shadowhelp::getHelp($player, 'aslset'); }
	
	public static function execute(SR_Player $player, array $args)
	{
		if ($player->getBase('age') > 0)
		{
			$player->msg('1016', array(Shadowfunc::displayASL($player)));
// 			$player->message(sprintf("You already have your asl set to: %s.", Shadowfunc::displayASL($player)));
			return false; 
		}
		
		if (count($args) === 0)
		{
			$player->message(self::getASLSetHelp($player));
			return false; 
		}
		
		if ( (count($args) === 1) && ($args[0] === 'RANDOM') )
		{
			return self::onASLSetRandom($player);
		}
		
		
		$arg = implode(' ', $args);
		$age = round(self::parseValue($arg, 'y'));
		$bmi = round(self::parseValue($arg, 'kg') * 1000);
		$height = self::parseValue($arg, 'cm');
		if ( ($height > 1) && ($height < 2) )
		{
// 			$player->message(sprintf('Auto corrected your height "%.03f" to "%dcm"', $height, round($height*100)));
			$height = round($height*100);
		}
		
		$errors = '';
		$errors .= self::validateAge($player, $age);
		$errors .= self::validateHeight($player, $height);
		$errors .= self::validateBMI($player, $bmi, $height);
		if ($errors !== '')
		{
			$message = sprintf('Error: %s.', $errors);
			self::reply($player, $message);
			$player->message(self::getASLSetHelp($player));
			return false;
		}
		
		return self::onASLSetCustom($player, $age, $bmi, $height);
	}
	
	public static function onASLSetCustom(SR_Player $player, $age, $bmi, $height)
	{
		$age = abs((int)$age);
		$bmi = abs((int)$bmi);
		$height = abs((int)$height);
		if (false === $player->saveVars(array(
			'sr4pl_age' => $age,
			'sr4pl_bmi' => $bmi,
			'sr4pl_height' => $height,
		))) {
			self::reply($player, 'Database errror 12!');
			return false;
		}
		$player->modify();
		return self::reply($player, sprintf('Your asl has been set to %s.', Shadowfunc::displayASL($player)));
	}
	
	public static function onASLSetRandom(SR_Player $player)
	{
		$data = SR_Player::$RACE_BASE[$player->getRace()];
		$rand = Shadowfunc::diceFloat(0.8, 1.2, 2);
		$age = round($data['age']*$rand);
		$age = Common::clamp($age, 18);
		$rand = Shadowfunc::diceFloat(0.8, 1.2, 2);
		$bmi = round($data['bmi']*$rand*1000);
		$height = round($data['height'] * $rand);
		return self::onASLSetCustom($player, $age, $bmi, $height);
	}
	
	
	private static function parseValue($arg, $key)
	{
		if (false === ($back = Common::regex('/(\\d{1,}[\\.,]?\\d{0,3}) *'.$key.'/i', $arg)))
		{
			return -1;
		}
		return floatval(str_replace(',', '.', $back));
	}
	
	private static function validateAge(SR_Player $player, $age)
	{
		if ($age <= 0)
		{
			return ' Your age could not get parsed or is negative. Try 30y.';
		}
		$off = 0.50;
		$a = $player->getRaceBaseVar('age');
		$minage = round($a * (1-$off));
		$minage = Common::clamp($minage, 18);
		$maxage = round($a * (1+$off));
		if ( ($age > $maxage) || ($age < $minage) )
		{
			return sprintf(' The age for a(n) %s should be between %d and %d years.', $player->getRace(), $minage, $maxage);
		}
		return '';
	}
	
	private static function validateHeight(SR_Player $player, $height)
	{
		if ($height <= 0)
		{
			return ' Your height could not get parsed. Try 170cm.';
		}
		$offp = 0.14;
		$offn = 0.18;
		$h = $player->getRaceBaseVar('height');
		$minh = round($h * (1-$offn));
		$maxh = round($h * (1+$offp));
		if ( ($height < $minh) || ($height > $maxh) )
		{
			return sprintf(' The height for a(n) %s should be between %d and %dcm.', $player->getRace(), $minh, $maxh);
		}
		return '';
	}
	
	private static function validateBMI(SR_Player $player, $mass, $height)
	{
		if ($mass <= 0)
		{
			return ' Your own body weight could not get parsed. Try 70kg.';
		}
		$bmi = self::calcBMI($mass, $height);
		if ( ($bmi < 0.5) || ($bmi > 1.5) )
		{
			echo "BMI:{$bmi}}n";
			return sprintf(' Your height (%dcm), compared with your weight(%s) does not match nicely.', $height, Shadowfunc::displayWeight($mass));
		} 
		$offp = 0.50;
		$offn = 0.20;
		$b = $player->getRaceBaseVar('bmi') * 1000;
		$min = round($b * (1-$offn));
		$max = round($b * (1+$offp));
		if ( ($mass < $min) || ($mass > $max) )
		{
			return sprintf(' The body mass for a(n) %s should be between %s and %s.', $player->getRace(), Shadowfunc::displayWeight($min), Shadowfunc::displayWeight($max));
		}
		return '';
	}
	
	public static function calcBMI($bmi, $height)
	{
		return $bmi / 1000 / $height * 2;
	}
}
?>