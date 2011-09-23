<?php
# Show src
if (isset($_GET['show']))
{
	# http://en.wikipedia.org/wiki/Quine_%28computing%29
	header('Content-Type: text/plain');
	die(file_get_contents('index.php'));
}

# Header
chdir('../../../');
define('GWF_PAGE_TITLE', 'Training: RegexMini');
require_once('html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, 'challenge/training/regex2/index.php', false);
}
$chall->showHeader();

# Info box
echo GWF_Box::box($chall->lang('info', array('index.php?show=source', 'index.php?highlight=christmas')), $chall->lang('title'));

if (isset($_GET['highlight']))
{
	$source = '[PHP title=regex2/index.php]'.file_get_contents('challenge/training/regex2/index.php').'[/PHP]';
	echo GWF_Box::box(GWF_Message::display($source, true, false));
}

# Submitted?
if (isset($_POST['submit']))
{
	# Check it!
	$error = ludde_is_satisfied($chall);
	
	# Oooops!
	if ($error === true)
	{
		$chall->onChallengeSolved(GWF_Session::getUserID());
	}
	
	# All normal and ok
	elseif ($error === false)
	{
		echo GWF_HTML::message(GWF_PAGE_TITLE, $chall->lang('msg_ok', array($_POST['username'])), false);
	}
	
	# Error!
	else
	{
		echo GWF_HTML::error(GWF_PAGE_TITLE, $error, false);
	}
}

# Check it!
function ludde_is_satisfied(WC_Challenge $chall)
{
	# Missing POST var?
	if (!isset($_POST['username']))
	{
		return $chall->lang('err_missing_var');
	}
	
	# Submitted a string?
	if (!is_string($_POST['username']))
	{
		return $chall->lang('err_var_type');
	}
	
	# Valid username?
	if (!preg_match('/^[a-zA-Z]{1,16}$/', $_POST['username']))
	{
		return $chall->lang('err_illegal_username', array(1, 16));
	}
	
	# WTF! WTF! WTF!
	if (strlen($_POST['username']) > 16)
	{
		return true;
	}
	
	# Normal, OK and no error :)
	return false; 
}
?>
<div id="EUISM" class="box box_c">
	<form id="Every User Input Seems Malicious" action="index.php" method="post">
		<label for="username"><?php echo $chall->lang('username'); ?></label>:&nbsp;<input type="text" name="username" value="" size="16" />
		<input type="submit" name="submit" value="<?php echo $chall->lang('submit'); ?>" />
	</form>
</div>
<?php
# Copyright + Footer
echo $chall->copyrightFooter();
require_once('html_foot.php');
?>