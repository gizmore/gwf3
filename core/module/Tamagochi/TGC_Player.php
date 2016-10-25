<?php
final class TGC_Player extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'tgc_players'; }
	public function getColumnDefines()
	{
		return array(
			'p_uid' => array(GDO::PRIMARY_KEY|GDO::UNSIGNED),
			'p_name' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_I|GDO::UNIQUE, GDO::NOT_NULL, 63),
			'p_active_avatar' => array(GDO::UINT, GDO::NULL),
			'p_active_color' => array(GDO::ENUM, TGC_Globals::BLACK, TGC_Const::$COLORS),
			'p_active_element' => array(GDO::ENUM, TGC_Globals::EARTH, TGC_Const::$ELEMENTS),
			'p_active_skill' => array(GDO::ENUM, TGC_Globals::FIGHTER, TGC_Const::$SKILLS),
			'p_active_mode' => array(GDO::ENUM, TGC::DEFEND, TGC_Const::$MODES),
			'users' => array(GDO::JOIN, GDO::NOT_NULL, array('GWF_User', 'p_uid', 'user_id')),
			'avatar' => array(GDO::JOIN, GDO::NOT_NULL, array('TGC_AVATAR', 'p_active_avatar', 'a_id')),
		);
	}
	
	private static function createPlayer(GWF_User $user, $name)
	{
		$player = new self(array(
			'p_uid' => $user->getID(),
			'p_name' => $name,
			'p_active_avatar' => GDO::NULL,
			'p_active_color' => TGC_Globals::BLACK,
			'p_active_element' => TGC_Globals::EARTH,
			'p_active_skill' => TGC_Globals::FIGHTER,
			'p_active_mode' => TGC_Globals::EXPLORE,
		));
		$player->replace();
		return $player;
	}
	
	public static function getCurrent()
	{
		if (1 >= ($uid = GWF_Session::getUserID())) {
			return false;
		}
		if ($player = self::table(__CLASS__)->selectFirstObject('*', "p_uid=$uid")) {
			return $player;
		}
		
		$name = TGC_AvatarNames::randomPlayerName();
		while (self::isNameTaken($name))
		{
			$name = TGC_AvatarNames::randomPlayerName();
		}
		
		return self::createPlayer(GWF_Session::getUser(), $name);
	}
	
	public static function isNameTaken($name)
	{
		return self::table(__CLASS__)->selectColumn('COUNT(*)', "name='$name'") !== false;
	}
	
	public function rehash()
	{
		
	}
}
