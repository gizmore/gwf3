<?php
/**
 * User privileges on a server.
 * @author gizmore
 * @version 4.0
 */
final class Dog_PrivServer extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'dog_priv_serv'; }
	public function getColumnDefines()
	{
		return array(
			'priv_sid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'priv_uid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'priv_privs' => array(GDO::UINT, GDO::NOT_NULL),
		);
	}
	
	public static function displayPrivs(Dog_Server $server, Dog_User $user)
	{
		return Dog_IRCPriv::displayBits(self::getPermbits($server, $user));
	}
	
	public static function hasPermChar(Dog_Server $server, Dog_User $user, $char)
	{
		return self::hasPermBits($server, $user, Dog_IRCPriv::charToBit($char));
	}
	
	public static function hasPermBits(Dog_Server $server, Dog_User $user, $bits, $needlogin=true)
	{
		return (self::getPermbits($server, $user, $needlogin) & $bits) >= $bits;
	}
	
	public static function getPermbits(Dog_Server $server, Dog_User $user, $needlogin=true)
	{
		$bits = $user->isRegistered() ? Dog_IRCPriv::REGBIT : 0;
		if ( ($needlogin) && (!$user->isLoggedIn()) )
		{
			return $bits;
		}
		$uid = $user->getID();
		$sid = $server->getID();
		if (0 === ($bits = $user->getVarDefault("dsp_$sid", 0)))
		{
			$bits |= Dog_IRCPriv::LOGBIT;
			$bits |= self::table(__CLASS__)->selectVar('priv_privs', "priv_sid={$sid} AND priv_uid={$uid}");
			# Cache
			if ($user->isHoster())
			{
				$bits |= Dog_IRCPriv::HOSTBIT;
			}
			$user->setVar("dsp_$sid", $bits);
		}
		return $bits;
	}
	
	public static function setPermbits(Dog_Server $server, Dog_User $user, $bits)
	{
		self::flushPermcache($server, $user);
		return self::table(__CLASS__)->insertAssoc(array(
			'priv_sid' => $server->getID(),
			'priv_uid' => $user->getID(),
			'priv_privs' => $bits,
		));
	}
	
	public static function flushPermcache(Dog_Server $server, Dog_User $user)
	{
		$user->unsetVar("dsp_{$server->getID()}");
	}
	
	/**
	 * Grant all permission on a server to a user.
	 * @param int $sid
	 * @param int $uid
	 * @return boolean
	 */
	public static function grantAll(Dog_Server $server, Dog_User $user)
	{
		return self::setPermbits($server, $user, Dog_IRCPriv::allBits());
	}
	public static function grantIrcop(Dog_Server $server, Dog_User $user)
	{
		return self::setPermbits($server, $user, Dog_IRCPriv::allBitsButOwner());
	}
}
?>
