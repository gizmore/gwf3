<?php
require_once 'Lamb_ScumGame.php';
require_once 'Lamb_ScumHistory.php';
require_once 'Lamb_ScumStats.php';

/**
 * Woho teh scum!
 * @author gizmore
 */
final class LambModule_Scum extends Lamb_Module
{
	const MAX_PLAYERS = 4;
	const ABORT_TIMEOUT = 337;
	
	private $games = array();
	
	################
	### Triggers ###
	################
	public function onInstall()
	{
		GDO::table('Lamb_ScumHistory')->createTable();
		GDO::table('Lamb_ScumStats')->createTable();
	}
	
	###############
	### Getters ###
	###############
	public function getTriggers($priviledge)
	{
		switch ($priviledge)
		{
			case 'public': return array('scum');
			default: return array();
		}
	}
	
	public function getHelp()
	{
		return array(
			'scum' => 'Scum is a cardgame. Use: %CMD% help to learn how to play.',
		);
	}
	
	################
	### Commands ###
	################
	public function onTrigger(Lamb_Server $server, Lamb_User $user, $from, $channel_name, $command, $msg)
	{
		$bot = Lamb::instance();
		$command = Common::substrUntil($msg, ' ');
		$message = Common::substrFrom($msg, ' ', '');
		switch ($command)
		{
			case 'help':
			case '': $out = $this->scumHelp($message); break;
			case 'init': $out = $this->scumInit($server, $channel_name, $user); break;
			case 'join': $out = $this->scumJoin($server, $channel_name, $user); break;
			case 'start': $out = $this->scumStart($server, $channel_name, $user); break;
			case 'cards': $out = $this->scumCards($server, $channel_name, $user); break;
			case 'turn':
			case 'deck': $out = $this->scumDeck($server, $channel_name, $user); break;
			case 'top5': $out = $this->scumTop5($server, $channel_name, $user, $message); break;
			case 'stats':$out = $this->scumStats($server, $channel_name, $user, $message); break;
			case 'abort': $out = $this->scumAbort($server, $channel_name, $user); break;
			case 'pass': $out = $this->scumPass($server, $channel_name, $user); break;
			default: $out = $this->scumPlay($server, $channel_name, $user, $msg, false); break;
		}
		
		if(empty($out))
		{
			Lamb_Log::logError('!!!Scum output is EMPTY!!!');
		}
		else
		{
			$bot->reply($out);
		}
	}
	
	##############
	### Errors ###
	##############
	private function errorSlot() { return 'Game slot not found.'; }
	private function errorPrivate() { return 'This command does not work in private.'; }
	private function errorInited() { return 'The game is already inited. You can join the game with '.LAMB_TRIGGER.'scum join.'; }
	private function errorRunning() { return 'The game is already running. Try '.LAMB_TRIGGER.'scum abort to abort the current game.'; }
	private function errorAlreadyInGame() { return 'You are already in the game. Try '.LAMB_TRIGGER.'scum start to start the game.'; }
	private function errorLowPlayers() { return 'There have to be at least 2 players.'; }
	private function errorNotInited() { return 'There is no game initiated. Try '.LAMB_TRIGGER.'scum init to start a new game.'; }
	private function errorNotRunning() { return 'There is no game running. Try '.LAMB_TRIGGER.'scum init to start a new game.'; }
	private function errorNotInGame() { return 'You are not in the game. You have to wait for the next round and type '.LAMB_TRIGGER.'scum join then.'; }
	private function errorNotYourTurn($name, $cards) { return sprintf('It`s not your turn. It`s %s`s turn. Cards on table: %s.', $name, $cards); }
	private function errorAbortTimeout($wait) { return sprintf('Please wait %d seconds until you can abort the game.', $wait); }
	private function errorUser() { return 'This user is unknown.'; }
	private function errorNotPlayed() { return 'This user did not play scum yet.'; }
	##############
	### Helper ###
	##############
	private function getGameSlot(Lamb_Server $server, $channel_name)
	{
		if (false === ($channel = $server->getChannel($channel_name))) {
			return false;
		}
		return $server->getID().'-'.$channel->getID();
	}
	
