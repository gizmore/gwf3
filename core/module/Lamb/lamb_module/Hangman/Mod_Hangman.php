<?php
require_once 'Hangman_Words.php';
require_once 'HangmanGame.php';

/**
 * The Lamb module with triggers for Nimdas hangman plugin
 * @author spaceone
 */
final class LambModule_Hangman extends Lamb_Module
{
	private $instances = array();

	################
	### Triggers ###
	################
	public function onInstall()
	{
		GDO::table('Hangman_Words')->createTable(false);
	}
	
	###############
	### Getters ###
	###############
	public function getTriggers($priviledge)
	{
		switch ($priviledge)
		{
			case 'public': return array('hang', '+hang', /* 'hang++', 'hang--'*/);
			case 'halfop': return array('-hang');
			default: return array();
		}
	}
	public function getHelp()
	{
		return array(
			'hang' => 'Usage: %CMD% <char>|"start" Guess a char.',
			'+hang' => 'Usage: %CMD%. Add a Word.',
//			'hang++' => 'Usage: %CMD% <id>. Vote a word up.',
//			'hang--' => 'Usage: %CMD% <id>. Vote a word down.',
			'-hang' => 'Usage: %CMD% <id>. Remove a word from the database.',
		);
	}

	public function onPrivmsg(Lamb_Server $server, Lamb_User $user, $from, $origin, $message)
	{
		# TODO
	}

	private function onAdd($hang_word)
	{
		if (false !== ($word = Hangman_Words::getByWord($hang_word)))
		{
			return 'This word was already in the database.';
		}

		if (false === ($word = Hangman_Words::insertWord($hang_word)))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}

		return sprintf('Inserted Word %s (ID:%d)', $hang_word, $word->getID());
	}

	private function onDelete($hang_word) {
		if (false === ($word = Hangman_Words::getByWord($hang_word)))
		{
			return 'This word does not exists in the database.';
		}
		$id = $word->getID();

		if (false === $word->delete()) # FIXME ?
		{
			return 'database error';
		}

		return sprintf('Deleted Word %s (ID:%d)', $hang_word, $id);
	}

	################
	### Commands ###
	################
	public function onTrigger(Lamb_Server $server, Lamb_User $user, $from, $origin, $command, $message)
	{
		switch ($command)
		{
			case 'hang': $out = $this->onGuess($server, $user, $from, $origin, $message); break;
			case '+hang': $out = $this->onAdd($message); break;
//			case 'hang++': $out = $this->onVote($message, 1); break;
//			case 'hang--': $out = $this->onVote($message, -1); break;
			case '-hang': $out = $this->onDelete($message); break;
		}
		$server->reply($origin, $out);
	}

	private function onGuess(Lamb_Server $server, Lamb_User $user, $from, $origin, $message)
	{
		if (false === isset($this->instances[$server->getID() . $origin]))
		{
			$this->instances[$server->getID() . $origin] = new HangmanGame(array('placeholder' => '*', 'lives' => 8));
		}
		$hang = $this->instances[$server->getID() . $origin];
		$hang instanceof HangmanGame;
		return $hang->onGuess($user->getName(), $message);
	}

}
