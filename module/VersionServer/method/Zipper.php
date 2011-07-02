<?php
final class VersionServer_Zipper extends GWF_Method
{
	public function getUserGroups() { return GWF_Group::ADMIN; }
	public function getHTAccess(GWF_Module $module)
	{
		return 
			'RewriteRule ^zipper/?$ index.php?mo=VersionServer&me=Zipper'.PHP_EOL;
	}
	
	private $style = array('default');
	private $num_files = 0;
	
	private $has_error = true;
	public function hasError() { return $this->has_error; }
	
	public static $rootfiles = array(
		'error.php',
		'gwf_cronjob.php',
		'index.php',
//		'robots.txt',
	);
	
	public static $protected_dirs = array(
		'protected/install_css',
		'protected/install_data',
		'protected/install_lang',
		'protected/install_scripts',
		'protected/install_upgrade',
	);
	
	public static $protected_files = array(
//		'protected/gwf_install.css',
//		'protected/install_config.php',
//		'protected/install_functions.php',
//		'protected/install_language.php',
//		'protected/install_wizard.inc.php',
		'protected/install_cli.php',
		'protected/install_wizard.php',
		'protected/install.php',
//		'protected/ip-to-country.csv',
//		'protected/uas_20091216-01.ini',
		'protected/readme_install.txt',
		'protected/temp_ban.php',
		'protected/temp_down.php',
		'protected/db_backup.sh',
	);
	
	public static $tempdirs = array(
		'cache', 'applet',
		'temp', 'temp/banner', 'temp/offer', 'temp/upload', 'temp/gpg',
		'dbimg/banner', 'dbimg/cover', 'dbimg/partner',
		'protected/logs', 'protected/db_backups', 'protected/db_backups_old', 'protected/rawlog', 'protected/zipped',
		'temp/smarty_cache', 'temp/smarty_cache/cache', 'temp/smarty_cache/cfg', 'temp/smarty_cache/tpl', 'temp/smarty_cache/tplc',
	);
	
	public function execute(GWF_Module $module)
	{
		if (false !== (Common::getPost('zipper'))) {
			return $this->onZipB($module);
		}
		return $this->templateZipper($module);
	}
	
	public function getForm(Module_VersionServer $module)
	{
		$data = array();
		
		$data['style'] = array(GWF_Form::STRING, 'default', $module->lang('style'));
		
		$data['div'] = array(GWF_Form::HEADLINE, '', $module->lang('ft_zipper'));
		
		$modules = GWF_ModuleLoader::loadModulesFS();
		
		GWF_ModuleLoader::sortModules($modules, 'module_name', 'ASC');
		
		foreach ($modules as $m)
		{
			#$m instanceof GWF_Module;
			$name = $m->getName();
			$key = sprintf('mod_%s', $name);
			$data[$key] = array(GWF_Form::CHECKBOX, $m->isEnabled(), $name);
		}
		$data['zipper'] = array(GWF_Form::SUBMIT, $module->lang('btn_zip'));
		
		return new GWF_Form($this, $data);
	}
	
	private function templateZipper(Module_VersionServer $module)
	{
		$form = $this->getForm($module);
		
		$tVars = array(
			'form' => $form->templateY($module->lang('ft_zipper')),
		);
		return $module->templatePHP('zipper.php', $tVars);
	}
	
	private $archiveName = false;
	public function setArchiveName($fullpath)
	{
		$this->archiveName = $fullpath;
	}
	
	private function getArchiveName()
	{
		if ($this->archiveName === false) {
			return sprintf('protected/zipped/%s_%s.zip', GWF_Time::getDate(GWF_Date::LEN_SECOND), implode(',', $this->style));
		}
		else {
			return $this->archiveName;
		}
	}
	
	public function onZip(Module_VersionServer $module, $modules, $design)
	{
		$_POST = array();
		foreach ($modules as $modulename)
		{
			$_POST['mod_'.$modulename] = 'yes';
		}
		$_POST['style'] = $design;
		return $this->onZipB($module);
	}
	
