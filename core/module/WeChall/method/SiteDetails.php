<?php

final class WeChall_SiteDetails extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^site/details/(\d+)/.*$ index.php?mo=WeChall&me=SiteDetails&sid=$1'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		if (false !== Common::getPost('quickjump')) {
			return $this->onQuickJump($module);
		}
		
		if (false === ($site = WC_Site::getByID(Common::getGet('sid')))) {
			return $module->error('err_site');
		}
		
		return $this->templateSiteDetail($module, $site);
	}
	
	public function templateSiteDetail(Module_WeChall $module, WC_Site $site)
	{
		require_once(GWF_CORE_PATH.'module/WeChall/WC_RegAt.php');
		require_once(GWF_CORE_PATH.'module/WeChall/WC_SiteAdmin.php');
		require_once GWF_CORE_PATH.'module/WeChall/WC_SiteDescr.php';
		
//		GWF_Module::loadModuleDB('Forum', true, true);
//		GWF_ForumBoard::init(true, true);
		GWF_Module::loadModuleDB('Votes', true);
		
		$time = $module->cfgLastPlayersTime();
		$tVars = array(
			'site' => $site,
			'descr' => WC_SiteDescr::getDescription($site->getID()),
			'site_quickjump' => $module->templateSiteQuickjumpDetail(),
			'latest_players_time' => GWF_Time::humanDuration($time),
			'latest_players' => $this->getLatestPlayers($time, $site->getID()),
			'jquery' => Common::getGet('ajax') !== false,
			'can_vote' => $site->canVote(GWF_User::getStaticOrGuest()),
		);
		return $module->templatePHP('site_detail.php', $tVars);
	}
	
	private function getLatestPlayers($time, $siteid)
	{
		$cut = GWF_Time::getDate(GWF_Date::LEN_SECOND, time()-$time);
		$siteid = (int)$siteid;
		return GDO::table('WC_RegAt')->selectColumn('user_name', "regat_lastdate>'{$cut}' AND regat_sid={$siteid}", '', array('user'));
//		$db = gdo_db();
//		$regat = GDO::table('WC_RegAt')->getTableName();
//		$users = GDO::table('GWF_User')->getTableName();
//		$cut = GWF_Time::getDate(GWF_Date::LEN_SECOND, time()-$time);
//		$query = "SELECT user_name FROM $regat JOIN $users AS u ON regat_uid=user_id WHERE regat_lastdate>'$cut' AND regat_sid=$siteid";
//		return $db->queryAll($query);
	}
	
	private function onQuickJump(Module_WeChall $module)
	{
		$jumps = Common::getPost('quickjumps');
		if (!is_array($jumps)) {
			return $module->error('err_site').'1';
		}
		
		foreach ($jumps as $key => $value)
		{
//			var_dump($key);
//			var_dump($value);
			if ($value === '0') {
				continue;
			}
			
			if (false === ($site = WC_Site::getByID($value))) {
				return $module->error('err_site').'2';
			}

			$sid = $site->getVar('site_id');
			GWF_Website::redirect(GWF_WEB_ROOT.'site/details/'.$sid.'/'.$site->urlencodeSEO('site_name'));
			return '';
		}

		return $module->error('err_site').'3';
	}
}

?>
