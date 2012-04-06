<?php
/**
 * Edit a single Module.
 * [+] Alter Modulevars
 * [+] Install, Update and Wipe
 * [+] Enable and Disable
 * @author gizmore
 * @version 1.03
 */
final class Admin_Module extends GWF_Method
{
	/**
	 * @var GWF_Module
	 */
	private $mod;
	
	##################
	### GWF_Method ###
	##################
	public function getUserGroups() { return GWF_Group::ADMIN; }
	
	public function getHTAccess()
	{
		return sprintf('RewriteRule ^%s/configure/([a-zA-Z]+)$ index.php?mo=Admin&me=Module&module=$1'.PHP_EOL, Module_Admin::ADMIN_URL_NAME);
	}
	public function execute()
	{
		if (false !== ($error = $this->sanitize()))
		{
			return $error;
		}
		
		$nav = $this->module->templateNav();
		$back = '';
		
		# Enable
		if (false !== (Common::getPost('enable')))
		{
			$back .= $this->onEnable('enabled');
		}
		elseif (false !== (Common::getPost('disable')))
		{
			$back .= $this->onEnable('disabled');
		}
		
		# Defaults
		elseif (false !== (Common::getPost('defaults')))
		{
			$back .= $this->onDefaults();
		}
		
		# Change Config
		elseif (false !== (Common::getPost('update')))
		{
			$back .= $this->onUpdate();
		}
		
		# Admin Section Wrap
		elseif (false !== Common::getPost('admin_sect'))
		{
			if ($this->mod->hasAdminSection())
			{
				GWF_Website::redirect($this->mod->getAdminSectionURL());
				return '';
			}
			else
			{
				$back .= $this->module->error('err_no_admin_sect');
			}
		}
		
		# Form
		return $nav.$back.$this->templateModule();
	}
	
	private function sanitize()
	{
		if (false === ($this->mod = GWF_Module::loadModuleDB(Common::getGet('module'))))
		{
			return GWF_HTML::err('ERR_MODULE_MISSING', array(Common::displayGet('module')));
		}
		
//		$this->mod->onInclude();
		$this->mod->onLoadLanguage();
		
		return false;
	}
	
	###################
	### Config Form ###
	###################
	private function getForm()
	{
		$mod = $this->mod;
		$m = $this->module;
		
		$data = array(
			'modulename' => array(GWF_Form::SSTRING, $mod->getName(), $m->lang('th_modulename')),
			'path' => array(GWF_Form::SSTRING, GWF_CORE_PATH.'module/'.$mod->getName(), $m->lang('th_path'), 30),
			'version_db' => array(GWF_Form::SSTRING, $mod->getVersionDB(), $m->lang('th_version_db')),
			'version_hd' => array(GWF_Form::SSTRING, $mod->getVersion(), $m->lang('th_version_hd')),
			'div1' => array(GWF_Form::DIVIDER),
		);
		
		# Modulevars
		$data = array_merge($data, $this->getFormModuleVars($mod));
		$data['div2'] = array(GWF_Form::DIVIDER);
		
		# Actions
		$data['btns'] = array(GWF_Form::SUBMITS, array('update'=>$m->lang('btn_update')));#, 'defaults'=>$m->lang('btn_defaults')));
		if ($mod->isEnabled())
		{
			$data['disable'] = array(GWF_Form::SUBMIT, $m->lang('btn_disable'), $m->lang('th_enabled'));
		}
		else
		{
			$data['enable'] = array(GWF_Form::SUBMIT, $m->lang('btn_enable'), $m->lang('th_disabled'));
		}
		
		if ($mod->getAdminSectionURL() !== '#')
		{
			$data['admin_sect'] = array(GWF_Form::SUBMIT, $m->lang('btn_admin_section'), $m->lang('btn_admin_section'));
		}
		
		return new GWF_Form($this, $data);
	}
	
