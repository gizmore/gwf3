<?php
final class Module_VersionServer extends GWF_Module
{
	public function getVersion() { return 1.00; }
	public function getPrice() { return 666.99; }
	public function onLoadLanguage() { return $this->loadLanguage('lang/vs'); }
	public function getDependencies() { return array('Admin'=>1.00); }
	public function getClasses() { return array('GWF_Client', 'GWF_ClientOrder', 'GWF_VersionFiles', 'GWF_VersionServerLog'); }
	public function getAdminSectionURL() { return $this->getMethodURL('PurgeFiles'); }
	
	public function onInstall($dropTable)
	{
		return
			GWF_VersionFiles::populateAll().
			GWF_ModuleLoader::installVars($this, array(
			));
	}
	
//	public function onAddMenu()
//	{
//		GWF_TopMenu::addMenu('purchase', $this->getMethodURL('Purchase'), '', $this->isMethodSelected('Purchasee'));
//	}
}
?>
