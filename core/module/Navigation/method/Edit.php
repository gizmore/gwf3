<?php
/**
 * @author spaceone
 * @todo GWF_Form, remove _GET
 * @todo JavaSchit
 */
class Navigation_Edit extends GWF_Method
{
	private $navigation;
	private $navigations;

	public function getUserGroups() { return array('admin', 'staff'); }
	
	public function getHTAccess() 
	{
		$back  = 'RewriteRule ^navigation/edit/([0-9]+)(?:/([A-Za-z\s]*))?$ index.php?mo=Navigation&me=Edit&nid=$1'.PHP_EOL;
		$back .= 'RewriteRule ^navigation/edit/([0-9]+)/(new|delete|hide|show|up|down)/([0-9]+)$ index.php?mo=Navigation&me=Edit&nid=$1&action=$2&id=$3'.PHP_EOL;

		return $back;
	}
	public function execute()
	{	
		$nid = Common::getGetInt('nid');
		$id = Common::getGetInt('id');

		$back = '';
		
		if (isset($_POST['editnavi']))
		{
			$back = $this->onEdit($this->module, $nid, $id);
		}
		
		$this->navigation = GWF_Navigation::getNavigation($nid);
		$this->navigations = GWF_Navigations::getByID($nid);
		
		return $back . $this->templateEdit();
	}
	
	public function onEdit(Module_Navigation $module, $nid, $id)
	{
		
	}
	
	public function editForm()
	{
		$nid; $id;
		$data = array(
//			'' => array(GWF_Form::, $default, $this->module->lang('th_')),
			'navis_name' => array(GWF_Form::STRING, $navis->getName(), $this->module->lang('th_')),
			'page_added[]' => array(GWF_Form::SSTRING, $default, $this->module->lang('th_')),
			'navi_deleted[]' => array(GWF_Form::SSTRING, $default, $this->module->lang('th_')),
			'navi_position[]' => array(GWF_Form::SSTRING, $default, $this->module->lang('th_')),
			'navi_options[]' => array(GWF_Form::CHECKBOX, $n->isOptionEnabled(GWF_Navigation::VISIBLE), $this->module->lang('th_visible')),
//			'btns' => array(GWF_Form::SUBMITS, $buttons),
		);
		return new GWF_Form($this, $data);
	}
	
	public function recalcPositions()
	{
		
	}
	
	public function onDelete($nid) { return GWF_Navigations::deleteNavigation($nid); }
	public function onHide($id) 
	{
		if(false === ($navigation = GWF_Navigation::getByID($id)))
		{
			return false;
		}
		if(!$navigation->isVisible())
		{
			return true;
		}

		return $navigation->saveOption(GWF_Navigation::ENABLE, false);
	}
	public function onShow($id)
	{
		if(false === ($navigation = GWF_Navigation::getByID($id)))
		{
			return false;
		}
		if($navigation->isVisible())
		{
			return true;
		}
		
		return $navigation->saveOption(GWF_Navigation::ENABLE);	
	}
	/**
	 * decrease position
	 * @param int $id
	 * @return boolean
	 */
	public function onUp($id)
	{
		$navigation = GWF_Navigation::getByID($id);
		$upid = $navigation->getID() - 1;
		
		if($upid <= 1 || false === ($up = GWF_Navigation::getByID($upid)))
			return false;
		if(false === $up->increase('navi_position'))
			return false;
		return $navigation->increase('navi_position', -1);
	}
	/**
	 * increase position
	 * @param int $id
	 * @return boolean
	 */
	public function onDown($id)
	{
		$navigation = GWF_Navigation::getByID($id);
		$upid = $navigation->getID() + 1;
		$up = GWF_Navigation::getByID($upid);
		if(false === $up->increase('navi_position', -1))
			return false;
		return $navigation->increase('navi_position');
	}

	public function templateEdit()
	{
		$pb = $this->navigations->isnotPB() ? 'GWF_NaviPage' : 'GWF_Page';
		
		$pages = GDO::table($pb);
		
		$tVars = array(
			'navigation' => $this->navigation,
			'navigations' => $this->navigations,
			'pages' => $pages->selectAll('page_id, page_url, page_title, page_cat, page_meta_desc, page_views, page_groups, page_options', 'page_options&'.GWF_Page::ENABLED, 'page_title', NULL, '-1', '-1', GDO::ARRAY_O),
			'sort_url' => NULL,
		);
		
		return $this->module->template('edit.tpl', $tVars);
	}

}
