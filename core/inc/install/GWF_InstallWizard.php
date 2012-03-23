<?php
# Disable output buffering
if (ob_get_level() > 0) ob_end_clean();
apache_setenv('no-gzip', 1);
ini_set('zlib.output_compression', 0);
/**
 * Functions for the GWF Installation Wizard
 * @author gizmore
 * @author spaceone
 */
final class GWF_InstallWizard
{
	public static $red = 0;
	public static $gwfil = NULL;

	## Set GWF Installatzion Language
	public static function setGWFIL($v)
	{
		self::$gwfil = $v;
	}
	
	public static function wizard_banner()
	{
		return
		'<div id="gwfinstallbanner">'.PHP_EOL.
		'<h1><a href="wizard.php">'.self::$gwfil->lang('pt_wizard').'</a></h1>'.PHP_EOL.
		'</div>'.PHP_EOL;
	}

	public static function wizard_0()
	{
		$back = '';

		$back .= sprintf('<p>%s</p>', self::$gwfil->lang('step_0_0')).PHP_EOL;

 		$back .= '<pre>'.PHP_EOL;
		$back .= "CREATE USER 'username'@'localhost' IDENTIFIED BY 'password';\n";
		$back .= "CREATE DATABASE `databasename`;\n";
		$back .= "GRANT ALL ON databasename.* TO 'username'@'localhost' IDENTIFIED BY 'password';\n";
		$back .= '</pre>'.PHP_EOL;

		$back .= sprintf('<p>%s</p>', self::$gwfil->lang('step_0_0a')).PHP_EOL;

		$back .= '<table>'.PHP_EOL;
		$back .= self::wizard_0_row('4', self::wizard_test_cfg_r());
		$back .= self::wizard_0_row('1', self::wizard_test_hta_sec());
		$back .= self::wizard_0_row('2', self::wizard_test_hta_w());
		$back .= self::wizard_0_row('3', self::wizard_test_cfg_w());
		$back .= self::wizard_0_row('5', self::wizard_test_dbimg());
		$back .= self::wizard_0_row('6', self::wizard_test_temp());
		$back .= self::wizard_0_row('7', self::wizard_test_logs());
		$back .= self::wizard_0_row('8', self::wizard_test_rawlogs());
		$back .= self::wizard_0_row('9', self::wizard_test_db());
		$back .= self::wizard_0_row('10', self::wizard_test_hash());
		$back .= self::wizard_0_row('11', self::wizard_test_zip());
		$back .= self::wizard_0_row('12', self::wizard_test_curl());
		$back .= self::wizard_0_row('13', self::wizard_test_mime());
		$back .= self::wizard_0_row('15', self::wizard_test_gpg());
		$back .= self::wizard_0_row('14', self::wizard_test_security1());
		$back .= '</table>'.PHP_EOL;


		$back .= '<div class="gwfinstallbtns">'.PHP_EOL;
		if (defined('GWF_WIZARD_COULD_WRITE_CFG_FILE'))
		{
			$back .= self::wizard_btn('1');
		}
		if (defined('GWF_WIZARD_COULD_WRITE_CFG_FILE') && defined('GWF_WIZARD_HAS_CFG_FILE'))
		{
			$back .= self::wizard_btn('2');
		}
		if (defined('GWF_WIZARD_HAS_DB') && self::$red === 0)
		{
			$back .= self::wizard_btn('3');
		}
		if (!defined('GWF_WIZARD_COULD_WRITE_CFG_FILE') && !defined('GWF_WIZARD_HAS_CFG_FILE'))
		{
			$back .= GWF_HTML::error(self::$gwfil->lang('wizard'), self::$gwfil->lang('err_create_config'), false, true);
		}
		$back .= '</div>';
		return $back;
	}
	public static function wizard_0_row($step, $value)
	{
		static $cycle = 1;
		$cycle = 1 - $cycle;
		return sprintf('<tr class="tr%d"><td>%s</td><td>%s</td></tr>', $cycle, self::$gwfil->lang('step_0_'.$step), $value).PHP_EOL;
	}
	public static function wizard_btn($step)
	{
		return sprintf('<p class="gwfinstallbtn"><a href="wizard.php?step=%s">Step %s: %s</a></p>', $step, $step, self::$gwfil->lang('step_'.$step)).PHP_EOL;
	}
	public static function wizard_bool($bool)
	{
		return $bool ? '<b class="gwfinstallyes">'.self::$gwfil->lang('yes').'</b>' : '<b class="gwfinstallno">'.self::$gwfil->lang('no').'</b>'; 
	}

