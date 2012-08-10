<?php
require_once 'settings.php';
require_once 'vuln.php';
if (isset($_GET['show']))
{
	header('Content-Type: text/plain');
	die(file_get_contents('vuln.php'));
}
chdir('../../../');
define('GWF_PAGE_TITLE', 'Are you blind?');
require_once('challenge/html_head.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 6, 'challenge/Mawekl/are_you_blind/index.php', false);
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
		if ($attemp > (BLIGHT4_ATTEMPS+1) )
		{
			echo GWF_HTML::error(GWF_PAGE_TITLE, $chall->lang('err_attemps', array($attemp, (BLIGHT4_ATTEMPS+1))));
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
				$have = GWF_Session::getOrDefault('BLIGHT4_CONSECUTIVE', '1');
				$need = BLIGHT4_CONSEC - $have;
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

	$attemp = blightAttemp()+1;
	$success = blightVuln($chall, $password, $attemp);
	
	
	echo GWF_HTML::message(GWF_PAGE_TITLE, $success);
	
// 	if ($success)
// 	{
// 		echo GWF_HTML::message(GWF_PAGE_TITLE, $chall->lang('msg_logged_in', array($attemp)));
// 	}
// 	else
// 	{
// 		echo GWF_HTML::error(GWF_PAGE_TITLE, $chall->lang('err_login', array($attemp)));
// 	}
	
	blightSetAttempt($attemp);
}

$url1 = 'index.php?show=source';
$url2 = 'index.php?highlight=christmas';
$url3 = 'index.php?reset=me';

$text = $chall->lang('info', array(BLIGHT4_ATTEMPS, BLIGHT4_CONSEC, $url1, $url2, $url3));
htmlTitleBox($chall->lang('title'), $text);
if (Common::getGetString('highlight') === 'christmas')
{
	echo GWF_Message::display('[php title=vuln.php]'.file_get_contents('challenge/Mawekl/are_you_blind/vuln.php').'[/php]');
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
