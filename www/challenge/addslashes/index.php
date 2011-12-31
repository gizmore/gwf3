<?php
chdir('../../');
define('GWF_PAGE_TITLE', 'Addslashes');
require_once('challenge/html_head.php');

if (false === ($chall = WC_Challenge::getByTitle('Addslashes'))) {
	$chall = WC_Challenge::dummyChallenge('Addslashes', 5, false, false);
}

$chall->showHeader();

# Mission
echo GWF_Box::box($chall->lang('info', array('addslashes.include', 'index.php?highlight=christmas')));


define('ADDSLASH_USERNAME', 'gizmore_addslash');
define('ADDSLASH_DATABASE', 'gizmore_addslash');
define('ADDSLASH_PASSWORD', 'addslash');

require_once 'addslashes.include';

if (false !== Common::getGet('login')) {
	if (true === asvsmysql_login(Common::getGet('username'), Common::getGet('password'))) {
		$chall->onChallengeSolved(GWF_Session::getUserID());
	}
}

if (false !== Common::getGet('highlight')) {
	$msg = file_get_contents('challenge/addslashes/addslashes.include');
	$msg = '[code=php title=addslashes.include]'.$msg.'[/code]';
	echo GWF_Box::box(GWF_Message::display($msg));
}

?>

<div class="box box_c">

<h2>欢迎登录页面</h2>
<h3>请登录</h3>
<?php
echo '<form action="index.php" method="get">';
echo '<div>用户名: <input type="text" name="username" value="" /></div>';
echo '<div>密码: <input type="password" name="password" value="" /></div>';
echo '<div><input type="submit" name="login" value="注册" /></div>';
echo '</form>';
echo '<hr/>';
echo '</div>';
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>
