<?php
chdir('../../../');
define('GWF_PAGE_TITLE', 'The Last Hope');
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');

if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 4, 'challenge/bsdhell/thelasthope/index.php', false);
}
$chall->showHeader();

if (strcasecmp(Common::getPost('answer'), 'username_password') === 0)
{
	$count = GWF_Counter::getCount('WC_BSD_LH_DOLT');
	if (false === GWF_Session::getOrDefault('WC_BSD_LH_DOLT', false)) {
		$count++;
		GWF_Counter::saveCounter('WC_BSD_LH_DOLT', $count);
		GWF_Session::set('WC_BSD_LH_DOLT', '1');
	}
	
	echo GWF_HTML::message('The Last Hope', $chall->lang('msg_literal'), false);
	echo GWF_HTML::error('The Last Hope', $chall->lang('err_literal', array($count)), false);
}
else {
	$chall->onCheckSolution();
}

htmlTitleBox($chall->lang('title'), $chall->lang('info', array('bsd_thelasthope.elf')));

formSolutionbox($chall);

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>