<?php
/**
 * Some core configs... don't like to have them splitted across many small modules.
 * @author gizmore
 * @version 3.0
 */
final class Module_Admin extends GWF_Module
{
	const LOGIN_AS_SESS = 'GWF_LOGIN_AS';
	const SUPERHASH_SESS = 'GWF_SUPERUSER';
	const ADMIN_URL_NAME = 'nanny';
	
	##############
	### Module ###
	##############
	public function getVersion() { return 1.01; }
	public function isCoreModule() { return true; }
	public function onLoadLanguage() { return $this->loadLanguage('lang/admin'); }
//	public function getAdminSectionURL() { return $this->getMethodURL('BaseCFG'); }
	
	########################
	### Config / Install ###
	########################
	public function onInstall($dropTable) { require_once GWF_CORE_PATH.'module/Admin/GWF_AdminInstall.php'; return GWF_AdminInstall::onInstall($this, $dropTable); }
	public function cfgUsersPerPage() { return $this->getModuleVarInt('users_per_page', 50); }
	public function cfgSuperHash() { return $this->getModuleVar('super_hash', ''); }
	public function cfgHasPassword() { return $this->cfgSuperHash() !== ''; }
	public function cfgSuperTime() { return $this->getModuleVar('super_time', 600); }
	public function cfgSaveSuperHash($hash) { return $this->saveModuleVar('super_hash', $hash); }
	public function cfgInstallSpiders() { return $this->getModuleVarBool('install_webspiders', '0'); }
	public function cfgHideSpiders() { return $this->getModuleVarBool('hide_web_spiders', '0'); }
	
	###############
	### Startup ###
	###############
	public function execute($methodname)
	{
		if ($this->checkSuperuserPassword()) {
			return parent::execute($methodname);
		}
		return '';
	}
	
//	public function onAddMenu()
//	{
//		$sel = $this->isSelected();
//		if (GWF_User::isAdminS())
//		{
//			GWF_TopMenu::addMenu('admin', GWF_WEB_ROOT.self::ADMIN_URL_NAME, '', $sel);
//		}
//	}
	
	##########################
	### Superuser Password ###
	##########################
	public function isSuperuser() { return GWF_Session::getOrDefault(self::SUPERHASH_SESS, 0) > time(); }
	public function onEnteredHash() { GWF_Session::set(self::SUPERHASH_SESS, time()+$this->cfgSuperTime()); }
	private function checkSuperuserPassword()
	{
		if ($this->cfgHasPassword())
		{
			if (!$this->isSuperuser())
			{
				if (!$this->isMethodSelected('Superuser'))
				{
					GWF_Website::redirect($this->getSuperuserBlockURL());
					return false;
				}
			}
		}
		return true;
	}
	
	################
	### Login As ###
	################
	public function onLoginAs()
	{
		GWF_Session::set(self::LOGIN_AS_SESS, 1);
	}
	
	
	#######################
	### Get All Modules ###
	#######################
	public function getAllModules($orderby='module_name', $orderdir="ASC")
	{
		$modHD = GWF_ModuleLoader::loadModulesFS();
		GWF_ModuleLoader::sortModules($modHD, $orderby, $orderdir);
		
		$back = array();
		foreach ($modHD as $name => $module)
		{
			$module instanceof GWF_Module;
			if (false !== ($moduleDB = GWF_Module::loadModuleDB($name))) {
				$module = $moduleDB;
			}
			$back[$name] = array(
				'name' => $module->getName(),
				'vdb' => sprintf('%.02f', $module->getVersionDB()),
				'vfs' => sprintf('%.02f', $module->getVersionFS()),
				'priority' => $module->getPriority(),
				'module' => $module,
				'sort_url' => self::getSortURL($orderby, $orderdir),
				'edit_url' => self::getEditURL($name), 
				'admin_url' => $module->getAdminSectionURL(),
				'install_url' => self::getInstallURL($name),
				'up_url' => $this->getMoveUpURL($name),
				'down_url' => $this->getMoveDownURL($name),
				'first_url' => $this->getMoveFirstURL($name),
				'last_url' => $this->getMoveLastURL($name),
				'enabled' => $module->isEnabled(),
			);
		}
		
		return $back;
	}

