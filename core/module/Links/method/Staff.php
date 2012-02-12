<?php
/**
 * Staff actions for the Links Module.
 * @author gizmore
 */
final class Links_Staff extends GWF_Method
{
	const DEFAULT_BY = 'link_id';
	const DEFAULT_DIR = 'DESC';
	
	public function execute()
	{
		if (false !== ($lid = Common::getGet('approve'))) {
			return $this->onApprove($lid, true);
		}
		if (false !== ($lid = Common::getGet('disapprove'))) {
			return $this->onApprove($lid, false);
		}
		
		if (!GWF_User::isStaffS()) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		if (false !== ($error = $this->sanitize())) {
			return $error;
		}
		
		return $this->overview();
	}
	
	private function sanitize()
	{
		$links = GDO::table('GWF_Links');
		$this->user = GWF_Session::getUser();
		$this->by = $links->getWhitelistedBy(Common::getGetString('by'), self::DEFAULT_BY);
		$this->dir =  GDO::getWhitelistedDirS(Common::getGetString('dir'), self::DEFAULT_DIR);
		$this->orderby = $this->by.' '.$this->dir;
		$this->ipp = $this->module->cfgLinksPerPage();
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
	
	private function overview()
	{
		$tVars = array(
			'links' => $this->module->templateLinks($this->links, $this->sort_url, $this->by, $this->dir, false, true, true),
		);
		return $this->module->templatePHP('staff.php', $tVars);
	}
	
	private function onApprove($lid, $approve)
	{
		if (false === ($link = GWF_Links::getByID($lid))) {
			return $this->module->error('err_link');
		}
		
		if (!$link->isInModeration()) {
			return $this->module->error('err_approved');
		}
		
		if ($link->getToken() !== Common::getGet('token')) {
			return $this->module->error('err_token');
		}
		
		if ($approve) {
			if (false !== ($error = $link->insertTags($this->module))) {
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
			if (false !== ($error = $link->deleteLink($this->module))) {
				return $error;
			}
		}
		
		return $this->module->message($approve ? 'msg_approved' : 'msg_deleted');
	}
}

?>