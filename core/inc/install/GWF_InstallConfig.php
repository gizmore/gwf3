<?php
/**
 * Config file generator. Config Vars are an array of array($type, $section, $varname, $varvalue, $comment)
 * Types are: 'int10', 'int8', 'text', 'bool', 'script'.
 * @author gizmore
 * @version 3.0
 * @since 2.0
 */
final class GWF_InstallConfig
{
	const POSTVARS = 'cfgvars';
	const CONFIG_FILENAME = 'protected/config.php';
	const TYPE = 0; const SECTION = 1; const VARNAME = 2; const VALUE = 3; const COMMENT = 4;
	
	private static $inited = false;
	private static $vars = array();
	private static $defaults = array();
	private static $lang = true;
	
	################
	### Checkers ###
	################
	public static function check__GWF_STAFF_EMAILS($arg)
	{
		$arg = trim($arg);
		if ($arg !== '')
		{
			$emails = array();
			$arg = explode(',', $arg);
			foreach ($arg as $email)
			{
				$email = trim($email);
				if (GWF_Validator::isValidEmail($email))
				{
					$keep[] = $email;
				}
			}
			if (count($keep) === 0) {
				return 'Invalid staff emails.';
			}
			$arg = implode(',', $keep);
		}
		self::setVar('GWF_STAFF_EMAILS', $arg);
		return false;
	}
	
	public static function check__GWF_IP_QUICK($arg)
	{
		if (GWF_IP6::isValidType($arg)) {
			return false;
		}
		return 'Invalid IP type.';
	}
	
	################
	### Test Var ###
	################
	/**
	 * Test a var if it`s valid. return error message or false.
	 * @param string $varname
	 * @param mixed $value
	 * @return mixed
	 */
	public static function testVar($varname, $value)
	{
		if (!isset(self::$vars[$varname])) {
			return self::error('err_unknown_var', htmlspecialchars($varname));
		}
		
		$type = self::$vars[$varname][self::TYPE];
		$name = htmlspecialchars($varname);
		
		switch ($type)
		{
			case 'text':
				if (!is_string($value)) {
					return self::error('err_text',  array($name));
				}
				break;
				
			case 'int8':
				if (!GWF_Validator::isOctalNumber(decoct(intval($value, 10)))) {
					return self::error('err_int8', array($name));
				}
				break;
				
			case 'int10':
				if (!GWF_Validator::isDecimalNumber($value)) {
					return self::error('err_int10', array($name));
				}
				break;
				
			case 'script':
//				if (!self::isDefaultValue($varname, $value)) {
//					return self::error('err_script', $name);
//				}
				break;
				
			case 'bool':
				if (!self::isBoolean($value)) {
					return self::error('err_bool', array($name));
				}
				break;
				
			default: return self::error('err_unknown_type', array(htmlspecialchars($type)));
		}
		
		$method_name = sprintf('check__%s', $varname);
		if (method_exists(__CLASS__, $method_name))
		{
			return call_user_func(array(__CLASS__, $method_name), $value);
		}
		else {
			return false;
		}
	}
	
	private static function isBoolean($value)
	{
		return $value === 'true' || $value === 'false'; # 0,1,yes,no ?
	}
	
//	private static function isDefaultValue($varname, $value)
//	{
//		return self::$defaults[$varname][self::VALUE] === $value;
//	}
	
	###############
	### Setters ###
	###############
	private static function setVar($varname, $value)
	{
		if (!isset(self::$vars[$varname])) {
			echo self::error('err_unknown_var', htmlspecialchars($varname));
			return false;
		}
		
		$type = self::$vars[$varname][self::TYPE];
		
		switch($type)
		{
			case 'script': return true;
			case 'int8': $value = octdec($value);
			default:
				break;
		}
		
		self::$vars[$varname][self::VALUE] = $value;
		return true;
	}
	
//	private static function setPostVar($varname, $value)
//	{
//		if (isset($_POST[self::POSTVARS]))
//		{
//			if (!is_array($_POST[self::POSTVARS])) {
//				$_POST[self::POSTVARS] = array();
//			}
//			$_POST[self::POSTVARS][$varname] = $value;
//		}
//	}
	
