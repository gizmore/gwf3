<?php
chdir("../../");
define('GWF_PAGE_TITLE', 'Letterworm');
require_once 'challenge/html_head.php';

if (false === ($chall = WC_Challenge::getByTitle("Letterworm"))) {
	$chall = WC_Challenge::dummyChallenge('Letterworm');
}
	
$chall->showHeader();

$solved = false;
if (isset($_GET["solution"])) {
	 $solved = checkSolution($chall);
}
if ($solved === true) {
	$chall->onChallengeSolved(GWF_Session::getUserID());
}

htmlTitleBox($chall->lang('title'), $chall->lang('info'));

?>
<div class="box box_c">
<iframe src='generate.php' scrolling='auto' style="margin: 10px; padding: 5px; height: 320px;"></iframe>
<form action='index.php' method='get'>
<input type="text" name="solution" value="" />
<input type="submit" name="submit" value="Submit" />
</form>
</div>

<?php
echo $chall->copyrightFooter();
require_once("challenge/html_foot.php");

function checkSolution(WC_Challenge $chall) {
	
//	if (!User::isLoggedIn()) {
//		return htmlDisplayError("You need to login to submit a solution.");
//	}
	
	if (false === ($correct = GWF_Session::getOrDefault('lw_solution'))) {
		return htmlDisplayError($chall->lang('err_no_req'));
	}
	
	$answer = Common::getGet('solution');
	
	$maxtime = 4.5;
	$timediff = microtime(true) - GWF_Session::getOrDefault('lw_timeout', 0);
	if ($answer !== $correct) {
		GWF_Session::remove('lw_timeout');
		GWF_Session::remove('lw_solution');
		$danswer = htmlspecialchars($answer, ENT_QUOTES);
		return htmlDisplayError($chall->lang('err_wrong', array($danswer, $correct, $timediff, $maxtime)));
	}
	
	if ($timediff >= $maxtime) {
		return htmlDisplayError($chall->lang('err_slow', array($maxtime, $timediff)));
	}
	
	return htmlDisplayMessage($chall->lang('msg_correct', array($timediff)));
}
?>
