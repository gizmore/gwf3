<?php
final class WeChall_RSSSite extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^site_activity_feed/?(.*)$ index.php?mo=WeChall&me=RSSSite&site=$1'.PHP_EOL;
	}
	
	public function execute()
	{
		if (!($site = WC_Site::getByClassName(Common::getGetString('site'))))
		{
			$this->module->ajaxErr('err_site');
		}
		
		require_once GWF_CORE_PATH.'module/WeChall/WC_HistoryUser2.php';
		$table = GDO::table('WC_HistoryUser2');
		$orderby = 'userhist_date DESC';
		$siteid = $site->getVar('site_id');
		$conditions = "userhist_sid=$siteid";
		$items = $table->selectObjects('*', $conditions, $orderby, 15);
	
		$feed = new GWF_RSS();
		$feed->setTitle($this->l('siterss_title', array($site->displayName())));
		$feed->setItems($items);
		$feed->setFeedURL($_SERVER['REQUEST_URI']);
		$feed->setWebURL(Common::getAbsoluteURL('site/history/'.$site->displayName()));
		die($feed->export());
	}
}
