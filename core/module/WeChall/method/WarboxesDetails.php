<?php
final class WeChall_WarboxesDetails extends GWF_Method
{
	/**
	 * @var WC_Site
	 */
	private $site;
	
	private $boxes;
	
	public function getHTAccess()
	{
		return 'RewriteRule ^(\d+)-wargames-on- /index.php?mo=WeChall&me=WarboxesDetails&siteid=$1'.PHP_EOL;
	}
	
	public function execute()
	{
		if (false === ($this->site = WC_Site::getByID(Common::getGetString('siteid'))))
		{
			return $this->module->error('err_site');
		}
		
		return $this->templateBoxes();
	}
	
	private function templateBoxes()
	{
		$this->module->includeClass('WC_Warbox');
		$this->module->includeClass('WC_Warflag');
		$this->module->includeClass('WC_SiteDescr');
		
		$sid = $this->site->getID();
		
		$_GET['sid'] = $sid;
		$_GET['bid'] = 0;
		
		$table = GDO::table('WC_Warbox');
		
		$by = Common::getGetString('by');
		$dir = Common::getGetString('dir');
		
		$orderby = $table->getMultiOrderby($by, $dir);
		
		$tVars = array(
			'site_quickjump' => $this->module->templateSiteQuickjump('boxdetails'),
			'boxes' => WC_Warbox::getBoxes($this->site, $orderby),
			'site' => $this->site,
			'sort_url' => GWF_WEB_ROOT.'index.php?mo=WeChall&me=WarboxesDetails&by=%BY%&dir=%DIR%&siteid='.$sid,
		);
		return $this->module->templatePHP('warboxes_details.php', $tVars);
	}
}	
?>
