<?php

final class Admin_Install extends GWF_Method
{
	public function getUserGroups() { return GWF_Group::ADMIN; }
	
	public function getHTAccess()
	{
		return 
			sprintf('RewriteRule ^%s/install_all$ index.php?mo=Admin&me=Install&all=true'.PHP_EOL, Module_Admin::ADMIN_URL_NAME).
			sprintf('RewriteRule ^%s/install/([a-zA-Z]+)$ index.php?mo=Admin&me=Install&module=$1&drop=0'.PHP_EOL, Module_Admin::ADMIN_URL_NAME).
			sprintf('RewriteRule ^%s/wipe/([a-zA-Z]+)$ index.php?mo=Admin&me=Install&module=$1&drop=1'.PHP_EOL, Module_Admin::ADMIN_URL_NAME);
	}
	
	public function getPageMenuLinks()
	{
		return array(
				array(
						'page_url' => Module_Admin::ADMIN_URL_NAME.'/install_all',
						'page_title' => 'Admin install all',
						'page_meta_desc' => 'Install all module from the admin page',
				),
		);
	}
	
	public function execute()
	{
		$nav = $this->module->templateNav();
		
		if ('true' === Common::getGetString('all')) {
			return $nav.$this->onInstallAll();
		}
		if (false !== Common::getPost('install')) {
			return $nav.$this->onInstallModuleSafe(false);
		}
		if (false !== Common::getPost('reinstall')) {
			return $nav.$this->onTemplateReinstall(true);
		}
		if (false !== Common::getPost('reinstall2')) {
			return $nav.$this->onInstallModuleSafe(true);
		}
		if (false !== Common::getPost('resetvars2')) {
			return $nav.$this->onResetModule();
		}
		if (false !== Common::getPost('delete')) {
			return $nav.$this->onTemplateReinstall(false);
		}
		if (false !== Common::getPost('delete2')) {
			return $nav.$this->onDeleteModule();
		}
		
		if (false !== ($modulename = Common::getGetString('module'))) {
			return $nav.$this->onInstall($modulename, false);
		}
		
		return GWF_HTML::err('ERR_GENERAL', array( __FILE__, __LINE__));
	}
	
	public function formInstall(GWF_Module $mod)
	{
		$data = array(
			'modulename' => array(GWF_Form::HIDDEN, $mod->display('module_name')),
			'install' => array(GWF_Form::SUBMIT, $this->module->lang('btn_install'), $this->module->lang('th_install')),
			'reinstall' => array(GWF_Form::SUBMIT, $this->module->lang('btn_reinstall'), $this->module->lang('th_reinstall')),
			'delete' => array(GWF_Form::SUBMIT, $this->module->lang('btn_delete')),
		);
		return new GWF_Form($this, $data);
	}
	
	public function validate_modulename(Module_Admin $m, $arg) { return false; }
	
	public function formReInstall(GWF_Module $mod)
	{
		$data = array(
			'modulename' => array(GWF_Form::HIDDEN, $mod->display('module_name')),
			'install' => array(GWF_Form::SUBMIT, $this->module->lang('btn_install'), $this->module->lang('th_install')),
			'resetvars2' => array(GWF_Form::SUBMIT, $this->module->lang('btn_defaults'), $this->module->lang('th_reset')),
			'reinstall2' => array(GWF_Form::SUBMIT, $this->module->lang('btn_reinstall'), $this->module->lang('th_reinstall')),
			'delete2' => array(GWF_Form::SUBMIT, $this->module->lang('btn_delete'), $this->module->lang('th_delete')),
		);
		return new GWF_Form($this, $data);
	}
	
	public function onTemplateReinstall($dropTable)
	{
		$arg = Common::getPost('modulename', '');
		if (false === ($post_module = GWF_ModuleLoader::loadModuleFS($arg))) {
			return $this->module->error('err_module', array(htmlspecialchars($arg)));
		}
		
		$form = $this->formReInstall($post_module);
		$tVars = array(
			'form' => $form->templateY($this->module->lang('ft_reinstall', array($post_module->display('module_name')), GWF_WEB_ROOT.Module_Admin::ADMIN_URL_NAME.'/install/'.$post_module->urlencode('module_name'))),
		);
		return $this->module->template('install.tpl', $tVars);
	}
	
	
	public function onResetModule()
	{
		$arg = Common::getPost('modulename', '');
		if (false === ($post_module = GWF_ModuleLoader::loadModuleFS($arg))) {
			return $this->module->error('err_module', htmlspecialchars($arg)).$this->onTemplateReinstall(false);
		}
		$form = $this->formReInstall($post_module);
		if (false !== ($error = $form->validate($this->module))) {
			return $error.$this->onTemplateReinstall(false);
		}
		if (false === GDO::table('GWF_ModuleVar')->deleteWhere('mv_mid='.$post_module->getID())) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		$post_module->loadVars();
		return
			$this->module->message('msg_defaults').
			$this->onInstall($post_module->getName(), false);
	}
			
	public function onInstallModuleSafe($dropTable)
	{
		$arg = Common::getPost('modulename', '');
		if (false === ($post_module = GWF_ModuleLoader::loadModuleFS($arg))) {
			return $this->module->error('err_module', htmlspecialchars($arg)).$this->onTemplateReinstall(false);
		}
		$form = $this->formReInstall($post_module);
		if (false !== ($error = $form->validate($this->module))) {
			return $error.$this->onTemplateReinstall(false);
		}
		return $this->onInstall($form->getVar('modulename'), $dropTable);
	}
	
	public function onInstall($modulename, $dropTable)
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
			return $errors.$this->module->error('err_install').$this->module->requestMethodB('Modules');
		}
		
//		if (false === ($install->saveOption(GWF_Module::ENABLED, true))) {
//			return 
//				GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__)).
//				$this->module->message('err_install').$this->module->requestMethodB('Modules');
//		}
		
		GWF_ModuleLoader::installHTAccess($modules);
		
		$msg = $dropTable === true ? 'msg_wipe' : 'msg_install';
		
		return 
			$this->module->message($msg, array(GWF_HTML::display($modulename))).
			$this->module->message('msg_installed', array(Module_Admin::getEditURL($modulename), GWF_HTML::display($modulename)));
	}

	public function onInstallAll()
	{
		$back = '';
		$modules = GWF_ModuleLoader::loadModulesFS();
		foreach ($modules as $m)
		{
			$m instanceof GWF_Module;
			$back .= GWF_ModuleLoader::installModule($m, false);
		}
		
		GWF_ModuleLoader::installHTAccess($modules);
		
		return $this->module->message('msg_install_all', array($this->module->getMethodURL('Modules'))).$back;
	}
	
	public function onDeleteModule()
	{
		$arg = Common::getPost('modulename', '');
		if (false === ($post_module = GWF_ModuleLoader::loadModuleFS($arg))) {
			return $this->module->error('err_module', htmlspecialchars($arg)).$this->onTemplateReinstall(false);
		}
		$form = $this->formReInstall($post_module);
		if (false !== ($error = $form->validate($this->module))) {
			return $error.$this->onTemplateReinstall(false);
		}
		
		if (0 == ($mid = $post_module->getID())) {
			return GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__)).$this->onTemplateReinstall(false);
		}
		
		if (false === GDO::table('GWF_Module')->deleteWhere("module_id={$mid}")) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__)).$this->onTemplateReinstall(false);
		}
		
		if (false === GDO::table('GWF_ModuleVar')->deleteWhere("mv_mid={$mid}")) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__)).$this->onTemplateReinstall(false);
		}
		
		return $this->module->message('msg_mod_del');
	}
}


?>