	private function getFormModuleVars(GWF_Module $mod)
	{
		$back = array();
		$mid = $mod->getID();
		$vars = GWF_ModuleLoader::getModuleVars($mid);
		if (count($vars) === 0)
		{
			return $back;
		}
		$vars = GWF_ModuleLoader::sortVarsByType($vars);
		$type = $vars[key($vars)]['mv_type'];
		foreach ($vars as $var)
		{
			if ($var['mv_type'] !== $type)
			{
				$back['div_'.$type] = array(GWF_Form::DIVIDER);
				$type = $var['mv_type'];
			}
			$name = $var['mv_key'];
			$getkey = sprintf('mv_%s', $name);
			$back[$getkey] = $this->getFormModuleVar($mod, $name, $var);
		}
		return $back;
	}
	
	/**
	 * @return GWF_Form
	 */
	private function getFormInstall()
	{
		if (false === ($method = $this->module->getMethod('Install')))
		{
			echo GWF_HTML::err('ERR_METHOD_MISSING', array( 'Install'));
			return false; 
		}
		$method instanceof Admin_Install;
		
		return $method->formInstall($this->mod);
	}
	
	
	private function getFormModuleVar(GWF_Module $mod, $name, array $def)
	{
		$tooltip = $this->getTooltip($mod, $name, $def);
		$helpkey = sprintf('cfg_%s', $name);
		switch ($def['mv_type'])
		{
			case 'bool':
				return array(GWF_Form::CHECKBOX, $def['mv_val']==='1', $mod->lang($helpkey), $tooltip);
			default:
				return array(GWF_Form::STRING_NO_CHECK, $def['mv_value'], $mod->lang($helpkey), $tooltip);
		}
		
		
	}
	
	private function getTooltip(GWF_Module $mod, $varname, array $var)
	{
		switch($var['mv_type'])
		{
			case 'int':
				$default_txt = $this->module->lang('tt_int', array($var['mv_min'], $var['mv_max']));
				break;
			case 'text':
				$default_txt = $this->module->lang('tt_text', array( $var['mv_min'], $var['mv_max']));
				break;
			case 'bool':
				$default_txt = $this->module->lang('tt_bool');
				break;
			case 'script':
				$default_txt = $this->module->lang('tt_script');
				break;
			case 'time':
				$min = GWF_TimeConvert::humanDuration((int)$var['mv_min']);
				$max = GWF_TimeConvert::humanDuration((int)$var['mv_max']);
				$default_txt = $this->module->lang('tt_time', array( $min, $max));
				break;
			case 'float':
				$default_txt = $this->module->lang('tt_float', array( $var['mv_min'], $var['mv_max']));
				break;
		}
		$extkey = 'tt_cfg_'.$varname;
		if ($extkey === ($extend = $mod->lang($extkey)))
		{
			$extend = '';
		}
		else
		{
			$extend = "\n".$extend;
		}

		return $default_txt.$extend;
	}
	
	################
	### Template ###
	################
	private function templateModule()
	{
		$form = $this->getForm();
		$form_install = $this->getFormInstall();
		$seoname = $this->mod->urlencodeSEO('module_name');
		$modname = $this->mod->display('module_name');
		$install_action = $this->module->getMethodURL('Install');
		$tVars = array(
			'cfgmodule' => $this->mod,
			'modules' => $this->module->getAllModules(),
			'form' => $form->templateY($this->module->lang('form_title', array($modname))),
			'form_install' => $form_install->templateY($this->module->lang('ft_install', array($modname)), $install_action),
//			'url_install' => sprintf('%s%s/install/%s', GWF_WEB_ROOT, Module_Admin::ADMIN_URL_NAME, $seoname),
//			'url_reinstall' => sprintf('%s%s/wipe/%s', GWF_WEB_ROOT, Module_Admin::ADMIN_URL_NAME, $seoname),
		
		);
		return $this->module->templatePHP('module.php', $tVars);
	}
	
