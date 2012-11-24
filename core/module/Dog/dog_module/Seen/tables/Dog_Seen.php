<?php
final class Dog_Seen extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'dog_seen'; }
	
	public function getColumnDefines()
	{
		return array(
			'dogseen_uid' => array(GDO::UINT|GDO::PRIMARY_KEY),
			'dogseen_cid' => array(GDO::UINT, 0),
			'dogseen_event' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NOT_NULL, 16),
			'dogseen_time' => array(GDO::DATE, GDO::NOT_NULL, 14),
			'dogseen_message' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),

			'users' => array(GDO::JOIN, GDO::NULL, array('Dog_User', 'dogseen_uid', 'user_id')),
		);
	}
	public function getEvent() { return $this->getVar('dogseen_event'); }
	public function getDate() { return $this->getVar('dogseen_time'); }
	public function displayDate() { return GWF_Time::displayDateISO($this->getDate(), Dog::getLangISO()); }
	public function displayAge() { return GWF_Time::displayAgeISO($this->getDate(), Dog::getLangISO()); }
	public function getMessage() { return $this->getVar('dogseen_message'); }
	public function getCID() { return $this->getVar('dogseen_cid'); }
	public function getChannel() { return Dog_Channel::getByID($this->getCID()); }
	
	/**
	 * @param Dog_User $user
	 * @return Dog_Seen
	 */
	public static function getSeen(Dog_User $user)
	{
		return self::table(__CLASS__)->getRow($user->getID());
	}
	
	public static function record(Dog_User $user, $channel, $event, $message)
	{
		return self::table(__CLASS__)->insertAssoc(array(
			'dogseen_uid' => $user->getID(),
			'dogseen_cid' => $channel === false ? '0' : $channel->getID(),
			'dogseen_event' => $event,
			'dogseen_time' => GWF_Time::getDate(),
			'dogseen_message' => $message,
		));
	}
}
?>
