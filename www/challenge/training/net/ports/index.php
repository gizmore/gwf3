<?php
chdir('../../../../');
define('GWF_PAGE_TITLE', 'Training: Net Ports');
require_once('challenge/html_head.php'); # output start of website

# Get the challenge
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 3, 'challenge/training/net/ports/index.php', false);
}

# And display the header
$chall->showHeader();

$PORT = 5;

if ($_SERVER['REMOTE_PORT'] == $PORT)
{
	$chall->onChallengeSolved();
}

$self = GWF_User::getStaticOrGuest()->displayUsername();
echo GWF_Box::box($chall->lang('info', array($self, $PORT, $_SERVER['REMOTE_PORT'])), $chall->lang('title'));

# Print Challenge Footer
echo $chall->copyrightFooter();
# Print end of website
require_once('challenge/html_foot.php');
