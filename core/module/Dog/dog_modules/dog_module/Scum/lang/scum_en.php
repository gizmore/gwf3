<?php
$lang = array(
	'conf_max_players' => 'Max number of players. Should be a multiple of 4.',
	'conf_reset_time' => 'Game idle time required to allow a reset.',
		
	'help_scum' => 'Scum is a cardgame. Use: %CMD% help to learn how to play.',
	'help_about' => 'Scum is a cardgame. Check out the rules at wikipedia: http://en.wikipedia.org/wiki/Asshole_%28game%29. Try .scum help commands',
	'help_help' => 'Use %T%scum help <command> to get a description for the specified command. Commands: help, init, join, start, abort | cards, pass, <cards to play>',
	'help_commands' => '%T%scum <commands>: init, join, start, help, cards, turn, deck, top5, stats, abort OR <cards to play>. Type scum help <command> to get more help',
	'help_init' => '%T%scum init will initiate a new game. Type %T%scum join to join the game.',
	'help_join' => 'Type %T%scum join to join an initiated game.',
	'help_start' => '%T%scum start will start the game.',
	'help_cards' => '%T%scum cards will show you your current cards.',
	'help_turn' => '%T%scum turn will show info about the current game.',
	'help_deck' => '%T%scum turn will show info about the current game.',
	'help_pass' => '%T%scum pass. You pass your turn and it`s the turn of the next player. Use this if you cannot play or want to keep your good cards.',
	'help_top5' => '%T%scum top5 [section] will show you the best 5 players stats, for an optionally section.',
	'help_stats' => '%T%scum stats [username] will show a users stats for scum.',
	'help_abort' => 'You can abort a game after inactivity with %T%scum abort.',

	'msg_stats' => '%s has played %d games and won %d. Points: %d',
	'msg_inited' => 'New game initiated. You joined the scum. %d more people may type %sscum join.',
	'msg_aborted' => 'The game has been aborted.',
		
	'your_cards' => 'Your cards: %s.',
);
?>
