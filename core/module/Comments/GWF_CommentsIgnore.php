<?php
/**
 * User options for the comments module.
 * @author gizmore
 */
final class GWF_CommentsIgnore extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'comments_ignore'; }
	public function getColumnDefines()
	{
		return array(
			'cmti_uid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'cmti_ignore' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
		);
	}
}
?>