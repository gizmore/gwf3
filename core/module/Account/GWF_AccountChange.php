<?php
/**
 * A table to store tokens associated with a userid and type.
 * @author gizmore
 */
final class GWF_AccountChange extends GDO
{
	const TOKEN_LENGTH = 8;
	
	public function getTableName() { return GWF_TABLE_PREFIX.'accchange'; }
	public function getClassName() { return __CLASS__; }
	
	public function getColumnDefines()
	{
		return array(
			'userid' => array(GDO::INT|GDO::UNSIGNED|GDO::PRIMARY_KEY, true, 11),
			'type' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S|GDO::PRIMARY_KEY, true, 16),
			'token' => array(GDO::CHAR|GDO::ASCII|GDO::CASE_S, true, self::TOKEN_LENGTH),
			'timestamp' => array(GDO::INT|GDO::UNSIGNED),
			'data' => array(GDO::BLOB),
		);
	}
	
	/**
	 * @param $userid
	 * @param $token
	 * @param $type
	 * @return GWF_AccountChange
	 */
	public static function checkToken($userid, $token, $type)
	{
		if (false === ($row = self::table(__CLASS__)->getRow($userid, $type)))
		{
			return false;
		}
		if ($token !== $row->getVar('token'))
		{
			return false;
		}
		return $row;
	}
	
	/**
	 * @param $userid int
	 * @param $type string
	 * @param $data string
	 * @return string new token
	 */
	public static function createToken($userid, $type, $data=false)
	{
		$token = GWF_Random::realSecureRandomKey(self::TOKEN_LENGTH);
		
		$gdodata = array(
			'userid' => $userid,
			'type' => $type,
			'token' => $token,
			'timestamp' => time(),
		);
		
		if (is_string($data))
		{
			$gdodata['data'] = $data;
		}
		
		$ac = new self($gdodata);
		
		return false === $ac->replace() ? false : $token;
	}
	
	/**
	 * @return GWF_AccountChange
	 */
	public static function getACRow($userid, $type)
	{
		return self::table(__CLASS__)->getRow($userid, $type);
	}
	
	/**
	 * @return GWF_User
	 */
	public function getUser()
	{
		return GWF_User::getByID($this->getVar('userid'));
	}
}