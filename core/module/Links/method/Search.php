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
			return $this->onSearch(false);
		}
		if (false !== Common::getGet('term')) {
			return $this->onSearch(false);
		}
		if (false !== Common::getPost('search_adv')) {
			return $this->onSearch(true);
		}
		return $this->templateSearch(array(), '');
	}
	
	private function getFormAdv()
	{
		return GWF_FormGDO::getSearchForm($this->module, $this, GDO::table('GWF_Links'), GWF_Session::getUser(), $this->module->lang('ft_search'));
	}
	
	private function getFormQuick()
	{
		$data = array(
			'term' => array(GWF_Form::STRING, '', GWF_HTML::lang('term')),
			'search_quick' => array(GWF_Form::SUBMIT, $this->module->lang('btn_search')),
		);
		return new GWF_Form($this, $data);
	}
	
	public function templateAdvSearch()
	{
		return $this->getFormAdv()->templateY($this->module->lang('ft_search'));
	}
	
	public function templateQuickSearch()
	{
		$form = $this->getFormQuick();
		$tVars = array(
			'form' => $form->templateX($this->module->lang('ft_search'), false, $this->module->hrefSearch()),
		);
		return $this->module->templatePHP('_search.php', $tVars);
	}
	
	public function templateSearch(array $matches, $term)
	{
		GWF_Website::setPageTitle($this->module->lang('pt_search'));
		GWF_Website::setMetaTags($this->module->lang('mt_search'));
		GWF_Website::setMetaDescr($this->module->lang('md_search'));
		$tVars = array(
			'cloud' => $this->module->templateCloud(),
			'matches' => $this->module->templateLinks($matches, '#', '', ''),
			'form' => $this->templateQuickSearch(),
			'term' => $term,
		);
		return $this->module->templatePHP('search.php', $tVars);
	}
	
	public function onSearch($adv)
	{
		$form = $adv ? $this->getFormAdv() : $this->getFormQuick();
		if (false !== ($error = $form->validate($this->module))) {
			return $error.$this->templateSearch(array(), $adv ? '' : $_REQUEST['term']);
		}
		if ($adv === true)
		{
			return $this->onAdvSearch($form);
		}
		else
		{
			return $this->onQuickSearch($_REQUEST['term']);
		}
	}
	
	private function onQuickSearch($term)
	{
		$fields = array('link_href', 'link_descr');
		if ($this->module->cfgLongDescription()) {
			$fields[] = 'link_descr2';
		}
		$links = GDO::table('GWF_Links');
		$by = $links->getWhitelistedBy(Common::getGet('by'), 'link_id');
		$dir = GDO::getWhitelistedDirS(Common::getGet('dir'), 'DESC');
		$conditions = $this->module->getPermQuery(GWF_Session::getUser());
		$limit = 50;
		$from = 0;
		if (false === ($matches = GWF_QuickSearch::search($links, $fields, $term, "$by $dir", $limit, $from, $conditions))) {
			return $this->templateSearch(array(), '');
		}
		return $this->templateSearch($matches, $term);
	}
	
	private function onAdvSearch(GWF_Form $form)
	{
		$table = GDO::table('GWF_Links');
		if (false === ($matches = $table->searchAdv(GWF_Session::getUser(), $form->getVars()))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__)).$this->templateSearch(array(), '');
		}
		return $this->templateSearch($matches, '');
	}
	##################
	### Validators ###
	##################
	public function validate_term(Module_Links $m, $arg) { return false; }
	public function validate_link_descr(Module_Links $m, $arg) { return false; }
	public function validate_link_descr2(Module_Links $m, $arg) { return false; }
	public function validate_link_href(Module_Links $m, $arg) { return false; }
	public function validate_link_date(Module_Links $m, $arg) { return false; }
	public function validate_user_name(Module_Links $m, $arg) { return false; }
	public function validate_vs_avg(Module_Links $m, $arg) { return false; }
	
		
}
