<?php
chdir('../../');
define('GWF_PAGE_TITLE', 'Screwed Signup');
require_once('challenge/html_head.php');
if (false === ($chall = WC_Challenge::getByTitle('Screwed Signup'))) {
	$chall = WC_Challenge::dummyChallenge('Screwed Signup', 7, 'challenge/screwed_signup/index.php', false);
}
$chall->showHeader();

switch (Common::getGet('hl'))
{
	case 'src': $highlight = 'screwed_signup.include'; break;
	case 'Login': $highlight = 'login.php'; break;
	case 'Register': $highlight = 'register.php'; break;
	default: break;
}

if (isset($highlight)) {
	$msg = file_get_contents('challenge/screwed_signup/'.$highlight);
	$msg = '[code=php title='.$highlight.']'.$msg.'[/code]';
	echo GWF_Box::box(GWF_Message::display($msg, true, true, true));
}

htmlTitleBox($chall->lang('title'), $chall->lang('info', array('screwed_signup.include', 'index.php?hl=src', 'index.php?hl=Login', 'index.php?hl=Register')));
?>
<div class="box box_c">
<div style="margin: 4px;"><a href="register.php">Register</a></div>
<div style="margin: 4px;"><a href="login.php">Login</a></div>
</div>
<?php
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>
