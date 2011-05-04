<?php
final class Lamb_ScumGame
{
	private static $ranks = array('1st','2nd','3rd','4th','5th','6th','7th','8th');
	private static $card_numbers = array('7','8','9','10','J','Q','K','A');

	private $history = NULL;
	private $stats = NULL;
	
	/**
	 * @var Lamb_Server
	 */
	private $server = NULL;
	private $channel = '';
	
	private $decksize = 1;
	private $inited  = false;         # A game was initiated.
	private $started = false;         # The game is running.
	private $beginner = 0;            # The player that came out.
	private $current  = 0;            # The current player.
	private $current_cards = array(); # The cards on table.
	private $players = array();       # The players.
	private $pc_start = 0;            # The playercount at start.
	private $cards   = array();       # The players cards arrays. 
	private $icards  = array();       # The players initial cards arrays. 
	private $winners = array();       # The winning order.
	private $cmdtime = 0;             # Last command time

	public function __construct(Lamb_Server $server, $channel_name, Lamb_User $user)
	{
		$this->server = $server;
		$this->channel = $channel_name;
	}
	
	public function resetGame()
	{
		$this->decksize = 1;
		$this->inited = false;
		$this->started = false;
		$this->beginner = 0;
		$this->current = 0;
		$this->current_cards = array();
		$this->players = array();
		$this->pc_start = 0;
		$this->cards = array();
		$this->icards = array();
		$this->winners = array();
		$this->cmdtime = time();
	}
	
	###############
	### Getters ###
	###############
	public function isInited() { return $this->inited; }
	public function isRunning() { return $this->started; }
	public function getPlayerCountLeft() { return count($this->players); }
	public function getPlayerCountStart() { return $this->pc_start; }
	public function isInGame(Lamb_User $user) { return in_array($user->getName(), $this->players, true); }
	public function join(Lamb_User $user) { $this->players[] = $user->getName(); }
	public function getCurrentCards() { return $this->current_cards; }
	public function getCurrentPlayerName() { return $this->players[$this->current]; }
	public function getDeckSize() { return $this->decksize * 32; }
	public function getDeckCount() { return $this->decksize; }
	public function getAbortTime() { return $this->cmdtime+LambModule_Scum::ABORT_TIMEOUT - time(); }
	/**
	 * @return Lamb_Channel
	 */
	public function getChannel() { return $this->server->getChannel($this->channel); }
	public function getWinners() { return $this->winners; }
	/**
	 * @return Lamb_Server
	 */
	public function getServer() { return $this->server; }
	public function getChannelName() { return $this->channel; }
	public function displayPlayers() { return implode(', ', $this->players); }
	public function getCards(Lamb_User $user) { return $this->cards[array_search($user->getName(), $this->players)]; }
	public function displayCards(Lamb_User $user) { return implode(', ', $this->getCards($user)); }
	public function output($message) { $this->server->sendPrivmsg($this->channel, $message); }
	
	############
	### Sort ###
	############
	public function cardsort($a, $b)
	{
		foreach (self::$card_numbers as $key => $value)
		{
			if ($a == $value) { return 0; }
			if ($b == $value) { return 1; }
		}
	}
	
	#############
	### Logic ###
	#############
	public function init()
	{
		$this->inited = true;
		$this->cmdtime = time();
	}
	
	public function start()
	{
		$this->started = true;
		$this->cmdtime = time();
		$this->pc_start = count($this->players);
		
		# History
		$this->history = new Lamb_ScumHistory(array(
			'scumh_id' => 0,
			'scumh_server' => $this->server->getID(),
			'scumh_channel' => $this->getChannel()->getID(),
			'scumh_players' => implode(',', $this->players),
		));
		
		# Random Beginner
		shuffle($this->players);
		
		# Fill history
		$this->history->setVar('scumh_order', implode(',', $this->players));
		
		# Create Card-Deck
		$pc = $this->getPlayerCountStart();
		$one_deck = array_merge(self::$card_numbers, self::$card_numbers, self::$card_numbers, self::$card_numbers);
		$this->decksize = intval(($pc-1)/4)+1;
		$all_cards = array();
		for ($i = 0; $i < $this->decksize; $i++) {
			$all_cards = array_merge($all_cards, $one_deck);
		}
		
		# Shuffle the deck
		shuffle($all_cards);
		
		# Give cards
		$history_csv = '';
		foreach ($this->players as $i => $name)
		{
			$this->cards[$i] = array_slice($all_cards, $i*8, 8);
			usort($this->cards[$i], array($this, 'cardsort'));
			$this->icards[$i] = $this->cards[$i];
			$this->server->sendNotice($name, sprintf('Your cards: %s', implode(', ', $this->cards[$i])));
			$history_csv .= ';'.implode(',', $this->cards[$i]);
	  	}
	  	$this->history->setVar('scumh_cards', substr($history_csv, 1));
	}
	
