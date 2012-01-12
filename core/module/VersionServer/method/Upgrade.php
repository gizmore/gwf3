<?php
/**
 * Zip upgrade stuff for client
 * @author gizmore
 */
final class VersionServer_Upgrade extends GWF_Method
{
	private $client;
	private $datestamp;
	
	public function execute(GWF_Module $module)
	{
		if (false !== ($error = $this->validate($this->_module))) {
			return $error;
		}
		
//		if (false !== ($client_token = Common::getGet('sync_token'))) {
//			return $this->onSyncToken($client_token);
//		}
//		
//		if (false !== ($client_token = Common::getGet('get_file_list'))) {
//			return $this->getTotalHash($client_token);
//		}
//		
//		if (false !== Common::getGet('update_versions')) {
//			return $this->templateVersions($this->_module);
//		}
		
		return $this->templateUpgrade($this->_module);
	}

	private function validate(Module_VersionServer $module)
	{
		if (false === ($this->client = GWF_Client::getByToken(Common::getGet('token')))) {
			return $this->_module->error('err_token');
		}
		
		$datestamp = Common::getGet('datestamp', '');
		if (!GWF_Time::isValidDate($datestamp, true, GWF_Date::LEN_SECOND)) {
			return $this->_module->error('err_datestamp');
		}
		$this->datestamp = $datestamp;
		
		return false;
	}
	
	/**
	 * Request versions of modules, kernel, etc.
	 * This is only an indicator when you should definately update!
	 * @param Module_VersionServer $module
	 * @return unknown_type
	 */
	private function templateVersions(Module_VersionServer $module)
	{
		$out = '';
		$modules = GWF_Module::loadModulesFS();
		
		$hash = $this->getHash('inc');
		$out .= sprintf('core:inc:%0.02f:%s', GWF_CORE_VERSION, $hash);
		
//		return 
	}
	
	
	
	private function templateUpgrade(Module_VersionServer $module)
	{
		$haveError = false;
		$modules = GWF_Module::loadModulesFS();
		GWF_Module::sortModules($this->_modules, 'module_name', 'asc');
		
		# No ZIP extension?
		if (!class_exists('ZipArchive', false)) {
			return $this->_module->error('err_no_zip');
		}
//		require_once 'core/inc/util/GWF_ZipArchive.php';
		
		# Populate the DB again
		GWF_VersionFiles::populateAll();
		
		# Open temp manifest file.
		$manifestName = sprintf('extra/temp/upgrade_manifest_%s_%s.gwf_manifest', $this->client->getVar('vsc_uid'), $this->datestamp);
		if (false === ($fhManifest = fopen($manifestName, 'w'))) {
			return GWF_HTML::err('ERR_WRITE_FILE', array( $manifestName));
		} 
		
		
		# Create ZIP
		$archive = new GWF_ZipArchive();
		$archivename = sprintf('extra/temp/upgrade_%s_%s.zip', $this->client->getVar('vsc_uid'), $this->datestamp);
		if (false === ($archive->open($archivename, ZipArchive::CREATE|ZipArchive::CM_REDUCE_4))) {
			fclose($fhManifest);
			return $this->_module->error('err_zip', __FILE__, __LINE__);
		}
		
		

		$files = GDO::table('GWF_VersionFiles');
		if (false === ($result = $files->queryReadAll('', 'vsf_path ASC'))) {
//		if (false === ($result = $files->queryReadAll("vsf_date>='$this->datestamp'", "vsf_path ASC"))) {
//		if (false === ($result = $files->queryAll())) {
			fclose($fhManifest);
			$archive->close();
			@unlink($archivename);
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		fprintf($fhManifest, 'GWF2:DATESTAMP:%s'.PHP_EOL, date('YmdHis'));
		
		while (false !== ($file = $files->fetchObject($result)))
		{
//			echo GWF_HTML::message('VS_Upgrade', 'Adding File: '.$file->getVar('vsf_path'));
			$file instanceof GWF_VersionFiles;
			if (!$this->client->ownsModule($file->getVar('vsf_module'))) {
				continue;
			}
			if (!$this->client->ownsDesign($file->getVar('vsf_design'))) {
				continue;
			}
			
			$path = $file->getVar('vsf_path');
			
			if (!file_exists($path)) {
				$file->delete();
				continue;
			}
			
			if (!is_readable($path)) {
				echo GWF_HTML::err('ERR_FILE_NOT_FOUND', array( $path));
				$haveError = true;
				break;
			}
			
			// is file new?
			$isNew = $file->getVar('vsf_date') >= $this->datestamp;
			
			if ($isNew)
			{
				// add it to archive
				if (false === $archive->addFile($path)) {
					echo GWF_HTML::err('ERR_WRITE_FILE', array( $file->getVar('vsf_path')));
					$haveError = true;
					break;
				}
			}
			
			
//			echo GWF_HTML::message('VS_Upgrade', 'Added File: '.$file->getVar('vsf_path'));

			// write manifest info
			fwrite($fhManifest, $file->asManifest($isNew));
			
		}
		fclose($fhManifest);
		

		if (false === $archive->addFile($manifestName)) {
			echo GWF_HTML::err('ERR_WRITE_FILE', array( $manifestName));
			$haveError = true;
		}
		
		if (false === $archive->close()) {
			echo GWF_HTML::err('ERR_WRITE_FILE', array( $archivename));
			$haveError = true;
		}
		
		if (!$haveError) {
			GWF_Upload::outputFile($archivename);
		}
		
		// Delete stuff??
		@unlink($manifestName);
		@unlink($archivename);
		
		return '';
	}

}

?>