<?php
chdir('../../../');
define('GWF_PAGE_TITLE', 'Z - Reloaded');
require_once('challenge/html_head.php');
$title = 'Z - Reloaded';
if (false === ($chall = WC_Challenge::getByTitle($title))) {
	$chall = WC_Challenge::dummyChallenge($title, 6, '/challenge/Z/reloaded', false);
}
$chall->showHeader();

htmlTitleBox($chall->lang('title'), $chall->lang('info', array('zshellz.php')));

echo $chall->copyrightFooter();

require_once('challenge/html_foot.php');
?>
