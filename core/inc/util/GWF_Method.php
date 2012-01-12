<?php
/**
 * A method called via index.php?mo=Module&me=Method.
 * The methods classname name has to be Module_Method.
 * The methods path has to be core/module/$Module/method/$Method.
 * The method has to support a method named "execute".
 * @author gizmore
 * @see GWF_Module
 */
abstract class GWF_Method
{
	protected $_tpl = NULL;
	protected $_module = NULL;

	public function __construct(GWF_Module $module) { $this->_module = $module; return $this; }
	public abstract function execute();
	public function getUserGroups() { return NULL; }
	public function isCSRFProtected() { return true; }
	public function isLoginRequired() { return false; }
	public function checkDependencies() { return false; }
	public function getHTAccess() { return ''; }
	public function getMetaKeywords() { return false; }
	public function getMetaDescription() { return false; }
	public function getPageTitle() { return false; }
	public function setTemplate($tpl) { $this->_tpl = $tpl; return $this; }

	/**
	 * Check if user has permission to execute this method
	 * @see GWF_Module->execute()
	 */
	public function hasPermission()
	{
		$user = GWF_Session::getUser();
		$groups = $this->getUserGroups();
		$need_login = $this->isLoginRequired() || $groups !== NULL;
		if (($need_login === true) && ($user === false))
		{
			return false;
		}
		if ($groups === NULL)
		{
			return true;
		}
//		if (is_string($groups)) { $groups = array($groups); }
		$groups = (array)$groups;
		foreach ($groups as $groupname)
		{
			if ($user->isInGroupName($groupname))
			{
				return true;
			}
		}
		return false;
	}

	/**
	 * Get the method Link
	 * @param string $app 
	 */
	public function getMethodHREF($app='')
	{
		list($mo, $me) = $this->getMoMe();
		return GWF_WEB_ROOT.'index.php?mo='.$mo.'&me='.$me.$app;
	}

	public function getName()
	{
		return Common::substrFrom(get_class($this), '_');
	}

	public function getMoMe()
	{
		$class = get_class($this);
		return array(Common::substrUntil($class, '_'), Common::substrFrom($class, '_'));
	}
	
	/**
	 * Generate htaccess rule for this method. Simply ^module/method$. 
	 */
	public function getHTAccessMethod()
	{
		list($mo, $me) = $this->getMoMe();
		return sprintf('RewriteRule ^%s/%s/?$ index.php?mo=%s&me=%s', strtolower($mo), strtolower($me), $mo, $me).PHP_EOL;
	}

	/**
	 * @author spaceone
	 * Generate link(s) in PageMenu for this method.
	 * @return false|array = GWF_Page ColumnDefines array
	 */
	public function getPageMenuLinks()
	{
//		return array(
//			array(
//				'page_url' => '/',
//				'page_title' => '',
//				'page_meta_desc' => '',
//				[...]
//			),[...]
//		);
		return false;
	}
}
?>
