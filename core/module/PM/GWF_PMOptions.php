<?php
final class GWF_PMOptions extends GDO
{
	###############
	### Options ###
	###############
	const EMAIL_ON_PM = 0x01;
	const ALLOW_GUEST_PM = 0x02;
	
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'pm_options'; }
	public function getOptionsName() { return 'pmo_options'; }
	public function getColumnDefines()
	{
		return array(
			'pmo_uid' => array(GDO::OBJECT|GDO::PRIMARY_KEY, GDO::NOT_NULL, array('GWF_User', 'pmo_uid', 'user_id')),
			'pmo_options' => array(GDO::UINT, 0),
			'pmo_auto_folder' => array(GDO::UINT, 0),
			'pmo_signature' => array(GDO::MESSAGE|GDO::UTF8|GDO::CASE_I),
			'pmo_user' => array(GDO::JOIN, 0, array('GWF_User', 'pmo_uid', 'user_id')),
			'pmo_level' => array(GDO::UINT, 0),
		);
	}
	public function getID() { return $this->getVar('pmo_uid'); }
	
	##################
	### Convinient ###
	##################
	public function getAutoFolderValue()
	{
		return $this->getVar('pmo_auto_folder');
	}
	public function isGuestPMAllowed() { return $this->isOptionEnabled(self::ALLOW_GUEST_PM); }

	###############
	### Get Row ###
	###############
	public static function getPMOptionsS()
	{
		static $row = true;
		if ($row === true)
		{
			if (false === ($user = GWF_Session::getUser())) {
				$row = false;
			}
			else {
				$row = self::getPMOptions($user);
			}
		}
		return $row;
	}
	
	/**
	 * @param GWF_User $user
	 * @return GWF_PMOptions
	 */
	public static function getPMOptions(GWF_User $user)
	{
		$userid = $user->getID();
//		if (false === ($back = self::table(__CLASS__)->selectFirstObject('*', "pmo_uid=$userid", '', array('pmo_user')))) {
		if (false === ($back = self::table(__CLASS__)->selectFirstObject('*', "pmo_uid=$userid"))) { # , '', array('pmo_user')))) {
			return self::createPMOptions($user);
		}
		return $back;
	}
	
	private static function createPMOptions(GWF_User $user)
	{
		$row = new self(array(
			'pmo_uid' => $user->getVar('user_id'),
			'pmo_options' => 0,
			'pmo_auto_folder' => 0,
			'pmo_signature' => '',
			'pmo_level' => 0,
		));
		if (false === ($row->replace())) {
			return false;
		}
//		$row->setVar('pmo_uid', $user);
		return $row;
	}
}
