<?php
chdir('../../');
define('GWF_PAGE_TITLE', 'Screwed Signup - Register');
require_once('challenge/html_head.php');
if (false === ($chall = WC_Challenge::getByTitle('Screwed Signup'))) {
	$chall = WC_Challenge::dummyChallenge('Screwed Signup', 7, 'challenge/screwed_signup/index.php', false);
}
$chall->showHeader();


require_once('screwed_signup.include');
if (isset($_POST['register']))
{
	screwed_signupRegister($chall);
}


?>
<div class="box"><a href="login.php"><?php echo $chall->lang('btn_login'); ?></a></div>

<?php htmlTitleBox($chall->lang('register_title'), $chall->lang('register_info')); ?>

<form action="" method="post">
	<?php #Session::CSRF(); ?>
	<table>
		<tr>
			<td><?php echo $chall->lang('th_username'); ?></td>
			<td><input type="text" name="username" value="" /></td>
		</tr>
		<tr>
			<td><?php echo $chall->lang('th_password'); ?></td>
			<td><input type="text" name="password" value="" /></td>
		</tr>
		<tr>
			<td><input type="submit" name="register" value="<?php echo $chall->lang('btn_register'); ?>" /></td>
			<td></td>
		</tr>
	</table>
</form>

<?php
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>
