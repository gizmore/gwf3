<?php
final class Download_List extends GWF_Method
{
	public function getHTAccess()
	{
		return
			'RewriteRule ^downloads$ index.php?mo=Download&me=List'.PHP_EOL.
			'RewriteRule ^downloads/by/page-(\d+)$ index.php?mo=Download&me=List&page=$1'.PHP_EOL.
			'RewriteRule ^downloads/by/([^/]+)/([DEASC,]+)/page-(\d+)$ index.php?mo=Download&me=List&by=$1&dir=$2&page=$3'.PHP_EOL.
			'';
	}

	public function execute()
	{
		# SEO
		GWF_Website::setMetaTags($this->_module->lang('mt_list'));
		GWF_Website::setMetaDescr($this->_module->lang('md_list'));
		GWF_Website::setPageTitle($this->_module->lang('pt_list'));
		$user = GWF_Session::getUser();
		# Permission
//		if ((false === ($user = GWF_Session::getUser())) && (!$this->_module->cfgAnonDown())) {
//			return GWF_HTML::err('ERR_NO_PERMISSION');
//		}
		
		if (false !== ($mod_pay = GWF_Module::getModule('Payment'))) {
			$mod_pay->onInclude();
		}
		
		return $this->templateList($user);
	}
	
	private function templateList($user)
	{
		$dl = GDO::table('GWF_Download');
		$permquery = GWF_Download::getPermissionQueryList($user);
		
		$ipp = $this->_module->cfgIPP();
		$nItems = $dl->countRows($permquery);
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$page = Common::clamp(intval(Common::getGet('page', 1)), 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		
		$by = Common::getGet('by', 'dl_id');
		$dir = Common::getGet('dir', 'ASC');
		$orderby = $dl->getMultiOrderby($by, $dir);
		
		$tVars = array(
			'href_add' => $this->_module->hrefAdd(),
			'may_upload' => $this->_module->mayUpload($user),
			'sort_url' => GWF_WEB_ROOT.'downloads/by/%BY%/%DIR%/page-1',
			'downloads' => $dl->selectObjects('*', $permquery, $orderby, $ipp, $from),
			'page_menu' => GWF_PageMenu::display($page, $nPages, GWF_WEB_ROOT.sprintf('downloads/by/%s/%s/page-%%PAGE%%', urlencode($by), urlencode($dir))),
		);
		return $this->_module->templatePHP('list.php', $tVars);
	}
}
?>