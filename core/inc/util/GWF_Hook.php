<?php
/**
 * Hook into GWF.
 * Currently only modules can hook.
 * To add a hook, override Module_Foo::onAddHooks()
 * Then re-install the module to rebuild hook table.
 * @author gizmore
 */
final class GWF_Hook
{
	#####################
	### Known Hooks:  #########################
	### Hooks have 2 args: GWF_User, array. ###
	###########################################
	const LOGIN = 'login';                # args: Pass1, Pass2, bool_autologin
	const LOGOUT = 'logout';              # args: none
	const LOGIN_PRE = 'login_pre';        # args: Pass1, Pass2
	const LOGIN_AFTER = 'login_after';    # args: none
	const ACTIVATE = 'activate';          # args: Pass1, Pass2
	const CHANGE_MAIL = 'change_mail';    # args: oldmail, newmail
	const CHANGE_UNAME = 'change_uname';  # args: oldname, newname
	const CHANGE_PASSWD = 'change_pass';  # args: NewPass, NewPIN
	const DELETE_USER = 'delete';         # args: none
	const PURGE_USER = 'purge';           # args: none

	const ENABLE_MODULE = 'enable_mod';   # args: module, enabled
	const INSTALL_MODULE = 'install_mod'; # args: module, dropTable

	const ADD_GROUP = 'add_group';        # args: groupid, groupname
	const REM_GROUP = 'rem_group';        # args: group

	const ADD_TO_GROUP = 'add_usr_grp';   # args: groupid, groupname
	const REM_FROM_GROUP = 'rem_usr_grp'; # args: groupid, groupname

	const EARN = 'earn';                  # args: type, credits
	const DOWNLOAD = 'download';          # args: download 
	const VOTED_POLL = 'voted_poll';      # args: vsid, score
	const VOTED_SCORE = 'voted_score';    # args: vmid, score
	
	########################
	### Build Hook Table ###
	########################
	private static $_write_hooks = array();
	/**
	 * Add a hook to be written to hook table.
	 * @param string $name One of the known hooks above
	 * @param unknown_type $function
	 */
	public static function add($name, $function)
	{
		if (!isset(self::$_write_hooks[$name]))
		{
			self::$_write_hooks[$name] = array();
		}

		if (!in_array($function, self::$_write_hooks[$name]))
		{
//			var_dump(__METHOD__, $name, $function);
			self::$_write_hooks[$name][] = $function;
		}
	}
	public static function writeHooks()
	{
		GWF_Settings::setSetting('gwf3_hooks', serialize(self::$_write_hooks));
	}

	###################
	### Call a hook ###
	###################
	private static $HOOKS = true;
	private static function initHooks()
	{
		if (self::$HOOKS === true)
		{
			if (false !== ($hooks = GWF_Settings::getSetting('gwf3_hooks', false)))
			{
				self::$HOOKS = unserialize($hooks);
			}
			else
			{
				self::$HOOKS = array();
			}
		}
	}

	/**
	 * Call a hook. User is a default argument. calls hook($user, array $args)
	 * @param string $name unique ID
	 * @param GWF_User $user the current user
	 * @param array $args
	 */
	public static function call($name, GWF_User $user, array $args=array())
	{
		self::initHooks();

		if (!isset(self::$HOOKS[$name]))
		{
// 			GWF_Log::logCritical('Unknown hook: '.$name);
			return true;
		}

		$output = '';

		foreach (self::$HOOKS[$name] as $hook)
		{
			$modulename = Common::substrFrom($hook[0], '_');
			if (false !== ($module = GWF_Module::loadModuleDB($modulename, true, true)))
			{
				$output .= self::cleanResult($hook, call_user_func(array($module, $hook[1]), $user, $args));
			}
		}

		if ($output === '')
		{
			return true;
		}

		GWF_Website::addDefaultOutput($output);
		return false;
	}

	/**
	 * Hooks return various shit, we unify booleans into success/error msg.
	 * @param array $hook
	 * @param unknown_type $result
	 * @return unknown_type
	 */
	private static function cleanResult(array $hook, $result)
	{
		if ($result === true) {
			return '';
		}

		if ($result === false) {
			return GWF_HTML::err('ERR_HOOK', array(self::callbackToName($hook)));
		}

		return $result;
	}

	##########################
	### Callback to string ###
	##########################
	/**
	 * Helper function to convert a hook to a string representation.
	 * @author gizmore
	 * @example callbackToName('funcname') returns funcname
	 * @example callbackToName(array($this, 'foo')) returns BlubClass->foo
	 * @example callbackToName(array('FooClass', 'bar')) returns FooClass::bar
	 * @param mixed $callback
	 * @return string
	 */
	public static function callbackToName($callback)
	{
		$cb = $callback[1];
		if (is_array($cb))
		{

			if (is_object($cb[0]))
			{
				return get_class($cb[0]).'->'.$cb[1];
//				return $cb[0]->getClassName().'->'.$cb[1];
			}
			else
			{
				return $cb[0].'::'.$cb[1];
			}
		}
		else
		{
			return (string)$cb;
		}
	}
}
