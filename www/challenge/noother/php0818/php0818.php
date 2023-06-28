<?php
chdir('../../../');
define('GWF_PAGE_TITLE', 'PHP 0818');
require_once('challenge/html_head.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 3, 'challenge/noother/php0818/index.php', false);
}
$chall->showHeader();
# ------ 8< ------ 8< ------ 8< ------ 8< ------ #
if (isset($_POST['answer']))
{
	if (noother_says_correct(Common::getPostString('number')))
	{
		$chall->onChallengeSolved(GWF_Session::getUserID());
	}
	else
	{
		echo GWF_HTML::error('PHP 0818', $chall->lang('err_wrong'), false);
	}
}
function noother_says_correct($number)
{
	$one = ord('1');
	$nine = ord('9');
	# Check all the input characters!
	for ($i = 0; $i < strlen($number); $i++)
	{ 
		# Disallow all the digits!
		$digit = ord($number[$i]);
		if ( ($digit >= $one) && ($digit <= $nine) )
		{
			# Aha, digit not allowed!
			return false;
		}
	}
	
	# Allow the magic number ...
	return $number == "3735929054";
}
# ------ 8< ------ 8< ------ 8< ------ 8< ------ #
?>
<div class="box box_c">
	<form action="php0818.php" method="post" enctype="application/x-www-form-urlencoded">
		<div><?php echo $chall->lang('your_magic_number'); ?>: <input type="text" name="number" value="" size="10" /></div>
		<div><input type="submit" name="answer" value="<?php echo $chall->lang('btn_submit'); ?>" /></div>
	</form>
</div>
<?php
# Foo-Tah!
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>
