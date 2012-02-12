<?php
/**
 * Update all users for a site.
 * A, so called, DoS attack :P
 * @author gizmore
 */
final class WeChall_SiteDDOS extends GWF_Method
{
	public function getUserGroups() { return 'admin'; }
	
	public function execute()
	{
		if (false === ($site = WC_Site::getByID(Common::getGet('siteid')))) {
			return $this->module->error('err_site');
		}
		
		return $this->templateDDOS($site);
	}
	
	private function templateDDOS(WC_Site $site)
	{
//		require_once GWF_CORE_PATH.'module/WeChall/WC_RegAt.php';
		
		$siteid = $site->getVar('site_id');
		$regat = GWF_TABLE_PREFIX.'wc_regat';
		$users = GWF_TABLE_PREFIX.'user';
		$query = "SELECT u.* FROM $regat JOIN $users u ON regat_uid=user_id WHERE regat_sid=$siteid";
		
		$db = gdo_db();
		if (false === ($result = $db->queryRead($query))) {
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$user = new GWF_User();
		while (false !== ($row = $db->fetchAssoc($result)))
		{
			$user->setGDOData($row);
			$site->onUpdateUser($user, false);
		}
		$db->free($result);
		$site->recalcSite();
	}
}
?>