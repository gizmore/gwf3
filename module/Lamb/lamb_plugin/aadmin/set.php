<?php # Usage: %CMD% [<var>] [<value>]. Set a config var to a new value or get the current value.
// List all
if ($message === '')
{
	if (false === ($keys = GDO::table('GWF_Settings')->selectColumn('set_key', '', 'set_key ASC'))) {
		$bot->reply('Database error.');
	}
	else {
		$bot->reply(sprintf('Known vars: %s', implode(', ', $keys)));
	}
	return;
}

$split = explode(' ', $message, 2);
if (false === ($old_value = GWF_Settings::getSetting($split[0], false))) {
	$bot->reply(sprintf('This var is unknown. Try %sset', LAMB_TRIGGER));
	return;
}

// Show one
if (count($split) === 1) {
	$bot->reply(sprintf('Current value of %s: %s.', $split[0], $old_value));
	return;
}


// Set one
if (false === (GWF_Settings::setSetting($split[0], $split[1]))) {
	$bot->reply('Database error.');
	return;
}
$new_value = GWF_Settings::getSetting($split[0], false);
$bot->reply(sprintf('Set the value of %s from %s to %s.', $split[0], $old_value, $new_value));
?>