<?php

# WeChall things
chdir('../../../');
define('GWF_PAGE_TITLE', 'PHP 0819');
require_once('challenge/html_head.php');

if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, 'challenge/space/php0819/index.php', false);
}

$chall->showHeader();

###############
## Challenge ##
###############

$challenge = function()
{
	// closure, because of namespace!

	$f = Common::getGetString('eval');
	$f = str_replace(array('`', '$', '*', '#', ':', '\\', '"', "'", '(', '.'), '', $f);

	if((strlen($f) > 13) || (false !== strpos('return', $f)))
	{
		die('sorry, not allowed!');
	}

	try
	{
		eval("\$spaceone = $f");
	}
	catch (Exception $e)
	{
		return false;
	}

	return ($spaceone === '1337');
};

if (isset($_GET['eval']))
{
	if (true === $challenge())
	{
		$chall->onChallengeSolved(GWF_Session::getUserID());
	}
}

#########
## END ##
#########

echo GWF_Box::box($chall->lang('info', array(GWF_WEB_ROOT.'challenge/space/php0819/index.php')), $chall->lang('title'));

$filename = 'challenge/space/php0819/index.php';
$message = '[PHP]'.file_get_contents($filename).'[/PHP]';
echo GWF_Message::display($message);

# TODO: GET form input box? (gizmore)

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
