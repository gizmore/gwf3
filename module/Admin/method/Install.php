<?php

final class Admin_Install extends GWF_Method
{
	public function getUserGroups() { return GWF_Group::ADMIN; }
	
	public function getHTAccess(GWF_Module $module)
	{
		return 
			sprintf('RewriteRule ^%s/install_all$ index.php?mo=Admin&me=Install&all=true'.PHP_EOL, Module_Admin::ADMIN_URL_NAME).
			sprintf('RewriteRule ^%s/install/([a-zA-Z]+)$ index.php?mo=Admin&me=Install&module=$1&drop=0'.PHP_EOL, Module_Admin::ADMIN_URL_NAME).
			sprintf('RewriteRule ^%s/wipe/([a-zA-Z]+)$ index.php?mo=Admin&me=Install&module=$1&drop=1'.PHP_EOL, Module_Admin::ADMIN_URL_NAME);
	}
	
	public function execute(GWF_Module $module)
	{
		$nav = $module->templateNav();
		
		if ('true' === Common::getGetString('all')) {
			return $nav.$this->onInstallAll($module);
		}
		if (false !== Common::getPost('install')) {
			return $nav.$this->onInstallModuleSafe($module, false);
		}
		if (false !== Common::getPost('reinstall')) {
			return $nav.$this->onTemplateReinstall($module, true);
		}
		if (false !== Common::getPost('reinstall2')) {
			return $nav.$this->onInstallModuleSafe($module, true);
		}
		if (false !== Common::getPost('resetvars2')) {
			return $nav.$this->onResetModule($module);
		}
		if (false !== Common::getPost('delete')) {
			return $nav.$this->onTemplateReinstall($module, false);
		}
		if (false !== Common::getPost('delete2')) {
			return $nav.$this->onDeleteModule($module);
		}
		
		if (false !== ($modulename = Common::getGetString('module'))) {
			return $nav.$this->onInstall($module, $modulename, false);
		}
		
		return GWF_HTML::err('ERR_GENERAL', array( __FILE__, __LINE__));
	}
	
	public function formInstall(Module_Admin $module, GWF_Module $mod)
	{
		$data = array(
			'modulename' => array(GWF_Form::HIDDEN, $mod->display('module_name')),
			'install' => array(GWF_Form::SUBMIT, $module->lang('btn_install'), $module->lang('th_install')),
			'reinstall' => array(GWF_Form::SUBMIT, $module->lang('btn_reinstall'), $module->lang('th_reinstall')),
			'delete' => array(GWF_Form::SUBMIT, $module->lang('btn_delete')),
		);
		return new GWF_Form($this, $data);
	}
	
	public function validate_modulename(Module_Admin $m, $arg) { return false; }
	
	public function formReInstall(Module_Admin $module, GWF_Module $mod)
	{
		$data = array(
			'modulename' => array(GWF_Form::HIDDEN, $mod->display('module_name')),
			'install' => array(GWF_Form::SUBMIT, $module->lang('btn_install'), $module->lang('th_install')),
			'resetvars2' => array(GWF_Form::SUBMIT, $module->lang('btn_defaults'), $module->lang('th_reset')),
			'reinstall2' => array(GWF_Form::SUBMIT, $module->lang('btn_reinstall'), $module->lang('th_reinstall')),
			'delete2' => array(GWF_Form::SUBMIT, $module->lang('btn_delete'), $module->lang('th_delete')),
		);
		return new GWF_Form($this, $data);
	}
	
