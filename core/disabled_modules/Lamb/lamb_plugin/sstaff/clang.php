<?php # Usage: %CMD% [<iso>]. Set or show the channel's language iso and available codes. This does only work in a channel.
$bot = Lamb::instance();
if (false === ($channel = $server = $bot->getCurrentChannel()))
{
	return $bot->getHelp('clang');
}

$code = $message;
$codes = $bot->getISOCodes();
$printcodes = GWF_Array::implodeHuman($codes);

if (false === ($old = $channel->getLangClass()))
{
	return $bot->reply('Database error 1.');
}

if ($message === '')
{
	return $bot->reply(sprintf(
			"This channel is set to \X02%s\X02. Available codes: %s.", 
			$old->displayName(), $printcodes));
}

if (false === in_array($code, $codes))
{
	return $bot->reply(sprintf("\X02Invalid code\X02. Available codes: %s.", $printcodes));
}
elseif (false === ($new = GWF_Language::getByISO($message)))
{
	return $bot->reply('Database error 2.');
}

if ($new->getID() === $old->getID())
{
	return $bot->reply(sprintf(
			"This channel is already set to \X02%s\X02. Available codes: %s.",
			$old->displayName(), $printcodes));
}

if (false === $channel->saveVar('chan_lang', $new->getISO()))
{
	return $bot->reply('Database error 3.');
}

$bot->reply(sprintf("The channel's language has been set to \X02%s\X02.", $new->displayName()));
?>