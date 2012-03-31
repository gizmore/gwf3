<?php
final class GWF_Group extends GDO
{
	const ADMIN = 'admin';
	const STAFF = 'staff';
	const MODERATOR = 'moderator';
	const PUBLISHER = 'publisher';

	const NAME_LEN = 63; # maxlen

	###############
	### Options ###
	###############
	const JOIN_FLAGS = 0xff;
	const FULL = 0x01;      # No new members
	const INVITE = 0x02;    # Only by invitation
	const MODERATE = 0x04;  # Memebership applications
	const FREE = 0x08;      # Click and join
	const SYSTEM = 0x10;    # By Script

	const VIEW_FLAGS = 0xf00;
	const VISIBLE = 0x100;   # Memberlist publicy visible
	const COMUNITY = 0x200;  # Memberlist visible to normal members
	const HIDDEN = 0x400;    # Memberlist visible to group members
	const SCRIPT = 0x800;    # Memberlist is only visible to scripts

	const VISIBLE_GROUP = 0x1000; # Is visible in group list
	const VISIBLE_MEMBERS = 0x2000; # Is memberlist always visible

	public function getTableName() { return GWF_TABLE_PREFIX.'group'; }
	public function getClassName() { return __CLASS__; }
	public function getOptionsName() { return 'group_options'; } 
	public function getColumnDefines()
	{
		return array(
			'group_id' => array(GDO::AUTO_INCREMENT),
			'group_name' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I|GDO::UNIQUE, GDO::NOT_NULL, self::NAME_LEN),
			'group_options' => array(GDO::UINT, self::FULL|self::SCRIPT),
			'group_lang' => array(GDO::UINT, 0), #, array('GWF_Language', 'group_lang')),
			'group_country' => array(GDO::UINT, 0), #, array('GWF_Country', 'group_country')),
			'group_founder' => array(GDO::OBJECT|GDO::INDEX, 0, array('GWF_User', 'group_founder', 'user_id')),
			'group_memberc' => array(GDO::UINT, 0),
			'group_bid' => array(GDO::UINT, 0), # BoardID(wtf)
			'group_date' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
//			'founder' => array(GDO::JOIN, GDO::NULL, array('GWF_User', 'group_founder', 'user_id')),
		);
	}
	public function getID() { return $this->getVar('group_id'); }
	public function getName() { return $this->getVar('group_name'); }
	public function getBoardID() { return $this->getVar('group_bid'); }
	public function getFounder() { return $this->getVar('group_founder'); }
	public function getFounderID() { return $this->getFounder()->getID(); }
	public function getVisibleMode() { return $this->getVar('group_options') & self::VIEW_FLAGS; }
	public function getJoinMode() { return $this->getVar('group_options') & self::JOIN_FLAGS; }
	public function isAskToJoin() { return ($this->getJoinMode() & (self::MODERATE|self::FREE)) > 0; }

	/**
	 * @param int $gid
	 * @return GWF_Group
	 */
	public static function getByID($gid) { return self::table(__CLASS__)->getRow($gid); }
	public static function getByName($name) { $name = self::escape($name); return self::table(__CLASS__)->selectFirstObject('*', "group_name='$name'"); }


	# Display
	public function displayJoinType(GWF_Module $module)
	{
		$flag = $this->getVar('group_options')&self::JOIN_FLAGS;
		switch ($flag)
		{
			case self::FULL:
			case self::INVITE:
			case self::MODERATE:
			case self::FREE:
			case self::SYSTEM:
				return $module->lang('th_group_options&'.$flag);
			default:
				return 'ERR_GRP_FLAG'.$flag;
		}
	}

	public function displayViewType(GWF_Module $module)
	{
		$flag = $this->getVar('group_options')&self::VIEW_FLAGS;
		switch ($flag)
		{
			case self::VISIBLE:
			case self::COMUNITY:
			case self::HIDDEN:
			case self::SCRIPT:
				return $module->lang('th_group_options&'.$flag);
			default:
				return 'ERR_GRP_FLAG'.$flag;
		}
	}

}
