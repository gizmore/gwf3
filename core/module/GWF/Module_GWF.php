<?php
/**
 * Error pages, and Fancy indexing.
 * @author gizmore, spaceone
 * @version 3.0
 * @since 1.0
 */
final class Module_GWF extends GWF_Module
{
	public function getVersion() { return 3.07; }
	public function onInstall($dropTable) { require_once GWF_CORE_PATH.'module/GWF/GWF_InstallGWF.php'; return GWF_InstallGWF::onInstall($this, $dropTable); }
	
//	public function cfgDesign() { return $this->getModuleVar('Design', GWF_Template::getDesign()); }

	# Fancy Config
	public function cfgFancyIndex() { return $this->getModuleVarBool('FancyIndex', '1'); }
	public function cfgNameWidth() { return $this->getModuleVar('NameWidth', '25'); }
	public function cfgDescriptionWidth() { return $this->getModuleVar('DescrWidth', '80'); }
	public function cfgIconWidth() { return $this->getModuleVar('IconWidth', '16'); }
	public function cfgIconHeight() { return $this->getModuleVar('IconHeight', '16'); }
	public function cfgHTMLTable() { return $this->getModuleVarBool('HTMLTable','0'); }
	public function cfgIgnoreClient() { return $this->getModuleVarBool('IgnoreClient', '0'); }
	public function cfgFoldersFirst() { return $this->getModuleVarBool('FoldersFirst', '1'); }
	public function cfgIgnoreCase() { return $this->getModuleVarBool('IgnoreCase', '1'); }
	public function cfgSuppressHTMLPreamble() { return $this->getModuleVarBool('SuppressHTMLPreamble', '1'); }
	public function cfgScanHTMLTitles() { return $this->getModuleVarBool('ScanHTMLTitles','1'); }
	public function cfgSuppressDescription() { return $this->getModuleVarBool('SuppressDescription', '1'); }
	public function cfgSuppressRules() { return $this->getModuleVarBool('SuppressRules', '1'); }
	
	# Error Config
	public function cfgLog404() { return $this->getModuleVarBool('log_404'); }
	public function cfgMail404() { return $this->getModuleVarBool('mail_404'); }
	
	# Captcha Config
	public function cfgCaptchaBG() { return $this->getModuleVar('CaptchaBGColor', 'FFFFFF'); }
	public function cfgCaptchaFont() { return explode(',', $this->getModuleVar('CaptchaFont', GWF_PATH.'extra/font/teen.ttf')); }
	public function cfgCaptchaWidth() { return (int)$this->getModuleVar('CaptchaWidth', '210'); }
	public function cfgCaptchaHeight() { return (int)$this->getModuleVar('CaptchaHeight', '42'); }
}
?>