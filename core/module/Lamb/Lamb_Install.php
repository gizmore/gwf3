<?php
final class Lamb_Install
{
	public static $DB_CLASSES = array('Lamb_Server', 'Lamb_Channel', 'Lamb_User', 'Lamb_IRCFrom', 'Lamb_IRCTo');
	
	# Edit me!
	const LAMB_SERVERS = 'irc.giz.org:31346';
	const LAMB_NICKNAMES = 'Lamb2';
	const LAMB_PASSWORDS = 'lamblamb';
	const LAMB_CHANNELS = '#sr';
	const LAMB_ADMINS = 'gizmore';
//	const LAMB_SERVERS = 'irc.giz.org:31346;ircs://irc.freenode.net:7000;irc://irc.2600.net;ircs://irc.idlemonkeys.net:7000;ircs://DOminiOn.german-elite.net:6670';
//	const LAMB_NICKNAMES = 'Lamb2;Lamb2;Lamb2;Lamb2;Lamb2';
//	const LAMB_PASSWORDS = 'lamblamb;lamblamb;lamblamb;lamblamb;lamblamb';
//	const LAMB_CHANNELS = '#sr;#wechall,#shadowlamb;#shadowlamb;#wechall,#shadowlamb;#shadowlamb';
//	const LAMB_ADMINS = 'gizmore;gizmore;gizmore;gizmore;gizmore';
	
	public static function onInstall(Module_Lamb $module, $dropTable)
	{
		return
			self::installLamb($module, $dropTable). 
			GWF_ModuleLoader::installVars($module, array(
				'LAMB_VERSION' => array('2.0.1', 'script'),
				'LAMB_USERNAME' => array('Lamb2', 'script'),
				'LAMB_REALNAME' => array('Lamb2 - IRC Bot', 'script'),
				'LAMB_HOSTNAME' => array('lamb.gizmore.org', 'script'),
				'LAMB_MODULES' => array('Link;News;Quote;Scum;Shadowlamb;Slapwarz', 'script'),
				'LAMB_OWNER' => array('gizmore', 'script'),
				'LAMB_EVENTS' => array('NO', 'bool'),
				'LAMB_TRIGGER' => array('.', 'script'),
				'LAMB_LOGGING' => array('YES', 'bool'),
				'LAMB_PING_TIMEOUT' => array('360', 'int', '30', '3600'),
				'LAMB_CONNECT_TIMEOUT' => array('3', 'int', '5', '300'),
				'LAMB_SLEEP_MILLIS' => array('50', 'int', '5', '5000'),
				'LAMB_NICKREPLY' => array('YES', 'bool'),
				# Servers
				'LAMB_SERVERS' => array(self::LAMB_SERVERS, 'script'),
				'LAMB_NICKNAMES' => array(self::LAMB_NICKNAMES, 'script'),
				'LAMB_PASSWORDS' => array(self::LAMB_PASSWORDS, 'script'),
				'LAMB_CHANNELS' => array(self::LAMB_CHANNELS, 'script'),
				'LAMB_ADMINS' => array(self::LAMB_ADMINS, 'script'),
			));
	}

	private static function installLamb(Module_Lamb $module, $dropTable)
	{
		if ('' !== ($error = GWF_ModuleLoader::installModuleClassesB($module, self::$DB_CLASSES, $dropTable)))
		{
			return $error;
		}
		return '';
	}
}
?>