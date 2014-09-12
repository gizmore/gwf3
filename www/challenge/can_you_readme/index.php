<?php
chdir("../../");
define('WC_CYRM_TIMEOUT', 2.5);
define('GWF_PAGE_TITLE', 'Can you read me');
require_once("challenge/html_head.php");

if (false === ($chall = WC_Challenge::getByTitle('Can you read me')))
{
	$chall = WC_Challenge::dummyChallenge('Can you read me');
}

$chall->showHeader();

$solved = false;
if (isset($_GET["solution"]))
{
	 $solved = checkSolution($chall);
}
if ($solved === true)
{
	$chall->onChallengeSolved(GWF_Session::getUserID());
}

htmlTitleBox($chall->lang('title'), $chall->lang('info', array(WC_CYRM_TIMEOUT)));
?>
<div class="box box_c">
<img src='gimme.php'><br/>
<form action='index.php' method='get'>
<input type='text' name='solution' value='' />
<input type="submit" name="cmd" value="Answer" />
</form>
</div>
<?php
echo $chall->copyrightFooter();
require_once("challenge/html_foot.php");

function checkSolution(WC_Challenge $chall)
{
	
	if (false === ($correct = GWF_Session::getOrDefault('cyrm_solution')))
	{
		return htmlDisplayError($chall->lang('err_no_request'));
	}
	
	$timediff = microtime(true) - GWF_Session::get('cyrm_timeout');
	$taken = sprintf('%.03fs', $timediff);	
	if ($correct !== ($answer = Common::getGetString('solution', '')))
	{
		GWF_Session::set('cyrm_timeout', false);
		return htmlDisplayError($chall->lang('err_wrong', array(htmlspecialchars($answer, ENT_QUOTES), $correct, $taken)));
	}
	
	$maxtime = 2.5;
	if ($timediff >= $maxtime)
	{
		return htmlDisplayError($chall->lang('err_slow', array($maxtime.'s', $taken)));
	}
	
	return htmlDisplayMessage($chall->lang('msg_correct', array($taken)));
}
