<?php
chdir('../../');

# Show source.
if (isset($_GET['show']))
{
	header('Content-Type: text/plain');
	die(file_get_contents('challenge/time_to_reset/index.php'));
}

define('GWF_PAGE_TITLE', 'Time to Reset');
require_once('challenge/html_head.php'); # output start of website
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';

# Get the challenge
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 7, 'challenge/time_to_reset/index.php', false);
}

require_once 'challenge/time_to_reset/TTR_Form.include';
require_once 'challenge/time_to_reset/TTR_Tokens.include';

# And display the header
$chall->showHeader();

# Generate csrf token
srand(time()+rand(0, 100));
$csrf = ttr_random(32);
$ttr = new TTR_Form();
$form = $ttr->getForm($chall, $csrf);

if (isset($_POST['reset']))
{
	echo ttr_request($chall, $form);
}
elseif (isset($_POST['solve']))
{
	ttr_submit($chall);
}

echo GWF_Website::getDefaultOutput();

echo GWF_Box::box($chall->lang('info', array('index.php?show=source', 'index.php?highlight=christmas')), $chall->lang('title'));

if (Common::getGetString('highlight') === 'christmas')
{
	$source = '[PHP title=TimeToReset]'.trim(file_get_contents('challenge/time_to_reset/index.php')).'[/PHP]';
	echo GWF_Box::box(GWF_BBCode::decode($source));
}

echo $form->templateY($chall->lang('ft_reset'), GWF_WEB_ROOT.'challenge/time_to_reset/index.php');

formSolutionbox($chall);

# Print Challenge Footer
echo $chall->copyrightFooter();
# Print end of website
require_once('challenge/html_foot.php');

#################
### FUNCTIONS ###
#################

function ttr_random($len, $alpha='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789')
{
	$alphalen = strlen($alpha) - 1;
	$key = '';
	for($i = 0; $i < $len; $i++)
	{
		$key .= $alpha[rand(0, $alphalen)];
	}
	return $key;
}

function ttr_request(WC_Challenge $chall, GWF_Form $form)
{
	if (false !== ($errors = $form->validate($chall)))
	{
		return $errors;
	}

	# Generate reset token
	$sid = GWF_Session::getSessSID();
	$email = $form->getVar('email');
	$token = ttr_random(16);
	
	if (!TTR_Tokens::insertToken($sid, $email, $token))
	{
		return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
	}
	
	# If it's your own real mail, even send it for the lulz :)
	if ($email === GWF_User::getStaticOrGuest()->getValidMail())
	{
		ttr_mail_me($chall, $email, $token);
	}
	
	return GWF_HTML::message($chall->lang('title'), $chall->lang('msg_mail_sent'));
}

function ttr_submit(WC_Challenge $chall)
{
	if ('' === ($answer = Common::getPostString('answer', '')))
	{
		return;
	}
	
	$sessid = GWF_Session::getSessSID();

	# First check all "custom" solutions
	$solutions = TTR_Tokens::getSolutions($sessid);
	foreach ($solutions as $solution)
	{
		if ($solution['ttr_token'] === $answer)
		{
			echo GWF_HTML::message($chall->lang('title'), $chall->lang('msg_reset_own', array(htmlspecialchars($solution['ttr_email']))));
			return;
		}
	}
	
	# Now lets check "THE" solution
	$solution = TTR_Tokens::getSolution($sessid);
	$chall->setSolution($solution['ttr_token']);
	$chall->onSolve(GWF_User::getStaticOrGuest(), $answer);
}

function ttr_mail_me(WC_Challenge $chall, $email, $token)
{
	$mail = new GWF_Mail();
	$mail->setSender(GWF_BOT_EMAIL);
	$mail->setReceiver($email);
	$mail->setSubject($chall->lang('mail_subj'));
	$mail->setBody($chall->lang('mail_body', array($token)));
	$mail->sendAsHTML('gizmore@wechall.net'); # cc me for testing purposes
}
?>

