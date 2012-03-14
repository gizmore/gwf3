<?php
require_once LAMB_CONFIG_FILENAME;
# Version
define('LAMB_VERSION', $LAMB_CFG['version']);
# Info
define('LAMB_USERNAME', $LAMB_CFG['username']);
define('LAMB_REALNAME', $LAMB_CFG['realname']);
define('LAMB_HOSTNAME', $LAMB_CFG['hostname']);
# Modules
define('LAMB_MODULES', $LAMB_CFG['modules']);
# Various
define('LAMB_OWNER', $LAMB_CFG['owner']);
define('LAMB_TRIGGER', $LAMB_CFG['trigger']);
define('LAMB_LOGGING', $LAMB_CFG['logging']?true:false);
define('LAMB_SLEEP_MILLIS', $LAMB_CFG['sleep_millis']);
define('LAMB_EVENT_PLUGINS', $LAMB_CFG['event_plugins']?true:false);
define('LAMB_PING_TIMEOUT', $LAMB_CFG['ping_timeout']);
define('LAMB_CONNECT_TIMEOUT', $LAMB_CFG['connect_timeout']);
define('LAMB_REPLY_ISSUING_NICK', $LAMB_CFG['send_command_issuer_nickname_on_reply']?true:false);
###############
### Servers ###
###############
$hosts = $nicks = $passs = $chans = $admns = $optss = array();
foreach ($LAMB_CFG['servers'] as $data)
{
	$hosts[] = $data['host'];
	$nicks[] = $data['nickname'];
	$passs[] = $data['password'];
	$chans[] = $data['channels'];
	$admns[] = $data['admins'];
	$optss[] = isset($data['options']) ? (string)$data['options'] : '0';
}
define('LAMB_SERVERS', trim(implode(';', $hosts), ';'));
define('LAMB_NICKNAMES', trim(implode(';', $nicks), ';'));
define('LAMB_PASSWORDS', trim(implode(';', $passs), ';'));
define('LAMB_CHANNELS', trim(implode(';', $chans), ';'));
define('LAMB_ADMINS', trim(implode(';', $admns), ';'));
define('LAMB_OPTIONS', trim(implode(';', $optss), ';'));
?>