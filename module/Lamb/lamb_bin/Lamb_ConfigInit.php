<?php
require_once 'Lamb_Config.php';
define('LAMB_HOSTNAME', $LAMB_CFG['hostname']);
define('LAMB_REALNAME', $LAMB_CFG['realname']);
define('LAMB_USERNAME', $LAMB_CFG['username']);
define('LAMB_MODULES', $LAMB_CFG['modules']);
define('LAMB_TRIGGER', $LAMB_CFG['trigger']);
define('LAMB_OWNER', $LAMB_CFG['owner']);
define('LAMB_VERSION', $LAMB_CFG['version']);
define('LAMB_BLOCKING_IO', $LAMB_CFG['blocking_io']);
define('LAMB_PING_TIMEOUT', $LAMB_CFG['ping_timeout']);
define('LAMB_CONNECT_TIMEOUT', $LAMB_CFG['connect_timeout']);
define('LAMB_SLEEP_MILLIS', $LAMB_CFG['sleep_millis']);
define('LAMB_TIMER_INTERVAL', $LAMB_CFG['timer_interval']);
define('LAMB_REPLY_ISSUING_NICK', $LAMB_CFG['send_command_issuer_nickname_on_reply']);

$hosts = $nicks = $passs = $chans = $admns = array();
foreach ($LAMB_CFG['servers'] as $data)
{
	$hosts[] = $data['host'];
	$nicks[] = $data['nickname'];
	$passs[] = $data['password'];
	$chans[] = $data['channels'];
	$admns[] = $data['admins'];
}
define('LAMB_SERVERS', trim(implode(';', $hosts), ';'));
define('LAMB_NICKNAMES', trim(implode(';', $nicks), ';'));
define('LAMB_PASSWORDS', trim(implode(';', $passs), ';'));
define('LAMB_CHANNELS', trim(implode(';', $chans), ';'));
define('LAMB_ADMINS', trim(implode(';', $admns), ';'));
?>