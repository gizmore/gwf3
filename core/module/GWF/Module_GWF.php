<?php
/**
 * Error pages, and Fancy indexing.
 * @author gizmore, spaceone
 * @version 3.0
 * @since 1.0
 */
final class Module_GWF extends GWF_Module
{
	public function getVersion() { return 3.01; }
	
	public function cfgDesign() { return $this->getModuleVar('Design', GWF_Template::getDesign()); }

	# Fancy Config
	public function cfgFancyIndex() { return $this->getModuleVar('FancyIndex', '1') === '1'; }
	public function cfgNameWidth() { return $this->getModuleVar('NameWidth', '25'); }
	public function cfgDescriptionWidth() { return $this->getModuleVar('DescrWidth', '80'); }
	public function cfgIconWidth() { return $this->getModuleVar('IconWidth', '16'); }
	public function cfgIconHeight() { return $this->getModuleVar('IconHeight', '16'); }
	public function cfgHTMLTable() { return $this->getModuleVar('HTMLTable','0') === '1'; }
	public function cfgIgnoreClient() { return $this->getModuleVar('IgnoreClient', '0') === '1'; }
	public function cfgFoldersFirst() { return $this->getModuleVar('FoldersFirst', '1') === '1'; }
	public function cfgIgnoreCase() { return $this->getModuleVar('IgnoreCase', '1') === '1'; }
	public function cfgSuppressHTMLPreamble() { return $this->getModuleVar('SuppressHTMLPreamble', '1') === '1'; }
	public function cfgScanHTMLTitles() { return $this->getModuleVar('ScanHTMLTitles','1') === '1'; }
	public function cfgSuppressDescription() { return $this->getModuleVar('SuppressDescription', '1') === '1'; }
	public function cfgSuppressRules() { return $this->getModuleVar('SuppressRules', '1') === '1'; }

	public function onInstall($dropTable)
	{
		return GWF_ModuleLoader::installVars($this, array(
			'Design' => array(GWF_Template::getDesign(), 'text'),
			# Fancy Config
			'FancyIndex' => array('YES', 'bool'),
			'NameWidth' => array('25', 'int'),
			'DescrWidth' => array('80', 'int'),
			'IconWidth' => array('16', 'int'),
			'IconHeight' => array('16', 'int'),
			'HTMLTable' => array('NO', 'bool'),
			'IgnoreClient' => array('NO', 'bool'),
			'FoldersFirst' => array('YES', 'bool'),
			'IgnoreCase' => array('YES', 'bool'),
			'SuppressHTMLPreamble' => array('YES', 'bool'),
			'ScanHTMLTitles' => array('YES', 'bool'),
			'SuppressDescription' => array('YES', 'bool'),
			'SuppressRules' => array('YES', 'bool'),
		));
	}	
}
?>