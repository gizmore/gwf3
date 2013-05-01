<?php # Usage: %CMD% <evil plan>. Gain world domination with your evil plan. TODO: implement.
 
$bot instanceof Lamb;
$server instanceof Lamb_Server;
#$message;

if ($message === '') {
	return $bot->processMessageA($server, LAMB_TRIGGER.'help world_domination', $from);
}

switch (rand(0,5))
{
	case 0:
		$msg = 'This is not bizarroworld.'; break;
	case 1:
		$msg = "Your evil plan failed."; break;
	case 2:
		$msg = sprintf('Syntax error in eval(\'$evil_plan\'); Luckily, the bot did not quit.'); break;
	case 3:
		$msg = sprintf('Evil plan is running. You did not specify a main contact email tho.'); break;
	case 4:
		$msg = sprintf('Evil plan is running.'); break;
	case 5:
		$msg = sprintf('Database error. If you are %s you might have exhausted the evil plan slots.', $user->getName()); break;
}

$bot->reply($msg);
