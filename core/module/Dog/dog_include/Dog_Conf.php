<?php
/**
 * Configuration tables.
 * There are 12 of them, for user/channel/server/module/plugin/bot variations.
 * @author gizmore
 * @version 4.0
 */
abstract class Dog_Conf extends GDO
{
	public function getClassName() { return __CLASS__; }
	
	protected abstract function getConfColumnName(); # conf_sid
	protected abstract function getConfColumnDefine(); #getIntegerColumnDefine()

	public function getTableName() { return GWF_TABLE_PREFIX.strtolower($this->getClassName()); }
	public function getColumnDefines()
	{
		return array(
			$this->getConfColumnName() => $this->getConfColumnDefine(),
			'conf_key' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S|GDO::PRIMARY_KEY, GDO::NOT_NULL, 63),
			'conf_value' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_S),
		);
	}

	protected function getTable() { return self::table($this->getClassName()); }
	
	protected function getConfWhere($id, $key)
	{
		return sprintf('%s=\'%s\' AND conf_key=\'%s\'',
			$this->getConfColumnName(), self::escape($id), self::escape($key)
		);
	}
	
	public function get($id, $key, $default)
	{
		if (false === ($value = $this->getCached($id, $key)))
		{
			if (false === ($value = $this->getTable()->selectVar('conf_value', $this->getConfWhere($id, $key))))
			{
				$value = $default;
			}
			$this->setCache($id, $key, $value);
		}
		
// 		if (!in_array($key, array('throttle')))
// 		{
// 			echo $this->getClassName()." GET ID=$id key=$key def=$default value=$value\n";
// 		}
		
		return $value;
	}
	
	private static $CACHE = array('Dog_Conf_Bot' => array(),'Dog_Conf_Chan' => array(),'Dog_Conf_Mod' => array(),'Dog_Conf_Mod_Chan' => array(),'Dog_Conf_Mod_Serv' => array(),'Dog_Conf_Mod_User' => array(),'Dog_Conf_Plug' => array(),'Dog_Conf_Plug_Chan' => array(),'Dog_Conf_Plug_Serv' => array(),'Dog_Conf_Plug_User' => array(),'Dog_Conf_User' => array(), /* Dog_Conf_Serv' => array()*/);
	public static function flushCache()
	{
		self::$CACHE = array('Dog_Conf_Bot' => array(),'Dog_Conf_Chan' => array(),'Dog_Conf_Mod' => array(),'Dog_Conf_Mod_Chan' => array(),'Dog_Conf_Mod_Serv' => array(),'Dog_Conf_Mod_User' => array(),'Dog_Conf_Plug' => array(),'Dog_Conf_Plug_Chan' => array(),'Dog_Conf_Plug_Serv' => array(),'Dog_Conf_Plug_User' => array(),'Dog_Conf_User' => array(), /* Dog_Conf_Serv' => array()*/);
	}
	
	private function getCached($id, $key)
	{
		if (isset(self::$CACHE[$this->getClassName()][$id.':'.$key]))
		{
			return self::$CACHE[$this->getClassName()][$id.':'.$key];
		}
		return false;
	}
	
	public function setCache($id, $key, $value)
	{
		self::$CACHE[$this->getClassName()][$id.':'.$key] = $value;
	}
	
	
	public function unsetCache($id, $key)
	{
		unset(self::$CACHE[$this->getClassName()][$id.':'.$key]);
	}
	
	public function set($id, $key, $value)
	{
		$value = $this->convertValue($value);
		$this->setCache($id, $key, $value);
		return $this->getTable()->insertAssoc(array(
			$this->getConfColumnName() => $id,
			'conf_key' => $key,
			'conf_value' => $value,
		));
	}
	
	private function convertValue($value)
	{
		if (is_bool($value))
		{
			return $value === true ? '1' : '0';
		}
		return (string) $value;
	}
	
	public function remove($id, $key)
	{
		return $this->getTable()->deleteWhere($this->getConfWhere($id, $key));
	}
}

