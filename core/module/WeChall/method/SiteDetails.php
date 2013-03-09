<?php

final class WeChall_SiteDetails extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^site/details/(\d+)/.*$ index.php?mo=WeChall&me=SiteDetails&sid=$1'.PHP_EOL;
	}
	
	public function execute()
	{
		if (false !== Common::getPost('quickjump'))
		{
			return $this->onQuickJump();
		}
		
		require_once(GWF_CORE_PATH.'module/WeChall/WC_RegAt.php');
		require_once(GWF_CORE_PATH.'module/WeChall/WC_SiteAdmin.php');
		require_once GWF_CORE_PATH.'module/WeChall/WC_SiteDescr.php';
		
		if (isset($_GET['url']))
		{
			if (false !== ($site = WC_Site::getByURL(Common::getGet('url'))))
			{
				return $this->templateSiteDetail($site);
			}
		}
		
		elseif (false !== ($site = WC_Site::getByID(Common::getGet('sid'))))
		{
			return $this->templateSiteDetail($site);
		}
		
		return $this->module->error('err_site');
	}
	
	public function templateSiteDetail(WC_Site $site)
	{
		$this->module->includeVotes();
//		$this->module->includeForums();
		
//		GWF_Module::loadModuleDB('Forum', true, true);
//		GWF_ForumBoard::init(true, true);
//		GWF_Module::loadModuleDB('Votes', true);
		
		$time = $this->module->cfgLastPlayersTime();
		$tVars = array(
			'site' => $site,
			'boxcount' => $site->getBoxCount(),
			'descr' => WC_SiteDescr::getDescription($site->getID()),
			'site_quickjump' => $this->module->templateSiteQuickjumpDetail(),
			'latest_players_time' => GWF_Time::humanDuration($time),
			'latest_players' => $this->getLatestPlayers($time, $site->getID()),
			'jquery' => Common::getGet('ajax') !== false,
			'can_vote' => $site->canVote(GWF_User::getStaticOrGuest()),
		);
		$ajax = isset($_GET['ajax']) ? '_ajax' : '';
		return $this->module->templatePHP('site_detail'.$ajax.'.php', $tVars);
	}
	
	private function getLatestPlayers($time, $siteid)
	{
		$cut = GWF_Time::getDate(GWF_Date::LEN_SECOND, time()-$time);
		$siteid = (int)$siteid;
		return GDO::table('WC_RegAt')->selectColumn('user_name', "regat_lastdate>'{$cut}' AND regat_sid={$siteid}", '', array('user'));
	}
	
	private function onQuickJump()
	{
		$jumps = Common::getPost('quickjumps');
		if (!is_array($jumps)) {
			return $this->module->error('err_site').'1';
		}
		
		foreach ($jumps as $key => $value)
		{
			if ($value === '0') {
				continue;
			}
			
			if (false === ($site = WC_Site::getByID($value))) {
				return $this->module->error('err_site').'2';
			}

			$sid = $site->getVar('site_id');
			GWF_Website::redirect(GWF_WEB_ROOT.'site/details/'.$sid.'/'.$site->urlencodeSEO('site_name'));
			return '';
		}

		return $this->module->error('err_site').'3';
	}
}

?>
