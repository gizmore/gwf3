<?php
/**
 * Page permissions
 * @author gizmore
 */
final class GWF_PageTags extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'page_tags'; }
	public function getColumnDefines()
	{
		return array(
			'ptag_pid' => array(GDO::UINT|GDO::PRIMARY_KEY),
			'ptag_tag' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I|GDO::PRIMARY_KEY, GDO::NOT_NULL, 63),
		);
	}
	
	public static function updateTags(GWF_Page $page, $tags)
	{
		return true;
	}
	
}
?>