<?php
/**
 * Staff actions for the Links Module.
 * @author gizmore
 */
final class Links_Staff extends GWF_Method
{
	const DEFAULT_BY = 'link_id';
	const DEFAULT_DIR = 'DESC';
	
	public function execute(GWF_Module $module)
	{
		if (false !== ($lid = Common::getGet('approve'))) {
			return $this->onApprove($module, $lid, true);
		}
		if (false !== ($lid = Common::getGet('disapprove'))) {
			return $this->onApprove($module, $lid, false);
		}
		
		if (!GWF_User::isStaffS()) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		if (false !== ($error = $this->sanitize($module))) {
			return $error;
		}
		
		return $this->overview($module);
	}
	
	private function sanitize(Module_Links $module)
	{
		$links = GDO::table('GWF_Links');
		$this->user = GWF_Session::getUser();
		$this->by = $links->getWhitelistedBy(Common::getGetString('by'), self::DEFAULT_BY);
		$this->dir =  GDO::getWhitelistedDirS(Common::getGetString('dir'), self::DEFAULT_DIR);
		$this->orderby = $this->by.' '.$this->dir;
		$this->ipp = $module->cfgLinksPerPage();
		$this->nItems = $links->countRows();
		$this->nPages = GWF_PageMenu::getPagecount($this->ipp, $this->nItems);
		$this->page = Common::clamp(intval(Common::getGet('page', 1)), 1, $this->nPages);
		$this->from = GWF_PageMenu::getFrom($this->page, $this->ipp);
		$this->sort_url = $this->getMethodHref('&by=%BY%&dir=%DIR%&page=1');
		if (false === ($this->links = $links->selectObjects('*', '', $this->orderby, $this->ipp, $this->from))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		return false;
	}
	
	private function overview(Module_Links $module)
	{
		$tVars = array(
			'links' => $module->templateLinks($this->links, $this->sort_url, $this->by, $this->dir, false, true, true),
		);
		return $module->templatePHP('staff.php', $tVars);
	}
	
	private function onApprove(Module_Links $module, $lid, $approve)
	{
		if (false === ($link = GWF_Links::getByID($lid))) {
			return $module->error('err_link');
		}
		
		if (!$link->isInModeration()) {
			return $module->error('err_approved');
		}
		
		if ($link->getToken() !== Common::getGet('token')) {
			return $module->error('err_token');
		}
		
		if ($approve) {
			if (false !== ($error = $link->insertTags($module))) {
				return $error;
			}
			if (false === $link->saveOption(GWF_Links::IN_MODERATION, false)) {
				return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
			}
			if (false === $link->setVotesEnabled(true)) {
				return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
			}
		}
		else {
			if (false !== ($error = $link->deleteLink($module))) {
				return $error;
			}
		}
		
		return $module->message($approve ? 'msg_approved' : 'msg_deleted');
	}
}

?>