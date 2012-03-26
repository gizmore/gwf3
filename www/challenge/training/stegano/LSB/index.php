<?php
define('LSB_IMAGE_PATH', 'challenge/training/stegano/LSB/gizmore2.png');
chdir('../../../../');
define('GWF_PAGE_TITLE', 'Training: LSB');
require_once 'challenge/html_head.php';
require_once GWF_CORE_PATH.'module/WeChall/WC_CryptoChall.php';
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, '/challenge/training/stegano/LSB/index.php', false);
}
$chall->showHeader();

if (isset($_POST['answer']) && is_string($_POST['answer'])) {
	$_POST['answer'] = strtoupper($_POST['answer']);
}
WC_CryptoChall::checkSolution($chall, 'YouAreNotLeanorado!', true, false);

$solution = WC_CryptoChall::generateSolution('YouAreNotLeanorado!', true, false);

$path = lsb_gen_image($solution);

$href = 'http://wechall.blogspot.com/2007/11/steganabara-explained.html';
$hidden_hint = sprintf('<p style="color: #eee;">Hidden Hint: %s</p>', $href);

$thx = 'buttmonkey';
if (false !== ($user = GWF_User::getByName($thx)))
{
	$thx = $user->displayProfileLink();
}
echo GWF_Box::box($chall->lang('info', array($hidden_hint, $thx)), $chall->lang('title'));

$title = $chall->lang('img_title');
$htmlimg = sprintf('<img src="%s%s" alt="%s" title="%s" width="480" height="212" />', GWF_WEB_ROOT, $path, $title, $title);
echo GWF_Box::box($htmlimg, $title);


formSolutionbox($chall);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');

function lsb_gen_image($solution)
{
	if (false === ($image = imagecreatefrompng(LSB_IMAGE_PATH))) {
		return GWF_WEB_ROOT.'error/Can_not_create_img';
	}
	
	if (false === imageistruecolor($image)) {
		return GWF_WEB_ROOT.'error/Image_not_true_color';
	}
	
	
	lsb_write_string($image, 0, $solution);
//	lsb_write_string($image, 1, $solution);
//	lsb_write_string($image, 2, $solution);

	$sessid = GWF_Session::getSessID();
	$out_path = "challenge/training/stegano/LSB/temp/{$sessid}.png";
// 	$out_path = 'dbimg/lsb/'.$sessid.'.png';
	
	imagepng($image, $out_path);
	
	imagedestroy($image);
	
	return $out_path;
}

function lsb_write_string($image, $n, $solution)
{
	$width = imagesx($image);
	$height = imagesy($image);
	$font = GWF_PATH.'extra/font/teen.ttf';
	$black = imagecolorallocate($image, 0, 0, 0);
	$white = imagecolorallocate($image, 255, 255, 255);
	
	$image2 = imagecreatetruecolor($width, $height);
	imagefilledrectangle($image2, 0, 0, $width, $height, $white);
	imagettftext($image2, 24, 10, 100, 100, $black, $font, $solution);
	lsb_write_string_b($n, $image, $image2);
//	imagepng($image2, "dbimg/lsb/$n.png");
	imagedestroy($image2);
}

function lsb_random_bit()
{
	$rand = array(1,2,3, 9,10,11, 17,18,19);
	return GWF_Random::arrayItem($rand);
}

function lsb_write_string_b($n, $image, $image2)
{
	$bit = lsb_random_bit();
	$bit = 1 << $bit;
	$width = imagesx($image);
	$height = imagesy($image);
	
	for ($y = 0; $y < $height; $y++)
	{
		for ($x = 0; $x < $width; $x++)
		{
			$p = imagecolorat($image2, $x, $y);
			$p2 = imagecolorat($image, $x, $y);
			if (($p&0x01)>0) {
				$p3 = $p2&(~$bit);
			} else {
				$p3 = $p2|$bit;
			}
			imagesetpixel($image, $x, $y, $p3);
		}
	}
}

?>