	/**
	 * @param Lamb_Server $server
	 * @param string $channel_name
	 * @return Lamb_ScumGame
	 */
	private function getGame(Lamb_Server $server, $channel_name)
	{
		if (false === ($slot = $this->getGameSlot($server, $channel_name))) {
			return false;
		}
		if (!isset($this->games[$slot])) {
			return false;
		}
		return $this->games[$slot];
	}
	
	############
	### Help ###
	############
	private function scumHelp($topic='')
	{
		$help = array(
			'scum' => 'Scum is a cardgame. Check out the rules at wikipedia: http://en.wikipedia.org/wiki/Asshole_%28game%29. try .scum help commands', 
			'help' => 'Use '.LAMB_TRIGGER.'scum help <command> to get a description for the specified command. Commands: help, init, join, start, abort | cards, pass, <cards to play>',
			'commands' => LAMB_TRIGGER.'scum <commands>: init, join, start, help, cards, turn, deck, top5, stats, abort OR <cards to play>. Type scum help <command> to get more help',
			'init' => LAMB_TRIGGER.'scum init will initiate a new game. Type '.LAMB_TRIGGER.'scum join to join the game.',
			'join' => 'Type '.LAMB_TRIGGER.'scum join to join an initiated game.',
			'start' => LAMB_TRIGGER.'scum start will start the game.',
			'cards' => LAMB_TRIGGER.'scum cards will show you your current cards.',
			'turn' => LAMB_TRIGGER.'scum turn will show info about the current game.',
			'deck' => LAMB_TRIGGER.'scum turn will show info about the current game.',
			'pass' => LAMB_TRIGGER.'scum pass. You pass your turn and it`s the turn of the next player. Use this if you cannot play or want to keep your good cards.',
			'top5' => LAMB_TRIGGER.'scum top5 [section] will show you the best 5 players stats, for an optionally section.',
			'stats' => LAMB_TRIGGER.'scum stats [username] will show a users stats for scum.',
			'abort' => sprintf('You can abort a game after %d seconds of inactivity with %sscum abort.', self::ABORT_TIMEOUT, LAMB_TRIGGER),
		);
		if (!array_key_exists($topic, $help)) {
			$topic = 'scum';
		}
		return $help[$topic];
	}
	
	############
	### Init ###
	############
	private function scumInit(Lamb_Server $server, $channel_name, Lamb_User $user)
	{
		if ($channel_name === $server->getBotsNickname()) {
			return $this->errorPrivate();
		}
		
		if (false === ($slot = $this->getGameSlot($server, $channel_name))) {
			return $this->errorSlot();
		}
		
		if (!isset($this->games[$slot])) {
			$this->games[$slot] = new Lamb_ScumGame($server, $channel_name, $user);
		}
		
		$game = $this->games[$slot]; $game instanceof Lamb_ScumGame;
		
		if ($game->isInited()) {
			return $this->errorInited();
		}
		if ($game->isRunning()) {
			return $this->errorRunning();
		}
		
		$game->init();
		
		$game->join($user);
		
		return sprintf('New game initiated. You joined the scum. 3 more people may type %sscum join.', LAMB_TRIGGER);
	}

	############
	### Join ###
	############
	private function scumJoin(Lamb_Server $server, $channel_name, Lamb_User $user)
	{
		if (false === ($game = $this->getGame($server, $channel_name))) {
			return $this->errorSlot();
		}
		
		if ($game->isRunning()) {
			return $this->errorRunning();
		}
		
		if ($game->isInGame($user)) {
			return $this->errorAlreadyInGame();
		}
		
		if ($game->getPlayerCountStart() >= self::MAX_PLAYERS) {
			return $this->errorGameFull();
		}
		
		$game->join($user);
		
		$message = sprintf('%s joined the scum.', $user->getVar('lusr_name'));
		if ($game->getPlayerCountStart() === self::MAX_PLAYERS) {
			return $message.$this->scumStart($server, $channel_name, $user);
		}
		return $message;
	}
	
