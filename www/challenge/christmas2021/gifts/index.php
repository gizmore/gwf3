<?php
chdir('../../../');
define('GWF_PAGE_TITLE', '2021 Christmas Gifts');
require_once('challenge/html_head.php');
require_once(GWF_CORE_PATH . 'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 4, 'challenge/christmas2021/gifts/index.php', false);
}
$chall->showHeader();

$solver = require 'packaging.php';

echo GWF_Website::getDefaultOutput();

if ($error = $chall->isAnswerBlocked(GWF_User::getStaticOrGuest()))
{
	echo $error;
}
else
{
	$answer = Common::getPostString('answer');
	if ($solver($chall, $answer))
	{
		$chall->onChallengeSolved();
	}
	elseif ($answer)
	{
		echo Module_WeChall::instance()->error('err_wrong');
	}
}

$kvirc = 'https://www.kvirc.net/';
$script = 'https://www.kvirc.net/doc/doc_language_index_all.html';
echo GWF_Box::box($chall->lang('info', [$kvirc, $script]), $chall->lang('title'));

# The UI is not my problem.
formSolutionbox($chall);

echo $chall->copyrightFooter();

require_once('challenge/html_foot.php');