	public function onZipB(Module_VersionServer $module)
	{
		# No ZIP extension?
		if (!class_exists('ZipArchive', false)) {
			return $module->error('err_no_zip');
		}
//		require_once 'inc/util/GWF_ZipArchive.php';
		
		# Post Vars
		$this->style = explode(',', Common::getPost('style', 'default'));
		unset($_POST['style']);
		unset($_POST['zipper']);
		return $this->onZipC($module);
	}
	
	public function onZipC(Module_VersionServer $module)
	{
		# Create ZIP
		$archive = new GWF_ZipArchive();
		$archivename = $this->getArchiveName();
		if (false === ($archive->open($archivename, ZipArchive::CREATE|ZipArchive::CM_REDUCE_4))) {
			return $module->error('err_zip', array(__FILE__, __LINE__));
		}
		
		# ZIP STUFF
		# Core
		if (false === ($this->zipDir($archive, 'inc'))) {
			return $module->error('err_zip', array(__FILE__, __LINE__));
		}
		# ZIP Module(Groups)
		foreach ($_POST as $group => $checked)
		{
			if (!Common::startsWith($group, 'mod_')) {
				continue;
			}
			# zip dir recursive, do not ignore style
			if (false === ($this->zipDir($archive, 'module/'.substr($group, 4), true, false))) {
				return $module->error('err_zip', array(__FILE__, __LINE__));
			}
		}
		
		# 3rd Party Core
		if (false === ($this->zipDir($archive, 'inc3p'))) {
			return $module->error('err_zip', array(__FILE__, __LINE__));
		}
		
		# Smarty
//		if (false === ($this->zipDir($archive, 'smarty_lib'))) {
//			return $module->error('err_zip', array(__FILE__, __LINE__));
//		}
		
		
		# JS
		if (false === ($this->zipDir($archive, 'js'))) {
			return $module->error('err_zip', array(__FILE__, __LINE__));
		}
		# Base Lang
		if (false === ($this->zipDir($archive, 'lang'))) {
			return $module->error('err_zip', array(__FILE__, __LINE__));
		}
		# Images
		if (false === ($this->zipDir($archive, 'img', false))) {
			return $module->error('err_zip', array(__FILE__, __LINE__));
		}
		if (false === ($this->zipDir($archive, 'img/country', false))) {
			return $module->error('err_zip', array(__FILE__, __LINE__));
		}
		if (false === ($this->zipDir($archive, 'img/smile', false))) {
			return $module->error('err_zip', array(__FILE__, __LINE__));
		}
		# Temp
		if (false === $this->addEmptyDirs($archive, self::$tempdirs)) {
			return $module->error('err_zip', array(__FILE__, __LINE__));
		}
		# Fonts
		if (false === ($this->zipDir($archive, 'font'))) {
			return $module->error('err_zip', array(__FILE__, __LINE__));
		}
		# Templates
		if (false === ($this->zipDir($archive, 'tpl', true, false))) {
			return $module->error('err_zip', array(__FILE__, __LINE__));
		}
		# Root Files
		if (false === ($this->addFiles($archive, self::$rootfiles))) {
			return $module->error('err_zip', array(__FILE__, __LINE__));
		}
		# Protected Dirs
		if (false === $this->zipDirs($archive, self::$protected_dirs)) {
			return $module->error('err_zip', array(__FILE__, __LINE__));
		}
		# Protected Files
		if (false === ($this->addFiles($archive, self::$protected_files))) {
			return $module->error('err_zip', array(__FILE__, __LINE__));
		}
		
		# Module Extra Files and Dirs
		if (false === $this->zipDirs($archive, $this->getModuleExtraDirs())) {
			return $module->error('err_zip', array(__FILE__, __LINE__));
		}
		
		if (false === ($this->addFiles($archive, $this->getModuleExtraFiles()))) {
			return $module->error('err_zip', array(__FILE__, __LINE__));
		}
		
		
		$total_files = $archive->getTotalFilesCounter();

		if (false === $archive->close()) {
			return $module->error('err_zip', array(__FILE__, __LINE__));
		}
		
		$this->has_error = false;
		
		return $module->message('msg_zipped', array($archivename, GWF_Upload::humanFilesize(filesize($archivename)), $total_files));
	}
	
