<?php
chdir('../../../../');
define('WCC_IP6_SESS', 'WCC_IP6_SESS');
define('GWF_PAGE_TITLE', 'Training: IPv6');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 1, 'challenge/training/www/ip6/index.php');
}
$chall->showHeader();

$wechall = Module_WeChall::instance();

$level = GWF_Session::getOrDefault(WCC_IP6_SESS, 1);

if (isset($_POST['answer']) && is_string($_POST['answer']))
{
	if (true === wcc_ip6_check_answer($chall, $_POST['answer'], $level)) {
		$_POST['answer'] = '';
		GWF_Session::set(WCC_IP6_SESS, ++$level);
		echo GWF_HTML::message('WCIPv6', $chall->lang('msg_correct', array($level)));
	}
	else {
		echo $wechall->error('err_wrong');
	}
}

echo GWF_Box::box($chall->lang('info_'.$level), $chall->lang('title', array($level)));

formSolutionbox($chall);

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');

function wcc_ip6_check_answer(WC_Challenge $chall, $answer, $level)
{
	$solutions = array(
		1 => array('1'),
		2 => array('2^128', '340282366920938463463374607431768211456'),
		3 => array('http://[::1]:8080'),
		4 => array('1280'),
		5 => array('::ffff:123.45.67.89'),
		6 => array('badf:d:15ba:d::1'),
	);
	
	if ($level === 7)
	{
		return 1 === preg_match('/^2002:7B2D:4359:[0-9A-Z]{1,4}:[0-9A-Z]{1,4}:[0-9A-Z]{1,4}:[0-9A-Z]{1,4}:[0-9A-Z]{1,4}$/i', $answer);
	}
		
	if ($level === 8)
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		if (GWF_IP6::isV6($ip)) {
			$chall->onChallengeSolved(GWF_Session::getUserID());
		}
		return false;
	}
	
	return in_array(strtolower($answer), $solutions[$level], true);
}
?>