<?php
final class Dog_PrivChannel extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'dog_priv_chan'; }
	public function getColumnDefines()
	{
		return array(
			'priv_cid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'priv_uid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'priv_privs' => array(GDO::UINT, GDO::NOT_NULL),
		);
	}
	
	public static function displayPrivs(Dog_Channel $channel, Dog_User $user)
	{
		return Dog_IRCPriv::displayBits(self::getPermbits($channel, $user));
	}
	
	public static function hasPermChar(Dog_Channel $channel, Dog_User $user, $char, $needlogin=true)
	{
		return self::hasPermBits($channel, $user, Dog_IRCPriv::charToBit($char), $needlogin);
	}
	
	public static function hasPermBits(Dog_Channel $channel, Dog_User $user, $bits, $needlogin=true)
	{
		return (self::getPermbits($channel, $user, $needlogin) & $bits) >= $bits;
	}
	
	public static function getPermbits(Dog_Channel $channel, Dog_User $user, $needlogin=true)
	{
		$bits = $user->isRegistered() ? Dog_IRCPriv::REGBIT : 0;
		if ( ($needlogin) && (!$user->isLoggedIn()) )
		{
			return $bits;
		}
		$uid = $user->getID();
		$cid = $channel->getID();
		if (0 === ($bits = $user->getVarDefault("dcp_$cid", 0)))
		{
			$bits |= Dog_IRCPriv::LOGBIT;
			$bits |= self::table(__CLASS__)->selectVar('priv_privs', "priv_cid={$channel->getID()} AND priv_uid={$uid}");
			if ($user->isHoster())
			{
				$bits |= Dog_IRCPriv::HOSTBIT;
			}
			# Cache
			$user->setVar("dcp_$cid", $bits);
		}
		
		return $bits;
	}

	public static function setPermbits(Dog_Channel $channel, Dog_User $user, $bits)
	{
		self::flushPermcache($channel, $user);
		return self::table(__CLASS__)->insertAssoc(array(
			'priv_cid' => $channel->getID(),
			'priv_uid' => $user->getID(),
			'priv_privs' => $bits,
		));
	}
	
	public static function flushPermcache(Dog_Channel $channel, Dog_User $user)
	{
		$user->unsetVar("dcp_{$channel->getID()}");
	}
	
	/**
	 * Grant a user all privileges on a server.
	 * @param int $sid
	 * @param int $uid
	 */
	public static function grantAllToAll(Dog_Server $server, Dog_User $user, $bits=NULL)
	{
		$uid = $user->getID();
		$all = $bits === NULL ? Dog_IRCPriv::allBits() : intval($bits);
		foreach (GDO::table('Dog_Channel')->selectColumn('chan_id', "chan_sid={$server->getID()}") as $cid)
		{
			if (false === self::table(__CLASS__)->insertAssoc(array(
				'priv_cid' => $cid,
				'priv_uid' => $uid,
				'priv_privs' => $all,
			)))
			{
				return false;
			}
			$user->setVar("dcp_$cid", $all);
		}
		return true;
	}
}
?>
