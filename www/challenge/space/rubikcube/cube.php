<?php

final class Cube
{

	//    [U]
	// [L][F][R][B]
	//    [D]
	const SOLVED_CUBE = '111111111222222222333333333444444444555555555666666666';

	function __construct($cube, $moves=0) {
		$this->cube = $cube;
		$this->moves = $moves;
	}

	public function getMoves()
	{
		return $this->moves;
	}

	public function move($moves)
	{
		$functs = array(
			'X' => 'X',
			'Y' => 'Y',
			'Z' => 'Z',
			'F' => 'front',
			'R' => 'right',
			'B' => 'back',
			'U' => 'up',
			'L' => 'left',
			'D' => 'down',
			'M' => 'middle',
			'E' => 'equatorial',
			'S' => 'standing',
		);

		foreach(explode(' ', $moves) as $move) {
			if ($move === '') {
				continue;
			}
			$count = strpos($move, "'") !== false ? 3 : (strpos($move, '2') !== false ? 2 : 1);
			$move = $move[0];

			if (isset($functs[$move])) {
				$this->_executeMove($functs[$move], $count);
			}
		}
	}

	public function isSolved() {
		$a = array(substr($this->cube, 0, 9), substr($this->cube, 9, 9), substr($this->cube, 18, 9), substr($this->cube, 27, 9), substr($this->cube, 36, 9), substr($this->cube, 45, 9));
		$b = array('111111111', '222222222', '333333333', '444444444', '555555555', '666666666');
		sort($a);
		sort($b);
		return $a === $b;
	}

	private function _executeMove($move, $count) {
		switch($move) {
			case 'X':
			case 'Y':
			case 'Z':
				break;
			default:
				$this->moves++;
				break;
		}
		for ($i=0; $i<$count; $i++) {
			$this->$move();
		}
	}

	private function front() {
		$cube = $this->cube;

		$moves = array(
			6 => 27,
			7 => 30,
			8 => 33,
			27 => 47,
			30 => 46,
			33 => 45,
			45 => 11,
			46 => 14,
			47 => 17,
			11 => 8,
			14 => 7,
			17 => 6,
		);
		foreach ($moves as $key => $val) {
			$cube = substr_replace($cube, $this->cube[$key], $val, 1);
		}
		$cube = substr_replace($cube, $this->rotate(substr($cube, 18, 9)), 18, 9);

		$this->cube = $cube;
	}

	private function rotate($cube, $count=1) {
		for ($i=0; $i < $count; $i++) {
			$cube = $this->_rotate($cube);
		}
		return $cube;
	}

	private function _rotate($ocube, $count=1) {
		$moves = array(
			0 => 2,
			2 => 8,
			8 => 6,
			6 => 0,
			1 => 5,
			5 => 7,
			7 => 3,
			3 => 1,
		);
		$cube = $ocube;
		foreach ($moves as $key => $val) {
			$cube = substr_replace($cube, $ocube[$key], $val, 1);
		}
		return $cube;
	}

	private function X() { // L' R M'
		$this->cube =
			substr($this->cube, 2 * 9, 9) .
			$this->rotate(substr($this->cube, 1 * 9, 9), 3) .
			substr($this->cube, 5 * 9, 9) .
			$this->rotate(substr($this->cube, 3 * 9, 9), 1) .
			$this->rotate(substr($this->cube, 0 * 9, 9), 2) .
			$this->rotate(substr($this->cube, 4 * 9, 9), 2);
	}

	private function Y() { // D' U E'
		$this->cube =
			$this->rotate(substr($this->cube, 0, 9), 1) .
			substr($this->cube, 18, 9) .
			substr($this->cube, 27, 9) .
			substr($this->cube, 36, 9) .
			substr($this->cube, 9, 9) .
			$this->rotate(substr($this->cube, 45, 9), 3);
	}

