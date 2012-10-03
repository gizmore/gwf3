<?php
chdir('../../');

# Show source.
if (isset($_GET['show']))
{
	header('Content-Type: text/plain');
	die(file_get_contents('challenge/time_to_reset2/index.php'));
}

define('GWF_PAGE_TITLE', 'Time to Reset II');
require_once('challenge/html_head.php'); # output start of website
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';

# Get the challenge
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 7, 'challenge/time_to_reset2/index.php', false);
}

require_once 'challenge/time_to_reset2/TTR2_Form.include';
require_once 'challenge/time_to_reset2/TTR2_Tokens.include';

# And display the header
$chall->showHeader();

# Generate csrf token         # noother says it's too easy
#srand(time()+rand(0, 100));  # noother says it's too easy
#$csrf = ttr2_random(32);     # noother says it's too easy

$ttr = new TTR2_Form();
$form = $ttr->getForm($chall);

if (isset($_POST['reset']))
{
	echo ttr2_request($chall, $form);
}

echo GWF_Website::getDefaultOutput();

echo $form->templateY($chall->lang('ft_reset'), GWF_WEB_ROOT.'challenge/time_to_reset2/reset.php');


# Print Challenge Footer
echo $chall->copyrightFooter();
# Print end of website
require_once('challenge/html_foot.php');

#################
### FUNCTIONS ###
#################

function ttr2_random($len, $alpha='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789')
{
	$alphalen = strlen($alpha) - 1;
	$key = '';
	for($i = 0; $i < $len; $i++)
	{
		$key .= $alpha[rand(0, $alphalen)];
	}
	return $key;
}

function ttr2_request(WC_Challenge $chall, GWF_Form $form)
{
	if (false !== ($errors = $form->validate($chall)))
	{
		return $errors;
	}

	# Generate reset token
	$sid = GWF_Session::getSessSID();
	$email = $form->getVar('email');
	$token = ttr2_random(16);
	
	if (!TTR2_Tokens::insertToken($sid, $email, $token))
	{
		return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
	}
	
	# If it's your own real mail, even send it for the lulz :)
	if ($email === GWF_User::getStaticOrGuest()->getValidMail())
	{
		ttr2_mail_me($chall, $email, $token);
	}
	
	return GWF_HTML::message($chall->lang('title'), $chall->lang('msg_mail_sent'));
}

function ttr2_mail_me(WC_Challenge $chall, $email, $token)
{
	$mail = new GWF_Mail();
	$mail->setSender(GWF_BOT_EMAIL);
	$mail->setReceiver($email);
	$mail->setSubject($chall->lang('mail_subj'));
	$mail->setBody($chall->lang('mail_body', array($token)));
	$mail->sendAsHTML('gizmore@wechall.net'); # cc me for testing purposes
}
?>

