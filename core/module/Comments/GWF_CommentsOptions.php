<?php
/**
 * User options for the comments module.
 * @author gizmore
 */
final class GWF_CommentsOptions extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'comments_options'; }
	public function getColumnDefines()
	{
		return array(
			'cmto_uid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'cmto_vote_thx' => array(GDO::UINT, 0),
			'cmto_vote_up' => array(GDO::UINT, 0),
			'cmto_vote_down' => array(GDO::UINT, 0),
		);
	}
}
?>