<?php
chdir('../../');
define('GWF_PAGE_TITLE', 'Crappyshare');
require_once('html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle('Crappyshare'))) {
	$chall = WC_Challenge::dummyChallenge('Crappyshare', 4, '/challenge/crappyshare/index.php', false);
}
$chall->showHeader();
$chall->onCheckSolution();

# Mission
htmlTitleBox($chall->lang('title'), $chall->lang('info'));

# Show This Code
if ('code' === Common::getGet('show'))
{
	$msg = '[CO'.'DE=PHP title=crappyshare.php]'.file_get_contents('challenge/crappyshare/crappyshare.php').'[/'.'CODE]';
	echo GWF_Box::box(GWF_Message::display($msg, true, true, true));
}

formSolutionbox($chall);

echo $chall->copyrightFooter();
require_once('html_foot.php');
?>
