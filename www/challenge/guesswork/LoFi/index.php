<?php
$solution = require 'solution.php';
chdir('../../../');
define('GWF_PAGE_TITLE', 'LoFi');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 1, 'challenge/guesswork/LoFi/index.php', $solution);
}
$chall->showHeader();

$hrefMP3 = 'http://mp3.gizmore.org';
$guesswork = WC_Challenge::getByTitle('Guesswork');
$hrefGuesswork = '/challenge/guesswork/index.php';

if ( (false === ($user = GWF_Session::getUser())) ||
     (!WC_ChallSolved::hasSolved($user->getID(), $guesswork->getID())) )
{
	echo GWF_HTML::error($chall->getTitle(), $chall->lang('err_guesswork', [$hrefGuesswork]));
}
else
{
	if (false === ($mod_forum = GWF_Module::loadModuleDB('Forum', true, true))) {
		echo GWF_HTML::err('ERR_MODULE_MISSING', 'Forum');
	}
	else {
		
		$chall->onCheckSolution();
		
		$msg1 = $chall->lang('msg_wechall');
		
		$msg2 = $chall->lang('msg_gizmore', [$hrefMP3]);
		
		$user1 = GWF_User::getByName('WeChall');
		$user2 = GWF_User::getByName('Gizmore');
		$posts = array(
			GWF_ForumPost::fakePost($user1, $chall->lang('msg_title'), $msg1, 0, 0, 0, '20220430023137', true),
			GWF_ForumPost::fakePost($user2, 'Re: '.$chall->lang('msg_title'), $msg2, 0, 0, 0, '20220430023142', true),
		);
		
		$tVars = array(
			'thread' => GWF_ForumThread::fakeThread($user1, $chall->lang('msg_title')),
			'posts' => $posts,
			'pagemenu' => '',
			'actions' => false,
			'title' => false,
			'reply' => true,
			'nav' => false,
			'can_vote' => false,
			'can_thank' => false,
			'term' => '',
		);
		$mod_forum->onLoadLanguage();
		echo GWF_Box::box($mod_forum->templatePHP('show_thread.php', $tVars));
	}
}

formSolutionbox($chall, 2048);

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