	public static function restoreDefault($varname)
	{
		if (!isset(self::$vars[$varname])) {
			echo self::error('err_unknown_var', htmlspecialchars($varname));
			return false;
		}
		self::$vars[$varname][self::VALUE] = self::$defaults[$varname][self::VALUE];
		return true;
	}
	
	#################
	### Init Vars ###
	#################
	private static function init(GWF_LangTrans $lang)
	{
		if (!self::$inited)
		{
			self::$lang = $lang;
			self::$vars = self::getDefaults($lang);
			self::$defaults = self::$vars;
			self::mergeConfig();
			self::mergePostVars();
			self::$inited = true;
		}
	}
	
	/**
	 * Config Vars are an array of array($type, $section, $varname, $varvalue, $comment). Types are: 'int10', 'int8', 'text', 'bool', 'script'.
	 * @return array of array($type, $section, $varname, $varvalue, $comment)
	 */
	private static function getDefaults(GWF_LangTrans $lang)
	{
		if (PHP_SAPI === 'cli')
		{
			$domain = 'localhost';
			$self = '/';
		}
		else
		{
			$domain = $_SERVER['HTTP_HOST'];
			$self = substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], '/install/')+1);
		}
		
		$path = GWF_PATH;
		
		$temp = array(
			# Main
			array('text',   'Main', 'GWF_DOMAIN', $domain, 'Example: \'www.foobar.com\'.'),
			array('text',   'Main', 'GWF_SITENAME', 'Gizmore Website Framework', 'Your Site`s name. htmlspecialchars() it yourself.'),
			array('text',   'Main', 'GWF_WEB_ROOT_NO_LANG', $self, 'Add trailing and leading slash. Example: \'/\' or \'/mywebdir/\'.'),
			array('text',   'Main', 'GWF_DEFAULT_DOCTYPE', 'html5', 'Set the default html-doctype for gwf. Modules can change it.'),

			# 3rd Party
			array('text', '3rd Party', 'GWF_SMARTY_PATH', GWF_SMARTY_PATH, 'Path to Smarty.class.php. Smarty replaced the GWF template engine and has to be available.'),
			array('text', '3rd Party', 'GWF_JPGRAPH_PATH', '/opt/php/jphraph/jpgraph.php', 'Path to jpgraph.php. JPGraph is a library to draw graphs with php. It is available under the GPL.'),
			array('text', '3rd Party', 'GWF_GESHI_PATH', '/opt/php/geshi/geshi.php', 'Path to geshi.php. GeSHi is a GPL licensed Syntax highlighter.'),

			# Smarty
			array('text', 'Smarty', 'GWF_SMARTY_DIRS', $path.'extra/temp/smarty/', 'Path to smarty directories for cache, config and compiling. With trailing slash.'),
// 			array('bool', 'Smarty', 'GWF_ERRORS_TO_SMARTY', false, 'Group all Error and display them in one Box?'),
			array('bool', 'Smarty', 'GWF_MESSAGES_TO_SMARTY', false, 'Same as above with success-messages'),

			# Defaults
			array('text', 'Defaults', 'GWF_DEFAULT_LANG', 'en', 'Fallback language. Should be \'en\'.'),
			array('text', 'Defaults', 'GWF_DEFAULT_MODULE', 'GWF', '1st visit module. Example: \'MyModule\'.'),
			array('text', 'Defaults', 'GWF_DEFAULT_METHOD', 'About', '1st visit method. Example: \'Home\'.'),
			array('text', 'Defaults', 'GWF_DEFAULT_DESIGN', 'default', 'Default design. Example: \'default\'.'),
			array('text', 'Defaults', 'GWF_ICON_SET', 'default', 'Default Icon-Set. Example: \'default\'.'),
			array('text', 'Defaults', 'GWF_DOWN_REASON', 'Converting the database atm. should be back within 45 minutes.', 'The Message if maintainance-mode is enabled.'),
			
			# Language
			array('text', 'Language', 'GWF_LANG_ADMIN', 'en', 'Admins language. Should be \'en\'.'),
			array('text', 'Language', 'GWF_SUPPORTED_LANGS', 'en;de;fr;it;pl;hu;es;bs;et;fi;ur;tr;sq;nl;ru;cs;sr', 'Separate 2 char ISO codes by semicolon. Currently (partially) Supported: en;de;fr;it;pl;hu;es;bs;et;fi;ur;tr;sq;nl;ru;cs;sr'),
			
			# Various
			array('int10', 'Various', 'GWF_ONLINE_TIMEOUT', 60, 'A request will mark you online for N seconds.'),
			array('int10', 'Various', 'GWF_CRONJOB_BY_WEB', 0, 'Chance in permille to trigger cronjob by www clients (0-1000)'),
			array('bool',  'Various', 'GWF_USER_STACKTRACE', true, 'Show stacktrace to the user on error? Example: true.' ),
			
			# Database
			array('text', 'Database', 'GWF_SECRET_SALT', GWF_Random::randomKey(16, GWF_Random::ALPHANUMUPLOW), 'May not be changed after install!'),
			array('int8', 'Database', 'GWF_CHMOD', 0700, 'CHMOD mask for file creation. 0700 for mpm-itk env. 0777 in worst case.'),
			array('text', 'Database', 'GWF_DB_HOST', 'localhost', 'Database host. Usually localhost.'),
			array('text', 'Database', 'GWF_DB_USER', '', 'Database username. Example: \'some_sql_username\'.'),
			array('text', 'Database', 'GWF_DB_PASSWORD', '', 'Database password.'),
			array('text', 'Database', 'GWF_DB_DATABASE', '', 'Database db-name.'),
			array('text', 'Database', 'GWF_DB_TYPE', 'mysql', 'Database type. Currently only \'mysql\' is supported.'),
			array('text', 'Database', 'GWF_DB_ENGINE', 'myIsam', 'Default database table type. Either \'innoDB\' or \'myIsam\'.'),
			array('text', 'Database', 'GWF_TABLE_PREFIX', 'gwf_', 'Database table prefix. Example: \'gwf3_\'.'),
			
			# Session
			array('text',  'Session', 'GWF_SESS_NAME', 'GWF', 'Cookie Prefix. Example: \'GWF\'.'),
			array('int10', 'Session', 'GWF_SESS_LIFETIME', 60*240, 'Session lifetime in seconds.'),
			array('int10',  'Session', 'GWF_SESS_PER_USER', '1', 'Number of allowed simultanous sessions per user. Example: 1'),
			
			# IP
			array('text',  'IP', 'GWF_IP_QUICK', 'hash_32_1', 'Hashed IP Duplicates. See core/inc/util/GWF_IP6.php'),
			array('text',  'IP', 'GWF_IP_EXACT', 'bin_32_128', 'Complete IP storage. See core/inc/util/GWF_IP6.php'),
			
			# EMail
			array('int10', 'EMail', 'GWF_DEBUG_EMAIL', 15, 'Send Mail on errors? 0=NONE, 1=DB ERRORS, 2=PHP_ERRORS, 4=404, 8=403, 16=MailToScreen)'),
			array('text',  'EMail', 'GWF_BOT_EMAIL', 'robot@'.$domain, 'Robot sender email. Example: robot@www.site.com.'),
			array('text',  'EMail', 'GWF_ADMIN_EMAIL', isset($_SERVER['SERVER_ADMIN']) ? $_SERVER['SERVER_ADMIN'] : 'admin@'.$domain, 'Hardcoded admin mail. Example: admin@www.site.com.'),
			array('text',  'EMail', 'GWF_SUPPORT_EMAIL', 'support@'.$domain, 'Support email. Example: support@www.site.com.'),
			array('text',  'EMail', 'GWF_STAFF_EMAILS', '', 'CC staff emails seperated by comma. Example: \'staff@foo.bar,staff2@blub.org\'.'),
//			array('text',  'EMail', 'GWF_EMAIL_GPG_SIG', '', 'EMail signature for mails sent by GWF2'),
		);
		$back = array();
		foreach ($temp as $t)
		{
			$back[$t[self::VARNAME]] = $t;
		}
		return $back;
	}
	
	private static function mergeConfig()
	{
		if (!Common::isFile('protected/config.php')) {
			return;
		}
		foreach (self::$vars as $var)
		{
			# debug
//			if (count($var) != 5) { var_dump($var); }
			list($type, $section, $varname, $value, $comment) = $var;
			if (defined($varname))
			{
				$defined_value = self::getDefinedValue($varname);
				if (false !== ($error = self::testVar($varname, $defined_value))) {
					echo self::error('err_config_value', array($varname));
					echo $error;
					continue;
				}
				
				self::setVar($varname, $defined_value);
			}
		}
	}
	
	private static function getDefinedValue($varname)
	{
		$value = constant($varname);
		if (is_bool($value)) {
			return self::getBoolValue($value);
		}
		elseif (self::$vars[$varname][self::TYPE] === 'int8') {
			return '0'.decoct($value);
		}
		else {
			return (string)$value;
		}
	}
	
	private static function getBoolValue($value)
	{
		return ($value === 'true' || $value === '1') ? 'true' : 'false';
	}
	
	private static function error($key, $params=array())
	{
		return GWF_HTML::error(self::$lang->lang('wizard'), self::$lang->lang($key, $params));
	}
	
	private static function mergePostVars()
	{
		$errors = array();
		$postvars = Common::getPostArray(self::POSTVARS, array());
		foreach ($postvars as $key => $value)
		{
			$value = trim($value);
			
			if (!isset(self::$vars[$key])) {
				$errors[] = self::$lang->lang('err_unknown_var', array(htmlspecialchars($key)));
				continue;
			}
			
			if (false !== ($error = self::testVar($key, $value))) {
				$errors[] = $error;
				continue;
			}
			
			self::setVar($key, $value);
		}
		
		if (count($errors) > 0) {
			echo GWF_HTML::error(self::$lang->lang('wizard'), $errors);
		}
	}
	
	############
	### Form ###
	############
	/**
	 * Display Form.
	 * @param $action
	 * @return string html
	 */
	public static function displayForm($action='install_wizard.php', GWF_LangTrans $lang)
	{
		self::init($lang);
		
		$back = sprintf('<form method="post" action="%s">', htmlspecialchars($action));
		$back .= '<table>';
		
		$color_toggle = -1;
		$current_section = '';
		foreach (self::$vars as $var)
		{
			list($type, $section, $define, $value, $comment) = $var;
			
			if ($section !== $current_section) {
				$current_section = $section;
				$color_toggle++;# = 1 - $color_toggle;
				$back .= self::displayDivRow($color_toggle, $current_section);
			}
			$back .= self::displayRow($color_toggle, $var);
		}
		
		# Buttons
		$buttons = GWF_Form::submit('test_db', 'Test DB');
		$buttons .= GWF_Form::submit('write_config', 'Write Config');
		$back .= sprintf('<tr class="gwfinstall%d"><td colspan="3">%s</td></tr>', $color_toggle, $buttons).PHP_EOL;
		
		$back .= '</table>'.PHP_EOL;
		$back .= '</form>'.PHP_EOL;
		return $back;
	}
	
	private static function displayRow($color=0, array $var)
	{
//		return sprintf('<tr class="gwfinstall%s"><td>%s</td><td>%s</td><td>%s</td></tr>', $color, $var[self::VARNAME], self::displayInput($var), $var[self::COMMENT]);
		return sprintf('<tr class="gwfinstall%s"><td>%s - %s</td></tr><tr class="gwfinstall%s"><td>%s</td></tr>', $color, $var[self::VARNAME], $var[self::COMMENT], $color, self::displayInput($var));
	}
	
	private static function displayDivRow($color=0, $section='Test')
	{
		return sprintf('<tr class="gwfinstall%s"><td colspan="3" class="gwfinstallformdiv">### %s ###</td></tr>', $color, $section).PHP_EOL;
	}
	
	private static function displayInput(array $var)
	{
		$pv = self::POSTVARS;
		$type = $var[self::TYPE];
		$name = htmlspecialchars($var[self::VARNAME]);
		$val = $var[self::VALUE];
		$value = htmlspecialchars($val);
		switch ($type)
		{
			case 'int8': 
				return sprintf('<input type="text" name="%s[%s]" value="%s" size="3" />', $pv, $name, decoct($value));
			case 'int10':
				return sprintf('<input type="text" name="%s[%s]" value="%s" size="11" />', $pv, $name, $value);
			case 'bool':
				return sprintf('<input type="text" name="%s[%s]" value="%s" size="5" />', $pv, $name, self::getBoolValue($value));
			case 'text':
				return sprintf('<input type="text" name="%s[%s]" value="%s" size="96" />', $pv, $name, $value);
			case 'script':
				return sprintf('<input type="text" name="%s[%s]" value="%s" size="32" />', $pv, $name, $value);
			default:
				return self::error('err_unknown_type', htmlspecialchars($type));
		}
	}
	
	##############
	### Writer ###
	##############
	/**
	 * Write a config file.
	 * @return boolean
	 */
	public static function writeConfig(GWF_LangTrans $lang)
	{
		self::init($lang);
		
		# Open File
		if (false === ($fh = fopen(self::CONFIG_FILENAME, 'w')))
		{
			echo GWF_HTML::err('ERR_FILE_NOT_FOUND', self::CONFIG_FILENAME);
			return false;
		}
		
		# Put in sections 
		$cfg2 = array();
		foreach (self::$vars as $data)
		{
			$section = $data[self::SECTION];
			if (!isset($cfg2[$section])) {
				$cfg2[$section] = array();
			}
			$cfg2[$section][] = $data;
		}
		
		# Header 
		self::writeHeader($fh);
		
		# Sections
		foreach ($cfg2 as $section => $cfg)
		{
			self::writeSectionHeader($fh, $section);
			foreach ($cfg as $data)
			{
				self::writeVar($fh, $data);
			}
			fwrite($fh, PHP_EOL);
		}

		# Site Down
		self::writeSiteDown($fh);
		
		# Footer
		self::writeFooter($fh);
		
		# Close File
		return fclose($fh);
	}
	
	private static function writeHeader($fh)
	{
		fwrite($fh, '<?php'.PHP_EOL);
		fwrite($fh, '/**'.PHP_EOL);
		fwrite($fh, ' * Auto Generated by GWFv'.GWF_CORE_VERSION.' *'.PHP_EOL);
		fwrite($fh, ' * It is good to have a backup at a second physical location *'.PHP_EOL);
		fwrite($fh, ' * Because of the GWF_SECRET_SALT *'.PHP_EOL);
		fwrite($fh, ' */'.PHP_EOL);
		self::writeSectionHeader($fh, 'Error reporting');
		fwrite($fh, 'ini_set(\'display_errors\', 1);'.PHP_EOL);
		fwrite($fh, 'error_reporting(0xffffffff);'.PHP_EOL);
		fwrite($fh, PHP_EOL);
	}
	
	private static function writeSiteDown($fh)
	{
		$t = "\t";
		self::writeSectionHeader($fh, 'Website Down?');
		$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1';
		fwrite($fh, "#define('GWF_WORKER_IP', '{$ip}');".PHP_EOL);
	}
	
	private static function writeFooter($fh)
	{
		fwrite($fh, '#(c)2009-2012 gizmore.'.PHP_EOL);
		fwrite($fh, '?>'.PHP_EOL);
	}
	
	private static function writeSectionHeader($fh, $section)
	{
		$section = sprintf('### %s ###', $section);
		$bound = str_repeat('#', strlen($section));
		fwrite($fh, $bound.PHP_EOL);
		fwrite($fh, $section.PHP_EOL);
		fwrite($fh, $bound.PHP_EOL);
	}
	
	private static function writeVar($fh, array $data)
	{
		list($type, $section, $key, $value, $comment) = $data;
		switch ($type)
		{
//			case 'bool': var_dump($value); $value = self::getBoolValue($value); break;
			case 'int8': $value = sprintf('0%s', decoct($value)); break;
			case 'int10': $value = intval($value, 10); break;
			case 'script': case 'bool': break;
			case 'text': $value = sprintf("'%s'", str_replace('\'', '\\\'', $value)); break;
			default:
				die(sprintf('Unknwon type[0] in data: '.implode(',',$data)));
		}
		$comment = $comment === '' ? '' : ' # '.$comment;
		fwrite($fh, sprintf('define(\'%s\', %s);%s', $key, $value, $comment).PHP_EOL);
	}
}
?>
