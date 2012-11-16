<?php
/**
 * Functions for the GWF Installer
 * @todo declare some functions as private
 * @todo use GWF_Result
 * @author gizmore
 * @author spaceone
 */
final class GWF_InstallFunctions
{
	############
	### Core ###
	############
	public static function get_core_tables()
	{
	//	Common::defineConst('GWF_CORE_PATH', dirname(__FILE__).'/../../core/');
		$classnames = array();
		foreach (scandir(GWF_CORE_PATH.'inc/util') as $file)
		{
			if (preg_match('/^GWF_([a-z0-9_]+)\\.php$/iD', $file, $matches))
			{
				$classname = $matches[1];
				if (false === ($content = file_get_contents(GWF_CORE_PATH."inc/util/{$file}"))) {
					continue;
				}
				if ( (strpos($content, ' extends GDO') !== false) && (strpos($content, 'abstract class') === false) )
				{
					$classnames[] = 'GWF_'.$classname;
				}
			}
		}
		return $classnames;
	//	return array('GWF_Country','GWF_Group','GWF_IP2Country','GWF_LangMap','GWF_Language','GWF_Module','GWF_ModuleVar','GWF_PublicKey','GWF_Session','GWF_Settings','GWF_User','GWF_UserGroup');
	}

	public static function core($drop=false, &$success)
	{
		$db = gdo_db();
		$tables = self::get_core_tables();
		$success = true;
		$ret = '<br/><br/>';
		foreach ($tables as $classname)
		{
			$ret .= sprintf("Installing %s table ... ", $classname);
			if (false === ($result = GDO::table($classname)->createTable($drop))) {
				#error
				$ret .= '<b class="gwfinstallno">FAILED!<br/>'.PHP_EOL;
				$success = false;
			}
			else {
				#success
				$ret .= '<b class="gwfinstallyes">OK</b><br/>'.PHP_EOL;
			}
		}
		$ret .= '<br/>';
		
		/** Try to set a birthdate **/
		if (false === GWF_Settings::getSetting('gwf_site_birthday', false))
		{
			$ret .= sprintf("Setting up a birthdate ... %s.", date('Ymd'));
			if (false === GWF_Settings::setSetting('gwf_site_birthday', date('Ymd')))
			{
				$ret .= '<b class="gwfinstallno">Cannot set site birthdate.<br/>'.PHP_EOL;
				$success = false;
			}
		}
		
		return $ret;
	}

