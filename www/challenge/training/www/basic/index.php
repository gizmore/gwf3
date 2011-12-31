<?php
chdir("../../../../");
define('GWF_PAGE_TITLE', 'Training: WWW-Basics');
require_once("challenge/html_head.php");
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 1, 'challenge/training/www/basic/index.php');
}
$chall->showHeader();
$user = GWF_User::getStaticOrGuest();
$name = $user->getVar('user_name');
$username = urlencode($name);
$ip = $_SERVER['REMOTE_ADDR'];
$port = Common::getPostInt('port', 80);
$content = $chall->lang('content', array($name));
$url = sprintf('http://%s:%d/%s/%s.html', $ip, $port, $username, $username);
if (false !== Common::getPost('go')) {
	www_basic_go($chall, $url, $content);
}
echo GWF_Box::box($chall->lang('info', array(htmlspecialchars($url), htmlspecialchars($content), strlen($content))), $chall->lang('title'));
?>
<div class="box box_c">
<form action="index.php" method="post">
	<div><?php echo $chall->lang('port'); ?>: <input type="text" name="port" size="5" value="<?php echo $port; ?>" /></div>
	<div><input type="submit" name="go" value="<?php echo $chall->lang('btn_go'); ?>" /></div>
</form>
</div>
<?php
echo $chall->copyrightFooter();
require_once("challenge/html_foot.php");

function www_basic_go(WC_Challenge $chall, $url, $content)
{
	if (false === ($response = GWF_HTTP::getFromURL($url))) {
		echo GWF_HTML::error('WWW Basics', $chall->lang('err_file_not_found'));
	}
	elseif ($response !== $content) {
		echo GWF_HTML::error('WWW Basics', $chall->lang('err_wrong', array(htmlspecialchars($response), htmlspecialchars($content), strlen($response), strlen($content))));
	}
	else {
		$chall->onChallengeSolved(GWF_Session::getUserID());
	}
}
?>