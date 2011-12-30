<?php
chdir('../../');
define('GWF_PAGE_TITLE', 'Crackcha');
require_once('challenge/html_head.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 8, 'challenge/crackcha/index.php', false);
}
$chall->showHeader();

require_once 'challenge/crackcha/WC_Crackcha.php';

$table = GDO::table('WC_Crackcha');

$by = Common::getGetString('by', 'wccc_start');
$dir = Common::getGetString('dir', 'ASC');
$orderby = $table->getMultiOrderby($by, $dir);

$ipp = 50;
$nRows = $table->countRows();
$nPages = GWF_PageMenu::getPagecount($ipp, $nRows);
$page = Common::clamp(Common::getGetInt('page', 1), 1, $nPages);
$from = GWF_PageMenu::getFrom($page, $ipp);
$pagemenu = GWF_PageMenu::display($page, $nPages, sprintf('highscore.php?by=%s&dir=%s&page=%%PAGE%%', urlencode($by), urlencode($dir)));

$headers = array(
	array($chall->lang('th_start'), 'wccc_start'),
	array($chall->lang('th_user'), 'user_name'),
	array($chall->lang('th_time'), 'wccc_time'),
	array($chall->lang('th_count'), 'wccc_count'),
	array($chall->lang('th_solved'), 'wccc_solved'),
	array($chall->lang('th_rate'), 'wccc_rate'),
);

if (false === ($result = $table->select('*', '', $orderby, array('wccc_uid'), $ipp, $from))) {
	die('DB ERROR');
}

echo $pagemenu;
echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers, sprintf('highscore.php?by=%%BY%%&dir=%%DIR%%&page=1'));
$user = new GWF_User(false);
while (false !== ($row = $table->fetch($result, GDO::ARRAY_A)))
{
	$user->setGDOData($row);
	echo GWF_Table::rowStart();
	echo sprintf('<td class="gwf_date">%s</td>', GWF_Time::displayDate($row['wccc_start'])).PHP_EOL;
	echo sprintf('<td>%s</td>', $user->displayProfileLink()).PHP_EOL;
	echo sprintf('<td class="gwf_num">%ss</td>', $row['wccc_time']).PHP_EOL;
	echo sprintf('<td class="gwf_num">%s</td>', $row['wccc_count']).PHP_EOL;
	echo sprintf('<td class="gwf_num">%s</td>', $row['wccc_solved']).PHP_EOL;
	echo sprintf('<td class="gwf_num">%.02f%%</td>', $row['wccc_rate']).PHP_EOL;
	echo GWF_Table::rowEnd();
}
$table->free($result);
echo GWF_Table::end();
echo $pagemenu;

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>