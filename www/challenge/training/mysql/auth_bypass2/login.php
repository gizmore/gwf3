<?php
/* TABLE STRUCTURE
CREATE TABLE IF NOT EXISTS users (
userid    INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
username  VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
password  CHAR(32) CHARACTER SET ascii COLLATE ascii_bin NOT NULL
) ENGINE=myISAM;
*/

# Username and Password sent?
if ( ('' !== ($username = Common::getPostString('username'))) && (false !== ($password = Common::getPostString('password', false))) ) {
	auth2_onLogin($chall, $username, $password);
}

/**
 * Get the database for this challenge.
 * @return GWF_Database
 */
function auth2_db()
{
	if (false === ($db = gdo_db_instance('localhost', WCC_AUTH_BYPASS2_USER, WCC_AUTH_BYPASS2_PASS, WCC_AUTH_BYPASS2_DB))) {
		die('Database error 0815_2!');
	}
	$db->setLogging(false);
	$db->setEMailOnError(false);
	return $db;
}

/**
 * Exploit this! It is the same as MySQL-I, but with an additional check, marked with ###
 * @param WC_Challenge $chall
 * @param unknown_type $username
 * @param unknown_type $password
 * @return boolean
 */
function auth2_onLogin(WC_Challenge $chall, $username, $password)
{
	$db = auth2_db();
	
	$password = md5($password);
	
	$query = "SELECT * FROM users WHERE username='$username'";
	
	if (false === ($result = $db->queryFirst($query))) {
		echo GWF_HTML::error('Auth2', $chall->lang('err_unknown'), false);
		return false;
	}
	
	
	#############################
	### This is the new check ###
	if ($result['password'] !== $password) {
		echo GWF_HTML::error('Auth2', $chall->lang('err_password'), false);
		return false;
	} #  End of the new code  ###
	#############################
	
	
	echo GWF_HTML::message('Auth2', $chall->lang('msg_welcome_back', array(htmlspecialchars($result['username']))), false);
	
	if (strtolower($result['username']) === 'admin') {
		$chall->onChallengeSolved(GWF_Session::getUserID());
	}
	
	return true;
}
?>
<form action="index.php" method="post">
<table>
<tr>
	<td><?php echo $chall->lang('username'); ?>:</td>
	<td><input type="text" name="username" value="" /></td>
</tr>
<tr>
	<td><?php echo $chall->lang('password'); ?>:</td>
	<td><input type="password" name="password" value="" /></td>
</tr>
<tr>
	<td></td>
	<td><input type="submit" name="login" value="<?php echo $chall->lang('btn_login'); ?>" /></td>
</tr>
</table>
</form>
