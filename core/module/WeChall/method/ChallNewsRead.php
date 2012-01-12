<?php
/**
 * Mark the challenge news as read.
 * @author gizmore
 */
final class WeChall_ChallNewsRead extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function execute()
	{
		return $this->onMarkRead();
	}
	
	private function onMarkRead()
	{
		$user = GWF_Session::getUser();
		$userid = $user->getID();
		$sites = GWF_TABLE_PREFIX.'wc_site';
		$regat = GWF_TABLE_PREFIX.'wc_regat';
		$query = "UPDATE $regat JOIN $sites ON regat_sid=site_id SET regat_challcount=site_challcount WHERE regat_uid=$userid";
		$db = gdo_db();
		if (false === $db->queryWrite($query)) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		return $this->_module->message('msg_challs_marked');
	}
}
?>