######################
### Helper classes ###
######################
abstract class Dog_ConfInteger extends Dog_Conf
{
	protected function getConfColumnDefine() { return array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL); }
}

abstract class Dog_ConfText extends Dog_Conf
{
	protected function getConfColumnDefine() { return array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S|GDO::PRIMARY_KEY, GDO::NOT_NULL, 63); }
}

#####################
### Config Tables ###
### Alphabetically ###
######################
# 1.Bot
final class Dog_Conf_Bot extends Dog_ConfInteger
{
	public function getClassName() { return __CLASS__; }
	public function getConfColumnName() { return 'conf_stub_id'; }
	public static function getConf($key, $def) { return self::table(__CLASS__)->get('1', $key, $def); }
	public static function setConf($key, $val) { return self::table(__CLASS__)->set('1', $key, $val); }
	public static function setLogging($mode) { return self::setConf('logging', 'mode'); }
}

# 2.Channel
final class Dog_Conf_Chan extends Dog_ConfInteger
{
	public function getClassName() { return __CLASS__; }
	public function getConfColumnName() { return 'conf_cid'; }
	public static function getConf($cid, $key, $def) { return self::table(__CLASS__)->get($cid, $key, $def); }
	public static function setConf($cid, $key, $val) { return self::table(__CLASS__)->set($cid, $key, $val); }
}

# 3.Module (Global)
final class Dog_Conf_Mod extends Dog_ConfText
{
	public function getClassName() { return __CLASS__; }
	public function getConfColumnName() { return 'conf_module'; }
	public static function getConf($mod, $key, $def) { return self::table(__CLASS__)->get($mod, $key, $def); }
	public static function setConf($mod, $key, $val) { return self::table(__CLASS__)->set($mod, $key, $val); }
	public static function setDisabled($mod, $disabled='1') { return self::setConf($mod, 'disabled', $disabled); }
	public static function isDisabled($mod, $def='0') { return self::getConf($mod, 'disabled', $def) === '1'; }
}

# 4.Module Channel
final class Dog_Conf_Mod_Chan extends Dog_ConfText
{
	public function getClassName() { return __CLASS__; }
	public function getConfColumnName() { return 'conf_mcid'; }
	public static function getConf($mod, $cid, $key, $def) { return self::table(__CLASS__)->get($cid.':'.$mod, $key, $def); }
	public static function setConf($mod, $cid, $key, $val) { return self::table(__CLASS__)->set($cid.':'.$mod, $key, $val); }
	public static function isModuleDisabled($mod, $cid, $def='0') { return self::getConf($mod, $cid, 'disabled', $def) === '1'; }
	public static function setModuleDisabled($mod, $cid, $disabled='1') { return self::setConf($mod, $cid, 'disabled', $disabled); }
	public static function isTriggerDisabled($mod, $cid, $trg, $def='0') { return self::getConf($mod, $cid, $trg.':disabled', $def) === '1'; }
	public static function setTriggerDisabled($mod, $cid, $trg, $disabled='1') { return self::setConf($mod, $cid, $trg.':disabled', $disabled); }
}

# 5.Module Server
final class Dog_Conf_Mod_Serv extends Dog_ConfText
{
	public function getClassName() { return __CLASS__; }
	public function getConfColumnName() { return 'conf_msid'; }
	public static function getConf($mod, $sid, $key, $def) { return self::table(__CLASS__)->get($sid.':'.$mod, $key, $def); }
	public static function setConf($mod, $sid, $key, $val) { return self::table(__CLASS__)->set($sid.':'.$mod, $key, $val); }
	public static function isModuleDisabled($mod, $sid, $def='0') { return self::getConf($mod, $sid, 'disabled', $def) === '1'; }
	public static function setModuleDisabled($mod, $sid, $disabled='1') { return self::setConf($mod, $sid, 'disabled', $disabled); }
	public static function isTriggerDisabled($mod, $sid, $trg, $def='0') { return self::getConf($mod, $sid, $trg.':disabled', $def) === '1'; }
	public static function setTriggerDisabled($mod, $sid, $trigger, $disabled='1') { return self::setConf($mod, $sid, $trigger.':disabled', $disabled); }
}

