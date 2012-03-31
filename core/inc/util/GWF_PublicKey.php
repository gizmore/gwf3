<?php

putenv("GNUPGHOME=/tmp");


/**
 * Hold the gpg public keys for users
 * @author gizmore
 * @version 3.0
 */
final class GWF_PublicKey extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'gpg'; }
	public function getOptionsName() { return 'gpg_options'; }
	public function getColumnDefines()
	{
		return array(
			'gpg_uid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'gpg_pubkey' => array(GDO::TEXT|GDO::ASCII|GDO::CASE_S),
			'gpg_options' => array(GDO::UINT, 0),
		);
	}

	##############
	### Static ###
	##############
	public static function removeKey($userid) { return self::table(__CLASS__)->deleteWhere('gpg_uid='.(int)$userid); }
	public static function updateKey($userid, $file_content) { return self::table(__CLASS__)->insertAssoc(array('gpg_uid'=>$userid,'gpg_pubkey'=>$file_content), true); }
	public static function getKeyForUser(GWF_User $user) { return self::getKeyForUID($user->getID()); }
	public static function getKeyForUID($userid) { return self::table(__CLASS__)->selectVar('gpg_pubkey', 'gpg_uid='.(int)$userid); }
	public static function getFingerprintForUser(GWF_User $user) { return self::getFingerprintForUID($user->getID()); }
	public static function getFingerprintForUID($userid)
	{
		if (false === ($key = self::getKeyForUID($userid))) {
			return false;
		}
		return self::grabFingerprint($key);
	}

	/**
	 * Return a public key in hex format or false.
	 * @param string $key
	 */
	public static function grabFingerprint($file_content)
	{
		$gpg = gnupg_init();
		if (false === ($result = gnupg_import($gpg, $file_content))) {
			GWF_Log::logCritical('gnupg_import() failed');
			GWF_Log::logCritical(GWF_HTML::lang('ERR_GENERAL', __FILE__, __LINE__));
			return false;
		}
		if ( ($result['imported']+$result['unchanged']) === 0 ) {
			return false;
		}
		return $result['fingerprint'];
	}
}