	public function onTemplateReinstall(Module_Admin $module, $dropTable)
	{
		$arg = Common::getPost('modulename', '');
		if (false === ($post_module = GWF_ModuleLoader::loadModuleFS($arg))) {
			return $module->error('err_module', array(htmlspecialchars($arg)));
		}
		
		$form = $this->formReInstall($module, $post_module);
		$tVars = array(
			'form' => $form->templateY($module->lang('ft_reinstall', array($post_module->display('module_name')), GWF_WEB_ROOT.Module_Admin::ADMIN_URL_NAME.'/install/'.$post_module->urlencode('module_name'))),
		);
		return $module->template('install.tpl', $tVars);
	}
	
	
	public function onResetModule(Module_Admin $module)
	{
		$arg = Common::getPost('modulename', '');
		if (false === ($post_module = GWF_ModuleLoader::loadModuleFS($arg))) {
			return $module->error('err_module', htmlspecialchars($arg)).$this->onTemplateReinstall($module, false);
		}
		$form = $this->formReInstall($module, $post_module);
		if (false !== ($error = $form->validate($module))) {
			return $error.$this->onTemplateReinstall($module, false);
		}
		if (false === GDO::table('GWF_ModuleVar')->deleteWhere('mv_mid='.$post_module->getID())) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		return
			$module->message('msg_defaults').
			$module->getMethod('Install')->onInstall($module, $post_module->getName(), false);
	}
			
	public function onInstallModuleSafe(Module_Admin $module, $dropTable)
	{
		$arg = Common::getPost('modulename', '');
		if (false === ($post_module = GWF_ModuleLoader::loadModuleFS($arg))) {
			return $module->error('err_module', htmlspecialchars($arg)).$this->onTemplateReinstall($module, false);
		}
		$form = $this->formReInstall($module, $post_module);
		if (false !== ($error = $form->validate($module))) {
			return $error.$this->onTemplateReinstall($module, false);
		}
		return $this->onInstall($module, $form->getVar('modulename'), $dropTable);
	}
	
	public function onInstall(Module_Admin $module, $modulename, $dropTable)
	{
		if (false === ($modules = GWF_ModuleLoader::loadModulesFS())) {
			return GWF_HTML::err('ERR_MODULE_MISSING', array(GWF_HTML::display($modulename)));
		}
		if (!isset($modules[$modulename])) {
			return GWF_HTML::err('ERR_MODULE_MISSING', array(GWF_HTML::display($modulename)));
		}
		$install = $modules[$modulename];
		$install instanceof GWF_Module;
		
		$errors = GWF_ModuleLoader::installModule($install, $dropTable);
		
		if ($errors !== '') {
			return $errors.$module->message('err_install').$module->requestMethodB('Modules');
		}
		
//		if (false === ($install->saveOption(GWF_Module::ENABLED, true))) {
//			return 
//				GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__)).
//				$module->message('err_install').$module->requestMethodB('Modules');
//		}
		
		GWF_ModuleLoader::installHTAccess($modules);
		
		$msg = $dropTable === true ? 'msg_wipe' : 'msg_install';
		
		return 
			$module->message($msg, array(GWF_HTML::display($modulename))).
			$module->message('msg_installed', array(Module_Admin::getEditURL($modulename), GWF_HTML::display($modulename)));
	}

	public function onInstallAll(Module_Admin $module)
	{
		$back = '';
		$modules = GWF_ModuleLoader::loadModulesFS();
		foreach ($modules as $m)
		{
			$m instanceof GWF_Module;
			$back .= GWF_ModuleLoader::installModule($m, false);
		}
		
		GWF_ModuleLoader::installHTAccess($modules);
		
		return $module->message('msg_install_all', array($module->getMethodURL('Modules'))).$back;
	}
	
	public function onDeleteModule(Module_Admin $module)
	{
		$arg = Common::getPost('modulename', '');
		if (false === ($post_module = GWF_ModuleLoader::loadModuleFS($arg))) {
			return $module->error('err_module', htmlspecialchars($arg)).$this->onTemplateReinstall($module, false);
		}
		$form = $this->formReInstall($module, $post_module);
		if (false !== ($error = $form->validate($module))) {
			return $error.$this->onTemplateReinstall($module, false);
		}
		
		if (0 == ($mid = $post_module->getID())) {
			return GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__)).$this->onTemplateReinstall($module, false);
		}
		
		if (false === GDO::table('GWF_Module')->deleteWhere("module_id={$mid}")) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__)).$this->onTemplateReinstall($module, false);
		}
		
		if (false === GDO::table('GWF_ModuleVar')->deleteWhere("mv_mid={$mid}")) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__)).$this->onTemplateReinstall($module, false);
		}
		
		return $module->message('msg_mod_del');
	}
}


?>