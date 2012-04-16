<?php

# WeChall things
chdir('../../../');
define('GWF_PAGE_TITLE', 'Where is spaceones doc?');
require_once('challenge/html_head.php');

if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, 'challenge/space/string/index.php', $solution);
}

$chall->showHeader();

###############
## Challenge ##
###############

$challenge = function()
{
	// closure, because of namespace!

	$f = (string)$_GET['eval'];
	$f = str_replace(array('`', '$', '*', '#', ':', '\\', '"', "'", '(', '.'), '', $f);

	if((strlen($f) > 13) || (false !== strpos('return'))
	{
		die('sorry, not allowed!');
	}

	eval("\$spaceone = $f");

	return ($spaceone === '1337');
};

if (true === $challenge())
{
	$chall->onChallengeSolved(GWF_Session::getID());
}

#########
## END ##
#########

echo GWF_Box::box($chall->lang('info', array(GWF_WEB_ROOT.'challenge/space/string/index.php')), $chall->lang('title'));

$filename = 'challenge/space/string/index.php';
$message = '[PHP]'.file_get_contents($filename).'[/PHP]';
echo GWF_Message::display($message);

# TODO: input box?

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