	public static function wizard_test_func($func, $required=true)
	{
		$b = function_exists($func);
		if (!$b && $required) {
			self::$red++;
		}
		return self::wizard_bool($b);
	}

	public static function wizard_test_hash()
	{
		return self::wizard_test_func('hash', true);
	}

	public static function wizard_test_curl()
	{
		return self::wizard_test_func('curl_init', false);
	}

	public static function wizard_test_zip()
	{
		return self::wizard_bool(class_exists('ZipArchive', false));
	}

	public static function wizard_test_cfg_w()
	{
		if (true === ($b = GWF_File::isWriteable('protected/config.php')))
		{
			define('GWF_WIZARD_COULD_WRITE_CFG_FILE', true);
		}
		else
		{
			self::$red++;
		}
		return self::wizard_bool($b);
	}

	public static function wizard_test_cfg_r()
	{
		if (true === ($b = Common::isFile('protected/config.php')))
		{
			define('GWF_WIZARD_HAS_CFG_FILE', true);
		}
		return self::wizard_bool($b);
	}

	public static function wizard_is_write($path, $required=true)
	{
		$b = GWF_File::isWriteable($path);
		if (!$b && $required) {
			self::$red++;
		}
		return self::wizard_bool($b);
	}

	public static function wizard_test_dbimg() { return self::wizard_is_write('dbimg', true); }
	public static function wizard_test_temp() { return self::wizard_is_write('temp', true); }
	public static function wizard_test_logs() { return self::wizard_is_write('protected/logs', true); }
	public static function wizard_test_rawlogs() { return self::wizard_is_write('protected/rawlog', true); }
	public static function wizard_test_hta_w() { return self::wizard_is_write('.htaccess', true); }
	public static function wizard_test_mime()
	{
		$b = function_exists('mime_content_type') || function_exists('finfo_open');
		if (!$b)
		{
//			self::$red++;
		}
		return self::wizard_bool($b);
	}

	public static function wizard_test_security1()
	{
		$secure = true;
		$bad_funcs = array('exec', 'system', 'passthru', 'shell_exec', 'proc_open', 'popen', 'pcntl_exec', 'link');
		foreach ($bad_funcs as $func)
		{
			if (function_exists($func))
			{
				echo GWF_Error::error('Install Wizard', sprintf('Function %s is available!', $func), false, true);
				$secure = false;
			}
		}
		return self::wizard_bool($secure);
	}

	public static function wizard_test_gpg()
	{
		return self::wizard_bool(function_exists('gnupg_init'));
	}

	public static function wizard_test_db()
	{
		if (!defined('GWF_WIZARD_HAS_CFG_FILE'))
		{
			return self::$gwfil->lang('no_cfg_file');
		}
		require_once 'protected/config.php';

		if (false !== ($db = gdo_db()))
		{
			define('GWF_WIZARD_HAS_DB', true);
		}

		return self::wizard_bool($db!==false);
	}

	public static function wizard_test_db_2()
	{
		$pv = Common::getPostArray(GWF_InstallConfig::POSTVARS, array());

		$host = isset($pv['GWF_DB_HOST']) ? $pv['GWF_DB_HOST'] : '';
		$user = isset($pv['GWF_DB_USER']) ? $pv['GWF_DB_USER'] : '';
		$pass = isset($pv['GWF_DB_PASSWORD']) ? $pv['GWF_DB_PASSWORD'] : '';
		$db = isset($pv['GWF_DB_DATABASE']) ? $pv['GWF_DB_DATABASE'] : '';
		$type = isset($pv['GWF_DB_TYPE']) ? $pv['GWF_DB_TYPE'] : 'mysql';

		if (false !== ($db = gdo_db_instance($host, $user, $pass, $db, $type, 'utf8', false)))
		{
			define('GWF_WIZARD_HAS_DB', true);
		}
		return self::wizard_bool($db!==false);
	}

	public static function wizard_test_hta_sec()
	{
		return is_file('protected/.htaccess') ? '<b style="color:#ff0000">Unknown</b>' : self::wizard_bool(false);
	}

