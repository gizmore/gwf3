<?php
/**
 * This module can build HTML-Navigations.
 * All GWF modules can entry in one PageMenu-Navigation.
 * You can build your own Navigations from Pagebuilder sites.
 * @todo let PageBuilder add pages on pagecreation
 * @todo (sub)Navigation overviewpage
 * (@todo WeChall: Overview page for challenges)
 * @todo extending GWF_Tree
 * @todo lock a navigation, protect before modifying
 * @todo title translation
 * @todo copy navigation
 * @todo Method: LinkParser for Links like CMS/(<sec>.*)/(<cat>.*)/link
 * @TODO: policy and module settings for the PageMenu Order... Maybe in this module
 * @decide allow to edit PageMenu? only copy it for editing? only do it via modulevars?
 * @todo: gwf_buttons actions: edit, delete, show, hide, up, down (left, right?), visible, hidden, add
 * @todo: convert FormY to smarty
 * @todo: Make general menu editing module?
 ** We could split it into 2 modules, one for only PageBuilder and one for pagemenu, but this would be much duplicated code
 * @todo: caching into html files
 * @todo possibility to add an unique ID?? WTF: was habe ich hier gemeint?
 * @author spaceone
 * @since 01.11.2011
 * @version 0.06
 */
final class Module_Navigation extends GWF_Module
{
	public function getVersion() { return 0.07; }
	public function getClasses()
	{
		require_once GWF_CORE_PATH.'module/PageBuilder/GWF_Page.php';
		require_once GWF_CORE_PATH.'module/Category/GWF_Category.php';
		return array('GWF_Navigation', 'GWF_Navigations', 'GWF_NaviPage');
	}
	public function onLoadLanguage() { return $this->loadLanguage('lang/navigation'); }
	public function getOptionalDependencies() { return array('PageBuilder'); }
//	public function getDependencies() { return array(); }	//PageBuilder here?, Category, GWF_Tree?
	public function onInstall($dropTable) 
	{
		require_once GWF_CORE_PATH.'module/Navigation/GWF_NaviInstall.php';
		$ret = GWF_NaviInstall::onInstall($this, $dropTable);

		if ($this->cfgInstallPageMenu())
		{
			if (true !== ($e = GWF_NaviInstall::installPageMenu()))
			{
				$e instanceof GWF_Exception;
			}
		}
		return $ret;
	}
	public function getAdminSectionURL() { return $this->getMethodURL('Admin'); }
	public function cfgLockedPageMenu() { return $this->getModuleVarBool('lockedPM'); }
	public function cfgInstallPagemenu() { return false; } # (re)Install PageMenu on module-installation?

	public function canModerate()
	{
		return false === ($user = GWF_Session::getUser()) ? false : $user->isStaff();
	}

}
