<?php
if (isset($_GET['show']))
{
	header('Content-Type: text/plain');
	die(file_get_contents('challenge.php'));
}
$secret = require('secret.php');
chdir('../../../');
define('GWF_PAGE_TITLE', 'Table Names II');
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');

if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 6, 'challenge/nurfed/more_table_names/index.php', $secret['flag']);
}
$chall->showHeader();

$chall->onCheckSolution();

echo GWF_Box::box($chall->lang('mission_i', array('index.php?show=source', 'index.php?highlight=christmas', 'challenge.php')), $chall->lang('mission_t'));

if (Common::getGetString('highlight') === 'christmas')
{
	echo GWF_Message::display('[php title=challenge.php]'.file_get_contents('challenge/nurfed/more_table_names/challenge.php').'[/php]');
}

formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
