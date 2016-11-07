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

	/**
	 * @var GWF_Module
	 */
	protected $module = NULL;

	public function __construct(GWF_Module $module) { $this->module = $module; return $this; }
	public abstract function execute();
	public function executeAjax() {}
	public function getModule() { return $this->module; }
	public function getLang() { return $this->module->getLang(); }
	public function getUserGroups() { return NULL; }
	public function isCSRFProtected() { return true; }
	public function isLoginRequired() { return false; }
	public function checkDependencies() { return false; }
	public function getHTAccess() { return $this->getHTAccessMethod(); }
	public function getMetaKeywords() { return false; }
	public function getMetaDescription() { return false; }
	public function getPageTitle() { return false; }
	public function setTemplate($tpl) { $this->_tpl = $tpl; return $this; }
	public function l($key, $args=NULL) { return $this->module->lang($key, $args); }
	public function lu(GWF_User $user, $key, $args=NULL) { return $this->module->langUser($user, $key, $args); }
	
	/**
	 * this method is called before real execution of method
	 * @todo implement :D:D
	 */
	public function preExecute()
	{
		if (($cache = $this->cacheControl()) instanceof GWF_Response)
		{
			return $cache;
		}

		return $_REQUEST['_ajax'] ? $this->executeAjax() : $this->execute();
	}

	public function getETag() { return false; }
	public function getModifiedTime() { return true; } # FIXME: a return value which is always <= 1 (infinite)

	public final function cacheControl()
	{
		if (false !== ($modified = GWF_HTTPHeader::getHeader('If-Modified-Since', false)))
		{
			if ($this->getModifiedTime() < $modified)
			{
				return GWF_Response(GWF_Response::NOT_MODIFIED);
			}
		}
		elseif (false !== ($etag = GWF_HTTPHeader::getHeader('E-Tag', false)))
		{
			if ($this->getETag() === $etag)
			{
			# TODO
			}
		}
		return false;
	}

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
	public final function getHTAccessMethod()
	{
		list($mo, $me) = $this->getMoMe();
		return sprintf('RewriteRule ^%s/%s/?$ index.php?mo=%s&me=%s', strtolower($mo), strtolower($me), $mo, $me).PHP_EOL;
	}

	public function showEmbededHTML()
	{
		return isset($_GET['embed']);
	}

	public function getWrappingContent($content)
	{
		$doctype = GWF_Doctype::getDoctype(GWF_DEFAULT_DOCTYPE);
		return sprintf("%s<html>\n<head></head>\n<body>\n%s\n</body>\n</html>", $doctype, $content);
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

