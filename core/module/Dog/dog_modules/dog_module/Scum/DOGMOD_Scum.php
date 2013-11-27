<?php
require_once 'Dog_ScumGame.php';

/**
 * Woho teh scum!
 * @author gizmore
 */
final class DOGMOD_Scum extends Dog_Module
{
	private $games = array();

	public function getOptions()
	{
		return array(
			'max_players' => 'c,h,i,8',
			'reset_time' => 'c,s,i,337',
		);
	}
	
	public function getResetTime() { return $this->getConfig('reset_time', 'c'); }
	public function getMaxPlayers() { return $this->getConfig('max_players', 'c'); }
	
	
	################
	### Commands ###
	################
	public function on_scum_Pc()
	{
		if (false === ($chanel = Dog::getChannel()))
		{
			return Dog::rply('err_only_channel');
		}
		$user = Dog::getUser();
		$msg = $this->msgarg();
		
		$command = Common::substrUntil($msg, ' ', $msg);
		$message = Common::substrFrom($msg, ' ', '');
		
		switch ($command)
		{
			case '':
			case 'help': $out = $this->scumHelp($message); break;
			case 'init': $out = $this->scumInit($user); break;
			case 'join': $out = $this->scumJoin($user); break;
			case 'start': $out = $this->scumStart($user); break;
			case 'cards': $out = $this->scumCards($user); break;
			case 'turn':
			case 'deck': $out = $this->scumDeck($user); break;
			case 'top5': $out = $this->scumTop5($user, $message); break;
			case 'stats':$out = $this->scumStats($user, $message); break;
			case 'abort': $out = $this->scumAbort($user); break;
			case 'pass': $out = $this->scumPass($user); break;
			default: $out = $this->scumPlay($user, $msg, false); break;
		}
		return Dog::reply($out);
	}
	
	##############
	### Errors ###
	##############
	private function errorSlot() { return 'There is no game found in this channel.'; }
	private function errorPrivate() { return 'This command does not work in private.'; }
	private function errorInited() { return 'The game is already inited. You can join the game with '.Dog::getTrigger().'scum join.'; }
	private function errorRunning() { return 'The game is already running. Try '.Dog::getTrigger().'scum abort to abort the current game.'; }
	private function errorAlreadyInGame() { return 'You are already in the game. Try '.Dog::getTrigger().'scum start to start the game.'; }
	private function errorLowPlayers() { return 'There have to be at least 2 players.'; }
	private function errorNotInited() { return 'There is no game initiated. Try '.Dog::getTrigger().'scum init to start a new game.'; }
	private function errorNotRunning() { return 'There is no game running. Try '.Dog::getTrigger().'scum init to start a new game.'; }
	private function errorNotInGame() { return 'You are not in the game. You have to wait for the next round and type '.Dog::getTrigger().'scum join then.'; }
	private function errorNotYourTurn($name, $cards) { return sprintf('It`s not your turn. It`s %s`s turn. Cards on table: %s.', $name, $cards); }
	private function errorAbortTimeout($wait) { return sprintf('Please wait %d seconds until you can abort the game.', $wait); }
	private function errorUser() { return 'This user is unknown.'; }
	private function errorNotPlayed() { return 'This user did not play scum yet.'; }
	
	##############
	### Helper ###
	##############
	private function getGameSlot()
	{
		return Dog::getChannel()->getID();
	}
	
	/**
	 * @param Dog_Server $server
	 * @return Dog_ScumGame
	 */
	private function getGame()
	{
		if (  (false === ($slot = $this->getGameSlot()))
			||(!isset($this->games[$slot])) )
		{
			return false;
		}
		return $this->games[$slot];
	}
	
	############
	### Help ###
	############
	private function scumHelp($topic='')
	{
		$topic = $this->hasTrans('help_'.$topic) ? $topic : 'about';
		return $this->getHelp($topic);
	}
	
	############
	### Init ###
	############
	private function scumInit(Dog_User $user)
	{
		if (false === ($slot = $this->getGameSlot()))
		{
			return $this->errorSlot();
		}
		
		if (!isset($this->games[$slot]))
		{
			$this->games[$slot] = new Dog_ScumGame(Dog::getChannel());
		}
		
		$game = $this->games[$slot];
		$game instanceof Dog_ScumGame;
		
		if ($game->isInited())
		{
			return $this->errorInited();
		}
		if ($game->isRunning())
		{
			return $this->errorRunning();
		}
		
		$game->init();
		
		$game->join($user);
		
		return $this->lang('msg_inited', array($this->getMaxPlayers()-1, Dog::getTrigger()));
	}

	############
	### Join ###
	############
	private function scumJoin(Dog_User $user)
	{
		if (false === ($game = $this->getGame()))
		{
			return $this->errorSlot();
		}
		
		if ($game->isRunning())
		{
			return $this->errorRunning();
		}
		
		if ($game->isInGame($user))
		{
			return $this->errorAlreadyInGame();
		}
		
		if ($game->getPlayerCountStart() >= $this->getMaxPlayers())
		{
			return $this->errorGameFull();
		}
		
		$game->join($user);
		
		$message = sprintf('%s joined the scum.', $user->getVar('user_name'));
		if ($game->getPlayerCountStart() === $this->getMaxPlayers())
		{
			return $message.$this->scumStart($server, $chan_name, $user);
		}
		return $message;
	}
	
	#############
	### Start ###
	#############
	private function scumStart(Dog_User $user)
	{
		if (false === ($game = $this->getGame()))
		{
			return $this->errorSlot();
		}
		
		if ($game->isRunning())
		{
			return $this->errorRunning();
		}
		
		if ($game->getPlayerCountLeft() < 2)
		{
			return $this->errorLowPlayers();
		}
		
		if (!$game->isInGame($user))
		{
			return $this->errorNotInGame();
		}
		
		$game->start();
		
		return sprintf('The scum has started with %s (%d players). %s`s turn.', $game->displayPlayers(), $game->getPlayerCountStart(), $game->getCurrentPlayerName());
	}
	