	private function getModuleExtraDirs()
	{
		$back = array();
//		foreach (GWF_Module::getModules() as $name => $module)
//		{
//			if (false !== ($mod = GWF_Module::getModule($name)))
//			{
//				$back = array_merge($back, $mod->getExtraDirs());
//			}
//		}
		return $back;
	}
	
	private function getModuleExtraFiles()
	{
		$back = array();
//		foreach (GWF_Module::getModules() as $name => $module)
//		{
//			if (false !== ($mod = GWF_Module::getModule($name)))
//			{
//				$back = array_merge($back, $mod->getExtraFiles());
//			}
//		}
		return $back;
	}
	
	private function addEmptyDirs(GWF_ZipArchive $archive, array $dirs)
	{
		foreach ($dirs as $dir)
		{
			if (false === $archive->addEmptyDir($dir)) {
				return false;
			}
			
			# Add htaccess and index.php if they exist for empty/temp dir
			$hta = $dir.'/'.'.htaccess';
			if (Common::isFile($hta)) {
				$archive->addFile($hta);
			}
			
			$index = $dir.'/'.'index.php';
			if (Common::isFile($index)) {
				$archive->addFile($index);
			}
			
		}
		return true;
	}
	
	private function addFiles(GWF_ZipArchive $archive, array $files)
	{
		foreach ($files as $file)
		{
			if (!$this->isFileWanted($file)) {
				continue;
			}
			
			if (false === $archive->addFile($file)) {
				echo GWF_HTML::err('ERR_FILE_NOT_FOUND', array( GWF_HTML::display($file)));
				return false;
			}
		}
		return true;
	}
	
	private function zipDirs(GWF_ZipArchive $archive, array $paths, $recursive=true, $ignoreTemplates=true)
	{
		foreach ($paths as $path)
		{
			if (false === $this->zipDir($archive, $path, $recursive, $ignoreTemplates))
			{
				return false;
			}
		}
		return true;
	}
	
	private function zipDir(GWF_ZipArchive $archive, $path, $recursive=true, $ignoreTemplates=true)
	{
		if (!is_dir($path)) {
			GWF_Log::logCritical('Is not Dir: '.$path);
			return false;
		}
		
		if (false === ($dir = @dir($path))) {
			GWF_Log::logCritical('Can not read Dir: '.$path);
			return false;
		}
		
		while(false !== ($entry = $dir->read()))
		{
			if ($entry === '.' || $entry === '..') {
				continue;
			}
			
			$fullpath = sprintf('%s/%s', $path, $entry);
			
			
			if (is_dir($fullpath))
			{
				# ignore some designs...
				if (!$ignoreTemplates && $this->isIgnored($fullpath)) {
					continue;
				}
				# recursion?
				if ($recursive) {
					if (false === ($this->zipDir($archive, $fullpath, $recursive, $ignoreTemplates))) {
						$dir->close();
						return false;
					}
				} else { # just skip dir
					continue;
				}
			}
			
			## TODO: REMOVE ME (Skip sensitive file)
			else if ($entry==='Convert.php') {
				continue;
			}
			
			else if ($this->isFileWanted($entry)) { # Add a file.
				
				if (false === $archive->addFile($fullpath)) {
					GWF_Log::logCritical('Can not add file: '.$fullpath);
					$dir->close();
					return false;
				}
			}
		}
		
		$dir->close();
		return true;
	}
	
	private function isFileWanted($entry)
	{
		if (Common::endsWith($entry, '.zip')) {
			return false;
		}
		if (Common::endsWith($entry, '.jar')) {
			return false;
		}
		return true;
	}
	
	private function isIgnored($fullpath)
	{
//		# ignored Modules
//		if ($this->isIgnoredModule($fullpath)) {
//			return true;
//		}
		
		# no template dir
		if (0 === preg_match('#tpl/([^/]+)$#', $fullpath, $matches)) {
			return false;
		}
		
		# wanted dir
		$t = $matches[1];
		if ($t === 'default' || in_array($t, $this->style, true) ) {
			return false;
		}
		
		# ignore this style
		return true;
	}
	
	private function isIgnoredModule($fullpath)
	{
//		var_dump($fullpath);
		return false;
	}
}

?>