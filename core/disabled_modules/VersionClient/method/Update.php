<?php

final class VersionClient_Update extends GWF_Method
{
	private $manifest;
	private $datestamp;
	
	public function getUserGroups() { return GWF_Group::STAFF; }
	
	public function execute(GWF_Module $module)
	{
		if (false !== Common::getPost('simulate')) {
			return GWF_HTML::err('ERR_METHOD_MISSING', array( 'simulate'));
		}
		if (false !== Common::getPost('update')) {
			return $this->onUpdate($module);
		}
		if (false !== Common::getPost('clean_update')) {
			return $this->onCleanUpdate($module);
		}
		
		return $this->templateUpdate($module);
	}
	
	private function formUpdate(Module_VersionClient $module)
	{
		$buttons = array(
			'simulate' => $module->lang('btn_simulate'),
			'update' => $module->lang('btn_update'),
			'clean_update' => $module->lang('btn_cleanupdate'),
		);
		$data = array(
			'buttons' => array(GWF_Form::SUBMITS, $buttons),
		);
		return new GWF_Form($this, $data);
	}
	
	private function templateUpdate(Module_VersionClient $module)
	{
		$form = $this->formUpdate($module);
		$tVars = array(
			'up_server' => $module->cfgUpdateURL(),
			'up_datestamp' => $module->cfgDatestamp(),
			'up_token' => $module->cfgUpdateToken(),
			'form' => $form->templateX($module->lang('ft_update')),
		);
		return $module->templatePHP('update.php', $tVars);
	}
	
	private function getArchiveName()
	{
		return 'extra/temp/update_'.GWF_Time::THIS_DATE.'.zip';
	}
	private function getArchiveDir()
	{
		return 'extra/temp/update_'.GWF_Time::THIS_DATE;
	}
	
	private function onCleanUpdate(Module_VersionClient $module)
	{
		$module->saveModuleVar('vc_datestamp', '00000000000000');
		return $this->onUpdate($module);
	}
	
	private function onUpdate(Module_VersionClient $module)
	{
		set_time_limit(15*GWF_Time::ONE_MINUTE);
		
		$form = $this->formUpdate($module);
		if (false !== ($error = $form->validate($module))) {
			return $error.$this->templateUpdate($module);
		}
		
		# No ZIP extension?
		if (!class_exists('ZipArchive', false)) {
			return $module->error('err_no_zip');
		}
//		require_once 'core/inc/util/GWF_ZipArchive.php';
		
		
		$curlurl = $module->cfgCURLURL();
		
//		var_dump($curlurl);
		
		$archivename = $this->getArchiveName();
		if (false === ($fh = fopen($archivename, 'wb'))) {
			return GWF_HTML::err('ERR_WRITE_FILE', array( $archivename));
		} 
		
		$ch = curl_init($module->cfgCURLURL());
//		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//		curl_setopt($ch, CURLOPT_FAILONERROR, true);
//		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_FILE, $fh);
		
		$result = curl_exec($ch);
		
		if (false === (fclose($fh))) {
			return GWF_HTML::err('ERR_WRITE_FILE', array( $archivename));
		}
		
		if (false !== ($error = $this->inspectArchive($module))) {
			$this->cleanup();
			return $error;
		}
		else {
			$back = $this->onUpdateB($module);
			$this->cleanup();
			return $back;
		}
	}
	
	private function inspectArchive(Module_VersionClient $module)
	{
		$archivename = $this->getArchiveName();
		if (false === ($fh = fopen($archivename, 'r'))) {
			return GWF_HTML::err('ERR_FILE_NOT_FOUND', array( $archivename));
		}
		
		if (false === ($magic = fread($fh, 2))) {
			fclose($fh);
			return GWF_HTML::err('ERR_FILE_NOT_FOUND', array( $archivename));
		}
		fclose($fh);
		
		if ($magic === 'PK') {
			echo $module->message('msg_update_archive_ok', array(GWF_Upload::humanFilesize(filesize($archivename))));
			return false;
		}
		
		return GWF_HTML::errorAjax(file_get_contents($archivename));
	}
	
	private function onUpdateB(Module_VersionClient $module)
	{
		$archivename = $this->getArchiveName();
		$archivedir = $this->getArchiveDir();
		
		if (false === mkdir($archivedir, GWF_CHMOD)) {
			return GWF_HTML::err('ERR_WRITE_FILE', array( $archivedir));
		}
		
		$archive = new GWF_ZipArchive();
		if (true !== $archive->open($archivename)) {
			return GWF_HTML::err('ERR_FILE_NOT_FOUND', array( $archivename));
		}
		
		if (false === $archive->extractTo($archivedir)) {
			return GWF_HTML::err('ERR_WRITE_FILE', array( $archivedir));
		}
		
		if (false === $archive->close()) {
			return GWF_HTML::err('ERR_WRITE_FILE', array( $archivename));
		}
		
		if (false !== ($error = $this->cacheManifest($module))) {
			return $error;
		}
		
		return $this->onUpdateC($module);
	}
	
