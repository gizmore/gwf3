<?php
require_once 'settings.php';
require_once 'vuln.php';
if (isset($_GET['show']))
{
	header('Content-Type: text/plain');
	die(file_get_contents('vuln.php'));
}
chdir('../../');
define('GWF_PAGE_TITLE', 'Blinded by the light');
require_once('html_head.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 4, 'challenge/blind_light/index.php', false);
}
$chall->showHeader();

if (Common::getGetString('reset') === 'me')
{
	blightReset();
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
		if ($attemp > (BLIGHT_ATTEMPS+1) )
		{
			echo GWF_HTML::error(GWF_PAGE_TITLE, $chall->lang('err_attemps', array($attemp, (BLIGHT_ATTEMPS+1))));
		}
		else
		{
			$chall->onChallengeSolved(GWF_Session::getUserID());
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
	$attemp = blightAttemp();
	
	if ($success)
	{
		echo GWF_HTML::message(GWF_PAGE_TITLE, $chall->lang('msg_logged_in', array($attemp)));
	}
	else
	{
		echo GWF_HTML::error(GWF_PAGE_TITLE, $chall->lang('err_login', array($attemp)));
	}
}

$url1 = 'index.php?show=source';
$url2 = 'index.php?highlight=christmas';
$url3 = 'index.php?reset=me';
$egg = '%68%74%74%70%3a%2f%2f%77%77%77%2e%79%6f%75%74%75%62%65%2e%63%6f%6d%2f%77%61%74%63%68%3f%76%3d%45%67%38%63%44%6d%69%37%2d%55%38';
$egg = '<span style="color: #eee;">'.$egg.'</span>';
htmlTitleBox($chall->lang('title'), $chall->lang('info', array(BLIGHT_ATTEMPS, $url1, $url2, $url3, $egg)));
if (Common::getGetString('highlight') === 'christmas')
{
	echo GWF_Message::display('[php title=vuln.php]'.file_get_contents('challenge/blind_light/vuln.php').'[/php]');
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
require_once('html_foot.php');
?>
