<?php
chdir("../../../");
define('GWF_PAGE_TITLE', 'Training: Programming I');
require_once 'challenge/html_head.php';

define("TIMELIMIT", 1.337);
if (false === ($chall = WC_Challenge::getByTitle("Training: Programming 1"))) {
	$chall = WC_Challenge::dummyChallenge("[Training: Programming 1]");
}

if ('request' === Common::getGet('action')) {
	prog2NextQuestion($chall);
}

$solved = false;

if (false !== ($answer = Common::getGet('answer'))) {
	$solved = prog2CheckResult($chall);
}

$chall->showHeader();

if ($solved === true) {
	$chall->onChallengeSolved(GWF_Session::getUserID());
}
elseif (is_string($solved)) {
	htmlDisplayError($solved, false);
}

?>

<?php 
$sol_url = Common::getAbsoluteURL($chall->getVar('chall_url')).'?answer=the_message';
echo GWF_Box::box($chall->lang('info', array('index.php?action=request', $sol_url, TIMELIMIT )));
?>

<?php
function prog2NextQuestion(WC_Challenge $chall)
{
	if (false === ($user = GWF_Session::getUser())) {
		die($chall->lang('err_login'));
	}
	$solution = GWF_Random::randomKey(rand(9, 12));
	GWF_Session::set('prog2_solution', $solution);
	GWF_Session::set('prog2_timeout', microtime(true));
//	GWF_Session::commit();
	die($solution);
}

function prog2CheckResult(WC_Challenge $chall)
{
	if (false === ($user = GWF_Session::getUser())) {
		die($chall->lang('err_login'));
	}
	
	if (false === ($answer = Common::getGet('answer'))) {
		die($chall->lang('err_no_answer'));
	}

	$solution = GWF_Session::getOrDefault('prog2_solution', false);
	$startTime = GWF_Session::getOrDefault('prog2_timeout', false);
	
	if ($solution === false || $startTime === false) {
		die($chall->lang('err_no_request'));
	}
	
	$back = "";
	if (trim($answer) !== $solution) {
		$back .= $chall->lang('err_wrong', array(htmlspecialchars($answer, ENT_QUOTES), $solution));
	}
	else {
		$back .= $chall->lang('msg_correct');
	}
	
	$timeNeeded = microtime(true) - $startTime; 
	if ($timeNeeded > TIMELIMIT) {
		return $back.$chall->lang('err_timeout', array(sprintf('%.02f', $timeNeeded), TIMELIMIT));
	}
	return trim($answer) === $solution ? true : $back;
}

echo $chall->copyrightFooter();

require_once 'challenge/html_foot.php';
?>