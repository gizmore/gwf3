<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <text>. Convert ascii text into decimal numbers. See also utf2dec.',
	),
);

$plugin = Dog::getPlugin();
if ('' === ($message = $plugin->msg()))
{
	return $plugin->showHelp();
}

$out = '';
$len = strlen($message);
for ($i = 0; $i < $len; $i++)
{
	$out .= sprintf(' %d', ord($message[$i]));
}

$plugin->reply(substr($out, 1));
?>
