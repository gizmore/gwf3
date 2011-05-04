<?php
/**
 * Page permissions
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
	
	public static function updateGIDs(GWF_Page $page, $gstring)
	{
		return true;
	}
}
?>