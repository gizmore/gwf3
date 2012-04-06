<?php

final class GWF_LinksFavorite extends GDO
{
	##########
	## GDO ###
	##########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'links_favorite'; }
	public function getColumnDefines()
	{
		return array(
			'lf_uid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'lf_lid' => array(GDO::OBJECT|GDO::PRIMARY_KEY, GDO::NOT_NULL, array('GWF_Links', 'lf_lid', 'link_id')),
		);
	}
	public function getLink()
	{
		return $this->getVar('lf_lid');
	}
	
	#####################
	### Mark Favorite ###
	#####################
	public static function mark(GWF_User $user, GWF_Links $link, $bool)
	{
		$userid = $user->getID();
		$linkid = $link->getID();
		$is_fav = self::table(__CLASS__)->getRow($userid, $linkid) !== false;
		
		if ($is_fav === $bool) {
			return true;
		}
		
		$row = new self(array(
			'lf_uid' => $userid,
			'lf_lid' => $linkid,
		));
		
		if ($bool) {
			if (!$row->replace()) {
				return false;
			}
		} else {
			if (!$row->delete()) {
				return false;
			}
		}
		
		if (false === $link->increase('link_favcount', $bool ? 1 : -1)) {
			return false;
		}
		
		if (false === $link->onCalcPopularity()) {
			return false;
		}
		
		return true;
	}
}