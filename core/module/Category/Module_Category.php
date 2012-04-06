<?php
/**
 * Categories. Could be a built-in class.
 * @author gizmore
 */
final class Module_Category extends GWF_Module
{
	public function getVersion() { return 1.01; }
	public function onLoadLanguage() { return $this->loadLanguage('lang/category'); }
	public function getAdminSectionURL() { return $this->getMethodURL('Admin'); }
	public function getClasses() { return array('GWF_Category', 'GWF_CategorySelect', 'GWF_CategoryTranslation'); }
	public function getDefaultPriority() { return 30; } # Has Deps
}
?>
