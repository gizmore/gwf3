<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% [<id>]. Display a scroll of wisdom.',
	),
);

$plugin = Dog::getPlugin();

$url = 'https://raw.githubusercontent.com/gizmore/anonymous-zen-book/master/'; # +n
$max = 79;

$argc = $plugin->argc();

if ($argc == 0)
{
	$id = GWF_Random::rand(1, $max);
}
else
{
	$id = (int) $plugin->argv(0);
}

$url = $url . $id;

$texts = explode("\n", GWF_HTTP::getFromURL($url));

$first = true;
foreach ($texts as $text)
{
	$pre = $first ? $id . ') ' : '';
	$first = false;
	$plugin->reply(sprintf("%s%s", $pre, $text));
}