# 6.Module User
final class Dog_Conf_Mod_User extends Dog_ConfText
{
	public function getClassName() { return __CLASS__; }
	public function getConfColumnName() { return 'conf_muid'; }
	public static function getConf($mod, $uid, $key, $def) { return self::table(__CLASS__)->get($uid.':'.$mod, $key, $def); }
	public static function setConf($mod, $uid, $key, $val) { return self::table(__CLASS__)->set($uid.':'.$mod, $key, $val); }
}

# 7.Plugin (Global)
final class Dog_Conf_Plug extends Dog_ConfText
{
	public function getClassName() { return __CLASS__; }
	public function getConfColumnName() { return 'conf_plug'; }
	public static function getConf($plg, $key, $def) { return self::table(__CLASS__)->get($plg, $key, $def); }
	public static function setConf($plg, $key, $val) { return self::table(__CLASS__)->set($plg, $key, $val); }
	public static function setDisabled($plg, $disabled='1') { return self::setConf($plg, 'disabled', $disabled); }
	public static function isDisabled($plg) { return self::getConf($plg, 'disabled', '0') === '1'; }
}

# 8.Plugin Channel
final class Dog_Conf_Plug_Chan extends Dog_ConfText
{
	public function getClassName() { return __CLASS__; }
	public function getConfColumnName() { return 'conf_pcid'; }
	public static function getConf($plg, $cid, $key, $def) { return self::table(__CLASS__)->get($cid.':'.$plg, $key, $def); }
	public static function setConf($plg, $cid, $key, $val) { return self::table(__CLASS__)->set($cid.':'.$plg, $key, $val); }
	public static function setDisabled($plg, $cid, $disabled='1') { return self::setConf($plg, $cid, 'disabled', $disabled); }
	public static function isDisabled($plg, $cid, $def='0') { return self::getConf($plg, $cid, 'disabled', $def) === '1'; }
}

# 9.Plugin Server
final class Dog_Conf_Plug_Serv extends Dog_ConfText
{
	public function getClassName() { return __CLASS__; }
	public function getConfColumnName() { return 'conf_psid'; }
	public static function getConf($plg, $sid, $key, $def) { return self::table(__CLASS__)->get($sid.':'.$plg, $key, $def); }
	public static function setConf($plg, $sid, $key, $val) { return self::table(__CLASS__)->set($sid.':'.$plg, $key, $val); }
	public static function setDisabled($plg, $sid, $disabled='1') { return self::setConf($plg, $sid, 'disabled', $disabled); }
	public static function isDisabled($plg, $sid) { return self::getConf($plg, $sid, 'disabled', '0') === '1'; }
}

# 10.Plugin User
final class Dog_Conf_Plug_User extends Dog_ConfText
{
	public function getClassName() { return __CLASS__; }
	public function getConfColumnName() { return 'conf_puid'; }
	public static function getConf($plg, $uid, $key, $def) { return self::table(__CLASS__)->get($uid.':'.$plg, $key, $def); }
	public static function setConf($plg, $uid, $key, $val) { return self::table(__CLASS__)->set($uid.':'.$plg, $key, $val); }
}

# 11.User
final class Dog_Conf_User extends Dog_ConfInteger
{
	public function getClassName() { return __CLASS__; }
	protected function getConfColumnName() { return 'conf_uid'; }
	public static function setConf($uid, $key, $val) { return self::table(__CLASS__)->set($uid, $key, $val); }
	public static function getConf($uid, $key, $def) { return self::table(__CLASS__)->get($uid, $key, $def); }
}

# 12.Server
// final class Dog_Conf_Serv extends Dog_ConfInteger
// {
// 	public function getClassName() { return __CLASS__; }
// 	protected function getConfColumnName() { return 'conf_sid'; }
// 	public static function setConf($sid, $key, $val) { return self::table(__CLASS__)->set($sid, $key, $val); }
// 	public static function getConf($sid, $key, $def) { return self::table(__CLASS__)->get($sid, $key, $def); }
// }
?>
