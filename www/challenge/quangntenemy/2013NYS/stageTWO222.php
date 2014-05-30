<?php
$secret = require('secret.php');
$key2 = file_get_contents('key2.key');
chdir('../../../');
define('GWF_PAGE_TITLE', '2013 New Years Special');
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 3, 'challenge/quangntenemy/2013NYS/index.php', false);
}
$chall->showHeader();

require_once GWF_CORE_PATH.'module/WeChall/WC_CryptoChall.php';
$SOLUTION = WC_CryptoChall::generateSolution($secret, true);

if (!($bot = GWF_User::getByName('Silvester2013')))
{
	die('oops');
}
if (!$user = GWF_User::getStaticOrGuest())
{
	die('oops');
}

if (isset($_POST['answer']))
{
	$chall->setVar('chall_solution', WC_Challenge::hashSolution($SOLUTION, true));
	$chall->onCheckSolution();
}


if (Common::getGetString('santa') === 'clause.json')
{
	if ('' === ($rec = $user->getValidMail()))
	{
		echo GWF_HTML::error('Happy Holidays', $chall->lang('err_no_mail'), false);
	}
	
	else
	{
		$mail = new GWF_Mail();
		$mail->setSender($bot->getValidMail());
		$mail->setSenderName('Silvester Stallhuhn');
		$mail->setReceiver($user->getValidMail());
		$mail->setReceiverName($user->getVar('user_name'));
		$mail->setupGPG($bot);
		$mail->setSubject($chall->lang('p2_subj'));
		$mail->setBody($chall->lang('p2_body', array($SOLUTION)));
		$mail->addAttachment('0xdeadc0de.asc', $key2, 'application/octet-stream', false);
		$mail->sendAsHTML();
		echo GWF_HTML::message('Happy Holidays', $chall->lang('msg_mail_sent', array($user->getValidMail())), false);
	}
}

echo GWF_Website::getDefaultOutput();


$self = GWF_User::getStaticOrGuest()->displayUsername();
$href = "?santa=clause.json";
echo GWF_Box::box($chall->lang('info2', array($self, $href)), $chall->lang('title2'));

formSolutionbox($chall);

echo $chall->copyrightFooter();

require_once('challenge/html_foot.php');