	private function Z() {
		$this->front();
		$this->back();
		$this->back();
		$this->back();
		$this->standing();
	}

	private function back() {
		$this->Y();
		$this->Y();
		$this->front();
		$this->Y();
		$this->Y();
	}

	private function right() {
		$this->Y();
		$this->front();
		$this->Y();
		$this->Y();
		$this->Y();
	}

	private function left() {
		$this->Y();
		$this->Y();
		$this->Y();
		$this->front();
		$this->Y();
	}

	private function up() {
		$this->X();
		$this->X();
		$this->X();
		$this->front();
		$this->X();
	}

	private function down() {
		$this->X();
		$this->front();
		$this->X();
		$this->X();
		$this->X();
	}

	private function middle() {
		$this->left();
		$this->left();
		$this->left();
		$this->right();
		$this->X();
		$this->X();
		$this->X();
	}

	private function equatorial() {
		$this->up();
		$this->down();
		$this->down();
		$this->down();
		$this->Y();
		$this->Y();
		$this->Y();
	}

	private function standing() {
		$this->Y();
		$this->middle();
		$this->Y();
		$this->Y();
		$this->Y();
	}

	public function __toString() {
		return self::smallCube($this->cube);
		return self::cube2Text($this->cube, true);
	}

	public static function cube2Text($cubes, $ansi=false, $html=false) {
		if ($ansi) {
			$cube = array();
			for ($i=0; $i<strlen($cubes); $i++) {
				$cube[$i] = "\33[";
				switch((int)(strpos(self::SOLVED_CUBE, $cubes[$i]) / 9)) {
					case 0:
						$cube[$i] .= '30;42'; break;  // Green
					case 1:
						$cube[$i] .= '30;41'; break;  // Red
					case 2:
						$cube[$i] .= '30;103'; break;  // Yellow
					case 3:
						$cube[$i] .= '30;43'; break;  // Orange
					case 4:
						$cube[$i] .= '30;47'; break;  // White
					case 5:
						$cube[$i] .= '30;44'; break;  // Blue
				}

				$cube[$i] .= 'm';
				$cube[$i] .= sprintf(' %2s ', $cubes[$i]);
//				$cube[$i] .= sprintf(' %2s ', $i);
				$cube[$i] .= "\x1b[0m";
			}
		} else if ($html) {
			$cube = array();
			for ($i=0; $i<strlen($cubes); $i++) {
				$bg = array(
					0 => 'green',
					1 => 'red',
					2 => 'yellow',
					3 => 'orange',
					4 => 'lightgrey',
					5 => 'blue'
				);
				$bg = $bg[(int)(strpos(self::SOLVED_CUBE, $cubes[$i]) / 9)];
				$cube[$i] = sprintf('<span style="background-color: %s;"> %2s </span>', $bg, $cubes[$i]);
			}
		} else {
			$cube = array();
			for ($i=0; $i<strlen($cubes); $i++) {
				$cube[$i] = sprintf(' %2s ', $cubes[$i]);
			}
		}
		$str = '';
		$str .= sprintf("               /--------------\\\n");
		$str .= sprintf("               |%s|%s|%s|\n", $cube[0], $cube[1], $cube[2]);
		$str .= sprintf("               |----+----+----|\n");
		$str .= sprintf("               |%s|%s|%s|\n", $cube[3], $cube[4], $cube[5]);
		$str .= sprintf("               |----+----+----|\n");
		$str .= sprintf("               |%s|%s|%s|\n", $cube[6], $cube[7], $cube[8]);
	//	$str .= sprintf("               ----------------\n");
		$str .= sprintf("/--------------+--------------+--------------+--------------\\\n");
		$str .= sprintf("|%s|%s|%s|%s|%s|%s|%s|%s|%s|%s|%s|%s|\n", $cube[9], $cube[10], $cube[11], $cube[18], $cube[19], $cube[20], $cube[27], $cube[28], $cube[29], $cube[36], $cube[37], $cube[38]);
		$str .= sprintf("|----+----+----|----+----+----|----+----+----|----+----+----|\n");
		$str .= sprintf("|%s|%s|%s|%s|%s|%s|%s|%s|%s|%s|%s|%s|\n", $cube[12], $cube[13], $cube[14], $cube[21], $cube[22], $cube[23], $cube[30], $cube[31], $cube[32], $cube[39], $cube[40], $cube[41]);
		$str .= sprintf("|----+----+----|----+----+----|----+----+----|----+----+----|\n");
		$str .= sprintf("|%s|%s|%s|%s|%s|%s|%s|%s|%s|%s|%s|%s|\n", $cube[15], $cube[16], $cube[17], $cube[24], $cube[25], $cube[26], $cube[33], $cube[34], $cube[35], $cube[42], $cube[43], $cube[44]);
		$str .= sprintf("\--------------+--------------+--------------+--------------/\n");
	//	$str .= sprintf("               ----------------\n");
		$str .= sprintf("               |%s|%s|%s|\n", $cube[45], $cube[46], $cube[47]);
		$str .= sprintf("               |----+----+----|\n");
		$str .= sprintf("               |%s|%s|%s|\n", $cube[48], $cube[49], $cube[50]);
		$str .= sprintf("               |----+----+----|\n");
		$str .= sprintf("               |%s|%s|%s|\n", $cube[51], $cube[52], $cube[53]);
		$str .= sprintf("               \\--------------/\n");
		return $str;
	}