	#############
	### Cards ###
	#############
	private function scumCards(Dog_User $user)
	{
		if (false === ($game = $this->getGame()))
		{
			return $this->errorSlot();
		}
		
		if (!$game->isRunning())
		{
			return $this->errorNotRunning();
		}

		$user->sendNOTICE($this->lang('your_cards', array($game->displayCards($user))));
	}
	
	###################
	### Turn / Deck ###
	###################
	private function scumDeck(Dog_User $user)
	{
		if (false === ($game = $this->getGame()))
		{
			return $this->errorSlot();
		}
		
		if (!$game->isRunning())
		{
			return $this->errorNotRunning();
		}
		
		$name = $game->getCurrentPlayerName();
		
		if ('' === ($cards = implode(', ', $game->getCurrentCards())))
		{
			$cot = '';
			$turn = sprintf(' %s may come out.', $name);
		}
		else
		{
			$cot = ' Cards on Table: '.$cards.'.';
			$turn = sprintf(' It`s %s`s turn.', $name);
		}
		
		return sprintf('Playing with %d of %d players (%d cards).%s%s', $game->getPlayerCountStart(), $game->getPlayerCountLeft(), $game->getDeckSize(), $cot, $turn); 
	}
	
	#############
	### Abort ###
	#############
	private function scumAbort(Dog_User $user)
	{
		if (false === ($game = $this->getGame()))
		{
			return $this->errorSlot();
		}
		
		if (!$game->isInited())
		{
			return $this->errorNotInited();
		}
		
		if (0 < ($wait = $game->getAbortTime($this->getResetTime())))
		{
			return $this->errorAbortTimeout($wait);
		} 
		
		$game->resetGame();
		
		return $this->lang('msg_aborted');
	}
	
	############
	### Play ###
	############
	private function scumPass(Dog_User $user)
	{
		return $this->scumPlay($user, '', true);
	}
	
	private function scumPlay(Dog_User $user, $message, $pass=false)
	{
		if (false === ($game = $this->getGame()))
		{
			return $this->errorSlot();
		}
		
		if (!$game->isRunning())
		{
			return $this->errorNotRunning();
		}
		
		if (!$game->isInGame($user))
		{
			return $this->errorNotInGame();
		}
		
		if ($game->getCurrentPlayerName() !== $user->getName())
		{
			return $this->errorNotYourTurn($game->getCurrentPlayerName(), implode(', ', $game->getCurrentCards()));
		}
		
		if ($pass === true)
		{
			$game->pass($user);
		}
		else
		{
			$game->output($game->play($user, $message));
		}
		return '';
	}
	
	#############
	### Stats ###
	#############
	private function scumStats(Dog_User $user, $message)
	{
		if ($message !== '')
		{
			if (false === ($user = $this->getGame()->getServer()->getUserByName($message)))
			{
				return $this->errorUser();
			}
		}
		
		if (false === ($row = Dog_ScumStats::getStatsRow($user->getID())))
		{
			return $this->errorNotPlayed();
		}
		
		return $this->lang('msg_stats', array($user->displayName(), $row->getGames(), $row->getWon(), $row->getScore()));
	}
	
	############
	### Top5 ###
	############
	private function scumTop5(Dog_User $user, $section)
	{
		if ($section === '')
		{
			return 'Try score|won|games or a username.';
		}
		
		switch ($section)
		{
			case 'games':
			case 'score':
			case 'won':
				return $this->scumTop5Section($user, $section);
			default:
				return $this->scumTop5Player($user, $section);
		}
	}
	
	private function scumTop5Section(Dog_User $user, $section)
	{
		$section = 'scums_'.$section;
		
		$back = '';
		$table = GDO::table('Dog_ScumStats');
		$entries = $table->selectAll('*', "", "$section DESC", array('user'), 5, -1, GDO::ARRAY_A);
		
		foreach ($entries as $entry)
		{
			$back .= sprintf(', %s!%s(%s)', $entry[$section], $entry['user_name'], $entry['user_sid']);
		}
		
		if ($back === '')
		{
			return 'NO DATA YET!';
		}
		
		$back = 'Scum Top5 '.$section.': '.substr($back, 2);

		return $back;
	}
	
	private function scumTop5Player(Dog_User $user, $username)
	{
		if (false === ($user = Dog::getUserByArg($username)))
		{
			return 'Ùnknown User';
		}
		
		$table = GDO::table('Dog_ScumStats');
		
		if (false === ($entry = $table->selectFirst('*', "scums_userid={$user->getID()}")))
		{
			return 'NO DATA FOR PLAYER YET!';
		}
		
		$sid = $user->getSID();
		$username = $user->getName();
		$games = $entry['scums_games'];
		$won = $entry['scums_won'];
		$score = $entry['scums_score'];
		$rank = $table->selectVar('COUNT(*)', "scums_score>{$score}") + 1;
		
		if (false === ($before = $table->selectFirst('*', "scums_score>{$score}", "scums_score ASC")))
		{
			return sprintf(
				'%s!%s has played %s games, won %s and scores %s points at rank %s. Praise the grand master!',
				$username, $sid, $games, $won, $score, $rank
			);
		}
		
		$scoreB = $before['scums_score'];
		
		return sprintf(
			'%s!%s has played %s games, won %s and scores %s points at rank %s. %s points needed for rankup.',
			$username, $sid, $games, $won, $score, $rank, $scoreB - $score + 1
				
		);
	}
}
