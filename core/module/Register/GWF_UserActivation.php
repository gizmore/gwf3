<?php
/**
 * User Activation table and row.
 * @author gizmore
 */
final class GWF_UserActivation extends GDO
{
	const TOKEN_LENGTH = 12;
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'useractivation'; }
	public function getColumnDefines()
	{
		return array(
			'token' => array(GDO::CHAR|GDO::ASCII|GDO::CASE_S|GDO::PRIMARY_KEY, GDO::NOT_NULL, self::TOKEN_LENGTH),
			'username' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_I, GDO::NOT_NULL, GWF_User::USERNAME_LENGTH),
			'email' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, '', 255),
			'birthdate' => array(GDO::CHAR|GDO::ASCII|GDO::CASE_S, '19000101', GWF_Date::LEN_DAY),
			'password' => array(GDO::CHAR|GDO::ASCII|GDO::CASE_S, GDO::NOT_NULL, 44),
			'countryid' => array(GDO::UINT, 0),
			'timestamp' => array(GDO::UINT, GDO::NOT_NULL),
			'ip' => GWF_IP6::gdoDefine(GWF_IP_EXACT, GDO::NOT_NULL),
		);
	}
	
	public static function generateToken()
	{
		$token = GWF_Random::randomKey(self::TOKEN_LENGTH);
		$ua = new self(false);
		if (false !== ($ua->selectFirst('1', sprintf('token=\'%s\'', $ua->escape($token))))) {
			return self::generateToken();
		}
		return $token;
	}
	
	###############
	### Display ###
	###############
	public function displayBirthdate() { return GWF_Time::displayDate($this->getVar('birthdate')); }
	public function displayCountry() { return GWF_HTML::display(GWF_Country::getByID($this->getVar('countryid'))); }
	public function displayTimestamp() { return GWF_Time::displayTimestamp($this->getVar('timestamp')); }
	public function displayIP() { return GWF_IP6::displayIP($this->getVar('ip'), GWF_IP_EXACT); }
	
}
?>