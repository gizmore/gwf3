<?php
/**
 * This module is planned to be an own mail client, like squirrel-mail.
 * It will be possible to setup your wechall mail, and so on. 
 * @author gizmore
 */
final class Module_Mail extends GWF_Module
{
	public function onLoadLanguage() { return $this->loadLanguage('lang/mail'); }
	public function getDefaultAutoLoad() { return true; }
}
?>