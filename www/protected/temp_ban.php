<?php
if (!isset($_SERVER['REMOTE_ADDR'])) {
	return;
}
if ('' === ($bans = file_get_contents('protected/temp_ban.lst.txt'))) {
	return;
}
$ip = $_SERVER['REMOTE_ADDR'];
$bans = explode("\n", $bans);
foreach ($bans as $i => $ban)
{
	$ban = explode(':', $ban);
	if (count($ban) === 2)
	{
		if ($ban[1] === $ip && $ban[0] > time())
		{
			die('You are banned until '.date('Y-m-d H:i:s', $ban[0]).'+UGZ.');
		}
	}
}
?>