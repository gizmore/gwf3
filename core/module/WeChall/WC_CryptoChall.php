<?php
/**
 * Crypto Challenge Helper Functions
 * @author gizmore
 */
final class WC_CryptoChall
{
	private static $SEARCH = array('0','1','2','3','4','5','6','7','8','9');
	private static $REPLACE = array('G','H','I','R','S','L','M','N','O','P');
	
	public static function generateSolution($random, $letters_only=false, $lowercase=false, $length=12)
	{
		if (false === ($user = GWF_Session::getUser()))
		{
			$username = GWF_Session::getSessID();
		}
		else
		{
			$username = $user->getVar('user_name');
		}
		
		$md5 = strtoupper(md5($random.$random.$username.$random.$random));
		if ($letters_only === true)
		{
			$md5 = str_replace(self::$SEARCH, self::$REPLACE, $md5);
		}
		
		if ($lowercase === true)
		{
			$md5 = strtolower($md5);
		}
		
		return substr($md5, 2, $length);
	}
	
	public static function checkSolution(WC_Challenge $chall, $random, $letters_only=false, $lowercase=false, $length=12)
	{
		if (false === ($answer = Common::getPostString('answer', false)))
		{
			return;
		}
		
		$solution = self::generateSolution($random, $letters_only, $lowercase, $length);
		
		if ($lowercase)
		{
			$answer = strtolower($answer);
		}
		
		$chall->setVar('chall_solution', WC_Challenge::hashSolution($solution, $lowercase));
		$chall->onSolve(GWF_Session::getUser(), $answer);
	}
	
	public static function hexdump($ct)
	{
		$back = '';
		$len = strlen($ct);
		$i = 0;
		
		for($i = 0; $i < $len; $i++)
		{
			$back .= sprintf('%02X', ord($ct{$i}));
			if (($i % 16) === 15)
			{
				$back .= PHP_EOL;
			}
			else
			{
				$back .= ' ';
			}
		}
		
		if (($i % 16) !== 15)
		{
			$back .= PHP_EOL;
		}
		
		return "<pre style=\"font-family: monospace;\">\n".$back."\n</pre>\n";
	}
	
	public static function checkPlaintext($pt, $lowercase=false, $check_utf8=true)
	{
		# Check if all needed letters occur in the plaintext. 
		if ($lowercase === true)
		{
			$need = array('a','b','c','d','e','f','g','h','i','r','s','l','m','n','o','p');
		}
		else
		{
			$need = array('A','B','C','D','E','F','G','H','I','R','S','L','M','N','O','P');
		}
		
		foreach ($need as $c)
		{
			if (false === strpos($pt, $c))
			{
				echo GWF_HTML::error('WCCC', sprintf('The letter %s is missing!', $c), false);
			}
		}
		
		# Check plaintext utf8 lengths
		if ($check_utf8 === true)
		{
			if (mb_strlen($pt, 'UTF8') !== strlen($pt))
			{
				echo GWF_HTML::error('WCCC', sprintf('Error: The plaintext is not extended ascii!'));
			}
		}
	}
}
?>