<?php
chdir("../../../../");
define('GWF_PAGE_TITLE', 'Training: WWW-Rewrites');
require_once("challenge/html_head.php");
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 1, 'challenge/training/www/rewrite/index.php');
}
$chall->showHeader();
$user = GWF_User::getStaticOrGuest();
$name = $user->getVar('user_name');
$username = urlencode($name);
$ip = $_SERVER['REMOTE_ADDR'];
$port = Common::getPostInt('port', 80);
$url = sprintf('http://%s:%d/%s/', $ip, $port, $username);
if (false !== Common::getPost('go')) {
	www_rewrite_go($chall, $url);
}
echo GWF_Box::box($chall->lang('info', array(htmlspecialchars($url))), $chall->lang('title'));

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

function www_rewrite_go(WC_Challenge $chall, $url)
{
	$n1 = rand(1000000, 1000000000).rand(1000000, 1000000000);
	$n2 = rand(1000000, 1000000000).rand(1000000, 1000000000);
	$solution = bcmul($n1, $n2);
	$url .= $n1.'_mul_'.$n2.'.html';
	if (false === ($response = GWF_HTTP::getFromURL($url))) {
		echo GWF_HTML::error('WWW Rewrite', $chall->lang('err_file_not_found'));
	}
	elseif ($response !== $solution) {
		echo GWF_HTML::error('WWW Rewrite', $chall->lang('err_wrong', array(htmlspecialchars($response), htmlspecialchars($solution), strlen($response), strlen($solution))));
	}
	else {
		$chall->onChallengeSolved(GWF_Session::getUserID());
	}
}
?>