	###############
	### Modules ###
	###############
	public static function all_modules($dropTables=false)
	{
		if (false === ($modules = GWF_ModuleLoader::loadModulesFS())) {
			return GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__), true, true);
		}
		
		return self::modules($modules, $dropTables);
	}

	public static function modules(array $modules, $dropTables=false)
	{
		$back = '';
		
		$modules = GWF_ModuleLoader::sortModules($modules, 'module_priority', 'ASC');
		
		foreach ($modules as $module)
		{
			$back .= sprintf('Installing %s...<br/>', $module->getName());
			$back .= GWF_ModuleLoader::installModule($module, $dropTables);
			$module->saveOption(GWF_Module::ENABLED, true); // TODO: gizmore.. check if bug
		}
		
		return $back;
	}

	##############
	### Groups ###
	##############
	public static function default_groups()
	{
		if (false === self::default_group(GWF_Group::ADMIN)) {
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__), true, true);
			return false;
		}
		if (false === self::default_group(GWF_Group::STAFF)) {
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__), true, true);
			return false;
		}
		if (false === self::default_group(GWF_Group::MODERATOR)) {
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__), true, true);
			return false;
		}
		if (false === self::default_group(GWF_Group::PUBLISHER)) {
			echo GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__), true, true);
			return false;
		}
		return true;
	}
	public static function default_group($name)
	{
		if (false !== GWF_Group::getByName($name)) {
			return true;
		}
		$group = new GWF_Group(array(
			'group_name' => $name,
			'group_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
		));
		return $group->replace();
	}
	#############
	### Users ###
	#############

	public static function default_users()
	{
		if (false === self::default_groups()) {
			return false;
		}
		self::createAdmin('Admin', '11111111', sprintf('admin@%s', GWF_DOMAIN), $out);
	}

	public static function createAdmin($username, $password, $email, &$output)
	{
		if (false === ($user = GWF_User::getByName($username)))
		{
			$user = new GWF_User(array(
				'user_name' => $username,
				'user_email' => $email,
				'user_password' => GWF_Password::hashPasswordS($password),
				'user_regdate' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
				'user_regip' => GWF_IP6::getIP(GWF_IP_EXACT),
				'user_lastactivity' => time(),
			));
			if (false === $user->insert())
			{
				return false;
			}
		}
		
		$userid = $user->getID();
		
		if (false === GWF_UserGroup::addToGroup($userid, GWF_Group::getByName(GWF_Group::ADMIN)->getID()))
		{
			return false;
		}
		
		if (false === GWF_UserGroup::addToGroup($userid, GWF_Group::getByName(GWF_Group::STAFF)->getID()))
		{
			return false;
		}
		
		$output .= GWF_HTML::message('Install Wizard', sprintf('Added new admin user: %s - Password: [censored]', $username));
		
		return true;
	}


	############################################
	### Language / Country / IPMap / LangMap ###
	############################################
	/**
	* Takes ages.
	* @return string
	* @todo integrate in design but do flushing and error handling
	*/
	public static function createLanguage($__langs=true, $__cunts=true, $__ipmap=false)
	{
		$success = true;
		require_once GWF_CORE_PATH.'inc/install/data/GWF_LanguageData.php';
		set_time_limit(0); # This function takes ages!

		$cache = array();
		$cache2 = array();
		# Language
		$i = 1;
		$linguas = GWF_LanguageData::getLanguages();
		$ret = 'Installing '.count($linguas).' Languages';
	//	flush();
		
		$lang_t = new GWF_Language();
		$supported = explode(';', GWF_SUPPORTED_LANGS);
		
		foreach ($linguas as $lang)
		{
	//		$ret .= '.';
	//		flush();

			array_map('trim', $lang);
			
			list($name, $native, $short, $iso) = $lang;

			if (false !== ($langrow = $lang_t->selectFirst('lang_id', "lang_short='$short'"))) { #GWF_Language::getByShort($short))) {
				$cache[$short] = $langrow['lang_id']; #->getID();
				continue;
			}
			
			if ($__langs)
			{
				if (false === $lang_t->insertAssoc(array(
					'lang_id' => $i,
					'lang_name' => $name,
					'lang_nativename' => $native,
					'lang_short' => $short,
					'lang_iso' => $iso,
					'lang_options' => in_array($iso, $supported, true) ? GWF_Language::SUPPORTED : 0,
				))) {
					$ret .= GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
					$success = false;
					continue;
				}
			}
			$i++;
			
			$cache[$short] = $i; #langrow['lang_id'];
		}
		
		$ret .= PHP_EOL;

		# Country and Langmap
		$countries = GWF_LanguageData::getCountries();
		$country_t = new GWF_Country();
		$ret .= 'Installing '.count($countries).' Countries';
	//	flush();
		
		foreach ($countries as $cid => $c)
		{
	//		$ret .= '.';
	//		flush();
			
			if (count($c) !== 5) {
				$ret .= GWF_HTML::error('Country error', sprintf('%s has error.', $c[0]), true, true);
			}
			
			array_map('trim', $c);
			list($name, $langs, $region, $tld, $pop) = $c;
			$tld = strtolower($tld);

			if ($__cunts)
			{
				if (false === $country_t->insertAssoc(array(
					'country_id' => $cid,
					'country_name' => $name,
					'country_tld' => $tld,
					'country_pop' => $pop,
				))) {
					$ret .= GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__), true, true);
					$success = false;
					continue;
				}
			}

			$cache2[$tld] = $cid;

			$langmap_t = new GWF_LangMap();
			if ($__cunts)
			{
				$langs = explode(':', $langs);
				foreach ($langs as $langshort)
				{
					if (!isset($cache[$langshort])) {
						$ret .= GWF_HTML::error('', 'Unknown iso-3: '.$langshort.' in country '.$name, true, true);
						$success = false;
						$ret .= GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__), true, true);
						continue;
					}
					$langid = $cache[$langshort];
					if (false === ($langmap_t->insertAssoc(array(
						'langmap_cid' => $cid,
						'langmap_lid' => $langid,
					)))) {
						$ret .= GWF_HTML::err('ERR_DATABASE', array( array(__FILE__, __LINE__)), true, true);
						$success = false;
						continue;
					}
				}
			}
		}
		$ret .= PHP_EOL;
		
		if (!$__ipmap) {
	//		return $success;
			return $ret;
		}

		$ret .= 'Installing ip2country'.PHP_EOL;
		
		# IP2Country
		$max = 89323;
		$now = 0;
		$filename = GWF_CORE_PATH."inc/install/data/ip-to-country.csv";

		if (false === ($fp = fopen($filename, "r"))) {
			$ret .= GWF_HTML::err('ERR_FILE_NOT_FOUND', array($filename), true, true);
	//		return false;
			return $ret;
		}
		
		$ip2c = new GWF_IP2Country();

		while (false !== ($line = fgetcsv($fp, 2048)))
		{
			if (count($line) !== 5) {
				$ret .= GWF_HTML::error('', $filename.' is corrupt!', true, true);
				$success = false;
				break;
			}

			list($ipstart, $ipend, $tld, $ccode2, $cname) = $line;
			$tld = strtolower($tld);
				
			if (!(isset($cache2[$tld]))) {
				$ret .= GWF_HTML::error('', 'Unknown TLD: '.$tld, true, true);
				$ret .= GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__), true, true);
				$success = false;
				continue;
			}
			
			if (false === $ip2c->insertAssoc(array(
				'ip2c_start' => $ipstart,
				'ip2c_end' => $ipend,
				'ip2c_cid' => $cache2[$tld],
			)))
			{
				$ret .= GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__), true, true);
				$success = false;
				continue;
			}
			
			$now++;
			if (!($now % 2500)) {
				$msg = sprintf('%d of %d...', $now, $max);
				$ret .= GWF_HTML::message('Progress', $msg, true, true);
	//			flush();
			}
		}
		return $ret;
	}

	public static function createLangBar()
	{
		$back = '<div class="gwf_langbar">';
		foreach( GWF_Language::getAvailable() as $iso )
		{
			if('' !== $iso)
			{
				if( false === ($lang = GWF_Language::getByISO($iso)))
				{
					continue;
				}

				$flag = ''; // TODO: get Country by Language ISO
				$alt = '['.strtoupper($iso).']';
				$title = $lang->displayName();
				$id = 'gwf_langbar_'.$iso;

				$back .= sprintf('	<a href="{$root}%s/" id="%s" title="%s"><img src="{$root}img/{$iconset}/%s" alt="%s"/></a>'.PHP_EOL, $iso, $id, $title, $flag, $alt);
			}
		}
		$back .= '</div>';

		return file_put_contents(GWF_WWW_PATH.'tpl/default/langbar.tpl', $back);
	}

	public static function createUserAgents()
	{
		return 'There are currently no UserAgents! (Not implemented)';
	}

	public static function copyExampleFiles(&$output)
	{
		$success = true;
		if (false === self::CopyExampleFile('index', GWF_WWW_PATH, '.php', $output))
		{
			$success = false;
		}
		if (false === self::CopyExampleFile('gwf_cronjob', GWF_WWW_PATH, '.php', $output))
		{
			$success = false;
		}
//		if (false === self::CopyExampleFile('pre_htaccess', GWF_PROTECTED_PATH, '.txt', $output))
//		{
//			$success = false;
//		}
		if (false === self::CopyExampleFile('db_backup', GWF_PROTECTED_PATH, '.sh', $output))
		{
			$success = false;
		}
		return $success;
	}

	/**
	 * Copy .example files and replace Variables
	 * Example files have to be in GWF_CORE_PATH/inc/install/data
	 * @param string $file the filename without extension
	 * @param string $path the destination path
	 * @param string $ext file extension (e.g. .php)
	 */
	public static function CopyExampleFile($file, $path, $ext='.php', &$output)
	{
		$copied = $path.$file.$ext;
		if (false === Common::isFile($copied))
		{
			if (false === GWF_File::isWriteable($copied))
			{
				$output .= GWF_InstallWizard::wizard_error('err_copy', array($copied));
				return false;
			}
			
			# Load skeleton.
			$example = GWF_CORE_PATH.'inc/install/data/'.$file.'.example'.$ext;
			if (false === ($content = file_get_contents($example)))
			{
				$output .= GWF_HTML::err('ERR_FILE_NOT_FOUND', array($example));
				return false;
			}

			# Replacements
			$replace = array(
				'%%GWFPATH%%' => GWF_DETECT_PATH,
				'%%DB%%' => escapeshellarg(GWF_DB_DATABASE),
				'%%USER%%' => escapeshellarg(GWF_DB_USER),
				'%%PASS%%' => escapeshellarg(GWF_DB_PASSWORD),
				'%%SALT%%' => escapeshellarg(GWF_Random::randomKey(16)),
			);
			$content = str_replace(array_keys($replace), array_values($replace), $content);
			
			# Write custom file.
			if (false === file_put_contents($copied, $content))
			{
				$output .= GWF_HTML::err('ERR_WRITE_FILE', array($copied));
				return false;
			}
			if (false === chmod($copied, GWF_CHMOD))
			{
				$output .= GWF_InstallWizard::wizard_error('err_copy', array($example));
				return false;
			}

			$output .= GWF_InstallWizard::wizard_message('msg_copy', array($copied));
		}
		else
		{
			$output .= GWF_InstallWizard::wizard_message('msg_copy_untouched', array($copied));
		}

		return true;
	}
}
