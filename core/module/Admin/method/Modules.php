<?php

final class Admin_Modules extends GWF_Method
{
	public function getUserGroups() { return GWF_Group::ADMIN; }
	
	public function getHTAccess()
	{
		return
			sprintf('RewriteRule ^%s$ index.php?mo=Admin&me=Modules&by=module_name&dir=ASC'.PHP_EOL, Module_Admin::ADMIN_URL_NAME).
			sprintf('RewriteRule ^%s/modules/by/([a-z_]+)/(DESC|ASC)$ index.php?mo=Admin&me=Modules&by=$1&dir=$2'.PHP_EOL, Module_Admin::ADMIN_URL_NAME);
			
	}
	
	public function getPageMenuLinks()
	{
		return array(
				array(
						'page_url' => Module_Admin::ADMIN_URL_NAME,
						'page_title' => 'Admin Page',
						'page_meta_desc' => 'Page reserved for administration stuff',
				),
		);
	}
	
	public function execute()
	{
		return $this->module->templateNav().$this->templateModules();
	}
	
	private function templateModules()
	{
		$gdo = GDO::table('GWF_Module');
		$by = $gdo->getWhitelistedBy(Common::getGetString('by'), 'module_name');
		$dir = GDO::getWhitelistedDirS(Common::getGetString('dir', 'ASC'));
		$headers = array(
			array($this->module->lang('th_priority'), 'module_priority', 'ASC'),
			array($this->module->lang('th_move')),
			array($this->module->lang('th_name'), 'module_name', 'ASC'),
			array($this->module->lang('th_version_db')),
			array($this->module->lang('th_version_hd')),
			array($this->module->lang('th_install')),
			array($this->module->lang('th_basic')),
			array($this->module->lang('th_adv')),
		);
		$modules = $this->module->getAllModules($by, $dir);
		
		# Need install?
		$install_all = '';
		foreach ($modules as $name => $d) {
			if (!$d['enabled']) {
				continue;
			}
			if ($d['vdb'] < $d['vfs']) {
				$install_all = $this->module->lang('install_info', array(Module_Admin::getInstallAllURL()));
				break;
			}
		}
		
		$tVars = array(
			'modules' => $modules,
			'install_all' => $install_all,
			'tablehead' => GWF_Table::displayHeaders1($headers, Module_Admin::getSortURL('%BY%', '%DIR%'), 'module_name', 'ASC'),
		
			'install' => $this->module->lang('btn_install'),
			'configure' => $this->module->lang('btn_config'),
			'adminsect' => $this->module->lang('btn_admin_section'),
		);
		
		return $this->module->template('modules.tpl', $tVars);
	}
}

?>
