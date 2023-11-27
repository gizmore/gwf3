<?php
final class GWF_DownloadToken extends GDO
{
	const TOKEN_LEN = 12;
	
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'down_token'; }
	public function getColumnDefines()
	{
		return array(
			'dlt_dlid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'dlt_uid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'dlt_token' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NOT_NULL, self::TOKEN_LEN),
			'dlt_expires' => array(GDO::DATE, '', GWF_Date::LEN_SECOND),
		);
	}
	
	public static function checkToken(Module_Download $module, GWF_Download $dl, $user, $token)
	{
		if (0 === preg_match('/^[a-z0-9_]{'.self::TOKEN_LEN.'}$/iD', $token))
		{
			return false;
		}
		
		$id = $dl->getID();
		$uid = $user === false ? '0' : $user->getID();
		$token = self::escape($token);
		$now = GWF_Time::getDate(GWF_Date::LEN_SECOND);
		return self::table(__CLASS__)->selectFirst('1', "dlt_dlid=$id AND dlt_uid=$uid AND dlt_token='$token' AND dlt_expires>'$now'") !== false;
	}
	
	public static function generateToken()
	{
		return GWF_Random::randomKey(self::TOKEN_LEN);
	}
	
	public static function insertToken(Module_Download $module, GWF_Download $dl, $user, $token)
	{
		$expires = $dl->expires() ? GWF_Time::getDate(GWF_Date::LEN_SECOND, time()+$dl->getVar('dl_expire')) : '';
		
		$row = new self(array(
			'dlt_dlid' => $dl->getID(),
			'dlt_uid' => $user === false ? 0 : $user->getID(),
			'dlt_token' => $token,
			'dlt_expires' => $expires,
		));
		if (false === ($row->insert())) {
			return false;
		}
		return true;
	}
	
	public static function checkUser(Module_Download $module, GWF_Download $dl, $user)
	{
		if ($user === false) {
			return false;
		}
		$id = $dl->getID();
		$uid = $user->getID();
		$now = GWF_Time::getDate(GWF_Date::LEN_SECOND);
		return self::table(__CLASS__)->selectVar('1', "dlt_dlid=$id AND dlt_uid=$uid AND (dlt_expires='' OR dlt_expires>'$now')") === '1';
	}
}
?>
