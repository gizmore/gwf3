<?php
final class Slaytags_MyTags extends GWF_Method
{
	const IPP = 25;
	const BY = '';
	const DIR = '';
	
	public function isLoginRequired() { return true; }
	
	public function execute()
	{
		return $this->templateMyTags();
	}
	
	private function templateMyTags()
	{
		$user = GWF_Session::getUser();
		$uid = $user->getID();
		$table = GDO::table('Slay_Song');
		$joins = array('tagvotes');
		$where = "stv_uid={$uid}";
		
		$nItems = $table->selectVar('COUNT(DISTINCT(ss_id))', $where, '', $joins);
		$nPages = GWF_PageMenu::getPagecount(self::IPP, $nItems);
		$page = Common::clamp(Common::getGetInt('page'), 1, $nPages);
		
		$by = Common::getGetString('by', self::BY);
		$dir = Common::getGetString('dir', self::DIR);
		$orderby = $table->getMultiOrderby($by, $dir, false);
		
		$songs = $table->selectAll('DISTINCT(ss_id), t.*', $where, $orderby, $joins, self::IPP, GWF_PageMenu::getFrom($page, self::IPP), GDO::ARRAY_O);
		
		$tVars = array(
			'sort_url' => GWF_WEB_ROOT.'index.php?mo=Slaytags&me=MyTags&by=%BY%&dir=%DIR%&page=1',
			'pagemenu' => GWF_PageMenu::display($page, $nPages, GWF_WEB_ROOT.sprintf('index.php?mo=Slaytags&me=MyTags&by=%s&dir=%s&page=%%PAGE%%', urlencode($by), urlencode($dir))),
			'songs' => $songs,
		);
		return $this->module->template('mytags.tpl', $tVars);
	}
}
?>