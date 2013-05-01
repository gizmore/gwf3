<?php # Usage: %CMD% [<iso>]. Set or show the server's iso and available codes.
$bot = Lamb::instance();
if (false === ($server = $bot->getCurrentServer()))
{
	return $bot->reply('Database error 1.');
}

$code = $message;
$codes = $bot->getISOCodes();
$printcodes = GWF_Array::implodeHuman($codes);

if (false === ($old = $server->getLangClass()))
{
	return $bot->reply('Database error 2.');
}

if ($message === '')
{
	return $bot->reply(sprintf(
			"This server is set to \X02%s\X02. Available codes: %s.",
			$old->displayName(), $printcodes));
}

if (false === in_array($code, $codes))
{
	return $bot->reply(sprintf("\X02Invalid code\X02. Available codes: %s.", $printcodes));
}
elseif (false === ($new = GWF_Language::getByISO($message)))
{
	return $bot->reply('Database error 3.');
}

if ($new->getID() === $old->getID())
{
	return $bot->reply(sprintf(
			"This server is already set to \X02%s\X02. Available codes: %s.",
			$old->displayName(), $printcodes));
}

if (false === $server->saveVar('serv_lang', $new->getISO()))
{
	return $bot->reply('Database error 4.');
}

$bot->reply(sprintf("The server's language has been set to \X02%s\X02.", $new->displayName()));
?>