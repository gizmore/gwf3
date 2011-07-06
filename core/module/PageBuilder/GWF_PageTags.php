<?php
/**
 * Page Tags
 * @see GWF_PageTagMap
 * @author gizmore
 */
final class GWF_PageTags extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'page_tags'; }
	public function getColumnDefines()
	{
		return array(
			'ptag_tid' => array(GDO::UINT|GDO::PRIMARY_KEY),
			'ptag_tag' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I|GDO::PRIMARY_KEY, GDO::NOT_NULL, 63),
			'ptag_count' => array(GDO::UINT|GDO::INDEX, 0),
		);
	}
	
	public static function updateTags(GWF_Page $page, $tags)
	{
		foreach (explode(',', $tags) as $tag)
		{
			if ($tag !== '')
			{
				self::insertTag($tag);
			}
		}
		
		
		return true;
	}
	
	private static function insertTag($tag)
	{
		$t = GDO::table('GWF_PageTags');
		$tag = GDO::escape($tag);
		if (false !== $t->selectVar('1', "ptag_tag='{$tag}'"))
		{
			return $t->insertAssoc(array(
				'ptag_tag' => $tag,
			));
		}
	}
	
}
?>