	private function cacheManifest(Module_VersionClient $module)
	{
		$manifestdir = $this->getArchiveDir().'/temp';
		
		$back = $module->error('err_manifest1');
		
		$dir = dir($manifestdir);
		
		while (false !== ($entry = $dir->read()))
		{
			if ($entry === '.' || $entry === '..') {
				continue;
			}
			if (1 === preg_match('/^upgrade_manifest_\d+_\d+.gwf_manifest$/D', $entry))
			{
				$fullpath = $manifestdir.'/'.$entry;
				$back = $this->cacheManifestB($module, $fullpath);
				break;
			}
		}
		return $back;
	}
	
	private function cacheManifestB(Module_VersionClient $module, $fullpath)
	{
		$this->manifest = file($fullpath);
		
		if (1 !== preg_match('/^GWF2:DATESTAMP:(\d{'.GWF_Date::LEN_SECOND.'})$/D', $this->manifest[0], $matches))
		{
			return $module->error('err_manifest2');
		}
		$this->datestamp = $matches[1];
		
		if (!GWF_Time::isValidDate($this->datestamp, false, GWF_Date::LEN_SECOND)) {
			return $module->error('err_manifest3');
		}
		
		@unlink($fullpath);
		unset($this->manifest[0]);
		
		return false;
	}
	
	/**
	 * Archive is extracted and ready to get installed.
	 * @param Module_VersionClient $module
	 * @return unknown_type
	 */
	private function onUpdateC(Module_VersionClient $module)
	{		
		$errors = array();
		$archivedir = $this->getArchiveDir();
		$this->onCheckPermissions($archivedir, $errors);
		if (count($errors) > 0) {
			return GWF_HTML::error('Update', $errors);
		}
		
		return $this->onUpdateD($module);
	}
	
	private function onCheckPermissions($path, array &$errors)
	{
		if (false === ($dir = dir($path))) {
			$errors[] = GWF_HTML::lang('ERR_FILE_NOT_FOUND', array( $path));
			return;
		}
		
		while (false !== ($entry = $dir->read()))
		{
			if ($entry === '.' || $entry === '..') {
				continue;
			}
			
			$fullpath = $path.'/'.$entry;
			
			if (is_dir($fullpath))
			{
				$this->onCheckPermissions($fullpath, $errors);
			}
			else
			{
				$this->onCheckPermission($fullpath, $errors);
			}
		}
	}
	
	private function getRealPath($path)
	{
		$realpath = Common::substrFrom($path, '/', $path);
		$realpath = Common::substrFrom($realpath, '/', $realpath);
		return $realpath;
	}
	
	private function onCheckPermission($path, array &$errors)
	{
		$realpath = $this->getRealPath($path);
		if ( (!is_writable($realpath)) && (!is_writable(dirname($realpath))) && (!mkdir(dirname($realpath), GWF_CHMOD, true)) )
		{
			$errors[] = GWF_HTML::lang('ERR_WRITE_FILE', array( $realpath));
		}
	}

	public static function hash($string)
	{
		return
			substr(Common::hashMD5($string), 0, 16).
			substr(Common::hashSHA1($string), 0, 16).
			substr(Common::hashCRC32($string));
	}
	
	/**
	 * We checked all write permissions for every file updated.
	 * Now we could simply move the files around and check against the manifest.
	 * @param Module_VersionClient $module
	 * @return unknown_type
	 */
	private function onUpdateD(Module_VersionClient $module)
	{
		$errors = 0;
		$oldFiles = 0;
		$newFiles = 0;
		
		$copyFiles = array();
		
		$dir_extracted = $this->getArchiveDir();
		foreach ($this->manifest as $mid => $manifest)
		{
//			echo htmlspecialchars($manifest);
			$manifest = explode(':', $manifest);
			$isNew = $manifest[0];
			$hash = $manifest[4];
			$date = $manifest[5];
			$path = $manifest[6];
			
//			var_dump('NEXT MANIFEST FILE:'.$path);
			
			$path = trim($path);
			$path_extracted = sprintf('%s/%s', $dir_extracted, $path);
			$hash_extracted = self::hash(file_get_contents($path_extracted));
			$path_real = $path;
			
//			var_dump($path_extracted);
//			var_dump(sprintf('%s=%s', $hash, $hash_extracted));
			
			if ($isNew==='1') {
				if ($hash === $hash_extracted) {
					$copyFiles[] = $path;
					$newFiles++;
				}
				else {
					echo $module->error('err_package_broken', $path);
					$errors++;
				}
			}
			else { // Old File
				$hash_old = self::hash(file_get_contents($path));
				if ($hash === $hash_old) {
					$oldFiles++;
				}
				else {
					echo $module->error('err_file_broken', $path);
					$errors++;
				}
			}
		}
		
		if ($errors > 0) {
			return $module->error('err_update', $errors).$this->templateUpdate($module);
		}
		
		foreach ($copyFiles as $path)
		{
			$src = $dir_extracted.'/'.$path;
			copy($src, $path);
			unlink($src);
		}
		
		$module->saveModuleVar('vc_datestamp', $this->datestamp);
		
		$back = '';
		
		if (false !== ($modules = GWF_Module::loadModulesFS()))
		{
			GWF_Module::sortModules($modules, 'module_priority', 'ASC');
			foreach ($modules as $m)
			{
				$m instanceof GWF_Module;
				$back .= $m->install(false);
			}
		}
		
		return $back.$module->message('msg_update_done', array($oldFiles, $newFiles));
	}

	private function cleanup()
	{
		Common::removeDir($this->getArchiveDir());
		unlink($this->getArchiveName());
	}
	
}

?>
