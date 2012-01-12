<?php
/**
 * Mark a warning as read. Bans can not set as mark read, so they effectively ban :)
 * @author gizmore
 */
final class Ban_MarkRead extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function execute()
	{
		if (false === ($ban = GWF_Ban::getByID(Common::getGet('bid')))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		if ($ban->getUser()->getID() !== GWF_Session::getUserID()) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		if (!$ban->isWarning()) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		if (false === $ban->saveOption(GWF_Ban::READ, true)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		return $this->_module->message('msg_marked_read');
	}
}
?>