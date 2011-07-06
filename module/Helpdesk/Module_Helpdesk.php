<?php
final class Module_Helpdesk extends GWF_Module
{
	# Module #
	public function getClasses() { return array('GWF_HelpdeskFAQ', 'GWF_HelpdeskMsg', 'GWF_HelpdeskTicket'); }
	public function onInstall($dropTable) { require_once 'core/module/Helpdesk/GWF_HelpdeskInstall.php'; GWF_HelpdeskInstall::onInstall($this, $dropTable); }
	public function onLoadLanguage() { return $this->loadLanguage('lang/helpdesk'); }
	# Config #
	public function cfgMaxTitleLen() { return $this->getModuleVar('maxlen_title', '255'); }
	public function cfgMaxMessageLen() { return $this->getModuleVar('maxlen_message', '2048'); }
	
	public function validate_message($arg) { return GWF_Validator::validateString($this, 'message', $arg, 8, $this->cfgMaxMessageLen(), false); }
}
?>