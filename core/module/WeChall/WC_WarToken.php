<?php
final class WC_WarToken extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'wc_war_token'; }
	public function getColumnDefines()
	{
		return array(
			'wt_uid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'wt_token' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NOT_NULL, 35),
			'wt_date' => array(GDO::DATE, GDO::NOT_NULL, 14),
		);
	}
	
	public static function genWarToken($uid)
	{
		if (false === ($token = self::table(__CLASS__)->getBy('wt_uid', $uid)))
		{
			$token = self::_getWarToken($uid);
		}
		return $token->getVar('wt_token');
	}
	
	private static function _getWarToken($uid)
	{
		$token = new self(array(
			'wt_uid' => $uid,
			'wt_token' => self::randomWarToken(),
			'wt_date' => GWF_Time::getDate(14),
		));
		return $token->replace() ? $token : false;
	}

	private static function randomWarToken()
	{
		$back = '';
		for ($i = 0; $i < 6; $i++)
		{
			$back .=  '-' . GWF_Random::randomKey(5, '0123456789ABCDEF');
		}
		return substr($back, 1);
	}
	
	
	public static function isValidWarToken(GWF_User $user, $token)
	{
		$token = strtoupper($token);

		if (!preg_match("/^([0-9A-F]{5}-){5}[0-9A-F]{5}$/D", $token))
		{
			return false;
		}

		$token = self::escape($token);
		if (false === ($token = self::table(__CLASS__)->selectVar('1', "wt_uid={$user->getID()} AND wt_token='$token'")))
		{
			return false;
		}
		return true;
	}
	
	public static function deleteWarToken(GWF_User $user)
	{
		return self::table(__CLASS__)->deleteWhere("wt_uid={$user->getID()}");
	}
}
?>
