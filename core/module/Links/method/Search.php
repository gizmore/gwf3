<?php

final class Links_Search extends GWF_Method
{
	public function getHTAccess()
	{
		return 
			'RewriteRule ^link/search$ index.php?mo=Links&me=Search'.PHP_EOL.
			'RewriteRule ^link/search/([^/]+)$ index.php?mo=Links&me=Search&term=$1'.PHP_EOL;
	}
	
	public function execute()
	{
		if (false !== Common::getPost('search_quick')) {
			return $this->onSearch($this->_module, false);
		}
		if (false !== Common::getGet('term')) {
			return $this->onSearch($this->_module, false);
		}
		if (false !== Common::getPost('search_adv')) {
			return $this->onSearch($this->_module, true);
		}
		return $this->templateSearch($this->_module, array(), '');
	}
	
	private function getFormAdv()
	{
		return GWF_FormGDO::getSearchForm($this->_module, $this, GDO::table('GWF_Links'), GWF_Session::getUser(), $this->_module->lang('ft_search'));
	}
	
	private function getFormQuick()
	{
		$data = array(
			'term' => array(GWF_Form::STRING, '', GWF_HTML::lang('term')),
			'search_quick' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_search')),
		);
		return new GWF_Form($this, $data);
	}
	
	public function templateAdvSearch()
	{
		return $this->getFormAdv()->templateY($this->_module->lang('ft_search'));
	}
	
	public function templateQuickSearch()
	{
		$form = $this->getFormQuick();
		$tVars = array(
			'form' => $form->templateX($this->_module->lang('ft_search'), false, $this->_module->hrefSearch()),
		);
		return $this->_module->templatePHP('_search.php', $tVars);
	}
	
	public function templateSearch(Module_Links $module, array $matches, $term)
	{
		GWF_Website::setPageTitle($this->_module->lang('pt_search'));
		GWF_Website::setMetaTags($this->_module->lang('mt_search'));
		GWF_Website::setMetaDescr($this->_module->lang('md_search'));
		$tVars = array(
			'cloud' => $this->_module->templateCloud(),
			'matches' => $this->_module->templateLinks($matches, '#', '', ''),
			'form' => $this->templateQuickSearch(),
			'term' => $term,
		);
		return $this->_module->templatePHP('search.php', $tVars);
	}
	
	public function onSearch(Module_Links $module, $adv)
	{
		$form = $adv ? $this->getFormAdv() : $this->getFormQuick($this->_module);
		if (false !== ($error = $form->validate($this->_module))) {
			return $error.$this->templateSearch($this->_module, array(), $adv ? '' : $_REQUEST['term']);
		}
		if ($adv === true)
		{
			return $this->onAdvSearch($this->_module, $form);
		}
		else
		{
			return $this->onQuickSearch($this->_module, $_REQUEST['term']);
		}
	}
	
	private function onQuickSearch(Module_Links $module, $term)
	{
		$fields = array('link_href', 'link_descr');
		if ($this->_module->cfgLongDescription()) {
			$fields[] = 'link_descr2';
		}
		$links = GDO::table('GWF_Links');
		$by = $links->getWhitelistedBy(Common::getGet('by'), 'link_id');
		$dir = GDO::getWhitelistedDirS(Common::getGet('dir'), 'DESC');
		$conditions = $this->_module->getPermQuery(GWF_Session::getUser());
		$limit = 50;
		$from = 0;
		if (false === ($matches = GWF_QuickSearch::search($links, $fields, $term, "$by $dir", $limit, $from, $conditions))) {
			return $this->templateSearch($this->_module, array(), '');
		}
		return $this->templateSearch($this->_module, $matches, $term);
	}
	
	private function onAdvSearch(Module_Links $module, GWF_Form $form)
	{
		$table = GDO::table('GWF_Links');
		if (false === ($matches = $table->searchAdv(GWF_Session::getUser(), $form->getVars()))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__)).$this->templateSearch($this->_module, array(), '');
		}
		return $this->templateSearch($this->_module, $matches, '');
	}
	##################
	### Validators ###
	##################
	public function validate_term(Module_Links $module, $arg) { return false; }
	public function validate_link_descr(Module_Links $module, $arg) { return false; }
	public function validate_link_descr2(Module_Links $module, $arg) { return false; }
	public function validate_link_href(Module_Links $module, $arg) { return false; }
	public function validate_link_date(Module_Links $module, $arg) { return false; }
	public function validate_user_name(Module_Links $module, $arg) { return false; }
	public function validate_vs_avg(Module_Links $module, $arg) { return false; }
	
		
}