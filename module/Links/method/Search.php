<?php

final class Links_Search extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 
			'RewriteRule ^link/search$ index.php?mo=Links&me=Search'.PHP_EOL.
			'RewriteRule ^link/search/([^/]+)$ index.php?mo=Links&me=Search&term=$1'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		if (false !== Common::getPost('search_quick')) {
			return $this->onSearch($module, false);
		}
		if (false !== Common::getGet('term')) {
			return $this->onSearch($module, false);
		}
		if (false !== Common::getPost('search_adv')) {
			return $this->onSearch($module, true);
		}
		return $this->templateSearch($module, array(), '');
	}
	
	private function getFormAdv(Module_Links $module)
	{
		return GWF_FormGDO::getSearchForm($module, $this, GDO::table('GWF_Links'), GWF_Session::getUser(), $module->lang('ft_search'));
	}
	
	private function getFormQuick(Module_Links $module)
	{
		$data = array(
			'term' => array(GWF_Form::STRING, '', GWF_HTML::lang('term'), 42),
			'search_quick' => array(GWF_Form::SUBMIT, $module->lang('btn_search'), ''),
		);
		return new GWF_Form($this, $data);
	}
	
	public function templateAdvSearch(Module_Links $module)
	{
		return $this->getFormAdv($module)->templateY($module->lang('ft_search'));
	}
	
	public function templateQuickSearch(Module_Links $module)
	{
		$form = $this->getFormQuick($module);
		$tVars = array(
			'form' => $form->templateX($module->lang('ft_search'), false, $module->hrefSearch()),
		);
		return $module->templatePHP('_search.php', $tVars);
	}
	
	public function templateSearch(Module_Links $module, array $matches, $term)
	{
		GWF_Website::setPageTitle($module->lang('pt_search'));
		GWF_Website::setMetaTags($module->lang('mt_search'));
		GWF_Website::setMetaDescr($module->lang('md_search'));
		$tVars = array(
			'cloud' => $module->templateCloud(),
			'matches' => $module->templateLinks($matches, '#', '', ''),
			'form' => $this->templateQuickSearch($module),
			'term' => $term,
		);
		return $module->templatePHP('search.php', $tVars);
	}
	
	public function onSearch(Module_Links $module, $adv)
	{
		$form = $adv ? $this->getFormAdv($module) : $this->getFormQuick($module);
		if (false !== ($error = $form->validate($module))) {
			return $error.$this->templateSearch($module, array(), $adv ? '' : $_REQUEST['term']);
		}
		if ($adv === true)
		{
			return $this->onAdvSearch($module, $form);
		}
		else
		{
			return $this->onQuickSearch($module, $_REQUEST['term']);
		}
	}
	
	private function onQuickSearch(Module_Links $module, $term)
	{
		$fields = array('link_href', 'link_descr');
		if ($module->cfgLongDescription()) {
			$fields[] = 'link_descr2';
		}
		$links = GDO::table('GWF_Links');
		$by = $links->getWhitelistedBy(Common::getGet('by'), 'link_id');
		$dir = GDO::getWhitelistedDirS(Common::getGet('dir'), 'DESC');
		$conditions = $module->getPermQuery(GWF_Session::getUser());
		$limit = 50;
		$from = 0;
		if (false === ($matches = GWF_QuickSearch::search($links, $fields, $term, "$by $dir", $limit, $from, $conditions))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		return $this->templateSearch($module, $matches, $term);
	}
	
	private function onAdvSearch(Module_Links $module, GWF_Form $form)
	{
		$table = GDO::table('GWF_Links');
		if (false === ($matches = $table->searchAdv(GWF_Session::getUser(), $form->getVars()))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__)).$this->templateSearch($module, array(), '');
		}
		return $this->templateSearch($module, $matches, '');
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