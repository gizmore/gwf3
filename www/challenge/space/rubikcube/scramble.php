<?php

final class Scrambler
{
	static $last = 0;
	static $first = 0;
	static $moves = array(1 => 'U', 2 => 'L', 3 => 'F', 4 => 'D', 5 => 'R', 6 => 'B');
	static $amount = array(1 => '', 2 => '2', 3 => "'", 4 => '2');

	public static function getScrambled($length=35)
	{
		$scramble = '';
		for ($i=0; $i<$length; $i++) {
			$scramble .= self::$moves[self::nextRand()];
			$scramble .= self::$amount[rand(1, 4)];
			$scramble .= ' ';
		}
		return $scramble;
	}

	private static function nextRand()
	{
		$rand = rand(1, 6);
		while ($rand === self::$first && $rand % 3 === self::$last % 3 || $rand === self::$last)
		{
			$rand = rand(1, 6);
		}

		self::$first = self::$last;
		self::$last = $rand;
		return $rand;
	}

	public static function requires20Moves() {
		$f_contents = file("challenge/space/rubikcube/random1000.txt");
		$line = $f_contents[array_rand($f_contents)];
		return str_replace('1', ' ', str_replace('3', "' ", str_replace('2', '2 ', $line)));
	}
}
