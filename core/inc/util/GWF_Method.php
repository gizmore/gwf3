<?php
/**
 * A method called via index.php?mo=Module&me=Method.
 * The methods classname name has to be Module_Method.
 * The methods path has to be core/module/Module/method/Method.
 * The method has to support a method named "execute".
 * @author gizmore
 * @see GWF_Module
 */
abstract class GWF_Method
{
	public abstract function execute(GWF_Module $module);
	public function getUserGroups() { return NULL; }
	public function isCSRFProtected() { return true; }
	public function isLoginRequired() { return false; }
	public function checkDependencies() { return false; }
	public function getHTAccess(GWF_Module $module) { return ''; }
	
	##################
	### Permission ###
	##################
	public function hasPermission()
	{
		$user = GWF_Session::getUser();
		$groups = $this->getUserGroups();
		$need_login = $this->isLoginRequired() || $groups !== NULL;
		if ($need_login && ($user === false)) {
			return false;
		}
		if ($groups === NULL) {
			return true;
		}
		if (is_string($groups)) { $groups = array($groups); }
		foreach ($groups as $groupname)
		{
			if ($user->isInGroupName($groupname))
			{
				return true;
			}
		}
		return false;
	}
	
	#############
	### HREFs ###
	#############
	public function getMethodHREF($app='')
	{
		list($mo, $me) = $this->getMoMe();
		return GWF_WEB_ROOT.'index.php?mo='.$mo.'&me='.$me.$app;
	}
	
	public function getMoMe()
	{
		$class = get_class($this);
		return array(Common::substrUntil($class, '_'), Common::substrFrom($class, '_'));
	}
	
	################
	### HTAccess ###
	################
	/**
	 * Generate htaccess rule for this method. Simply ^module/method$. 
	 */
	public function getHTAccessMethod()
	{
		list($mo, $me) = $this->getMoMe();
		return sprintf('RewriteRule ^%s/%s/?$ index.php?mo=%s&me=%s', strtolower($mo), strtolower($me), $mo, $me).PHP_EOL;
	}

	################
	### PageMenu ###
	################
	/**
	 * Generate link(s) in PageMenu for this method.
	 */
	public function getPageMenuLinks()
	{
		return false;
	}
}
?>
