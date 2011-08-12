<?php # Usage: %CMD% <username>. Show the last message from a user.
$bot instanceof Lamb;
$user instanceof Lamb_User; 
$server instanceof Lamb_Server;
$username = Common::substrUntil($message, ' ', $message);
if ($username === '')
{
	return $bot->processMessageA($server, LAMB_TRIGGER.'help seen', $from);
}
if (!preg_match('/^[a-z0-9_\\[\\]]+$/i', $username))
{
	return $bot->getHelp('seen');
}

$eu = GDO::escape($username);
$sid = $server->getID();
if (false === ($user = GDO::table('Lamb_User')->selectFirstObject('*', "lusr_name='$eu' AND lusr_sid=$sid"))) {
	return $bot->reply(sprintf('The user %s is unknown.', $username));
}

$timestamp = $user->getVar('lusr_timestamp');
$date = GWF_Time::getDate(GWF_Date::LEN_SECOND, $timestamp);
$ago = time() - $timestamp;
$ago = GWF_Time::humanDuration($ago);
//$bot->reply(sprintf('I have seen %s %s ago in %s saying: "%s".', $username, GWF_Time::displayAge($user->getVar('lusr_last_date')), $user->getVar('lusr_last_channel'), $user->getVar('lusr_last_message')));
$bot->reply(sprintf('I have seen %s at %s (%s ago) in %s saying: "%s".', $username, GWF_Time::displayDate($date), $ago, $user->getVar('lusr_last_channel'), $user->getVar('lusr_last_message')));
?>