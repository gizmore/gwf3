<?php # Usage: %CMD% [<iso>]. Set your bot's language or list the known iso codes.
$bot = Lamb::instance();

# Gather ISO codes
$iso_codes = explode(';', GWF_SUPPORTED_LANGS);
$iso_codes[] = 'bot'; # Special bot and custom client language.
array_map('strtolower', $iso_codes); # lower them

if ($message === '')
{
	return $bot->reply('Known ISO-1 language codes: '.GWF_Array::implodeHuman($iso_codes));
} 

if (false === in_array($message, $iso_codes, true))
{
	return $bot->reply('Unknown language ISO-1 code.');
}

$old = $user->getLangISO();
if ($old === $message)
{
	return $bot->reply(sprintf('Your language was already set to "%s".', $old));
}

if (false === $user->saveVar('lusr_language', $message))
{
	return $bot->reply('Database error!');
}

return $bot->reply(sprintf('Your language has been set from "%s" to "%s".', $old, $message));
?>
