<?php
chdir('../../../');
define('GWF_PAGE_TITLE', 'Training: Prime Factory');
require_once("challenge/html_head.php");
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle('Prime Factory'))) {
	$chall = WC_Challenge::dummyChallenge('Prime Factory', 1, 'index.php', '1');
}
$chall->showHeader();
$chall->onCheckSolution();
?>
<div class="box box_c"><?php echo $chall->lang('info'); ?></div>
<?php
formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>
