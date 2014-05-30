<?php
$SOLUTION = 'IKnowWhatYouDidThere';
if (isset($_POST['answer']) && is_string($_POST['answer']) && $_POST['answer'] === $SOLUTION)
{
	header('Location: stageTWO222.php');
	die(0);
}
$key1 = file_get_contents('key1.key');
chdir('../../../');
define('GWF_PAGE_TITLE', '2013 New Years Special');
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 3, 'challenge/quangntenemy/2013NYS/index.php', false);
}
$chall->showHeader();

if (!$bot = GWF_User::getByName('Rudolph2013'))
{
	die('oops');
}
if (!$user = GWF_User::getStaticOrGuest())
{
	die('oops');
}


if (Common::getGetString('letterbox') === 'santa.php')
{
	if ('' === ($rec = $user->getValidMail()))
	{
		echo GWF_HTML::error('Happy Holidays', $chall->lang('err_no_mail'), false);
	}
	
	else
	{
		$mail = new GWF_Mail();
		$mail->setSender($bot->getValidMail());
		$mail->setSenderName('Rudolph Northwood');
		$mail->setReceiver($user->getValidMail());
		$mail->setReceiverName($user->getVar('user_name'));
		$mail->setupGPG($bot);
		$mail->setSubject($chall->lang('p1_subj'));
		$mail->setBody($chall->lang('p1_body'));
		$mail->addAttachment('0xdeadbeef.asc', $key1, 'application/octet-stream', false);
		$mail->sendAsHTML();
	}
}

echo GWF_Website::getDefaultOutput();


$self = GWF_User::getStaticOrGuest()->displayUsername();
$quan = '<a href="/profile/quangntenemy">quangntenemy</a>';
$href = "?letterbox=santa.php";

echo GWF_Box::box($chall->lang('info1', array($self, $quan, $href)), $chall->lang('title1'));

formSolutionbox($chall);

echo $chall->copyrightFooter();

require_once('challenge/html_foot.php');
