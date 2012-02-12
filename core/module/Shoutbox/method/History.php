<?php
final class Shoutbox_History extends GWF_Method
{
	public function getHTAccess()
	{
		return
			'RewriteRule ^shoutbox/history$ index.php?mo=Shoutbox&me=History'.PHP_EOL.
			'RewriteRule ^shoutbox/history/by/page-(\d+)$ index.php?mo=Shoutbox&me=History&page=$1'.PHP_EOL.
			'RewriteRule ^shoutbox/history/by/([^/]+)/([DEASC,]+)/page-(\d+)$ index.php?mo=Shoutbox&me=History&by=$1&dir=$2&page=$3'.PHP_EOL.
			'';
	}

	public function execute()
	{
		if (false !== ($array = Common::getPost('delete'))) {
			return $this->onDelete($array);
		}
		return $this->templatePage();
	}

	private function templatePage()
	{
		$ipp = $this->module->cfgIPP();
		$shouts = GDO::table('GWF_Shoutbox');
		$by = Common::getGet('by', 'shout_date');
		$dir = Common::getGet('dir', 'ASC');
		$orderby = $shouts->getMultiOrderby($by, $dir);
		
		$nItems = $shouts->countRows();
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$page = Common::clamp(intval(Common::getGet('page', $nPages)), 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		
		GWF_Website::setPageTitle($this->module->lang('pt_history', array( $page, $nPages)));
		GWF_Website::setMetaDescr($this->module->lang('md_history'));
		GWF_Website::setMetaTags($this->module->lang('mt_history'));
		
		$tVars = array(
			'data' => $shouts->selectAll('*', '', $orderby, array('shout_uid'), $ipp, $from, GDO::ARRAY_O),
			'sort_url' => GWF_WEB_ROOT.'shoutbox/history/by/%BY%/%DIR%/page-1',
			'page_menu' => GWF_PageMenu::display($page, $nPages, GWF_WEB_ROOT.'shoutbox/history/by/'.urlencode($by).'/'.urlencode($dir).'/page-%PAGE%'),
			'form_action' => $this->module->hrefShout(),
		);
		
		return $this->module->templatePHP('history.php', $tVars);
	}
	
	private function onDelete($array)
	{
		if (!GWF_User::isInGroupS('moderator')) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		if (!is_array($array)) {
			return GWF_HTML::err('ERR_GENERAL', array( __FILE__, __LINE__));
		}
		
		if (false !== ($error = GWF_Form::validateCSRF_WeakS())) {
			return GWF_HTML::error('Shoutbox', $error);
		}
		
		foreach ($array as $id => $foo) { break; }
		
		if (false === ($row = GWF_Shoutbox::getByID($id))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		if (false === $row->delete()) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		return $this->module->message('msg_deleted');
	}
}
?>