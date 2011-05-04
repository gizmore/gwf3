<?php

final class GWF_VersionFilesClient extends GDO
{
	const HASH_LEN = 40;
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }	
	public function getTableName() { return GWF_TABLE_PREFIX.'gwfvsfilesc'; }
	public function getColumnDefines()
	{
		return array(
			'vsfc_id' => array(GDO::UINT||GDO::AUTO_INCREMENT),
			'vsfc_dir' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S|GDO::INDEX, GDO::NOT_NULL, 63),
			'vsfc_path' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S|GDO::INDEX, GDO::NOT_NULL, 255),
			'vsfc_hash' => array(GDO::CHAR, GDO::NOT_NULL, self::HASH_LEN),
			'vsfc_date' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
		);
	}
	
	public static function getByPath($fullpath)
	{
		$fullpath = self::escape($fullpath);
		return self::table(__CLASS__)->selectFirst("vsf_path='$fullpath'");
	}
	
	public static function populateFile($basedir, $fullpath)
	{
		$mtime = GWF_Time::getDate(GWF_Date::LEN_SECOND, filemtime($fullpath));
		
		if (false === ($row = self::getByPath($fullpath))) {
			$row = new self(array(
				'vsf_id' => 0,
				'vsf_dir' => $basedir,
				'vsf_path' => $fullpath,
				'vsf_hash' => self::hash(file_get_contents($fullpath)),
				'vsf_date' => $mtime,
			));
			return $row->insert();
		}
		
		if ($row->getVar('vsf_date') < $mtime) {
			return $row->saveVars(array(
				'vsf_hash' => self::hash(file_get_contents($fullpath)),
				'vsf_date' => $mtime,
			));
		}
		
		return true;
	}
	
	public static function hash($string)
	{
		return
			substr(Common::hashMD5($string), 0, 16).
			substr(Common::hashSHA1($string), 0, 16).
			substr(Common::hashCRC32($string));
	}
	
	public static function populateAll()
	{
		self::populate('inc');
		self::populate('modules');
		self::populate('templates');
		self::populateFile('', 'index.php');
		self::populateFile('', 'gwf_cronjob.php');
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
			if (Common::startsWith($entry, '.')) {
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
}