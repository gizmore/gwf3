<?php

final class Admin_Modules extends GWF_Method
{
	public function getUserGroups() { return GWF_Group::ADMIN; }
	
	public function getHTAccess(GWF_Module $module)
	{
		return
			sprintf('RewriteRule ^%s$ index.php?mo=Admin&me=Modules&by=module_name&dir=ASC'.PHP_EOL, Module_Admin::ADMIN_URL_NAME).
			sprintf('RewriteRule ^%s/modules/by/([a-z_]+)/(DESC|ASC)$ index.php?mo=Admin&me=Modules&by=$1&dir=$2'.PHP_EOL, Module_Admin::ADMIN_URL_NAME);
			
	}
	public function execute(GWF_Module $module)
	{
		return $module->templateNav().$this->templateModules($module);
	}
	
	private function templateModules(Module_Admin $module)
	{
		$gdo = GDO::table('GWF_Module');
		$by = $gdo->getWhitelistedBy(Common::getGetString('by'), 'module_name');
		$dir = GDO::getWhitelistedDirS(Common::getGetString('dir', 'ASC'));
		$headers = array(
			array($module->lang('th_priority'), 'module_priority', 'ASC'),
			array($module->lang('th_move')),
			array($module->lang('th_name'), 'module_name', 'ASC'),
			array($module->lang('th_version_db')),
			array($module->lang('th_version_hd')),
			array($module->lang('th_install')),
			array($module->lang('th_basic')),
			array($module->lang('th_adv')),
		);
		$modules = $module->getAllModules($by, $dir);
		
		# Need install?
		$install_all = '';
		foreach ($modules as $name => $d) {
			if (!$d['enabled']) {
				continue;
			}
			if ($d['vdb'] < $d['vfs']) {
				$install_all = $module->lang('install_info', array(Module_Admin::getInstallAllURL()));
				break;
			}
		}
		
		$tVars = array(
			'modules' => $modules,
			'install_all' => $install_all,
			'tablehead' => GWF_Table::displayHeaders1($headers, Module_Admin::getSortURL('%BY%', '%DIR%'), 'module_name', 'ASC'),
		
			'install' => $module->lang('btn_install'),
			'configure' => $module->lang('btn_config'),
			'adminsect' => $module->lang('btn_admin_section'),
		);
		
		return $module->template('modules.tpl', $tVars);
	}
}

?>
