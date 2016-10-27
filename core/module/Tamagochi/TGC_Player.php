<?php
final class TGC_Player extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'tgc_players'; }
	public function getColumnDefines()
	{
		return array(
			'p_uid' => array(GDO::PRIMARY_KEY|GDO::UINT),
			'p_name' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_I|GDO::UNIQUE, GDO::NOT_NULL, 63),
			'p_active_avatar' => array(GDO::UINT, GDO::NULL),
			'p_active_color' => array(GDO::ENUM, TGC_Const::BLACK, TGC_Const::$COLORS),
			'p_active_element' => array(GDO::ENUM, TGC_Const::EARTH, TGC_Const::$ELEMENTS),
			'p_active_skill' => array(GDO::ENUM, TGC_Const::FIGHTER, TGC_Const::$SKILLS),
			'p_active_mode' => array(GDO::ENUM, TGC_Const::DEFEND, TGC_Const::$MODES),
			'users' => array(GDO::JOIN, GDO::NOT_NULL, array('GWF_User', 'p_uid', 'user_id')),
			'avatar' => array(GDO::JOIN, GDO::NOT_NULL, array('TGC_Avatar', 'p_active_avatar', 'a_id')),
		);
	}
	
	private static function createPlayer(GWF_User $user, $name)
	{
		$player = new self(array(
			'p_uid' => $user->getID(),
			'p_name' => $name,
			'p_active_avatar' => null,
			'p_active_color' => TGC_Const::BLACK,
			'p_active_element' => TGC_Const::EARTH,
			'p_active_skill' => TGC_Const::FIGHTER,
			'p_active_mode' => TGC_Const::EXPLORE,
		));
		$player->insert();
		return $player;
	}
	
	public static function getJSONUser()
	{
		if (0 == ($uid = GWF_Session::getUserID())) {
			return false;
		}
		return self::table('GWF_User')->selectFirst("user_id, user_regdate, user_gender, user_lastlogin, user_lastactivity, user_birthdate, user_countryid, user_langid, user_langid2", "user_id=$uid");
	}
	
	public static function getCurrent($create=false)
	{
		$uid = GWF_Session::getUserID();
		if ($uid == 0) {
			return false;
		}
		if ($player = self::table(__CLASS__)->selectFirstObject('*', "p_uid=$uid")) {
			return $player;
		}
		if ($create) {
			$name = TGC_AvatarNames::randomPlayerName(GWF_Session::getUser());
			while (self::isNameTaken($name))
			{
				$name = TGC_AvatarNames::randomPlayerName(GWF_Session::getUser());
			}
			
			return self::createPlayer(GWF_Session::getUser(), $name);
		}
		return false;
	}
	
	public static function isNameTaken($name)
	{
		return self::table(__CLASS__)->countRows("p_name='$name'") > 0;
	}
	
	public function rehash()
	{
		
	}
}
