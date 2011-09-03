<?php
final class SR_Clan extends GDO
{
	const MIN_MEMBERCOUNT = 1;
	const MAX_MEMBERCOUNT = 50;
	const MIN_STORAGE = 1000; # 1kg
	const MAX_STORAGE = 500000; # 500kg
	const MIN_MONEY = 10000;
	const MAX_MONEY = 1000000;
	
	const MAX_SLOGAN_LEN = 196;
	
	const MODERATED = 0x01;
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'sr4_clan'; }
	public function getColumnDefines()
	{
		return array(
			'sr4cl_id' => array(GDO::AUTO_INCREMENT),
			'sr4cl_name' => array(GDO::UINT, 0),
			'sr4cl_founder' => array(GDO::UINT, 0),
			'sr4cl_slogan' => array(GDO::TEXT|GDO::CASE_I|GDO::UTF8),
			'sr4cl_date' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'sr4cl_members' => array(GDO::UINT, 0),
			'sr4cl_max_members' => array(GDO::UINT, self::MIN_MEMBERCOUNT),
			'sr4cl_storage' => array(GDO::UINT, 0),
			'sr4cl_max_storage' => array(GDO::UINT, self::MIN_STORAGE),
			'sr4cl_money' => array(GDO::UINT, 0),
			'sr4cl_max_money' => array(GDO::UINT, 0),
			'sr4cl_options' => array(GDO::UINT, 0),
		
			'members' => array(GDO::JOIN, GDO::NULL, array('SR_ClanMembers', 'sr4cl_id', 'sr4cm_cid')),
		);
	}
	
	public function isModerated() { return $this->isOptionEnabled(self::MODERATED); }
	public function getName() { return $this->getVar('sr4cl_name'); }
	public static function getByName($name) { return $this->getBy('sr4cl_name', $name); }
	public static function getByPlayer(SR_Player $player) { return $this->getBy('sr4cm_pid', $player->getID()); }
}
?>