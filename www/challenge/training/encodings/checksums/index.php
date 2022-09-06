<?php
chdir('../../../../');
define('GWF_PAGE_TITLE', 'Training: Checksums');
require_once('challenge/html_head.php');
// require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 3, 'challenge/training/encodings/checksums/index.php', false);
}
$chall->showHeader();

require 'gan.frm.htm';

if (isset($_POST['gan']))
{
	$gan = checkGAN($_POST['gan']);
	if ($gan)
	{
		$chall->onChallengeSolved();
	}
}

$link = '<a href="gan.frm.htm">gan.frm.htm</a>';
echo GWF_Box::box($chall->lang('info', array($link)), $chall->lang('title'));


echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
