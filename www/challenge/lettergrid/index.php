<?php
chdir("../../");
define('GWF_PAGE_TITLE', 'Lettergrid');
require_once('challenge/html_head.php');

define('LETTERGRID_MAX_TIME', 4.5);

if (false === ($chall = WC_Challenge::getByTitle('Lettergrid'))) {
	$chall = WC_Challenge::dummyChallenge('Lettergrid');
}
$chall->showHeader();

$solved = false;
if (false !== ($answer = Common::getGet('solution'))) {
	 $solved = checkSolution($chall);
}
if ($solved === true) {
	$chall->onChallengeSolved(GWF_Session::getUserID());
}

echo htmlTitleBox($chall->lang('title'), $chall->lang('info', array(LETTERGRID_MAX_TIME)))

?>
<div class="box box_c">
<iframe src='generate.php' scrolling='auto'>
</iframe>

<form action='index.php' method='get'>
<input type='text' name='solution' value='' />
<input type="submit" name="cmd" value="Submit Answer" />
</form>

</div>
<?php
echo $chall->copyrightFooter();
require_once("challenge/html_foot.php");

function checkSolution(WC_Challenge $chall)
{
	if (false === ($correct = GWF_Session::getOrDefault('lg_solution'))) {
		return htmlDisplayError($chall->lang('err_no_req'));
	}
	
	$maxtime = LETTERGRID_MAX_TIME;
	$timediff = microtime(true) - GWF_Session::getOrDefault('lg_timeout', 0);
	if ($correct !== Common::getGet('solution')) {
		GWF_Session::remove('lg_timeout');
		GWF_Session::remove('lg_solution');
		return htmlDisplayError($chall->lang('err_wrong', array(htmlspecialchars(Common::getGet('solution'), ENT_QUOTES), $correct, $timediff, $maxtime)));
	}
	
	if ($timediff >= $maxtime) {
		return htmlDisplayError($chall->lang('err_slow', array($maxtime, $timediff)));
	}
	
	return htmlDisplayMessage($chall->lang('msg_correct', array($timediff)));
}
?>
