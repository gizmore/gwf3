<?php
/**
 * Map tags to pages.
 * @see GWF_PageTags
 * @author gizmore
 */
final class GWF_PageTagMap extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'page_tagmap'; }
	public function getColumnDefines()
	{
		return array(
			'ptm_pid' => array(GDO::UINT|GDO::PRIMARY_KEY),
			'ptm_tid' => array(GDO::UINT|GDO::PRIMARY_KEY),
		);
	}
	
	/**
	 * Delete all tag associations for a page.
	 * @param GWF_Page $page
	 * @return boolean
	 */
	public static function onDelete(GWF_Page $page)
	{
		return self::table(__CLASS__)->deleteWhere('ptm_pid='.$page->getID());
	}
}
?>