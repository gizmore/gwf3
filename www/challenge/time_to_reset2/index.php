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

if (isset($_POST['solve']))
{
	ttr2_submit($chall);
}

echo GWF_Website::getDefaultOutput();

$noother = sprintf('<a href="/profile/noother">noother</a>');
echo GWF_Box::box($chall->lang('info', array($noother, 'reset.php', 'index.php?show=source', 'index.php?highlight=christmas')), $chall->lang('title'));

if (Common::getGetString('highlight') === 'christmas')
{
	$source = '[PHP title=TimeToReset]'.trim(file_get_contents('challenge/time_to_reset2/index.php')).'[/PHP]';
	echo GWF_Box::box(GWF_BBCode::decode($source));
}

formSolutionbox($chall);

# Print Challenge Footer
echo $chall->copyrightFooter();
# Print end of website
require_once('challenge/html_foot.php');


function ttr2_submit(WC_Challenge $chall)
{
	if ('' === ($answer = Common::getPostString('answer', '')))
	{
		return;
	}
	
	$sessid = GWF_Session::getSessSID();

	# First check all "custom" solutions
	$solutions = TTR2_Tokens::getSolutions($sessid);
	foreach ($solutions as $solution)
	{
		if ($solution['ttr_token'] === $answer)
		{
			echo GWF_HTML::message($chall->lang('title'), $chall->lang('msg_reset_own', array(htmlspecialchars($solution['ttr_email']))));
			return;
		}
	}
	
	# Now lets check "THE" solution
	$solution = TTR2_Tokens::getSolution($sessid);
	$chall->setSolution($solution['ttr_token']);
	$chall->onSolve(GWF_User::getStaticOrGuest(), $answer);
}

?>

