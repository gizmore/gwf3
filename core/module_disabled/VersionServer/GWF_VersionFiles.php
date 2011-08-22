<?php
final class GWF_VersionFiles extends GDO
{
	const HASH_LEN = 40;
	
	private static $size_unpacked = 0;
	
	private static $blacklist = array(
		'#^core/module/WeChall/method/Convert.php$#',
	);
	
//	private static $whitelist = array(
//		# WeChall extra whitelist.
//		# Dir, Module, Design, Path
//		array('form', 'WeChall', '', GWF_CORE_PATH.'module/WeChall/solutionbox.php'),
//		array('',     'WeChall', '', 'html_foot.php'),
//		array('',     'WeChall', '', 'html_head.php'),
//		array('',     'WeChall', '', 'remoteupdate.php'),
//	);
	
//	private static $indexFiles = array(
////		'db_backup.sh',
//		'gwf_cronjob.php',
//		'index.php',
//		'robots.txt',
//	);
//	
//	private static $protectedFiles = array(
//		'install_css',
//		'index.php',
//		'install_config.php',
//		'install_functions.php',
//		'install_language.php',
//		'install_wizard.inc.php',
//		'install_wizard.php',
//		'install.php',
//		'ip-to-country.csv',
//		'readme_install.txt',
//		'uas_20091216-01.ini',
//		'install_lang',
//	);
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }	
	public function getTableName() { return GWF_TABLE_PREFIX.'vs_files'; }
	public function getColumnDefines()
	{
		return array(
			'vsf_id' => array(GDO::AUTO_INCREMENT), // ID
			'vsf_dir' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S|GDO::INDEX, GDO::NOT_NULL, 63),
			'vsf_module' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S|GDO::INDEX, GDO::NOT_NULL, 63),
			'vsf_design' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S|GDO::INDEX, GDO::NOT_NULL, 63),
			'vsf_path' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S|GDO::UNIQUE, GDO::NOT_NULL, 255),
			'vsf_date' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'vsf_size' => array(GDO::UINT, GDO::NOT_NULL),
			'vsf_hash' => array(GDO::TOKEN, GDO::NOT_NULL, self::HASH_LEN),
		);
	}
	
	public static function getByPath($fullpath)
	{
		return self::table(__CLASS__)->getBy('vsf_path', self::escape($fullpath));
//		$fullpath = ;
//		return self::table(__CLASS__)->selectFirstObject("vsf_path='$fullpath'");
	}
	
	private static function isBlacklisted($fullpath)
	{
		foreach (self::$blacklist as $regex)
		{
			if (preg_match($regex, $fullpath))
			{
//				echo GWF_HTML::message(__CLASS__, 'Blacklisted file: '.$fullpath);
				return true;
			}
		}
		return false;
	}
	
	public static function populateFile($basedir, $fullpath, $modulename=true, $designname=true)
	{
		if (self::isBlacklisted($fullpath)) {
			return true;
		}
		
		$mtimeOld = GWF_Time::getDate(GWF_Date::LEN_SECOND, filemtime($fullpath));
		
		# Get modulename
		if (is_string($modulename)) { // keep
		}
		elseif ($basedir === 'modules') {
			$modulename = substr($fullpath, 8);
			$modulename = Common::substrUntil($modulename, '/');
		}
		else {
			$modulename = '';
		}
		
		# Get designname
		if (is_string($designname)) { // keep
		}
		if (preg_match('#.*(^|/)tpl/([^/]+)/.+$#', $fullpath, $matches)) {
			$designname = $matches[2];
		} else {
			$designname = '';
		}
		
		self::$size_unpacked += filesize($fullpath);
		
		if (false === ($row = self::getByPath($fullpath))) {
//			echo GWF_HTML::message('New File Detected', 'New File: '.$fullpath);
			$row = new self(array(
				'vsf_id' => 0,
				'vsf_dir' => $basedir,
				'vsf_path' => $fullpath,
				'vsf_module' => $modulename,
				'vsf_design' => $designname,
				'vsf_hash' => self::hash(file_get_contents($fullpath)),
				'vsf_date' => $mtimeOld,
				'vsf_size' => filesize($fullpath),
			));
			return $row->insert();
		}
		
		$mtimeDB = $row->getVar('vsf_date');
		if ($mtimeOld != $mtimeDB) {
//			echo GWF_HTML::message('New File Detected', 'Updated: '.$fullpath. 'OLD='.$mtimeOld.' | DB='.$mtimeDB);
			return $row->saveVars(array(
				'vsf_hash' => self::hash(file_get_contents($fullpath)),
				'vsf_date' => $mtimeOld,
				'vsf_size' => filesize($fullpath),
			));
		}
		
		return true;
	}
	
	public static function hash( $string)
	{
		return
			substr(GWF_Password::md5($string), 0, 16).
			substr(GWF_Password::hashSHA1($string), 0, 16).
			substr(GWF_Password::hashCRC32($string), 0, 8);
	}
	
	public static function getSizeUnpacked()
	{
		return self::$size_unpacked;
	}
	
	public static function populateAll()
	{
		self::$size_unpacked = 0;
		
		self::populate(GWF_PATH.'extra/font');
		self::populate(GWF_WWW_PATH.'img');
		self::populate(GWF_PATH.'core/inc');
		self::populate(GWF_WWW_PATH.'js');
		self::populate(GWF_PATH.'core/lang');
		self::populate(GWF_PATH.'core/module');
		self::populate(GWF_WWW_PATH.'tpl');
		
		GWF_Module::getModule('VersionServer')->getMethod('Zipper');
		
		foreach (VersionServer_Zipper::$protected_files as $fullpath)
		{
			self::populateFile('protected', $fullpath);
		}
		
		foreach (VersionServer_Zipper::$protected_dirs as $fullpath)
		{
			self::populateRec('protected', $fullpath);
		}
		
		foreach (VersionServer_Zipper::$rootfiles as $fullpath)
		{
			self::populateFile('', $fullpath);
		}

//		foreach (self::$whitelist as $data)
//		{
//			list($basedir, $modulename, $designname, $fullpath) = $data;
//			self::populateFile($basedir, $fullpath, $modulename, $designname);
//		}
	}
	
	public static function populate($basedir)
	{
		self::populateRec($basedir, $basedir);
	}

	public static function populateRec($basedir, $path)
	{
		if (false === ($dir = dir($path))) {
			return false;
		}
		
		while (false !== ($entry = $dir->read()))
		{
			if ($entry === '.' || $entry === '..') {
				continue;
			}
			
			$fullpath = $path.'/'.$entry;
			if (is_dir($fullpath)) {
				self::populateRec($basedir, $fullpath);
			} else {
				self::populateFile($basedir, $fullpath);
			}
		}
	}
	
	public function asManifest($isNew)
	{
		return sprintf("%s:%s:%s:%s:%s:%s:%s\n", $isNew?'1':'0', $this->getVar('vsf_dir'), $this->getVar('vsf_module'), $this->getVar('vsf_design'), $this->getVar('vsf_hash'), $this->getVar('vsf_date'), $this->getVar('vsf_path'));
	}
}