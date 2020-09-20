<?php
# Show src
if (isset($_GET['show']))
{
	# http://en.wikipedia.org/wiki/Quine_%28computing%29
	header('Content-Type: text/plain');
	die(file_get_contents('vulnerable.php'));
}

# Header
define('GWF_PAGE_TITLE', 'Training: Time is of the Essence');
$password = require 'password.php';
chdir('../../../');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
    $chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 6, 'challenge/training/timing1/index.php', $password);
}
$chall->showHeader();

# Submitted?
if (isset($_POST['solve']))
{
    $solved = require 'challenge/training/timing1/vulnerable.php';
    if ($solved)
    {
        $chall->onChallengeSolved();
    }
    else
    {
        echo WC_HTML::error('err_wrong');
    }
}

# Info box
echo GWF_Box::box($chall->lang('info', array('index.php?show=source', 'index.php?highlight=christmas')), $chall->lang('title'));

# Show highlighted src
if (isset($_GET['highlight']))
{
	$source = '[PHP title=timing1/vulnerable.php]'.file_get_contents('challenge/training/timing1/vulnerable.php').'[/PHP]';
	echo GWF_Box::box(GWF_Message::display($source, true, false));
}


formSolutionbox($chall);

# Copyright + Footer
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
