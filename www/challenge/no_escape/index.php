<?php
define('NO_ESCAPE_USER', 'gizmore_noesc');
define('NO_ESCAPE_DB', 'gizmore_noesc');
define('NO_ESCAPE_PW', 'gizmore_noesc');
require_once 'code.include';

chdir('../../');
define('GWF_PAGE_TITLE', 'No Escape');
require_once('challenge/html_head.php');
if (!($chall = WC_Challenge::getByTitle('No Escape')))
{
	$chall = WC_Challenge::dummyChallenge('No Escape', 2, '/challenge/no_escape/index.php', false);
}
$chall->showHeader();

if ($who = Common::getGetString('vote_for', false))
{
	noesc_voteup($who);
}

htmlTitleBox($chall->lang('title'), $chall->lang('info', array('code.include', 'index.php?highlight=christmas')));

if (Common::getGetString('highlight') === 'christmas')
{
	$msg = file_get_contents('challenge/no_escape/code.include');
	$msg = '[code=php title=code.include]'.$msg.'[/code]';
	echo GWF_Box::box(GWF_Message::display($msg, true, false, false));
}

echo noesc_DisplayVotes($chall);

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>