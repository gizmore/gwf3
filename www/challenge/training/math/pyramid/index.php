<?php
# Change dir to web root
chdir('../../../../');
define('GWF_PAGE_TITLE', 'Training: Math Pyramid');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'inc/3p/EvalMath.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, 'challenge/training/math/pyramid/index.php', false);
}
$chall->showHeader();

$maxlen = GWF_Settings::getSetting('WC_MATH_PYRAMID', 1000);

$img = sprintf('<img src="%schallenge/training/math/pyramid/pyramid.png" title="pyramid.png" alt="pyramid.png" />', GWF_WEB_ROOT);

# credits
if (false !== ($momo = GWF_User::getByName('momo'))) {
	$c1 = $momo->displayProfileLink();
} else {
	$c1 = '<b>Momo</b>';
}
if (false !== ($jinx = GWF_User::getByName('Jinx'))) {
	$c2 = $jinx->displayProfileLink();
} else {
	$c2 = '<b>Jinx</b>';
}
if (false !== ($paipai = GWF_User::getByName('paipai'))) {
	$c3 = $paipai->displayProfileLink();
} else {
	$c3 = '<b>paipai</b>';
}
$c4 = '<b>Miles Kaufmann</b>';

echo GWF_Box::box($chall->lang('info', array($maxlen, $img, $c1, $c2, $c3, $c4)), $chall->lang('title'));

if (WC_ChallSolved::hasSolved(GWF_Session::getUserID(), $chall->getID())) {
	require_once GWF_CORE_PATH.'module/WeChall/WC_MathChall.php';
	echo GWF_Box::box(WC_HTML::lang('msg_wmc_solved', array($chall->display('chall_title'), WC_MathChall::getLimitedHREF($chall, 0))));
}

if ('' !== ($formula = Common::getPostString('formula'))) {
	math_pyramid_check($chall, $formula, $maxlen);
}
?>
<div class="box box_c">
<form action="index.php" method="post">
<div><?php echo $chall->lang('th_formula'); ?>: <input type="text" name="formula" value="<?php echo htmlspecialchars($formula); ?>" /> <input type="submit" name="btn" value="<?php echo $chall->lang('btn_go'); ?>" /></div>
</form>
</div>
<?php
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>
<?php
function math_pyramid_check(WC_Challenge $chall, $formula, $maxlen, $precision=4)
{
	error_reporting(E_ERROR);
	GWF_Debug::setDieOnError(false);
	GWF_Debug::setMailOnError(false);
	
	$len = strlen($formula);
	
	$tests = array(
		'0' => 0,
		'1' => 0.2357,
		'3.14' => 7.2971,
		'10' => 235.7023,
		'100' => 235702.2604,
	);
	
	$eval = new EvalMath();
	$fa = "f(a) = $formula";
	if (false === $eval->evaluate($fa)) {
		echo GWF_HTML::error('Math Pyramid', $chall->lang('err_formula', array(htmlspecialchars($fa))));
		return false;
	}
	
	GWF_Debug::setDieOnError(true);
	GWF_Debug::setMailOnError(true);
	
	$back = GWF_HTML::message('Math Pyramid', $chall->lang('msg_formula', array(htmlspecialchars($fa))), false);
	
	$correct = 0;
	foreach ($tests as $a => $result)
	{
		$result2 = $eval->evaluate("f($a)");
		$result = sprintf('%.0'.$precision.'f', $result);
		$result2 = sprintf('%.0'.$precision.'f', $result2);
		if ($result === $result2) {
			$back .= GWF_HTML::message('Math Pyramid', $chall->lang('msg_correct', array($a, $result2, $result)), false);
			$correct++;
		} else {
			$back .= GWF_HTML::error('Math Pyramid', $chall->lang('err_wrong', array($a, $result2, $result)), false);
		}
	}
	
	require_once GWF_CORE_PATH.'module/WeChall/WC_MathChall.php';
	if ( ($chall->getID() > 0) && ($correct === count($tests)) ) {
		if (false === WC_MathChall::insertSolution($chall->getID(), GWF_Session::getUserID(), $formula)) {
			$back .= GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		} else {
			$back .= GWF_HTML::message('Math Pyramid', WC_HTML::lang('msg_wmc_sol_inserted', array($len, WC_MathChall::getLimitedHREF($chall, $len))), false);
		}
	}
	
	# Check Len
	if ($len > $maxlen) {
		$back .= GWF_HTML::error('Math Pyramid', $chall->lang('err_too_long', array($len, $maxlen)), false);
	}
	
	echo $back;

	if ( ($correct === count($tests)) && ($len <= $maxlen) ) {
		if ($len < $maxlen) {
			echo GWF_HTML::message('Math Pyramid', $chall->lang('msg_new_record', array($len, $maxlen)), false);
			GWF_Settings::setSetting('WC_MATH_PYRAMID', $len);
		}
		$chall->onChallengeSolved(GWF_Session::getUserID());
	}
}
?>