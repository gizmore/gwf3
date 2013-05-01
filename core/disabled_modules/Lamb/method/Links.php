<?php
/**
 * Lamb www binding to the links module.
 * @author gizmore
 */
final class Lamb_Links extends GWF_Method
{
	public function execute()
	{
		$module = $this->module;
		$module instanceof Module_Lamb;
		if (false === $module->includeClass('lamb_module/Link/Lamb_Link'))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		if (false === ($table = GDO::table('Lamb_Link')))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$where = '1';
		if ('' !== ($term = Common::getGetString('term', '')))
		{
			$fields = array('link_text', 'link_url', 'link_username');
			if (false === ($where = GWF_QuickSearch::getQuickSearchConditions($table, $fields, $term)))
			{
				$where = '1';
			}
		}
		
		$ipp = 50;
		$nItems = $table->countRows($where);
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$page = Common::clamp(Common::getGetInt('page', 1), 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		
		$by = Common::getGetString('by', 'link_id');
		$dir = Common::getGetString('dir', 'ASC');
		$orderby = $table->getMultiOrderby($by, $dir);
		
		$form = $this->formQuicksearch();
		
		$tVars = array(
				'quicksearch' => $form->templateX($this->module->lang('ft_quicksearch'), GWF_WEB_ROOT.'index.php'),
				'quotes' => $table->selectAll('*', $where, $orderby, NULL, $ipp, $from),
				'pagemenu' => GWF_PageMenu::display($page, $nPages, GWF_WEB_ROOT.'index.php?mo=Lamb&me=Links&term='.urlencode($term).'&by='.urlencode($by).'&dir='.urlencode($dir).'&page=%PAGE%'),
				'sort_url' => GWF_WEB_ROOT.'index.php?mo=Lamb&me=Links&term='.urlencode($term).'&by=%BY%&dir=%DIR%&page='.$page,
		);
		
		return $module->template('links.tpl', $tVars);
	}
		
	private function formQuicksearch()
	{
		$data = array(
			'mo' => array(GWF_Form::HIDDEN, 'Lamb'),
			'me' => array(GWF_Form::HIDDEN, 'Links'),
			'term' => array(GWF_Form::STRING_NO_CHECK, '', $this->module->lang('th_term')),
			'quicksearch' => array(GWF_Form::SUBMIT, $this->module->lang('btn_quicksearch')),
		);
		return new GWF_Form($this, $data, GWF_Form::METHOD_GET);
	}
}
?>