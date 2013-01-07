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
	
	
	public static function isValidWarToken($username, $token)
	{
		$username = self::escape($username);
		if (false === ($uid = GDO::table('GWF_User')->selectVar('user_id', "user_name='$username'")))
		{
			return false;
		}
		$token = self::escape(strtoupper($token));
		if (false !== ($token = self::table(__CLASS__)->selectFirstObject('*', "wt_uid=$uid AND wt_token='$token'")))
		{
			$token->delete();
			return true;
		}
		return false;
	}
}
?>