	############
	### Play ###
	############
	public function pass(Lamb_User $user)
	{
		$this->cmdtime = time();
		$name = $user->getName();
		$msg = "$name passes.";
		$this->next_player();
		if ($this->beginner == $this->current)
		{
			$name = $this->players[$this->current];
			$msg .= " $name wins this round. $name's turn.";
			$this->current_cards = array();
		}
		else { $msg .= " ".$this->players[$this->current]."'s turn."; }
		
		$this->output($msg);
		
		return '';
	}
	
	public function play(Lamb_User $user, $message)
	{
		$this->cmdtime = time();
		# Command
		$message = strtoupper($message);
		if (0 === preg_match('/^[ ,78910JQKA]+$/', $message)) {
			return 'Error in play syntax!';
		}
		$cards = preg_split('/[, ]+/', $message);
		$pn = $this->current;
		$cc = $this->current_cards;
		
		# Identical cards?
		if (count(array_unique($cards)) !== 1) { return 'You have to play only 1 kind of a card.'; }
		
		# Player has these cards?
		$acv = array_count_values($this->cards[$pn]);
		$check = $cards[0];
		if ($check > 0) { $check = (int)$check; }
		if ( (!isset($acv[$check])) || (count($cards) > $acv[$check]) ) { return 'You dont have the right cards.'; }
		
		# Cards are on table.
		if (count($cc) > 0)
		{
			# Played same ammount of cards:
			if (count($cc) !== count($cards)) {
				return 'You have to play the same number of cards';
			}
			# Are played cards higher?
			if (array_search($cc[0], self::$card_numbers) >= array_search($cards[0], self::$card_numbers)) {
				return sprintf('You have to play higher cards than %s.', implode(" ", $cc));
			}
		}
		
		#########################
		# All ok => play cards:
		foreach ($cards as $card)
		{
			$key = array_search($card, $this->cards[$pn]);
			unset($this->cards[$pn][$key]);
		}
		$this->cards[$pn] = array_values($this->cards[$pn]);
		$cards_left = count($this->cards[$pn]);
		$msg = sprintf('%s played %s and has %d cards left.', $user->getName(), implode(' ', $cards), $cards_left);
		$this->output($msg);

		# Player finished:
		if ($cards_left === 0)
		{ 
			$this->player_finished($user->getName());
			
			if (!($this->started)) {
				return '';
			}
			if ($cards[0] == "A") {
				$this->current_cards = array();
			}
			else {
				$this->current_cards = $cards;
			}
			
			$this->beginner = $this->current;
			$this->output(sprintf('%s`s turn.', $this->players[$this->current]));
		}

		# Player played ace and won round:
		else if ($cards[0] == "A") {
			$this->player_wins_round();
		}
		
		# Player raised current cards:
		else {
			$this->current_cards = $cards;
			$this->beginner = $this->current;
			$this->next_player();
			$this->output(sprintf('%s`s turn.', $this->players[$this->current]));
		}
		
		return '';
	}

	private function next_player()
	{
		$num_players = count($this->players);

		$this->current++;
		if ($this->current === $num_players) {
			$this->current = 0;
		}
	}
	
	private function player_finished($name)
	{
		$rank = count($this->winners);
		$this->winners[] = $name;
		unset( $this->players[$this->current] );
		unset( $this->cards[$this->current] );
		$cards = implode(', ', $this->icards[$this->current]);
		unset( $this->icards[$this->current] );
		$this->players = array_values( $this->players );
		$this->cards = array_values( $this->cards );
		$this->icards = array_values( $this->icards );
		$this->output("$name got ".self::$ranks[$rank]." ($cards).");
		if (count( $this->players ) == 1) {
			$rank++;
			$name = $this->players[0];
			$this->winners[] = $name;
			$rank = self::$ranks[$rank];
			$cards = implode(', ', $this->icards[0]);
			$this->output("$name got $rank ($cards). Game over.");
			$this->game_over();
			return;
		}
		$this->current--;
		$this->next_player();
		$this->beginner = $this->current;
	}
	
	private function player_wins_round()
	{
		$name = $this->players[$this->current];
		$this->beginner = $this->current;
		$this->current_cards = array();
		$this->output("$name wins this round. $name's turn.");
	}
	
	private function game_over()
	{
		Lamb_ScumStats::updateScumStats($this);
		$this->history->setVar('scumh_winners', implode(',', $this->winners));
		$this->history->insert();
		$this->resetGame();
	}
	
}
?>