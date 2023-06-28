<?php
chdir('../../../../');
define('GWF_PAGE_TITLE', 'Training: Bacon Returns');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/WC_CryptoChall.php';
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 3, 'challenge/training/encodings/bacon2/index.php', false);
}
$chall->showHeader();

if (isset($_POST['answer']) && is_string($_POST['answer'])) {
	$_POST['answer'] = strtoupper($_POST['answer']);
}
$SOLUTION = require_once 'challenge/training/encodings/bacon2/secret.php';
WC_CryptoChall::checkSolution($chall, $SOLUTION, true, false);

$href1 = GWF_WEB_ROOT.'challenge/training/encodings/bacon/index.php';

echo GWF_Box::box($chall->lang('info', array($href1)), $chall->lang('title'));

$hidden = bacon2_prepare_hidden($chall);

echo GWF_Box::box(bacon2_encode($chall, $hidden), $chall->lang('msg_title'));

formSolutionbox($chall);

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');

function bacon2_prepare_hidden(WC_Challenge $chall)
{
	global $SOLUTION;
	
	$solution = WC_CryptoChall::generateSolution($SOLUTION, true, false);
	$hidden = $chall->lang('hidden', array($solution));
	$hidden = str_replace(' ', 'X', $hidden);
	$hidden = strtoupper($hidden);#.'XX';
	return $hidden;
}

function bacon2_to_stream($hidden)
{
	$back = '';
	$a = ord('A');
	$len = strlen($hidden);
	for ($i = 0; $i < $len; $i++)
	{
		$c = ord($hidden[$i]) - $a;
		$back .= sprintf('%05d', decbin($c));
	}
	return $back;
}

function bacon2_encode(WC_Challenge $chall, $hidden)
{
	$back = '';
	$message = strtolower($chall->lang('message'));
	$mlen = strlen($message);
	$hiddenstream = bacon2_to_stream($hidden);
	$slen = strlen($hiddenstream);
	$si = 0;
	$pos = 0;
	
	
	
	while ($si < $slen)
	{
		if ($pos >= $mlen) {
			return GWF_HTML::error('Bacon2', $chall->lang('err_carrier'), false);
		}

		# current char in carrier
		$curr = $message[$pos];
		if ($curr >= 'a' && $curr <= 'z')
		{
			# what char do we need
			switch ($hiddenstream[$si])
			{
				case '0':
					if ($curr >= 'n') { # we need a 0 but fail
						$back .= $curr;
					} else {
						$back .= strtoupper($curr);
						$si++;
					}
					break;
				case '1':
					if ($curr >= 'n') { # we need a 1
						$back .= strtoupper($curr);
						$si++;
					} else {
						$back .= $curr;
					}
					break;
			}
		}
		else {
			$back .= $curr;
		}
		
		$pos++;
	}
	
	### 010101
//	$j = 0;
//	while ($pos < $mlen)
//	{
//		$curr = $message{$pos};
//		if ($curr >= 'a' && $curr <= 'z')
//		{
//			if ($j === 0) {
//				$back .= $curr;
//				$j = 1;
//			} else {
//				$back .= strtoupper($curr);
//				$j = 0;
//			}
//		}
//		else {
//			$back .= $curr;
//		}
//		
//		$pos++;
//	}
	
	$back .= substr($message, $pos);
	
	return $back;
}
?>
