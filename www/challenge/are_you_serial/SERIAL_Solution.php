<?php
class SERIAL_Solution
{
	public function __wakeup()
	{
		if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
		{
			$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 4, 'challenge/are_you_serial/index.php');
		}
		$chall->onChallengeSolved(GWF_Session::getUserID());
	}
}
?>
