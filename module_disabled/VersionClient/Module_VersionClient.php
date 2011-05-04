<?php
/**
 * @author gizmore
 */
final class Module_VersionClient extends GWF_Module
{
	public function getVersion() { return 1.00; }
	
	public function onLoadLanguage() { return $this->loadLanguage('lang/vc'); }
	
	public function getAdminSectionURL() { return $this->getMethodURL('Update'); }
	
	public function onInstall($dropTable)
	{
		return $this->installVars(array(
			'vc_server' => array('http://gwf2.gizmore.org', 'text', 11, 512),
			'vc_token' => array('123456789012', 'text', 12, 12),
			'vc_datestamp' => array('00000000000000', 'text', GWF_Date::LEN_SECOND, GWF_Date::LEN_SECOND),
		));
	}
	
	public function cfgUpdateURL() { return $this->getModuleVar('vc_server', 'http://gwf2.gizmore.org'); }
	public function cfgUpdateToken() { return $this->getModuleVar('vc_token', '123456789012'); }
	public function cfgDatestamp() { return $this->getModuleVar('vc_datestamp', '00000000000000'); }
	
	public function cfgCURLURL() { return sprintf('%s/index.php?mo=VersionServer&me=Upgrade&token=%s&datestamp=%s&ajax=yes', $this->cfgUpdateURL(), $this->cfgUpdateToken(), $this->cfgDatestamp()); }
	
	#######################
	### Hash Generation ###
	#######################
	/**
	 * Get a hash for a directory or file.
	 * @param unknown_type $filenames
	 * @return unknown_type
	 */
	public function getHash($filenames)
	{
		$this->hashes = array();
		if (is_string($filenames)) {
			$filenames = array($filenames);
		}
		elseif (!is_array($filenames)) {
			echo GWF_HTML::err('ERR_GENERAL', array( __FILE__, __LINE__));
			return false;
		}
		
		foreach ($filenames as $filename)
		{
			$this->getHashRec($filename);
		}
		
		return $this->getHashFinalize();
	}
	
	private function getHashFinalize()
	{
		sort($this->hashes);
		
		$hash = implode($this->hashes);
		
		foreach($this->hashes as $hash)
		{
			
		}
		
	}
	
	private function hash($string, $filename)
	{
		$md5 = Common::hashMD5($string, 0, 16);
		$sha1 =  substr(Common::hashSHA1($string), 0, 16);
		$crc32 = Common::hashCRC32($string);
		return $md5.$sha1.$crc32.':'.$filename;
	}
	
	public function getHashFile($filename)
	{
		if (false === ($contents = file_get_contents($filename))) {
			echo GWF_HTML::err('ERR_GENERAL', array( __FILE__, __LINE__));
		}
		else {
			$this->hashes[] = $this->hash($contents, $filename);
		}
	}
	
	private $hashes = NULL;
		
	public function getHashRec($fullpath)
	{
		if (!is_readable($fullpath)) {
			echo GWF_HTML::err('ERR_FILE_NOT_FOUND', array( htmlspecialchars($fullpath)));
			return;
		}
		
		if (is_file($fullpath)) {
			$this->getHashFile($fullpath);
			return;
		}
		
		if (false === ($dir = dir($fullpath))) {
			echo GWF_HTML::err('ERR_FILE_NOT_FOUND', array( htmlspecialchars($fullpath)));
			return;
		}

		while (false !== ($entry = $dir->read()))
		{
			if (Common::startsWith($entry, '.')) {
				continue;
			}
			
			$newpath = $fullpath.'/'.$entry;
			$this->getHashRec($newpath);
		}
		
		$dir->close();
	}
}

?>
