<?php

/**
 * Convert all passwords to new format on first login.
 * In about 1 year we can delete this table then :P
 * @author gizmore
 */
final class WC_PasswordMap extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'wc_passmap'; }
	public function getColumnDefines()
	{
		return array(
			'pmap_uid' => array(GDO::UINT|GDO::PRIMARY_KEY),
			'pmap_password' => array(GDO::CHAR|GDO::ASCII|GDO::CASE_S, GDO::NOT_NULL, 32),
		);
	}
	
	########################
	### Convert Password ###
	########################
	const OLD_SECRET_SALT = '7qza+.!';
	public static function oldHash($password)
	{
		return md5(md5($password).self::OLD_SECRET_SALT);
	}
	
	public static function convert(GWF_User $user, $password)
	{
		if (false === ($row = self::table(__CLASS__)->getRow($user->getID()))) {
			return true;
		}
		
		$oldHash = self::oldHash($password);
		if ($oldHash !== $row->getVar('pmap_password')) {
			return GWF_Module::getModule('WeChall')->error('err_password');
		}
		
		$row->delete();
		$user->saveVar('user_password', GWF_Password::hashPasswordS($password));

		return true;
	}
}

?>