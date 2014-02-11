<?php
$secret = require('secret.php');
chdir('../../../');
define('GWF_PAGE_TITLE', 'Table Names II');
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');

if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 6, 'challenge/nurfed/more_table_names/index.php', $secret['flag']);
}
$chall->showHeader();
$chall->onCheckSolution();

if (false !== Common::getGet('login'))
{
	$username = Common::getGetString('username', '');
	$password = Common::getGetString('password', '');
	
	if (preg_match('/statistics|tables|columns|table_constraints|key_column_usage|partitions|schema_privileges|schemata|database/i', $username.$password))
	{
		echo GWF_HTML::error(GWF_PAGE_TITLE, $chall->lang('on_match'));
	}
	else
	{
		if (false === ($db = gdo_db_instance($secret['host'], $secret['username'], $secret['password'], $secret['database'])))
		{
			die('Database error.');
		}

		$db->setVerbose(false);
		$db->setLogging(false);
		$db->setEMailOnError(false);
		
		
		$query = "SELECT * FROM {$secret['database']}.{$secret['table_name']} WHERE username='$username' AND password='$password'";
		if (false === ($result = ($db->queryFirst($query, false))))
		{
			echo GWF_HTML::error(GWF_PAGE_TITLE, $chall->lang('on_login_fail'));
		}
		else
		{
			echo GWF_HTML::message(GWF_PAGE_TITLE, $chall->lang('on_logged_in', array(GWF_HTML::display($result['username']), GWF_HTML::display($result['message']))));
		}
	}
}

?>
<div class="box box_c">
<form action="challenge.php" method="get">
<div><?php echo $chall->lang('username'); ?>: <input type="text" name="username" value="" /></div>
<div><?php echo $chall->lang('password'); ?>: <input type="text" name="password" value="" /></div>
<div><input type="submit" name="login" value="<?php echo $chall->lang('login'); ?>" /></div>
</form>
</div>
<?php
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
