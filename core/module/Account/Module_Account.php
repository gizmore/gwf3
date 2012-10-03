<?php
/**
 * Member Account Changes.
 * @author gizmore
 */
final class Module_Account extends GWF_Module
{
	##################
	### GWF_Module ###
	##################
	public function getVersion() { return 1.03; }
	public function onLoadLanguage() { return $this->loadLanguage('lang/account'); }
	public function onCronjob() { require_once 'GWF_AccountCronjob.php'; GWF_AccountCronjob::onCronjob($this); }
	public function getClasses() { return array('GWF_AccountChange', 'GWF_AccountDelete'); }
	public function getDescription() { return 'Change account settings. Delete Account'; }
	###############
	### Install ###
	###############
	public function onInstall($dropTable)
	{
		return GWF_ModuleLoader::installVars($this, array(
			'use_email' => array(true, 'bool'),
			'show_adult' => array(true, 'bool'),
			'adult_age' => array('21', 'int', '12', '40'),
			'show_gender' => array(true, 'bool'),
			'mail_sender' => array(GWF_BOT_EMAIL, 'text', 0, 128),
			'show_avatar' => array(true, 'bool'),
			'avatar_min_x' => array('1', 'int', '1', '2048'),
			'avatar_max_x' => array('96', 'int', '1', '2048'),
			'avatar_min_y' => array('1', 'int', '1', '4096'),
			'avatar_max_y' => array('96', 'int', '1', '4096'),
			'demo_changetime' => array(GWF_Time::ONE_MONTH*3, 'time', 0, GWF_TIME::ONE_YEAR*2),
			'show_checkboxes' => array(true, 'bool'),
		));
	}
	##################
	### Convinient ###
	##################
	public function cfgUseEmail() { return $this->getModuleVarBool('use_email', '1'); }
	public function cfgShowAdult() { return $this->getModuleVarBool('show_adult', '1'); }
	public function cfgShowGender() { return $this->getModuleVarBool('show_gender', '1'); }
	public function cfgChangeTime() { return $this->getModuleVarInt('demo_changetime', 2592000*3); }
	public function cfgMailSender() { return $this->getModuleVar('mail_sender', GWF_BOT_EMAIL); }
	public function cfgAdultAge() { return $this->getModuleVarInt('adult_age', 21); }
	public function cfgAvatarMinWidth() { return $this->getModuleVarInt('avatar_min_x', 1); }
	public function cfgAvatarMaxWidth() { return $this->getModuleVarInt('avatar_max_x', 96); }
	public function cfgAvatarMinHeight() { return $this->getModuleVarInt('avatar_min_y', 1); }
	public function cfgAvatarMaxHeight() { return $this->getModuleVarInt('avatar_max_y', 96); }
	public function cfgUseAvatar() { return $this->getModuleVarBool('show_avatar', '1'); }
	public function cfgShowCheckboxes() { return $this->getModuleVarBool('show_checkboxes', '1'); }
}

?>