	#########################
	### --- Step 1 --- ######
	### --- Create Config ###
	#########################
	public static function wizard_h2($step, $param=array())
	{
		return sprintf('<h2>%s) - %s</h2>', self::$gwfil->lang('step', array($step)), self::$gwfil->lang('step_'.$step, $param));
	}

	public static function wizard_1()
	{
		$back = self::wizard_h2('1');
		$back .= GWF_InstallConfig::displayForm('wizard.php', self::$gwfil);
		return $back;
	}

	public static function wizard_1a()
	{
		$back = self::wizard_h2('1a');
		$back .= sprintf('<p>%s</p>', self::$gwfil->lang('step_1a_1', array(self::wizard_test_db_2())));
		if (!Common::isFile(GWF_SMARTY_PATH)) {
			$back .= self::wizard_error('err_no_smarty');
		}

		return $back.self::wizard_1().self::wizard_btn('2');
	}

	public static function wizard_1b()
	{
		$back = self::wizard_h2('1b');
		$back .= sprintf('<p>%s</p>', self::$gwfil->lang('step_1b_0', array(self::wizard_bool(GWF_InstallConfig::writeConfig(self::$gwfil)))));
		return $back.self::wizard_1a();
	}

	#######################
	### --- Step 2 --- ########
	### --- Test Config --- ###
	###########################
	public static function wizard_error($key, $param=NULL)
	{
		return GWF_Error::error(self::$gwfil->lang('wizard'), self::$gwfil->lang($key, $param), false, true).PHP_EOL;
	}
		
	public static function wizard_message($key, $param=NULL)
	{
		return GWF_Error::message(self::$gwfil->lang('wizard'), self::$gwfil->lang($key, $param), false, true).PHP_EOL;
	}
	
	public static function wizard_2()
	{
		$back = self::wizard_h2('2');

		$back .= sprintf('<p>%s</p>', self::$gwfil->lang('step_1a_0', array(self::wizard_test_cfg_r())));
		if (!defined('GWF_WIZARD_HAS_CFG_FILE')) {
			return $back.self::wizard_error('err_no_config').self::wizard_1();
		}

		$back .= sprintf('<p>%s</p>', self::$gwfil->lang('step_1a_1', array(self::wizard_test_db())));
		if (!defined('GWF_WIZARD_HAS_DB')) {
			return $back.self::wizard_error('err_no_db').self::wizard_1();
		}

		return
			$back.PHP_EOL.
			sprintf('<p>%s</p>', self::$gwfil->lang('step_2_0')).PHP_EOL.
			self::wizard_btn('3');
	}

	######################
	### --- Step 3 --- #########
	### --- Install Core --- ###
	############################
	public static function wizard_check_cfg_quick()
	{
		if (false === ($db = gdo_db()))
		{
			return self::wizard_error('err_no_db');
		}

		if (!Common::isFile(GWF_SMARTY_PATH))
		{
			return self::wizard_error('err_no_smarty');
		}

		return false;
	}

	/**
	 * Install core on the fly ...
	 */
	public static function wizard_3()
	{
		$back = self::wizard_h2('3');
		
		if (false !== ($error = self::wizard_check_cfg_quick()))
		{
			return $error;
		}

		$back .= self::$gwfil->lang('step_3_0').PHP_EOL;

		$success = true;
		if (false === ($core = GWF_InstallFunctions::core(false, $success)))
		{
			return $core.GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__, true, true);
		}
		else
		{
			$back .= $core;
		}
		
		if ($success)
		{
			$back .= self::wizard_btn('4');
		}
		
