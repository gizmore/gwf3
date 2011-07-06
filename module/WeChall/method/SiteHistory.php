<?php
final class WeChall_SiteHistory extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return
			'RewriteRule ^site/history/([^/]+)$ index.php?mo=WeChall&me=SiteHistory&site=$1'.PHP_EOL.
			'RewriteRule ^site/history/([^/]+)/page/(\\d+)$ index.php?mo=WeChall&me=SiteHistory&site=$1&page=$2'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		if (false !== (Common::getPost('quickjump'))) {
			return $this->onQuickjump($module);
		}
		
		if (false === ($site = WC_Site::getByName(Common::getGetString('site', NULL)))) {
			return $module->error('err_unknown_site');
		}
		
		$_GET['sid'] = $site->getID();
		
		return $this->templateHistory($module, $site);
	}
	
	private function templateHistory(Module_WeChall $module, WC_Site $site)
	{
		require_once 'core/module/WeChall/WC_HistoryUser2.php';
		$table = GDO::table('WC_HistoryUser2');
		$orderby = 'userhist_date ASC';
		$siteid = $site->getVar('site_id');
		$conditions = "userhist_sid=$siteid";
		$ipp = 50;
		$nItems = $table->countRows($conditions);
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$page = Common::clamp(Common::getGetInt('page', $nPages), 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		$rows = $table->select('*', $conditions, $orderby, array('userhist_uid','userhist_sid'), 50, $from);
		$href_pagemenu = GWF_WEB_ROOT.'site/history/'.$site->urlencode2('site_name').'/page/%PAGE%';
		$tVars = array(
			'pagemenu' => GWF_PageMenu::display($page, $nPages, $href_pagemenu),
			'result' => $rows,
			'site_quickjump' => $module->templateSiteQuickjumpHistory(),
		);
		return $module->templatePHP('site_history.php', $tVars);
	}
	
	private function onQuickjump(Module_WeChall $module)
	{
		$jumps = Common::getPost('quickjumps');
		if (!is_array($jumps)) {
			return $module->error('err_site').'1';
		}
		
		foreach ($jumps as $key => $value)
		{
			if ($value === '0') {
				continue;
			}
			
			if (false === ($site = WC_Site::getByID($value))) {
				return $module->error('err_site').'2';
			}

			$sid = $site->getVar('site_id');
			GWF_Website::redirect(GWF_WEB_ROOT.'site/history/'.$site->urlencode2('site_name'));
			return '';
		}

		return $module->error('err_site').'3';
	}
	
}
?>