	#############
	### Start ###
	#############
	private function scumStart(Lamb_Server $server, $channel_name, Lamb_User $user)
	{
		if (false === ($game = $this->getGame($server, $channel_name))) {
			return $this->errorSlot();
		}
		
		if ($game->isRunning()) {
			return $this->errorRunning();
		}
		
		if ($game->getPlayerCountLeft() < 2) {
			return $this->errorLowPlayers();
		}
		
		$game->start();
		
		return sprintf('The scum has started with %s (%d players). %s`s turn.', $game->displayPlayers(), $game->getPlayerCountStart(), $game->getCurrentPlayerName());
	}
	
	#############
	### Cards ###
	#############
	private function scumCards(Lamb_Server $server, $channel_name, Lamb_User $user)
	{
		if (false === ($game = $this->getGame($server, $channel_name))) {
			return $this->errorSlot();
		}
		
		if (!$game->isRunning()) {
			return $this->errorNotRunning();
		}
		$server->sendNotice($user->getName(), sprintf('Your cards: %s', $game->displayCards($user)));
		return '';
	}
	
	###################
	### Turn / Deck ###
	###################
	private function scumDeck(Lamb_Server $server, $channel_name, Lamb_User $user)
	{
		if (false === ($game = $this->getGame($server, $channel_name))) {
			return $this->errorSlot();
		}
		if (!$game->isRunning()) {
			return $this->errorNotRunning();
		}
		$name = $game->getCurrentPlayerName();
		if ('' === ($cards = implode(', ', $game->getCurrentCards()))) {
			$cot = '';
			$turn = sprintf(' %s may come out.', $name);
		} else {
			$cot = ' Cards on Table: '.$cards.'.';
			$turn = sprintf(' It`s %s`s turn.', $name);
		}
		return sprintf('Playing with %d of %d players (%d cards).%s%s', $game->getPlayerCountStart(), $game->getPlayerCountLeft(), $game->getDeckSize(), $cot, $turn); 
	}
	
	#############
	### Abort ###
	#############
	private function scumAbort(Lamb_Server $server, $channel_name, Lamb_User $user)
	{
		if (false === ($game = $this->getGame($server, $channel_name))) {
			return $this->errorSlot();
		}
		
		if (!$game->isInited()) {
			return $this->errorNotInited();
		}
		
//		if (!$game->isRunning()) {
//			return $this->errorNotRunning();
//		}
		
		if (0 < ($wait = $game->getAbortTime())) {
			return $this->errorAbortTimeout($wait);
		} 
		
		$game->resetGame();
		
		return sprintf('The game has been aborted.');
	}
	
	############
	### Play ###
	############
	private function scumPass(Lamb_Server $server, $channel_name, Lamb_User $user)
	{
		return $this->scumPlay($server, $channel_name, $user, '', true);
	}
	
	private function scumPlay(Lamb_Server $server, $channel_name, Lamb_User $user, $message, $pass=false)
	{
		if (false === ($game = $this->getGame($server, $channel_name))) {
			return $this->errorSlot();
		}
		
		if (!$game->isRunning()) {
			return $this->errorNotRunning();
		}
		
		if (!$game->isInGame($user)) {
			return $this->errorNotInGame();
		}
		
		if ($game->getCurrentPlayerName() !== $user->getName()) {
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
	private function scumStats(Lamb_Server $server, $channel_name, Lamb_User $user, $message)
	{
		if ($message !== '') {
			if (false === ($user = $server->getUserByNickname($message))) {
				return $this->errorUser();
			}
		}
		
		if (false === ($row = Lamb_ScumStats::getStatsRow($user->getID()))) {
			return $this->errorNotPlayed();
		}
		
		return sprintf('%s has played %d games and won %d. Points: %d', $user->getName(), $row->getVar('scums_games'), $row->getVar('scums_won'), $row->getVar('scums_score'));
	}
	
	############
	### Top5 ###
	############
	private function scumTop5(Lamb_Server $server, $channel_name, Lamb_User $user, $message)
	{
		return 'TOTO';
	}
	
	
}
?>