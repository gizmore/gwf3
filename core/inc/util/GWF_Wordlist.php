<?php
/**
 * Wordlist utility (for some challs)
 * @author gizmore
 * @deprecated
 */
class GWF_Wordlist
{
	# return random words out of a wordlist, dont return the same word more than once.
	# @Args: path to wordlist
	#		number of words
	# @Back: array of strings
	public static function getRandomWords($wordlistPath, $amount)
	{
		if (false === ($words = file($wordlistPath))) {
			htmlDisplayError("File not found: $wordlistPath");
			return array();
		}

		if (count($words) < $amount + 3) {
			htmlDisplayError("Wordlist is too small");
			return array();
		}

		$back = array();
		for ($i = 0; $i < $amount; $i++) {

			$index = rand(0, count($words)-1);

			if (isset($back[$index])) {
				$i--;
				continue;
			}

			$back[$index] = trim($words[$index]);

		}

		return $back;

	}

	# Check a wordlist for duplicates
	# @Args: path to wordlist
	# @Back: boolean: true on no duplicates
	public static function checkDuplicates($wordlistPath)
	{
		$file = file($wordlistPath);
		$checked = array();
		$back = true;

		foreach ($file as $word) {

			if (in_array($word, $checked)) {
				htmlDisplayError("Warning: Duplicate entry '$word' in $wordlistPath");
				$back = false;
			}
			else {
				$checked[] = $word;
			}

		}
		return $back;
	}
}


