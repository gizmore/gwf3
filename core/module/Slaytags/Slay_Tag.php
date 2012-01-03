<?php
final class Slay_Tag extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'slay_tag'; }
//	public function getOptionsName() { return 'st_options'; }
	public function getColumnDefines()
	{
		return array(
			'st_id' => array(GDO::AUTO_INCREMENT),
			'st_uid' => array(GDO::UINT, 0), # owner/proposer of tag
			'st_name' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_I|GDO::UNIQUE, GDO::NOT_NULL, 63),
//			'st_options' => array(GDO::UINT, 0),

//			'st_group' => array(GDO::UINT, 0),

			'users' => array(GDO::JOIN, GDO::NOT_NULL, array('GWF_User', 'st_uid', 'user_id'))
		);
	}
	
	public static function getByID($id)
	{
		return self::table(__CLASS__)->getBy('st_id', $id);
	}
	
	public static function getByName($name)
	{
		return self::table(__CLASS__)->getBy('st_name', $name);
	}
	
	public static function getTags(Slay_Song $song)
	{
		return Slay_TagVote::getTags($song);
	}
	
	public static function getAllTags()
	{
		return self::table(__CLASS__)->selectAll('*', '', 'st_name ASC', NULL, -1, -1, GDO::ARRAY_O);
	}
	
	public static function getTagNames()
	{
		return self::table(__CLASS__)->selectColumn('st_name', '', 'st_name ASC');
	}
	
	public static function getTagIDs()
	{
		return self::table(__CLASS__)->selectColumn('st_id', '', 'st_id ASC');
	}
	
	public static function mayAddTag(GWF_User $user)
	{
		if ($user->isStaff())
		{
			return true;
		}
		$uid = $user->getID();
		return self::table(__CLASS__)->selectFirst('1', "st_uid={$uid}") === false;
	}
	
	public static function getIDByName($tag)
	{
		$tag = self::escape($tag);
		return self::table(__CLASS__)->selectVar('st_id', "st_name='{$tag}'");
	}
		
	public static function getNameByID($id)
	{
		$id = (int)$id;
		return self::table(__CLASS__)->selectVar('st_name', 'st_id='.$id);
	}
}
?>