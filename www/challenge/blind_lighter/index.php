<?php
require_once 'settings.php';
require_once 'vuln.php';
if (isset($_GET['show']))
{
	header('Content-Type: text/plain');
	die(file_get_contents('vuln.php'));
}
chdir('../../');
define('GWF_PAGE_TITLE', 'Blinded by the lighter');
require_once('challenge/html_head.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 6, 'challenge/blind_lighter/index.php', false);
}
$chall->showHeader();

if (Common::getGetString('reset') === 'me')
{
	if (false !== ($solution = blightGetHash()))
	{
		echo GWF_HTML::error(GWF_PAGE_TITLE, $chall->lang('msg_old_pass', array($solution)));
	}
	blightReset(true);
	echo GWF_HTML::message(GWF_PAGE_TITLE, $chall->lang('msg_reset'));
}
elseif (isset($_POST['mybutton']))
{
	blightInit();
	$answer = Common::getPostString('thehash');
	$solution = blightGetHash();
	$attemp = blightAttemp();
	
	if (!strcasecmp($answer, $solution))
	{
		if ($attemp > (BLIGHT2_ATTEMPS+1) )
		{
			echo GWF_HTML::error(GWF_PAGE_TITLE, $chall->lang('err_attemps', array($attemp, (BLIGHT2_ATTEMPS+1))));
		}
		elseif (blightTimeout())
		{
			echo GWF_HTML::error(GWF_PAGE_TITLE, $chall->lang('err_too_slow'));
		}
		else
		{
			if (blightSolved())
			{
				$chall->onChallengeSolved(GWF_Session::getUserID());
			}
			else
			{
				$have = GWF_Session::getOrDefault('BLIGHT2_CONSECUTIVE', '1');
				$need = BLIGHT2_CONSEC - $have;
				echo GWF_HTML::message(GWF_PAGE_TITLE, $chall->lang('msg_consec_success', array($need)));
			}
			blightReset(false);
		}
	}
	else
	{
		echo GWF_HTML::error(GWF_PAGE_TITLE, $chall->lang('err_wrong', array($attemp)));
	}
	
}
elseif (isset($_POST['inject']))
{
	blightInit();
	$password = Common::getPostString('injection');
	$success = blightVuln($password);
	$attemp = blightAttemp()+1;
	
	if ($success)
	{
		echo GWF_HTML::message(GWF_PAGE_TITLE, $chall->lang('msg_logged_in', array($attemp)));
	}
	else
	{
		echo GWF_HTML::error(GWF_PAGE_TITLE, $chall->lang('err_login', array($attemp)));
	}
	
	blightSetAttempt($attemp);
}

$url1 = 'index.php?show=source';
$url2 = 'index.php?highlight=christmas';
$url3 = 'index.php?reset=me';
$egg = 'On the run to the great gig.';
$egg = '<span style="color: #eee;">'.$egg.'</span>';
if (false !== ($dloser = GWF_User::getByName('dloser')))
{
	$dloser = $dloser->displayProfileLink();
}
else
{
	$dloser = 'dloser';
}

$text = $chall->lang('info', array(BLIGHT2_ATTEMPS, BLIGHT2_CONSEC, $url1, $url2, $url3, $egg, $dloser));
htmlTitleBox($chall->lang('title'), $text);
if (Common::getGetString('highlight') === 'christmas')
{
	echo GWF_Message::display('[php title=vuln.php]'.file_get_contents('challenge/blind_lighter/vuln.php').'[/php]');
}
?>
<div class="box box_c">
	<form method="post" action="index.php">
		<div><?php echo $chall->lang('th_injection'); ?>: <input name="injection" type="text" value="" /></div>
		<div><input name="inject" type="submit" value="<?php echo $chall->lang('btn_inject'); ?>" /></div>
	</form>
</div>

<div class="box box_c">
	<form method="post" action="index.php">
		<div><?php echo $chall->lang('th_thehash'); ?>: <input name="thehash" type="text" value="" /></div>
		<div><input name="mybutton" type="submit" value="<?php echo $chall->lang('btn_submit'); ?>" /></div>
	</form>
</div>
<?php
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>
