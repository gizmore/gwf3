<?php
final class TGC_PlayerAvatar extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'tgc_playeravatars'; }
	public function getColumnDefines()
	{
		return array(
			'pa_pid' => array(GDO::PRIMARY_KEY|GDO::UINT, GDO::NOT_NULL, 4),
			'pa_aid' => array(GDO::PRIMARY_KEY|GDO::UINT, GDO::NOT_NULL, 4),
			'users' => array(GDO::JOIN, GDO::NOT_NULL, array('GWF_User', 'pa_pid', 'user_id')),
			'players' => array(GDO::JOIN, GDO::NOT_NULL, array('TGC_Player', 'pa_pid', 'p_uid')),
			'avatars' => array(GDO::JOIN, GDO::NOT_NULL, array('TGC_PlayerAvatar', 'pa_aid', 'a_id')),
		);
	}
}
