<?php
final class WeChall_WarboxDetails extends GWF_Method
{
	/**
	 * @var WC_Warbox
	 */
	private $box;
	
	public function isCSRFProtected() { return false; }
	
	public function getHTAccess()
	{
		return 'RewriteRule ^(\d+)-levels-on- /index.php?mo=WeChall&me=WarboxDetails&boxid=$1'.PHP_EOL;
	}
	
	public function execute()
	{
		if (isset($_POST['wc_boxes_quickjump']))
		{
			$_GET['boxid'] = Common::getPostString('wc_boxes_quickjump');
		}
		
		$this->module->includeClass('WC_Warbox');
		$this->module->includeClass('WC_Warflag');
		$this->module->includeClass('WC_Warflags');
		$this->module->includeClass('WC_SiteDescr');
		$this->module->includeClass('sites/warbox/WCSite_WARBOX');
		
		if (false === ($this->box = WC_Warbox::getByID(Common::getGetString('boxid'))))
		{
			return $this->module->error('err_warboxa', array(GWF_HTML::display(Common::getGetString('boxid'))));
		}
		
		if ('' !== ($answer = Common::getPostString('password_solution', '')))
		{
			return $this->onSolve($answer) . $this->templateLevels();
		}
		
		return $this->templateLevels();
	}
	
	private function onSolve($answer)
	{
		if (false === ($flag = WC_Warflag::getByWarboxAndID($this->box, Common::getPostString('wfid'))))
		{
			return $this->module->error('err_warflag');
		}
		
		if (false === ($solver = $this->module->getMethod('Warsolve')))
		{
			return GWF_HTML::err('ERR_METHOD_MISSING', array('Warsolve', 'WeChall'));
		}

		$solver instanceof WeChall_Warsolve;
		return $solver->onAnswer($flag, $answer);
	}

	private function templateLevels()
	{
		$bid = $this->box->getID();
		
		$_GET['sid'] = $this->box->getSiteID();
		$_GET['bid'] = $bid;
		
		$tVars = array(
			'site_quickjump' => $this->module->templateSiteQuickjump('boxdetail'),
			'data' => $this->getData(),
			'box' => $this->box,
			'site' => $this->box->getSite(),
			'method' => $this,
			'sort_url' => GWF_WEB_ROOT.'index.php?mo=WeChall&me=WarboxDetails&boxid='.$bid.'&by=%BY%&dir=%DIR%',
		);
		return $this->module->templatePHP('warbox_details.php', $tVars);
	}
	
	private function getData()
	{
		$table = GDO::table('WC_Warflags');
		$by = Common::getGetString('by', 'wf_order');
		$dir = Common::getGetString('dir', 'ASC');
		$orderby = $table->getMultiOrderby($by, $dir);
		return WC_Warflag::getForBoxAndUser($this->box, GWF_User::getStaticOrGuest(), $orderby);
	}
}
