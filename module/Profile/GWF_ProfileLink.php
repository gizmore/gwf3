<?php
/**
 * Link your profile to other sites, like twitter.
 * @author gizmore
 * @version 1.0
 */
final class GWF_ProfileLink extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'profile_links'; }
	public function getColumnDefines()
	{
		return array(
			'pl_id' => array(GDO::AUTO_INCREMENT),
			'pl_uid' => array(GDO::UINT, GDO::NOT_NULL),
			'pl_sitename' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_I, GDO::NOT_NULL, 63),
			'pl_href' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'pl_comment' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
		);
	}
}

?>