	############
	### URLs ###
	############ 
	public static function getEditURL($modulename) { return sprintf('%s%s/configure/%s', GWF_WEB_ROOT, self::ADMIN_URL_NAME, $modulename); }
	public static function getInstallURL($modulename) { return sprintf('%s%s/install/%s', GWF_WEB_ROOT, self::ADMIN_URL_NAME, $modulename); }
	public static function getInstallAllURL() { return sprintf('%s%s/install_all', GWF_WEB_ROOT, self::ADMIN_URL_NAME); }
	public static function getSortURL($orderby, $orderdir) { return sprintf('%s%s/modules/by/%s/%s', GWF_WEB_ROOT, self::ADMIN_URL_NAME, $orderby, $orderdir); }
	public static function getModulesURL() { return sprintf('%s%s', GWF_WEB_ROOT, self::ADMIN_URL_NAME); }
	public static function getSuperuserBlockURL() { return GWF_WEB_ROOT.'index.php?mo=Admin&me=Superuser&prompt=now'; }
	public static function getSuperuserSetupURL() { return GWF_WEB_ROOT.'index.php?mo=Admin&me=SetPass'; }
	public static function getUsersURL() { return GWF_WEB_ROOT.'index.php?mo=Admin&me=Users'; }
	public static function getUserEditURL($userid) { return GWF_WEB_ROOT.'index.php?mo=Admin&me=UserEdit&uid='.$userid; }
	public static function getGroupsURL() { return GWF_WEB_ROOT.'index.php?mo=Admin&me=Groups'; }
	public static function getGroupEditURL($groupid) { return GWF_WEB_ROOT.'index.php?mo=Admin&me=GroupEdit&uid='.$groupid; }
	public static function getLoginAsURL($username='') { return GWF_WEB_ROOT.'index.php?mo=Admin&me=LoginAs&username='.urlencode($username); }
	public function getMoveUpURL($modulename) { return $this->getMoveURL('up', $modulename); }
	public function getMoveDownURL($modulename) { return $this->getMoveURL('down', $modulename); }
	public function getMoveFirstURL($modulename) { return $this->getMoveURL('first', $modulename); }
	public function getMoveLastURL($modulename) { return $this->getMoveURL('last', $modulename); }
	public function getMoveURL($dir, $modulename) { return sprintf('%s%s/move/%s/%s', GWF_WEB_ROOT, self::ADMIN_URL_NAME, $dir, $modulename); }
	
	####################
	### Nav Template ###
	####################
	public function templateNav()
	{
		$tVars = array(
			'buttons' => $this->getNavButtons(),
		);
		return $this->template('_nav.tpl', $tVars);
	}
	
	/**
	 * Get Tab menu buttons?
	 * @return array
	 */
	public function getNavButtons()
	{
		$method = Common::getGetString('me', false);
		return array(
			array(
				self::getModulesURL(),
				$this->lang('btn_modules'),
				in_array($method, array('Install', 'Module', 'Modules', 'Move'), true),
			),
			array(
				self::getSuperuserSetupURL(),
				$this->lang('btn_superuser'),
				$method === 'Superuser',
			),
			array(
				self::getUsersURL(),
				$this->lang('btn_users'),
				in_array($method, array('Users', 'UserEdit'), true),
			),
			array(
				self::getGroupsURL(),
				$this->lang('btn_groups'),
				in_array($method, array('Groups', 'GroupEdit'), true),
			),
			array(
				self::getLoginAsURL(),
				$this->lang('btn_login_as'),
				$method === 'LoginAs',
			),
			array(
				$this->getMethodURL('Cronjob'),
				$this->lang('btn_cronjob'),
				$method === 'Cronjob',
			),
		);
	}
}

?>