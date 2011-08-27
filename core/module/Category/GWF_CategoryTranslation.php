<?php
final class GWF_CategoryTranslation extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'catlang'; }
	public function getColumnDefines()
	{
		return array(
			'cl_catid' => array(GDO::UINT|GDO::PRIMARY_KEY, true),
			'cl_langid' => array(GDO::UINT|GDO::PRIMARY_KEY, true),
			'cl_translation' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I, true),
			'cats' => array(GDO::JOIN, GDO::NULL, array('GWF_Category', 'cl_catid', 'cat_tree_id')),
		);
	}
}
?>
