<?php
$solution = require('railsbin.solution.php');
chdir('../../');
define('GWF_PAGE_TITLE', 'Railsbin');
require_once('challenge/html_head.php'); # output start of website
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
# get the challenge
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 5, 'challenge/railsbin/index.php', $solution);
}
# display the header
$chall->showHeader();

# check solution submission
$chall->onCheckSolution();

# display description
echo GWF_Box::box($chall->lang('info', array('https://github.com/gizmore/railsbin', 'http://railsbin.wechall.net')), $chall->lang('title'));

# display solutionbox
formSolutionbox($chall);

# display challenge footer
echo $chall->copyrightFooter();

# print end of website
require_once('challenge/html_foot.php');
