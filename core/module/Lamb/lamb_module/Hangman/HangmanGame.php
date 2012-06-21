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

class HangmanGame {
	
	private $CONFIG;
	private $IRC;
	private $channel;
	private $MySQL;
	private $info;
	private $lives;
	private $grid;
	private $solution;
	private $lastNick;
	public  $finish = false;
	
	function HangmanGame($plugin,$channel) {
		$this->info		= $plugin->info;
		$this->IRC		= $plugin;
		$this->MySQL	= $plugin->IRCBot->MySQL;
		$this->CONFIG	= $plugin->CONFIG;
		$this->channel	= $channel;
		
		$this->IRC->sendOutput("Hangman started.");
	echo $this->info['channel']." has initiated a new game of Hangman.\n";
		$tmp = $this->MySQL->sendQuery("SELECT word FROM hangman ORDER BY RAND() LIMIT 1");
		$this->solution = $tmp['result'][0]['word'];
	//echo "Solution: ".$this->solution."\n";
		
		$length = strlen($this->solution);
		$grid = str_pad("",$length,$this->CONFIG['placeholder']);
		$this->grid = $grid;
		$this->sendGrid();
		
		$this->lives = $this->CONFIG['lives'];
		$this->sendLivesLeft();
	return true;
	}
	
	function sendLivesLeft() {
		if($this->lives == 1) $str = "life";
		else $str = "lives";
		$this->IRC->sendOutput($this->lives." ".$str." left.");
	return true;
	}
	
	function tryChar($nick,$char) {
		if(strtolower($nick) == strtolower($this->lastNick)) {
			$this->IRC->sendOutput("You can't guess chars twice in a row.");
			return;
		}
		
		$charset = "abcdefghijklmnopqrstuvwxyz";
		if(!stristr($charset,$char)) {
			$this->IRC->sendOutput("Charset is a-z.");
			return;
		}
		
		$this->lastNick = $nick;
		
		if(!stristr($this->solution,$char)) {
			if($this->subLife() === "lose") return;
			$this->IRC->sendOutput("That char doesn't match.");
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
	
	function trySolution($nick,$solution) {
		$solution = libString::convertUmlaute($solution);
		if(strtolower($solution) != strtolower($this->solution)) {
			if($this->subLife() === "lose") return;
			$this->IRC->sendOutput("Sorry ".$nick.", that was not the correct solution.");
			$this->sendGrid();
			$this->sendLivesLeft();
			return false;
		}
		
		$this->winGame($nick);
	return true;
	}
	
	function sendGrid() {
		$this->IRC->sendOutput($this->grid);
	return true;
	}
	
	function winGame($nick) {
		$send = sprintf("Congrats %s. The solution was: %s",
							$nick,
							$this->solution);
		$this->IRC->sendOutput($send);
		
		$this->updateStats($nick);
		
		
		$this->finish = true;
	return true;
	}
	
	function LoseGame() {
		$this->IRC->sendOutput("Nobody guessed the solution.");
		$this->showSolution();
		$this->finish = true;
	}
	
	function showSolution() {
		$this->IRC->sendOutput("The correct solution was: ".$this->solution);
	return;
	}
	
	function subLife() {
		$this->lives--;
		if($this->lives == 0) {
			$this->loseGame();
			return "lose";
		}
	return true;
	}
	
	function updateStats($nick) {
		$sql = "SELECT points FROM hangman_stats WHERE channel='".addslashes($this->channel)."' AND nick='".addslashes($nick)."'";
		$res = $this->MySQL->sendQuery($sql);
		if($res['count'] == 0) {
			$sql = "INSERT INTO 
						hangman_stats 
						(channel, nick, points, created, last_played)
					VALUES (
						'".addslashes($this->channel)."',
						'".addslashes($nick)."',
						1,
						NOW(),
						NOW()
					)";
			$this->MySQL->sendQuery($sql);
			$this->IRC->sendOutput("You've just made your first point. :)");
			return;
		}
		
		$points = $res['result'][0]['points'];
		$sql = "UPDATE
					hangman_stats
				SET
					points=points+1,
					last_played = NOW()
				WHERE 
					nick='".addslashes($nick)."' AND
					channel='".addslashes($this->channel)."'";
		$this->MySQL->sendQuery($sql);
		$this->IRC->sendOutput("You now have ".($points+1)." points.");
	return;
	}
}

?>
