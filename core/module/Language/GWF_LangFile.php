<?php
final class GWF_LangFile extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'langfile'; }
	
	public function getColumnDefines()
	{
		return array(
			'lf_name' => array(self::VARCHAR|self::ASCII|self::CASE_I|self::PRIMARY_KEY, self::NOT_NULL, 255),
			'lf_rev' => array(self::UINT|self::PRIMARY_KEY, self::NOT_NULL),
			'lf_editor' => array(self::OBJECT, self::NOT_NULL, array('GWF_User', 'lf_editor', 'user_id')),
			'lf_editat' => array(self::TIME),
			'lf_size' => array(self::UINT, self::NOT_NULL),
			'lf_data' => array(self::MESSAGE|self::UTF8|self::CASE_S, self::NOT_NULL),
		);
	}
	
	public static function getByPath($fullpath, $force=true)
	{
		$ename = self::escape($fullpath);
		if (false === ($file = self::table(__CLASS__)->selectFirstObject('*', "lf_name='{$ename}'", 'lf_rev DESC')))
		{
			return ($force === true) ? self::createByPath($fullpath) : false;
		}
		return $file;
	}
	
	private static function createByPath($fullpath)
	{
		if (!is_file($fullpath) || !is_readable($fullpath))
		{
			return $fullpath;
		}
		
		$file = new self(array(
			'lf_name' => $fullpath,
			'lf_rev' => 0,
			'lf_editor' => 0,
			'lf_editat' => 0,
			'lf_size' => filesize($fullpath),
			'lf_data' => file_get_contents($fullpath),
		));
		if (false === ($file->replace()))
		{
			return false;
		}
		return $file;
	}
}
?>
