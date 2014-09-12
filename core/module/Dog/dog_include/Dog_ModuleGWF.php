<?php
abstract class Dog_ModuleGWF extends Dog_Module
{
	public abstract function getGWFModulenames();
	
	public function getGWFModulename()
	{
		$back = $this->getGWFModulenames();
		return $back[0];
	}

	/**
	 * @return GWF_Module
	 */
	public function getGWFModule()
	{
		return GWF_Module::loadModuleDB($this->getGWFModulename(), false, true, true);
	}
	
	/**
	 * @return GWF_User
	 */
	public static function getGWFUser()
	{
		return (!($user = Dog::getUser())) ? false : $user->getGWFUser();
	}
	
	public function onInstall($flush_tables)
	{
// 		return $this->getModule()->onInstall($flush_tables);
	}
	
	public static function executeHook($hook, $args)
	{
		self::executeDogHook($hook, $args);
// 		self::executeGWFHook($hook, $args);
	}
	
	public static function executeDogHook($hook, $args)
	{
		return Dog_Module::map("trigger_$hook", $args);
	}
	
	public static function executeGWFHook($hook, $args)
	{
		if ($gwf_user = self::getGWFUser())
		{
			return GWF_Hook::call($hook, $gwf_user, $args);
		}
	}
	
	public static function executeGWFModuleMethod($modulename, $methodname, $get=null, $post=null)
	{
		if (!($gwf_module = GWF_Module::loadModuleDB($modulename, false, false, true)))
		{
			return false;
		}
		
	}
	
}
