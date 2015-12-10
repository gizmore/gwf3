<?php
chdir("../../../");
define('GWF_PAGE_TITLE', 'Training: Encodings II');
require_once("challenge/html_head.php");
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle("Training: Encodings II"))) {
	$chall = WC_Challenge::dummyChallenge('Training: Encodings II');
}
$chall->showHeader();
$chall->onCheckSolution();
?>

<div class="box box_c">
	<?php echo $chall->lang('info'); ?>
	<br/>
	<br/>
<pre>
\u14cd\u14ca\u14ac\u14d1\u14d2\u14c9\u14bd\u14d1\u14d2\u14c1\u14ba\u14c4\u14cf\u14d2\u14ce\u14c7\u14cb\u14b5\u14c5
</pre>
</div>

<?php
formSolutionbox($chall);

$chall->copyrightFooter();
require_once("challenge/html_foot.php");
?>
