<?php
chdir("../../../../");
define('GWF_PAGE_TITLE', 'Training: GPG');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/WC_CryptoChall.php';
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, '/challenge/training/crypto/gpg/index.php', false);
}
$chall->showHeader();
WC_CryptoChall::checkSolution($chall, 'OHOYOUGOTGPG!', true, false);

if (false !== Common::getPost('send'))
{
	wccgpg_doit($chall, GWF_Session::getUser());
}

$url = GWF_WEB_ROOT.'account';
echo GWF_Box::box($chall->lang('info', array($url)), $chall->lang('title'));

$form = '<form action="index.php" method="post">'.PHP_EOL;
$form .= '<input type="submit" name="send" value="'.$chall->lang('btn_send').'" />'.PHP_EOL;
$form .= '</form>'.PHP_EOL;

echo GWF_Box::box($form);

formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');

function wccgpg_doit(WC_Challenge $chall, $user)
{
	if ($user === false) {
		echo GWF_HTML::error('GPG', $chall->lang('err_login'), false);
		return;
	}
	
	if (!$user->hasValidMail()) {
		echo GWF_HTML::error('GPG', $chall->lang('err_no_mail'));
		return;
	}
	$receiver = $user->getValidMail();
	
	if (!function_exists('gnupg_init')) {
		echo GWF_HTML::error('GPG', $chall->lang('err_server'));
		return;
	}
	
	if (false === ($fingerprint = GWF_PublicKey::getFingerprintForUser($user))) {
		$url = GWF_WEB_ROOT.'account';
		echo GWF_HTML::error('GPG', $chall->lang('err_no_gpg', $url), false);
		return;
	}
	
	$solution = WC_CryptoChall::generateSolution('OHOYOUGOTGPG!', true, false);
	$mail = new GWF_Mail();
	$mail->setSubject($chall->lang('mail_s'));
	$mail->setSender(GWF_BOT_EMAIL);
	$mail->setReceiver($receiver);
	$mail->setBody($chall->lang('mail_b', array($user->displayUsername(), $solution)));
	
	if (false === $mail->sendToUser($user)) {
		echo GWF_HTML::err('ERR_MAIL_SENT');
	}
	else {
		echo GWF_HTML::message('GPG', $chall->lang('msg_mail_sent', array(htmlspecialchars($receiver))));
	}
}
?>