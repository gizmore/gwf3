<?php
/**
 * A channel on a server.
 * @author gizmore
 */
final class Lamb_Channel extends GDO
{
	private $users = array();
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'lamb_channel'; }
//	public function getOptionsName() { return ''; }
	public function getColumnDefines()
	{
		return array(
			'chan_id' => array(GDO::AUTO_INCREMENT),
			'chan_sid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'chan_name' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S|GDO::INDEX, GDO::NOT_NULL, 64),
			'chan_maxusers' => array(GDO::UINT, 0),
			'chan_ops' => array(GDO::BLOB|GDO::ASCII|GDO::CASE_S),
			'chan_hops' => array(GDO::BLOB|GDO::ASCII|GDO::CASE_S),
			'chan_voice' => array(GDO::BLOB|GDO::ASCII|GDO::CASE_S),
		);
	}
	
	##############
	### Static ###
	##############
	/**
	 * @param int $channel_id
	 * @return Lamb_Channel
	 */
	public static function getByID($channel_id)
	{
		return self::table(__CLASS__)->getRow($channel_id);
	}
	
	/**
	 * @param Lamb_Server $server
	 * @param string $channel_name
	 * @return Lamb_Channel
	 */
	public static function getByName(Lamb_Server $server, $channel_name)
	{
		$sid = $server->getID();
		$channel_name = self::escape($channel_name);
		return self::table(__CLASS__)->selectFirstObject('*', "chan_sid=$sid AND chan_name='$channel_name'");
	}

	/**
	 * Create a new channel.
	 * @param Lamb_Server $server
	 * @param string $channel_name
	 * @return Lamb_Channel
	 */
	public static function createChannel(Lamb_Server $server, $channel_name)
	{
		$channel = new self(array(
			'chan_id' => 0,
			'chan_sid' => $server->getID(),
			'chan_name' => $channel_name,
			'chan_maxusers' => 0,
			'chan_ops' => '',
			'chan_hops' => '',
			'chan_voice' => '',
		));
		if (false === ($channel->insert())) {
			return false;
		}
		return $channel;
	}
	
	public function getName()
	{
		return $this->getVar('chan_name');
	}
	
	public function getUsers()
	{
		return $this->users;
	}
	
	public function addUser(Lamb_User $user, $usermode='')
	{
		$username = $user->getVar('lusr_name');
		$this->users[$username] = array($user, $usermode);
	}
	
	public function getUserByName($username)
	{
		return $this->users[$username][0];
	}
	
	public function isUserInChannel($username)
	{
		return isset($this->users[$username]);
	}
	
	public function getModeByName($username)
	{
		return $this->users[$username][1];
	}
	
	public function setUserMode($username, $usermode)
	{
		$this->users[$username] = array($this->getUserByName($username), $usermode);
	}
	
	public function removeUser($username)
	{
		unset($this->users[$username]);
	}
}
?>