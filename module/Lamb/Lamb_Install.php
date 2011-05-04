<?php
final class Lamb_Install
{
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
				'LAMB_OWNER' => array('gizmore', 'script'),
				'LAMB_VERSION' => array('2.0.1', 'script'),
				'LAMB_BLOCKING_IO' => array('NO', 'bool'),
				'LAMB_PING_TIMEOUT' => array('240', 'int', '30', '3600'),
				'LAMB_CONNECT_TIMEOUT' => array('20', 'int', '5', '300'),
				'LAMB_TRIGGER' => array('.', 'script'),
				'LAMB_SLEEP_MILLIS' => array('75', 'int', '5', '5000'),
				'LAMB_TIMER_INTERVAL' => array('10.0', 'float', '1.0', '7200.0'),
				'LAMB_HOSTNAME' => array('lamb.gizmore.org', 'script'),
				'LAMB_REALNAME' => array('Lamb2 - IRC Bot', 'script'),
				'LAMB_USERNAME' => array('Lamb2', 'script'),
				'LAMB_MODULES' => array('Link;News;Quote;Scum;Shadowlamb;Slapwarz', 'script'),
				'LAMB_SERVERS' => array(self::LAMB_SERVERS, 'script'),
				'LAMB_NICKNAMES' => array(self::LAMB_NICKNAMES, 'script'),
				'LAMB_PASSWORDS' => array(self::LAMB_PASSWORDS, 'script'),
				'LAMB_CHANNELS' => array(self::LAMB_CHANNELS, 'script'),
				'LAMB_ADMINS' => array(self::LAMB_ADMINS, 'script'),
			));
	}

	private static $DB_CLASSES = array('Lamb_Channel', 'Lamb_User');
	private static function installLamb(Module_Lamb $module, $dropTable)
	{
		if ('' !== ($error = GWF_ModuleLoader::installModuleClassesB($module, self::$DB_CLASSES, $dropTable))) {
			return $error;
		}
		$db = gdo_db();
		$table = GWF_TABLE_PREFIX.'lamb_server';
		$query =
			'CREATE TABLE IF NOT EXISTS '.$table.' ('.
			'serv_id    INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, '.
			'serv_name  VARCHAR(255) CHARACTER SET ascii COLLATE ascii_bin, '.
			'serv_ip    VARCHAR(40)  CHARACTER SET ascii COLLATE ascii_bin, '.
			'serv_maxusers INT(11) UNSIGNED NOT NULL DEFAULT 0, '.
			'serv_maxchannels INT(11) UNSIGNED NOT NULL DEFAULT 0, '.
			'serv_version VARCHAR(255) CHARACTER SET ascii COLLATE ascii_bin DEFAULT "", '.
			'serv_options INT(11) UNSIGNED NOT NULL DEFAULT 0, '.
			'serv_password VARCHAR(255) CHARACTER SET ascii COLLATE ascii_bin, '.
			'serv_nicknames TEXT CHARACTER SET ascii COLLATE ascii_bin, '.
			'serv_channels TEXT CHARACTER SET ascii COLLATE ascii_bin, '.
			'serv_admins TEXT CHARACTER SET ascii COLLATE ascii_bin '.
		') ENGINE=InnoDB DEFAULT CHARSET=utf8';
		
		if (false === $db->queryWrite($query)) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		
		return '';
	}
}
?>