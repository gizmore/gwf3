<?php

final class WeChall_Challs extends GWF_Method
{
	const DEFAULT_BY = 'chall_score,chall_date';
	const DEFAULT_DIR = 'ASC,ASC';
	public function getHTAccess(GWF_Module $module)
	{
		return
			'RewriteRule ^challs/?$ index.php?mo=WeChall&me=Challs'.PHP_EOL.
			'RewriteRule ^challs/([a-zA-Z0-9]+)$ index.php?mo=WeChall&me=Challs&tag=$1'.PHP_EOL.
			'RewriteRule ^challs/by/([^/]+)/([DEASC,]+)/page-(\d+)$ index.php?mo=WeChall&me=Challs&by=$1&dir=$2&page=$3'.PHP_EOL.
			'RewriteRule ^challs/by/page-(\d+)$ index.php?mo=WeChall&me=Challs&page=$1'.PHP_EOL.
			'RewriteRule ^challs/([a-zA-Z0-9]+)/by/page-(\d+)$ index.php?mo=WeChall&me=Challs&tag=$1&page=$2'.PHP_EOL.
			'RewriteRule ^challs/([a-zA-Z0-9]+)/by/([^/]+)/([DEASC,]+)/page-(\d+)$ index.php?mo=WeChall&me=Challs&tag=$1&by=$2&dir=$3&page=$4'.PHP_EOL.
			'RewriteRule ^chall/solvers/(\d+)/[^/]+$ index.php?mo=WeChall&me=Challs&solvers=$1'.PHP_EOL.
			'RewriteRule ^chall/solvers/(\d+)/[^/]/by/([^/]+)/([DEASC,]+)/page-(\d+)$ index.php?mo=WeChall&me=Challs&solvers=$1&by=$2&dir=$3&page=$4'.PHP_EOL.
			'';
	}
	
	public function execute(GWF_Module $module)
	{
		Module_WeChall::includeForums();
		
		if (false !== ($cid = Common::getGet('solver'))) {
			return $this->templateSolvers($module, $cid);
		}
		
		WC_HTML::$RIGHT_PANEL = WC_HTML::$LEFT_PANEL = -1;
		
		$for_userid = GWF_Session::getUserID();
		$from_userid = false;
		$tag = Common::getGetString('tag', '');
		$by = Common::getGetString('by', self::DEFAULT_BY);
		$dir = Common::getGetString('dir', self::DEFAULT_DIR);
		return $this->templateChalls($module, $for_userid, $from_userid, $tag, $by, $dir);
	}
	
	public function templateChalls(Module_WeChall $module, $for_userid=false, $from_userid=false, $tag='', $by='', $dir='', $show_cloud=true, $show_empty=true)
	{
		require_once GWF_CORE_PATH.'module/WeChall/WC_ChallSolved.php';
		$challs = GDO::table('WC_Challenge');
		
		$for_userid = (int) $for_userid;
		$from_userid = (int) $from_userid;
		
		$solved_bits = $for_userid > 0 ? WC_ChallSolved::getSolvedForUser($for_userid, true) : array();
		if ((count($solved_bits) === 0) && (!$show_empty) && $from_userid === 0) {
			return '';
		}
		
		$from_query = $from_userid === 0 ? '1' : "chall_creator LIKE '%,$from_userid,%'";
		$tag_query = $tag == '' ? '1' : "chall_tags LIKE '%,".GDO::escape($tag)."%'";
		$conditions = "($from_query) AND ($tag_query)";
//		var_dump($conditions);
		if (0 === ($count = $challs->countRows($conditions))) {
			return '';
		}
		
		$orderby = $challs->getMultiOrderby($by, $dir);
		
		$this->setPageDescr($module, $for_userid, $from_userid, $tag, $count);
		
		$tag_2 = $tag == '' ? '' : $tag.'/';
		$tVars = array(
			'sort_url' => GWF_WEB_ROOT.'challs/'.$tag_2.'by/%BY%/%DIR%/page-1',
//			'challs' => $challs->select($conditions, $orderby),
			'challs' => $challs->selectObjects('*', $conditions, $orderby),
			'tags' => $show_cloud ? $this->getTags($module) : '',
			'solved_bits' => $solved_bits,
			'table_title' => $this->getTableTitle($module, $for_userid, $from_userid, $tag, $count),
			'by' => $by,
			'dir' => $dir,
		);
		return $module->templatePHP('challs.php', $tVars);
	}
	
	private function getTableTitle(Module_WeChall $module, $for_userid, $from_userid, $tag, $challcount)
	{
		$dtag = GWF_HTML::display($tag);
		if ($for_userid != 0) {
			return $module->lang('tt_challs_for', array($dtag, GWF_User::getByIDOrGuest($for_userid)->displayUsername()));
		} else if ($from_userid != 0) {
			return $module->lang('tt_challs_from', array($challcount, $dtag, GWF_User::getByIDOrGuest($from_userid)->displayUsername()));
		} else {
			return $module->lang('tt_challs', array($dtag));
		}
	}
	
	private function setPageDescr(Module_WeChall $module, $for_userid, $from_userid, $tag, $challcount)
	{
		$dtag = GWF_HTML::display($tag);
		
		GWF_Website::setPageTitle($this->getTableTitle($module, $for_userid, $from_userid, $tag, $challcount), false);
		
		if ($for_userid != 0) {
			$for_user = GWF_User::getByIDOrGuest($for_userid);
			$for_username = $for_user->displayUsername();
			GWF_Website::setMetaTags($module->lang('mt_challs_for', array($dtag, $for_username)), false);
			GWF_Website::setMetaDescr($module->lang('md_challs_for', array($dtag, $for_username)), false);
		}
		else if ($from_userid != 0) {
			$from_user = GWF_User::getByIDOrGuest($from_userid);
			$from_username = $from_user->displayUsername();
			GWF_Website::setMetaTags($module->lang('mt_challs_from', array($dtag, $from_username)), false);
			GWF_Website::setMetaDescr($module->lang('md_challs_from', array($dtag, $from_username)), false);
		}
		else {
			GWF_Website::setMetaTags($module->lang('mt_challs', array($dtag, GWF_HTML::display($tag))), false);
			GWF_Website::setMetaDescr($module->lang('md_challs', array($dtag, GWF_HTML::display($tag))), false);
		}
	}
	
	
	private function getTags(Module_WeChall $module)
	{
		$tags = explode(':', $module->cfgChallTags());
		$back = array();
		foreach ($tags as $tag)
		{
			if ($tag === '') {
				continue;
			}
			$tag = explode('-', $tag);
			$back[$tag[0]] = intval($tag[1]);
		}
		return $back;
	}
	
	###############
	### Solvers ###
	###############
	public function templateSolvers(Module_WeChall $module, $cid)
	{
		if (false === ($chall = WC_Challenge::getByID($cid))) {
			return $module->error('err_chall');
		}
	}
}

?>