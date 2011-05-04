<?php
final class Register_Admin extends GWF_Method
{
	/**
	 * @var GWF_UserActivation
	 */
	private $table;
	
	##################
	### GWF_Method ###
	##################
	public function getUserGroups() { return GWF_Group::STAFF; }
	public function execute(GWF_Module $module)
	{
		if (false === ($errors = $this->sanitize($module))) {
			return $errors;
		}
		
		return $this->templateAdmin($module);
	}

	################
	### Sanitize ###
	################
	private $ipp;
	private $nItems;
	private $page;
	private $nPages;
	private $by;
	private $dir;
	private $orderby;
	private function sanitize(Module_Register $module)
	{
		$this->table = new GWF_UserActivation(false);
		$this->ipp = $module->getActivationsPerPage();
		$this->nItems = $this->table->countRows();
		$this->nPages = GWF_PageMenu::getPagecount($this->ipp, $this->nItems);
		$this->page = Common::clamp((int)Common::getGet('page', 1), 1, $this->nPages);
		$this->by = $this->table->getWhitelistedBy(Common::getGetString('by'), 'timestamp');
		$this->dir = GDO::getWhitelistedDirS(Common::getGetString('dir'), 'DESC');
		$this->orderby = "$this->by $this->dir";
	}
	
	################
	### Template ###
	################
	private function templateAdmin(Module_Register $module)
	{
		$headers = array(
			array($module->lang('th_username'), 'username', 'ASC'),
			array($module->lang('th_token'), 'token', 'ASC'),
			array($module->lang('th_email'), 'email', 'ASC'),
			array($module->lang('th_birthdate'), 'birthdate', 'ASC'),
			array($module->lang('th_countryid'), 'countryid', 'ASC'),
			array($module->lang('th_timestamp'), 'timestamp', 'ASC'),
			array($module->lang('th_ip'), 'ip', 'ASC'),
		);
		$tVars = array(
//			'by' => $this->by,
//			'dir' => $this->dir,
			'headers' => GWF_Table::displayHeaders1($headers, GWF_WEB_ROOT.'index.php?mo=Register&me=Admin&by=%BY%&dir=%DIR%&page=1'),
//			'sort_url' => ',
			'activations' => $this->table->selectAll('*', '', $this->orderby, NULL, $this->ipp, GWF_PageMenu::getFrom($this->page, $this->ipp)),
			'pagemenu' => $this->getPageMenu(),
		);
		return $module->template('admin.tpl', $tVars);
	}
	
	private function getPageMenu()
	{
		$href = sprintf(GWF_WEB_ROOT.'index.php?mo=Register&me=Admin&by=%s&dir=%s;&page=%%PAGE%%', urlencode($this->by), urlencode($this->dir));
		return GWF_PageMenu::display($this->page, $this->nPages, $href);	
	}
}
?>