<?php
/**
 * Display a Navigation
 * @author spaceone
 */
final class Navigation_Show extends GWF_Method
{
	protected $_tpl = 'show.tpl';

	/** @todo rethink */
	public function stylesheet($path) { GWF_Website::addCSS(GWF_WEB_ROOT.$path); return $this; }

	public function execute()
	{
		$name = Common::getPostString('navigation', 'PageMenu');

		if(false === ($navi = $this->getNavigation(GWF_Navigations::getIdByName($name))))
		{
			GWF_HTML::error('');
			$navi = array();
		}
		$tVars = array(
			'navi' => $navi,
		);
		return $this->templateShow($this->_tpl, $tVars);
	}

	/** @todo recursion ____? */
	private function templateShow($template, $tVars=array()) 
	{
		$tVars['show'] = $this;
		return $this->module->template($template, $tVars);
	}

	/** @return array|false */
	private function getNavigation($id)
	{
		if(false === ($navis = GWF_Navigations::getById($id)))
		{
			return false;
		}
		$nsid = $navis->getID();

		$pb = $navis->isnotPB() ? 'navi_vars' : 'navi_pbvars';
		$cols = 't.*, page_id, page_url, page_title, page_lang, page_cat, page_meta_desc, page_views, page_groups, page_options';
		$t = GDO::table('GWF_Navigation');
		$navi = $t->selectAll($cols, "navi_nid={$nsid} AND page_groups != 'TODO' AND page_options&".GWF_Page::ENABLED, 'navi_position', array($pb), '-1', '-1', GDO::ARRAY_O);

		$navi['category_name'] = $navis->getName();

		$navi['subs'] = NULL;
		if (false !== ($subs = $navis->selectAll('navis_id', 'navis_pid='.$nsid/*TODO:, 'position'*/) && count($subs)))
		{
			$navi['subs'] = array();
			foreach ($subs as $sub)
			{
				if (false !== ($sn = $this->getNavigation($sub['navis_id'])))
				{
					$navi['subs'][] = $sn;
				}
				else
				{
					GWF_HTML::error('');
				}
			}
		}

		return $navi;
	}

	/**
	 * each subnavi will beginn with an underscore
	 * needet for recursion
	 * @param array $navi a subnavigation
	 */
	public function display(array $navi) { return $this->templateShow("_{$this->_tpl}", array('navi' => $navi)); }
}