	public static function smallCube($cubes) {
		$cube = array();
		for ($i=0; $i<strlen($cubes); $i++) {
			$cube[$i] = "\33[";
			switch((int)(strpos(self::SOLVED_CUBE, $cubes[$i]) / 9)) {
				case 0:
					$cube[$i] .= '30;42'; break;  // Green
				case 1:
					$cube[$i] .= '30;41'; break;  // Red
				case 2:
					$cube[$i] .= '30;103'; break;  // Yellow
				case 3:
					$cube[$i] .= '30;43'; break;  // Orange
				case 4:
					$cube[$i] .= '30;47'; break;  // White
				case 5:
					$cube[$i] .= '30;44'; break;  // Blue
			}

			$cube[$i] .= 'm';
			$cube[$i] .= sprintf('  ', $cubes[$i]);
			$cube[$i] .= "\x1b[0m";
		}
		$str = '';
		$str .= sprintf("      %s%s%s\n", $cube[0], $cube[1], $cube[2]);
		$str .= sprintf("      %s%s%s\n", $cube[3], $cube[4], $cube[5]);
		$str .= sprintf("      %s%s%s\n", $cube[6], $cube[7], $cube[8]);
		$str .= sprintf("%s%s%s%s%s%s%s%s%s%s%s%s\n", $cube[9], $cube[10], $cube[11], $cube[18], $cube[19], $cube[20], $cube[27], $cube[28], $cube[29], $cube[36], $cube[37], $cube[38]);
		$str .= sprintf("%s%s%s%s%s%s%s%s%s%s%s%s\n", $cube[12], $cube[13], $cube[14], $cube[21], $cube[22], $cube[23], $cube[30], $cube[31], $cube[32], $cube[39], $cube[40], $cube[41]);
		$str .= sprintf("%s%s%s%s%s%s%s%s%s%s%s%s\n", $cube[15], $cube[16], $cube[17], $cube[24], $cube[25], $cube[26], $cube[33], $cube[34], $cube[35], $cube[42], $cube[43], $cube[44]);
		$str .= sprintf("      %s%s%s\n", $cube[45], $cube[46], $cube[47]);
		$str .= sprintf("      %s%s%s\n", $cube[48], $cube[49], $cube[50]);
		$str .= sprintf("      %s%s%s\n\n", $cube[51], $cube[52], $cube[53]);
		return $str;
	}

}
