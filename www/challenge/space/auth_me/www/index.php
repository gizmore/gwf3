<?php
chdir('../../../../');
define('GWF_PAGE_TITLE', 'AUTH me');
require_once('challenge/html_head.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, 'challenge/space/auth_me/index.php', false);
}
$chall->showHeader();
$chall->onChallengeSolved(); # THE GAME! ;)
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
