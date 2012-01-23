<?php
chdir('../../../');
define('GWF_PAGE_TITLE', 'Vermeer');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 3, 'challenge/XcrackX/Vermeer/index.php');
}
$chall->showHeader();
# -------------------------- #
$chall->onCheckSolution();
# -------------------------- #
$hint = sprintf('<span style="color: #def1ed">%s</span>', $chall->lang('hint'));
echo GWF_Box::box($chall->lang('info', array($hint)), $chall->lang('title'));
# -------------------------- #
echo GWF_Box::box(x169($chall), $chall->lang('title_ct'));
# -------------------------- #
echo formSolutionbox($chall);
# -------------------------- #
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>
<?php
function x169Matrix()
{
	return array(
		'43x10',
		'31x10',
		'17x16',
		'25x14',
		'40x12',
		'10x10',
		'37x12',
		'20x13',
		'34x16',
		'20x16',
		'43x13',
		'12x12',
		'35x13',
		'12x16',
		'34x10',
		'40x16',
		'26x14',
		'34x12',
		'17x12',
		'34x13',
		'27x11',
		'31x14',
		'43x16',
		'17x10',
		'12x14',
		'40x10',
		'22x10',
		'21x16',
		'42x16',
		'10x12',
		'37x14',
		'42x13',
		'31x16',
		'20x15',
		'16x10',
		'43x15',
		'36x13',
		'12x13',
		'20x10',
		'42x14',
		'17x11',
		'10x15',
		'43x14',
		'17x14',
		'37x16',
		'20x12',
		'34x15',
		'22x16',
		'28x10',
		'31x11',
		'15x13',
		'42x10',
		'25x15',
		'34x11',
		'20x14',
		'36x15',
		'25x13',
		'40x14',
		'10x11',
		'17x15',
		'41x10',
		'26x12',
		'34x14',
		'20x11',
		'40x15',
		'35x11',
		'15x16',
		'12x10',
		'37x15',
		'17x13',
		'25x12',
		'37x10',
		'15x10',
		'41x16',
		'25x10',
		'31x15',
		'21x10',
		'10x13',
		'15x14',
		'35x12',
		'12x11',
		'37x13',
		'25x11',
		'10x16',
		'15x15',
		'28x16',
		'36x14',
		'15x11',
		'40x11',
		'31x12',
		'27x15',
		'11x13',
		'37x11',
		'26x13',
		'40x13',
		'16x13',
		'31x13',
		'10x14',
		'15x12',
		'25x16',
		'12x15',
	);	
}

function x169(WC_Challenge $chall)
{
	$matrix = x169Matrix();
	shuffle($matrix);
	$embed = $chall->lang('embed');
	$el = strlen($embed);
	$ml = count($matrix);
	
	if ($el > $ml)
	{
		die('WHAT THE HACK!!!');
	}
	
	$embed .= str_repeat('o', $ml - $el + 1);
	
	$i = 0;
	$out = '';
	foreach ($matrix as $m)
	{
		$out .= mb_substr($embed, $i, 1, 'UTF8');
//		$out .= substr($embed, $i, 1);
		$out .= $m;
		$i++;
	}
	
	return $out;
}
?>
