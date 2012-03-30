<?php
/**
 * Page permissions. Note that a page also has a gidstring for some different access model.
 * @author gizmore
 */
final class GWF_PageGID extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'page_gid'; }
	public function getColumnDefines()
	{
		return array(
			'pgid_oid' => array(GDO::UINT|GDO::PRIMARY_KEY),
			'pgid_gid' => array(GDO::UINT|GDO::PRIMARY_KEY),
		);
	}
	
	/**
	 * Update GID table for a page. This function is not sanitized!
	 * @param GWF_Page $page
	 * @param array $groups
	 * @return boolean
	 */
	public static function updateGIDs(GWF_Page $page, array $groups)
	{
		return false === self::onDelete($page) ? false : self::addGIDs($page, $groups);
	}

	public static function addGIDs(GWF_Page $page, array $groups)
	{
		$oid = $page->getOtherID();
		$table = self::table(__CLASS__);
		foreach ($groups as $gid)
		{
			if (false === $table->insertAssoc(array('pgid_oid'=>$oid, 'pgid_gid'=>$gid)))
			{
				return false;
			}
		}
		return true;
	}
	
	public static function onDelete(GWF_Page $page)
	{
		return self::table(__CLASS__)->deleteWhere('pgid_oid='.$page->getID());
	}
}
?>