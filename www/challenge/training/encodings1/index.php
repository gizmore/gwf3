<?php
chdir("../../../");
define('GWF_PAGE_TITLE', 'Training: Encodings I');
require_once("challenge/html_head.php");
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle("Training: Encodings I"))) {
	$chall = WC_Challenge::dummyChallenge('Training: Encodings I');
}
$chall->showHeader();
$chall->onCheckSolution();
?>

<div class="box box_c">
	<?php echo $chall->lang('info', array(GWF_WEB_ROOT.'tools/JPK')); ?>
	<br/>
	<br/>
<pre>
10101001101000110100111100110100
00011101001100101111100011101000
10000011010011110011010000001101
11010110111000101101001111010001
00000110010111011101100011110111
11100100110010111001000100000110
00011110011110001111010011101001
01011100100000101100111011111110
10111100100100000111000011000011
11001111100111110111110111111100
10110010001000001101001111001101
00000110010111000011110011111100
11110011111010011000011110010111
0100110010111100100101110
</pre>
</div>

<?php
formSolutionbox($chall);

$chall->copyrightFooter();
require_once("challenge/html_foot.php");
?>