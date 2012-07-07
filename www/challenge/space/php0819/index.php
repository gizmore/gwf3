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
require_once 'challenge/space/php0819/php0819.php';

echo GWF_Box::box($chall->lang('info', array(GWF_WEB_ROOT.'profile/space')), $chall->lang('title'));

GWF_Debug::setDieOnError(false);
GWF_Debug::setMailOnError(false);

if (isset($_GET['eval']))
{
	if (true === $challenge())
	{
		$chall->onChallengeSolved(GWF_Session::getUserID());
	}
}
GWF_Debug::setDieOnError(true);
GWF_Debug::setMailOnError(true);


$filename = 'challenge/space/php0819/php0819.php';
$message = '[PHP]'.file_get_contents($filename).'[/PHP]';
echo GWF_Message::display($message);

# TODO: GET form input box? (gizmore)

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
