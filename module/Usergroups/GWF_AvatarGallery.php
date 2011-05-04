<?php

final class GWF_AvatarGallery extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'user_avatar_g'; }
	public function getColumnDefines()
	{
		return array(
			'ag_uid' => array(GDO::OBJECT|GDO::PRIMARY_KEY, GDO::NOT_NULL, array('GWF_User', 'ag_uid')),
			'ag_hits' => array(GDO::UINT, 0),
			'ag_version' => array(GDO::UINT, 0),
		);
	}
	
	public static function getByID($userid)
	{
		return self::table(__CLASS__)->getRow($userid);
	}
	
	public static function onViewed(GWF_User $user)
	{
		$userid = $user->getID();
		if (false === ($row = self::getByID($userid))) {
			$row = new self(array(
				'ag_uid' => $userid,
				'ag_hits' => 1,
				'ag_version' => $user->getAvatarVersion(),
			));
			if (false === $row->insert()) {
				return false;
			}
			$row->setVar('ag_uid', $user);
			return true;
		}
		
		if ($row->getVar('ag_version') !== $user->getAvatarVersion()) {
			return $row->saveVars(array(
				'ag_hits' => 1,
				'ag_version' => $user->getAvatarVersion(),
			));
		}
		
		return $row->increase('ag_hits', 1);
	}
	
	
	
}

?>