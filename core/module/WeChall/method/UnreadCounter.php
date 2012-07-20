<?php
/**
 * Ajax method to return unread threads and pm and stuff.
 * @author gizmore
 */
final class WeChall_UnreadCounter extends GWF_Method
{
	public function execute()
	{
		GWF3::setConfig('log_request', false);
		
		$back = array();
		$user = GWF_User::getStaticOrGuest();
		$back['news'] = (int)$this->module->getNewsCount();
		$back['pm'] = (int)WC_HTML::getUnreadPMCount($user);
		$back['links'] = (int)WC_HTML::getUnreadLinksCount($user);
		$back['forum'] = (int)WC_HTML::getUnreadThreadCount($user);
		return json_encode($back);
	}
}
?>
