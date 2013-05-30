<?php

# WeChall things
chdir('../../../');
define('GWF_PAGE_TITLE', 'HOST me');
require_once('challenge/html_head.php');

if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, 'challenge/space/host_me/index.php', false);
}

$chall->showHeader();

###############
## Challenge ##
###############
require_once 'challenge/space/host_me/host_me.php';

echo GWF_Box::box($chall->lang('info', array(GWF_WEB_ROOT.'profile/space')), $chall->lang('title'));

GWF_Debug::setDieOnError(false);
GWF_Debug::setMailOnError(false);

if (true === $challenge())
{
	$chall->onChallengeSolved(GWF_Session::getUserID());
}
GWF_Debug::setDieOnError(true);
GWF_Debug::setMailOnError(true);


$filename = 'challenge/space/host_me/host_me.php';
$message = '[PHP]'.file_get_contents($filename).'[/PHP]';
echo GWF_Message::display($message);

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
