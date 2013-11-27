<?php
/*
	This file is part of Nimda - An advanced event-driven IRC Bot written in PHP with a nice plugin system
	Copyright (C) 2009  noother [noothy@gmail.com]

	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA
*/

/**
 * @author noother <noothy@gmail.com>
 * @author spaceone <space@wechall.net>
 * @see https://github.com/noother/Nimda
 */
final class HangmanGame {

	private $CONFIG;
	private $lives;
	private $grid;
	private $guesses;
	private $solution;
	private $lastNick;
	private $lastTime;
	private $finish = true;
	private $output = '';

	public function HangmanGame($config) {
		$this->CONFIG = $config;
	}

	/**
	 *
	 * @param string $user the username
	 * @param string|char $message the guess
	 * @return the answer
	 */
	public function onGuess($user, $message)
	{
		$message = trim($message);

		if ($this->finish)
		{
			if ($message === 'false')
			{
				$this->CONFIG['solution_allowed_everytime'] = false;
			}
			$iso = Common::substrFrom($message, ' ', Dog::getChannel()->getLangISO());
			$this->onStartGame($iso);
		}
		
		elseif ($message === '')
		{
			$this->sendOutput('The game has already started');
		}

		else
		{
			 if (GWF_String::strlen($message) !== 1)
			 {
				$this->trySolution($user, $message);
			 }
			 else
			 {
				$this->tryChar($user, $message);
			 }

			 if (GWF_String::toLower($this->grid) === GWF_String::tolower($this->solution))
			 {
				$this->winGame($nick);
			 }
		}
		
		return $this->clearOutput();
	}

	private function clearOutput()
	{
		$output = $this->output;
		$this->output = '';
		return $output;
	}

	private function sendOutput($out)
	{
		$this->output .= $out . " ";
	}

	private function onStartGame($iso)
	{
		if (false === ($this->solution = Hangman_Words::getRandomWord($iso)))
		{
			$this->sendOutput('something went wrong! Database error while selecting a random word! cannot play, sorry!');
			return false;
		}
		$this->sendOutput('Hangman started. ');
		$this->finish = false;
		$this->lastNick = NULL;
		$this->lastTime = time();
		$this->guesses = '';
		
		$length = strlen($this->solution);
		$this->grid = str_pad('',$length,$this->CONFIG['placeholder']);
		$this->sendGrid();
		
		$this->sendOutput(' ');
		
		$this->lives = $this->CONFIG['lives'];
		$this->sendLivesLeft();
	return true;
	}

	private function sendLivesLeft() {
		$str = $this->lives == 1 ? 'life' : 'lives';
		$this->sendOutput(sprintf('%d %s left', $this->lives, $str));
	return true;
	}

	private function testUser($nick) {
		if ($this->CONFIG['singleplayer'])
		{
			return true;
		}

		if(strtolower($nick) == strtolower($this->lastNick)) {
			if (($this->lastTime + 60) > time())
			{
				$this->sendOutput("You can't guess chars twice in a row.");
				return false;
			}
		}
	return true;
	}

	public function tryChar($nick,$char) {
		if(false === $this->testUser($nick)) {
			return;
		}
		
		$charset = 'abcdefghijklmnopqrstuvwxyz';
		if(!stristr($charset,$char)) {
			$this->sendOutput('Charset is a-z.');
			return;
		}

		if (false !== strpos($this->guesses, $char))
		{
			$this->sendOutput(sprintf('The char was already guessed, guessed chars: %s', $this->guesses));
			return;
		}

		$this->guesses .= $char;
		$this->lastNick = $nick;
		$this->lastTime = time();

		if(!stristr($this->solution,$char)) {
			if($this->subLife() === 'lose') return;
			$this->sendOutput("That char doesn't match.");
			$this->sendGrid();
			$this->sendLivesLeft();
			return false;
		}
		
		for($x=0;$x<strlen($this->solution);$x++) {
			if(strtolower($this->solution[$x]) == strtolower($char)) {
				$this->grid[$x] = $this->solution[$x];
			}
		}
		
		$this->sendGrid();
	}

	private static function convertUmlaute($string) {
		$replace = array("ä" => "ae", "ö" => "oe", "ü" => "ue", "Ä" => "Ae", "Ö" => "Oe", "Ü" => "Ue");
		return strtr($string,$replace);
	}

	public function trySolution($nick,$solution) {
		if(!$this->CONFIG['solution_allowed_everytime'] && false === $this->testUser($nick)) {
			return;
		}
		$solution = self::convertUmlaute($solution);
		if(strtolower($solution) != strtolower($this->solution)) {
			if($this->subLife() === "lose") return;
			$this->sendOutput(sprintf('Sorry %s, that was not the correct solution.', $nick));
			$this->lastNick = $nick;
			$this->sendGrid();
			$this->sendLivesLeft();
			return false;
		}
		
		$this->winGame($nick);
	return true;
	}

	private function sendGrid() {
		$this->sendOutput($this->grid);
	return true;
	}

	private function winGame($nick) {
		$send = sprintf('Congrats %s. The solution was: %s',
							$nick,
							$this->solution);
		$this->sendOutput($send);
		
		$this->finish = true;
	return true;
	}

	private function LoseGame() {
		$this->sendOutput('Nobody guessed the solution.');
		$this->showSolution();
		$this->finish = true;
	}

	private function showSolution() {
		$this->sendOutput(sprintf('The correct solution was: %s', $this->solution));
	return;
	}

	private function subLife() {
		$this->lives--;
		if($this->lives == 0) {
			$this->loseGame();
			return 'lose';
		}
	return true;
	}

}
?>
