<?php
final class Module_Slaytags extends GWF_Module
{
	public function getVersion() { return 1.01; }
	public function getDefaultPriority() { return 60; }
	public function getDefaultAutoLoad() { return true; }
	public function onLoadLanguage() { return $this->loadLanguage('lang/slaytags'); }
	public function getClasses() { return array('Slay_Lyrics', 'Slay_PlayHistory', 'Slay_Song', 'Slay_SongTag', 'Slay_Tag', 'Slay_TagVote'); }
	public function onInstall($dropTable) { require_once 'Slay_Install.php'; Slay_Install::install($this, $dropTable); }
	public function getAdminSectionURL() { return $this->getMethodURL('Admin'); }
	
	public function onStartup()
	{
		GWF_Website::addJavascript(GWF_WEB_ROOT.'tpl/slay/js/slay.js');
		GWF_Website::addJavascriptOnload('slayInit();');
	}
	
	public function onAddHooks()
	{
		GWF_Hook::add(GWF_Hook::DELETE_USER, array(__CLASS__, 'hookDeleteUser'));
	}

	public function hookDeleteUser(GWF_User $user, array $args)
	{
	}
}
?>