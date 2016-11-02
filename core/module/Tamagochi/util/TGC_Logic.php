<?php
final class TGC_Logic
{
	public static function getAvatarLevelForXP($xp)
	{
		return TGC_Const::NEOPHYTE;
	}
	
	public static function getSessionUserSecret()
	{
		return self::getUserSecret(GWF_Session::getUser());
	}
	
	public static function getUserSecret(GWF_User $user)
	{
		return sprintf("%s:%s:%s", $user->getID(), $user->getVar('user_name'), substr($user->getVar('user_password'), 33));
	}
	
	public static function compareUserSecret(GWF_User $user, $secret)
	{
		return $secret === self::getUserSecret($user);
	}
}
