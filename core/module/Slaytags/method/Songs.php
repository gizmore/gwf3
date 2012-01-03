<?php
final class Slaytags_Songs extends GWF_Method
{
	const IPP = 25;
	const BY = 'ss_id';
	const DIR = 'ASC';
	
	public function execute(GWF_Module $module)
	{
		return $this->templateSongs($module);
	}
	
	private function templateSongs(Module_Slaytags $module)
	{
//		$user = GWF_Session::getUser();
//		$uid = $user->getID();
		$table = GDO::table('Slay_Song');
		$joins = NULL;
		
		$headers = array();
		$headers[] = array($module->lang('th_artist'), 'ss_artist');
		$headers[] = array($module->lang('th_title'), 'ss_title');
		$headers[] = array($module->lang('th_duration'), 'ss_duration');
		$headers[] = array($module->lang('D'));
		$headers[] = array($module->lang('L'));
		$headers[] = array($module->lang('T'));
		$headers[] = array($module->lang('th_tags'));
		
		$where = "";
		
		
		
		$nItems = $table->selectVar('COUNT(ss_id)', $where, '', $joins);
		$nPages = GWF_PageMenu::getPagecount(self::IPP, $nItems);
		$page = Common::clamp(Common::getGetInt('page'), 1, $nPages);
		
		$by = Common::getGetString('by', self::BY);
		$dir = Common::getGetString('dir', self::DIR);
		$orderby = $table->getMultiOrderby($by, $dir, false);
		
		$songs = $table->selectAll('*', $where, $orderby, $joins, self::IPP, GWF_PageMenu::getFrom($page, self::IPP), GDO::ARRAY_O);
		
		$tVars = array(
			'sort_url' => GWF_WEB_ROOT.'index.php?mo=Slaytags&me=Songs&by=%BY%&dir=%DIR%&page=1',
			'pagemenu' => GWF_PageMenu::display($page, $nPages, GWF_WEB_ROOT.sprintf('index.php?mo=Slaytags&me=Songs&by=%s&dir=%s&page=%%PAGE%%', urlencode($by), urlencode($dir))),
			'songs' => $songs,
			'headers' => $headers,
		);
		return $module->template('songs.tpl', $tVars);
	}
}
?>