<?php
chdir('../../');
define('GWF_PAGE_TITLE', 'PHP 0817');
require_once('challenge/html_head.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 1, 'challenge/php0817/index.php');
}
$chall->showHeader();

$filename = 'challenge/php0817/php0817.include';
$code = '[php]'.file_get_contents($filename).'[/php]';
$code = GWF_Message::display($code, true, false, false);

$a2 = 'solution.php';
$a3 = 'index.php?which=0';
$a4 = 'index.php?which=1';
$a5 = 'index.php?which=2';

echo GWF_Box::box($chall->lang('info', array($code, $a2, $a3, $a4, $a5)), $chall->lang('title'));

$which = Common::getGetString('which', '');

if ( (strpos($which, '/') !== false) )
{
	echo GWF_HTML::error('PHP 0817', $chall->lang('err_security'));
}
else
{
	GWF_Debug::setMailOnError(false);
	echo '<div class="box box_c">'.PHP_EOL;
	require_once $filename;
	echo '</div>'.PHP_EOL;
	GWF_Debug::setMailOnError(true);
}

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
