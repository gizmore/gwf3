<?php
/**
 * This module is a stub since v3. Only providing a default method "About" gwf3, showing the credits.
 * @author gizmore
 * @version 3.0
 * @since 1.0
 */
final class Module_GWF extends GWF_Module
{
	public function getVersion() { return 3.00; }
	
	# Fancy Config
	public function cfgDescriptionWidth() { return $this->getModuleVar('NameWidth', '450'); }
	public function cfgNameWidth() { return $this->getModuleVar('NameWidth', '25'); }
	public function cfgIconHeight() { return $this->getModuleVar('IconHeight', '16'); }
	public function cfgIconWidth() { return $this->getModuleVar('IconWidth', '16'); }
	public function cfgDesign() { return $this->getModuleVar('Design', GWF_Template::getDesign()); }
	public function cfgSuppressHTMLPreamble() { return $this->getModuleVar('SuppressHTMLPreamble', 'true') === 'true'; }
	public function cfgFoldersFirst() { return $this->getModuleVar('FoldersFirst', 'true') === 'true'; }
	public function cfgScanHTMLTitles() { return $this->getModuleVar('ScanHTMLTitles','true') === 'true'; }
	public function cfgHTMLTable() { return $this->getModuleVar('HTMLTable','false') === 'true'; }
	public function cfgSuppressDescription() { return $this->getModuleVar('SuppressDescription', 'true') === 'true'; }
	public function cfgSuppressRules() { return $this->getModuleVar('SuppressRules', 'true') === 'true'; }
	
}
?>