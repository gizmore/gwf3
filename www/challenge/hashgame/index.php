<?php
require_once 'hg_wc3.php';
require_once 'hg_wc4.php';
require_once 'passwords.php';
chdir('../../');
define('GWF_PAGE_TITLE', 'WC Hashing Game');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, '/challenge/hashgame/index.php', false);
}
$chall->showHeader();

if ('' !== ($answer = Common::getPostString('answer'))) {
	hashgame_check_answer($chall, $answer, $list1, $list2);
}

if (false !== ($z = GWF_User::getByName('Z'))) {
	$credits = $z->displayProfileLink();
} else {
	$credits = 'Z';
}

echo GWF_Box::box($chall->lang('info', array('index.php?list=wc3', 'index.php?algo=wc3', 'index.php?list=wc4', 'index.php?algo=wc4', $credits)), $chall->lang('title'));

if (Common::getGetString('algo') === 'wc3') {
	$code = sprintf('[PHP title=hg_wc3.php]%s[/PHP]', file_get_contents('challenge/hashgame/hg_wc3.php'));
	echo GWF_Box::box(GWF_Message::display($code));
}
elseif (Common::getGetString('algo') === 'wc4') {
	$code = sprintf('[PHP title=hg_wc4.php]%s[/PHP]', file_get_contents('challenge/hashgame/hg_wc4.php'));
	echo GWF_Box::box(GWF_Message::display($code));
}
if (Common::getGetString('list') === 'wc3') {
	$content = '';
	$content .= GWF_Table::start();
	foreach ($list1 as $plaintext) {
		$content .= GWF_Table::rowStart();
		$content .= sprintf('<td style="font-family:monospace;">%s</td>', hashgame_wc3($plaintext));
		$content .= GWF_Table::rowEnd();
	}
	$content .= GWF_Table::end();
	echo GWF_Box::box($content, $chall->lang('tt_list_wc3', array('index.php?algo=wc3&list=wc3')));
}
elseif (Common::getGetString('list') === 'wc4') {
	$content = '';
	$content .= GWF_Table::start();
	foreach ($list2 as $plaintext) {
		$content .= GWF_Table::rowStart();
		$content .= sprintf('<td style="font-family:monospace;">%s</td>', hashgame_wc4($plaintext));
		$content .= GWF_Table::rowEnd();
	}
	$content .= GWF_Table::end();
	echo GWF_Box::box($content, $chall->lang('tt_list_wc4', array('index.php?algo=wc4&list=wc4')));
}

formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');

####################
### Check answer ###
####################
function sort_strlen($a, $b)
{
	return strlen($b) - strlen($a);
}

function hashgame_longest_two(array $list)
{
	usort($list, 'sort_strlen');
	return array(array_shift($list),array_shift($list));
}

function hashgame_check_answer(WC_Challenge $chall, $answer, array $list1, array $list2)
{
	$solutions = array_merge(hashgame_longest_two($list1), hashgame_longest_two($list2));
	$answers = explode(',', $answer);
	if (count($answers) !== 4) {
		echo GWF_HTML::error('HashGame', $chall->lang('err_answer_count', array(count($answers))), false);
//		return false;
	}
	
	if (count($answers) > 4) {
		echo GWF_HTML::error('HashGame', $chall->lang('err_answer_count_high', array(count($answers))), false);
		$answers = array_slice($answers, 0, 4);
	}
	
	$correct = 0;
	foreach ($answers as $word)
	{
		$word = trim($word);
		foreach ($solutions as $i => $solution)
		{
			if ($word === $solution)
			{
				unset($solutions[$i]);
				$correct++;
				break;
			}
		}
	}
	
	if ($correct === 4) {
		$chall->onChallengeSolved(GWF_Session::getUserID());
	}
	else {
		echo GWF_HTML::error('HashGame', $chall->lang('err_some_good', array($correct)), false);
	}
}
?>