	##############
	### Update ###
	##############
	private function getVarsFor(array $vars, $key)
	{
		foreach ($vars as $data)
		{
			if ($data['mv_key'] === $key)
			{
				return $data;
			}
		}
		return false;
	}
	
	private function updateVar($key, $value, array $vars, array $varsa)
	{
		$type = $varsa['mv_type'];
		$min = $varsa['mv_min'];
		$max = $varsa['mv_max'];
		$transkey = $this->mod->lang('cfg_'.$key);

		$ex = 0;
		if (false === ($val = GWF_ModuleLoader::getVarValue($value, $type, $min, $max, $ex)))
		{
			if ($ex)
			{
				unset($_POST['mv_'.$key]);
				return $this->module->lang('err_arg_range', array($transkey, $min, $max));
			}
			else
			{
				unset($_POST['mv_'.$key]);
				return $this->module->lang('err_arg_type', array($transkey));
			}
		}
		
		if ($val == $varsa['mv_val'])
		{
			return '';
		}
		
		if ($type === 'script')
		{
			unset($_POST['mv_'.$key]);
			return $this->module->lang('err_arg_script', array($transkey));
		}
		
		if (false === GDO::table('GWF_ModuleVar')->insertAssoc(array(
			'mv_mid' => $this->mod->getID(),
			'mv_key' => $key,
			'mv_val' => $val,
			'mv_value' => $value,
			'mv_type' => $type,
			'mv_min' => $min,
			'mv_max' => $max,
		), true)) {
			return GWF_HTML::lang('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		return false;
	}
	
	private function onUpdate()
	{
		$form = $this->getForm();
		if (false !== ($error = $form->validate($this->module)))
		{
			return $error;
		}
		
		$moduleid = $this->mod->getID();
		$errors = $messages = array();
		$vars = GWF_ModuleLoader::getModuleVars($moduleid);
		foreach ($vars as $row) 
		{
			$key = $row['mv_key'];
			$mvkey = 'mv_'.$key;
			if ($row['mv_type'] === 'bool')
			{
				$newval = isset($_POST[$mvkey]) ? '1' : '0';
			}
			elseif (isset($_POST[$mvkey]))
			{
				$newval = $_POST[$mvkey];
			}
			else
			{
				$errors[] = GWF_HTML::err('ERR_MISSING_VAR', array(htmlspecialchars($mvkey)));
				continue;
			}

			
			if (false !== ($error = $this->updateVar($key, $newval, $vars, $row)))
			{
				if ($error !== '')
				{
					$errors[] = $error;
				}
			}
			else
			{
				$transkey = $this->mod->lang('cfg_'.$key);
				$messages[] = $this->module->lang('msg_update_var', array($transkey, GWF_HTML::display($newval)));
			}
		}
		
		$back = '';
		$modname = $this->mod->display('module_name');
		if (!empty($errors))
		{
			$back .= GWF_HTML::error($modname, $errors);
		}
		if (!empty($messages))
		{
			$back .= GWF_HTML::messageA($modname, $messages);
		}
		return $back;
	}

	##############
	### Enable ###
	##############
	private function onEnable($enum)
	{
		if (false !== ($error = GWF_Form::validateCSRF_WeakS()))
		{
			return GWF_HTML::error('', $error);
		}
		
		if ($this->mod->isCoreModule())
		{
			return $this->module->error('err_disable_core_module');
		}
		
		if (false === $this->mod->saveOption(GWF_Module::ENABLED, $enum==='enabled'))
		{
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		if (false === GWF_ModuleLoader::reinstallHTAccess())
		{
			return GWF_HTML::err('ERR_GENERAL', array( __FILE__, __LINE__));
		}

		return $this->module->message('msg_module_'.$enum, array($this->mod->display('module_name')));
	}
	
	private function onDefaults()
	{
		$_POST['reinstall'] = true;
		$_POST['modulename'] = $this->mod->getName();
		$this->module->execute('Install');
	}

}

?>