		return $back;
	}

	/**
	 * Choose Lang+Country+IP2C 
	 * Enter description here ...
	 */
	public static function wizard_4()
	{
		if (false !== ($error = self::wizard_check_cfg_quick()))
		{
			return $error;
		}
		
		$back = self::wizard_h2('4');
		$back .= sprintf('<p>%s</p>', self::$gwfil->lang('step_4_0'));
		$back .= self::wizard_btn('4_1');
		$back .= self::wizard_btn('4_2');
		return $back;
	}
	
	/**
	 * Install Language + Country
	 */
	public static function wizard_4_1()
	{
		$back = self::wizard_h2('4');
		$back .= sprintf('<p>%s</p>', self::$gwfil->lang('step_4_1'));
		$back .= '<pre>';
		$back .= GWF_InstallFunctions::createLanguage(true, true, false);
		$back .= '</pre>';
		$back .= self::wizard_btn('5');
		return $back;
	}

	/**
	 * Install Language + Country + IP2Country
	 */
	public static function wizard_4_2()
	{
		$back = self::wizard_h2('4');
		$back .= sprintf('<p>%s</p>', self::$gwfil->lang('step_4_2'));
		$back .= '<pre>';
		$back .= GWF_InstallFunctions::createLanguage(true, true, true);
		$back .= '</pre>';
		$back .= self::wizard_btn('5');
		return $back;
	}
	
	/**
	 * Choose useragent.
	 */
	public static function wizard_5()
	{
		if (false !== ($error = self::wizard_check_cfg_quick()))
		{
			return $error;
		}
		
		$back = self::wizard_h2('5');
		$back .= sprintf('<p>%s</p>', self::$gwfil->lang('step_5_0'));
		$back .= self::wizard_btn('5_1');
		$back .= self::wizard_btn('6');
		return $back;
	}

	/**
	 * Install useragent.
	 */
	public static function wizard_5_1()
	{
		$back = self::wizard_h2('5');
		$back .= sprintf('<p>%s</p>', self::$gwfil->lang('step_5_1'));
		$back .= '<pre>';
		$back .= GWF_InstallFunctions::createUserAgents();
		$back .= '</pre>';
		$back .= self::wizard_btn('6');
		return $back;
		
	}

	/**
	 * Choose modules.
	 */
	public static function wizard_6()
	{
		if (false !== ($error = self::wizard_check_cfg_quick()))
		{
			return $error;
		}
		
		$back = self::wizard_h2('6');
		if (false === ($modules = GWF_ModuleLoader::loadModulesFS())) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__, true, true);
		}
		$back .= self::wizard_modules_form($modules);
		return $back;
	}

	public static function wizard_modules_form(array $modules)
	{
		$back = '<div><table>';
		
		$js = 'var c = $(\'input:checkbox\');  this.checked ? c.attr(\'checked\', \'checked\') : c.removeAttr(\'checked\');';
		$back .= sprintf('<tr><td><input name="toggle_all" type="checkbox" checked="checked" onclick="%s" /></td><td></td></tr>', $js).PHP_EOL;
		
		$back .= '<form action="wizard.php?step=6" method="post" id="form_install_modules" >'.PHP_EOL;

		GWF_ModuleLoader::sortModules($modules, 'module_name', 'ASC');

		foreach ($modules as $module)
		{
			$module instanceof GWF_Module;
			$checked = $module->getDefaultAutoLoad() ? '' : ' checked="checked"';
			$disabled = $module->isCoreModule() ? ' disabled="disabled"' : '';
			$name = $module->getName();
			$style = $disabled === '' ? '' : 'font-style:italic;';
			$style.= $checked === '' ? 'font-weight:bold;' : '';
			$back .= sprintf('<tr><td><input name="mod[%s]" type="checkbox"%s%s /></td><td style="%s">%s</td></tr>', $name, $checked, $disabled, $style, $name).PHP_EOL;
		}
		$back .= '<tr><td colspan="2">Take care, because some Modules have Dependencies!</td></tr>';
		$back .= '<tr><td colspan="2"><input type="submit" name="install_modules" value="Install Modules" /></td></tr>'.PHP_EOL;
		$back .= '</form>'.PHP_EOL;
		$back .= '</table></div>'.PHP_EOL;

		return $back;
	}

	public static function wizard_6_1()
	{
		$names = Common::getPostArray('mod', array());
		// Nothing to install Oo
		if (count($names) === 0)
		{
			return self::wizard_error('err_no_mods_selected').self::wizard_6();
		}
		
		$back = self::wizard_h2('6_1');

		$modules = GWF_ModuleLoader::loadModulesFS();
		$names = Common::getPostArray('mod', array());
		foreach ($modules as $id => $module)
		{
			$module instanceof GWF_Module;
			$name = $module->getName();
			if ( (!isset($names[$name])) && (!$module->isCoreModule()) )
			{
				unset($modules[$id]);
			}
		}

		GWF_ModuleLoader::sortModules($modules, 'module_priority', 'ASC');

		$back .= GWF_InstallFunctions::modules($modules, false);

		$back .= self::wizard_btn('7');

		return $back;
	}

	/**
	 * Copy a few .example files
	 */
	public static function wizard_7()
	{
		if (false !== ($error = self::wizard_check_cfg_quick()))
		{
			return $error;
		}
		
		$back = self::wizard_h2('7');
		if (false === GWF_InstallFunctions::copyExampleFiles($back))
		{
			echo GWF_HTML::err('ERR_GENERAL', array('Please copy index.example.php => index.php'), true, true);
			return $back;
		}
		return $back.self::wizard_btn('8');
	}
	
	/**
	 * Create .htaccess
	 */
	public static function wizard_8()
	{
		if (false !== ($error = self::wizard_check_cfg_quick()))
		{
			return $error;
		}
		
		$back = self::wizard_h2('8');
		
		if ( (false !== GWF_ModuleLoader::reinstallHTAccess()) && (false !== GWF_HTAccess::installCountryRewrites()) )
		{
			return self::wizard_message('msg_htaccess').self::wizard_btn('9');
		}
		
		return self::wizard_error('err_htaccess');
	}
	
	/**
	 * Create admins
	 */
	public static function wizard_9()
	{
		if (false !== ($error = self::wizard_check_cfg_quick()))
		{
			return $error;
		}
		
		$back = self::wizard_h2('9');
		$back .= '<div>';
		$back .= sprintf('<form method="post" action="wizard.php?step=9">');
		$back .= '<div>Username:';
		$back .= sprintf('<input type="text" name="username" value="" />');
		$back .= '</div>';
		$back .= '<div>Password:';
		$back .= sprintf('<input type="text" name="password" value="" />');
		$back .= '</div>';
		$back .= '<div>EMail:';
		$back .= sprintf('<input type="text" name="email" value="" />');
		$back .= '</div>';
		$back .= sprintf('<div><input type="submit" name="create_admin" value="Install Admin" /></div>');
		$back .= '</form>';
		$back .= '</div>';
		return $back;
	}

	/**
	 * Add admin
	 */
	public static function wizard_9_1()
	{
		$username = Common::getPostString('username', '');
		if (!GWF_Validator::isValidUsername($username))
		{
			return GWF_HTML::error('Install Wizard', 'Invalid username.', false).self::wizard_8();
		}

		$password = Common::getPostString('password', '');
		if (!GWF_Validator::isValidPassword($password))
		{
			return GWF_HTML::error('Install Wizard', 'Invalid password (minlength: 6).', false).self::wizard_8();
		}

		$email = Common::getPostString('email', '');
		if (!GWF_Validator::isValidEmail($email))
		{
			return GWF_HTML::error('Install Wizard', 'Invalid email.', false).self::wizard_8();
		}
		
		if (false === GWF_InstallFunctions::default_groups())
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$back = '';
		if (false === GWF_InstallFunctions::createAdmin($username, $password, $email, $back))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}

		return
			$back.
			self::wizard_btn('9').
			self::wizard_btn('10');
	}

	/**
	 * Clear smarty cache.
	 */
	public static function wizard_10()
	{
		if (false !== ($error = self::wizard_check_cfg_quick()))
		{
			return $error;
		}
		
		$back = self::wizard_h2('10');
		
		$template_cache = GWF_SMARTY_DIRS.'tplc';
		if (false === GWF_File::removeDir($template_cache, true, true)) # FIXME: remove only .php or dont remove .git and .svn
		{
			$back .= self::wizard_error('err_clear_smarty');
		}
		
		$back .= sprintf('<p>%s</p>', self::$gwfil->lang('step_10_0'));
		$back .= self::wizard_btn('11');
		return $back;
	}

	/**
	 * Protect install folder.
	 */
	public static function wizard_11()
	{
		if (false !== ($error = self::wizard_check_cfg_quick()))
		{
			return $error;
		}
		
		$back = self::wizard_h2('11');
		
		if (false === GWF_HTAccess::protect404(GWF_WWW_PATH.'install'))
		{
			return $back . GWF_HTML::err('ERR_WRITE_FILE', array('install/.htaccess'));
		}
		
		$back .= sprintf('<p>%s</p>', self::$gwfil->lang('step_11_0'));
		
		$back .= sprintf('<p>%s</p>', self::$gwfil->lang('msg_all_done'));
		
		return $back;
	}
}
