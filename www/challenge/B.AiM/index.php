<?php
chdir('../../'); # chroot to web root
define('GWF_PAGE_TITLE', 'B.AiM'); # Wrapper hack
require_once('challenge/html_head.php'); # output start of website
# Get the challenge
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 7, 'challenge/B.AiM/index.php');
}
# And display the header
$chall->showHeader();

if (false === ($u = GWF_User::getByName('gizmore'))) {
	$gizmore = '<b>gizmore</b>';
	$egizmore = 'gizmore{at}wechall{dot}net';
} else {
	$gizmore = $u->displayProfileLink();
	$egizmore = $u->displayEMail();
}

if (false === ($u = GWF_User::getByName('BAIM'))) {
	$baim = '<b>BAIM</b>';
	$ebaim = 'baim{at}wechall{dot}net';
} else {
	$baim = $u->displayProfileLink();
	$ebaim = $u->displayEMail();
}

$url = 'http://baim.gizmore.org';
$url2 = '/download/22/B_AiM_uncracked_zip';

echo GWF_Box::box($chall->lang('info', array($baim, $gizmore, $url, $ebaim, $egizmore, GWF_User::getStaticOrGuest()->displayUsername())), $chall->lang('title'));
echo GWF_Box::box($chall->lang('new_info', array($url2)), $chall->lang('title'));

require_once 'challenge/B.AiM/baim_solve_form.php';
if (WC_BaimForms::hasPermission()) {
	echo GWF_Box::box($chall->lang('info_unlock', array('solved_it.php')), $chall->lang('form_title'));
	
}

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php'); # output start of website
?>