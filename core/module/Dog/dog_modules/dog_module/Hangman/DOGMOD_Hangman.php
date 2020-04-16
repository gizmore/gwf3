<?php
require_once 'HangmanGame.php';
/**
 * The Dog module with triggers for Nimdas hangman plugin.
 * @version 4.0
 * @author spaceone
 * @author noother
 * @author gizmore
 */
final class DOGMOD_Hangman extends Dog_Module
{
	private $instances = array();
	
	public static $PUNCTUATION = array(' ', '.', ',', '!', '?');

	public function getOptions()
	{
		return array(
			'solve_anytime' => 'c,o,b,1', # channel operator boolean
			'placeholder' => 'c,o,s,*',   # channel operator string
			'lives' => 'c,o,i,8',         # channel operator integer
			'singleplayer' => 'c,o,b,1',  # channel operator boolean
		);
	}

	public function on_ADDhang_Pc()
	{
		$hang_word = trim($this->msgarg());
		
		$iso = Dog::getChannel()->getLangISO();
		
		if (GWF_String::strlen($hang_word) < 6 || GWF_String::strlen($hang_word) > 100)
		{
			return $this->rply('err_wordlen', array(6, 100));
		}

		$punctuation = implode('', self::$PUNCTUATION);
		if (!preg_match('/^[üäößa-z'.$punctuation.']+$/Diu', $hang_word))
		{
			return $this->rply('err_alpha');
		}

		if (false !== ($word = Hangman_Words::getByWord($hang_word)))
		{
			return $this->rply('err_dup');
		}

		if (false === ($word = Hangman_Words::insertWord($hang_word, $iso)))
		{
			return Dog::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$this->rply('msg_added', array($hang_word, $word->getID()));
	}

	public function on_REMOVEhang_Hb()
	{
		$hang_word = $this->msgarg();
		
		if (  (false === ($word = Hangman_Words::getByWord($hang_word)))
			&&(false === ($word = Hangman_Words::getByID($hang_word))) )
		{
			return $this->rply('err_word');
		}
		
		$id = $word->getID();

		if (false === $word->delete())
		{
			return Dog::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}

		return $this->rply('msg_deleted', array($word->getVar('hangman_text'), $id));
	}

	public function on_hang_Pc()
	{
		$channel = Dog::getChannel();
		
		if (false === isset($this->instances[$channel->getID()]))
		{
			$config = array(
				'solution_allowed_everytime' => $this->getConfig('solve_anytime', 'c') === 1,
				'placeholder' => $this->getConfig('placeholder', 'c'),
				'lives' => $this->getConfig('lives', 'c'),
				'singleplayer' => $this->getConfig('singleplayer', 'c') == 1,
			);
			$this->instances[$channel->getID()] = new HangmanGame($config);
		}
		$hang = $this->instances[$channel->getID()];
		$hang instanceof HangmanGame;
		$this->reply($hang->onGuess(Dog::getUser()->getName(), $this->msgarg()));
	}
}
