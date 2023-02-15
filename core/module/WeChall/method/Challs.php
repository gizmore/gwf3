<?php

final class WeChall_Challs extends GWF_Method
{
	const DEFAULT_BY = 'chall_score';
	const DEFAULT_DIR = 'ASC';
	public function getHTAccess()
	{
		return
			'RewriteRule ^all_challs/?$ index.php?mo=WeChall&me=Challs&all=1'.PHP_EOL.
			'RewriteRule ^all_challs/([a-zA-Z0-9]+)$ index.php?mo=WeChall&me=Challs&tag=$1&all=1'.PHP_EOL.
			'RewriteRule ^all_challs/by/([^/]+)/([DEASC,]+)/page-(\d+)$ index.php?mo=WeChall&me=Challs&by=$1&dir=$2&page=$3&all=1'.PHP_EOL.
			'RewriteRule ^all_challs/by/page-(\d+)$ index.php?mo=WeChall&me=Challs&page=$1&all=1'.PHP_EOL.
			'RewriteRule ^all_challs/([a-zA-Z0-9]+)/by/page-(\d+)$ index.php?mo=WeChall&me=Challs&tag=$1&page=$2&all=1'.PHP_EOL.
			'RewriteRule ^all_challs/([a-zA-Z0-9]+)/by/([^/]+)/([DEASC,]+)/page-(\d+)$ index.php?mo=WeChall&me=Challs&tag=$1&by=$2&dir=$3&page=$4&all=1'.PHP_EOL.
			
			'RewriteRule ^challs/?$ index.php?mo=WeChall&me=Challs'.PHP_EOL.
			'RewriteRule ^challs/([a-zA-Z0-9]+)$ index.php?mo=WeChall&me=Challs&tag=$1'.PHP_EOL.
			'RewriteRule ^challs/by/([^/]+)/([DEASC,]+)/page-(\d+)$ index.php?mo=WeChall&me=Challs&by=$1&dir=$2&page=$3'.PHP_EOL.
			'RewriteRule ^challs/by/page-(\d+)$ index.php?mo=WeChall&me=Challs&page=$1'.PHP_EOL.
			'RewriteRule ^challs/([a-zA-Z0-9]+)/by/page-(\d+)$ index.php?mo=WeChall&me=Challs&tag=$1&page=$2'.PHP_EOL.
			'RewriteRule ^challs/([a-zA-Z0-9]+)/by/([^/]+)/([DEASC,]+)/page-(\d+)$ index.php?mo=WeChall&me=Challs&tag=$1&by=$2&dir=$3&page=$4'.PHP_EOL.
			'RewriteRule ^chall/solvers/(\d+)/[^/]+$ index.php?mo=WeChall&me=Challs&solvers=$1'.PHP_EOL.
			'RewriteRule ^chall/solvers/(\d+)/[^/]/by/([^/]+)/([DEASC,]+)/page-(\d+)$ index.php?mo=WeChall&me=Challs&solvers=$1&by=$2&dir=$3&page=$4'.PHP_EOL.

			'RewriteRule ^solved_challs/?$ index.php?mo=WeChall&me=Challs&filter=solved'.PHP_EOL.
			'RewriteRule ^solved_challs/([a-zA-Z0-9]+)$ index.php?mo=WeChall&me=Challs&tag=$1&filter=solved'.PHP_EOL.
			'RewriteRule ^solved_challs/by/([^/]+)/([DEASC,]+)/page-(\d+)$ index.php?mo=WeChall&me=Challs&by=$1&dir=$2&page=$3&filter=solved'.PHP_EOL.
			'RewriteRule ^solved_challs/by/page-(\d+)$ index.php?mo=WeChall&me=Challs&page=$1&filter=solved'.PHP_EOL.
			'RewriteRule ^solved_challs/([a-zA-Z0-9]+)/by/page-(\d+)$ index.php?mo=WeChall&me=Challs&tag=$1&page=$2&filter=solved'.PHP_EOL.
			'RewriteRule ^solved_challs/([a-zA-Z0-9]+)/by/([^/]+)/([DEASC,]+)/page-(\d+)$ index.php?mo=WeChall&me=Challs&tag=$1&by=$2&dir=$3&page=$4&filter=solved'.PHP_EOL.
			
			'RewriteRule ^open_challs/?$ index.php?mo=WeChall&me=Challs&filter=open'.PHP_EOL.
			'RewriteRule ^open_challs/([a-zA-Z0-9]+)$ index.php?mo=WeChall&me=Challs&tag=$1&filter=open'.PHP_EOL.
			'RewriteRule ^open_challs/by/([^/]+)/([DEASC,]+)/page-(\d+)$ index.php?mo=WeChall&me=Challs&by=$1&dir=$2&page=$3&filter=open'.PHP_EOL.
			'RewriteRule ^open_challs/by/page-(\d+)$ index.php?mo=WeChall&me=Challs&page=$1&filter=open'.PHP_EOL.
			'RewriteRule ^open_challs/([a-zA-Z0-9]+)/by/page-(\d+)$ index.php?mo=WeChall&me=Challs&tag=$1&page=$2&filter=open'.PHP_EOL.
			'RewriteRule ^open_challs/([a-zA-Z0-9]+)/by/([^/]+)/([DEASC,]+)/page-(\d+)$ index.php?mo=WeChall&me=Challs&tag=$1&by=$2&dir=$3&page=$4&filter=open'.PHP_EOL.
			'';
	}
	
	public function execute()
	{
		Module_WeChall::includeForums();
		
		if (false !== ($cid = Common::getGet('solver'))) {
			return $this->templateSolvers($cid);
		}
		
		WC_HTML::$RIGHT_PANEL = WC_HTML::$LEFT_PANEL = -1;
		
		$for_userid = GWF_Session::getUserID();
		$from_userid = false;
		$tag = Common::getGetString('tag', '');
		$by = $_GET['by'] = Common::getGetString('by', self::DEFAULT_BY);
		$dir = $_GET['dir'] =  Common::getGetString('dir', self::DEFAULT_DIR);
		return $this->templateChalls($for_userid, $from_userid, $tag, $by, $dir);
	}
	
	public function templateChalls($for_userid=false, $from_userid=false, $tag='', $by='', $dir='', $show_cloud=true, $show_empty=true, $show_colors=true)
	{
		require_once GWF_CORE_PATH.'module/WeChall/WC_ChallSolved.php';
		$challs = GDO::table('WC_Challenge');
		
		$for_userid = (int) $for_userid;
		$from_userid = (int) $from_userid;
		
		$solved_bits = $for_userid > 0 ? WC_ChallSolved::getSolvedForUser($for_userid, true) : array();
		if ((count($solved_bits) === 0) && (!$show_empty) && $from_userid === 0) {
			return '';
		}
		
		$solve_filter = Common::getGetString('filter', '');
		if ($solve_filter === 'solved' or $solve_filter == 'open')
		{
			$filter_prefix = $solve_filter.'_';
		} else {
			$filter_prefix = '';
		}
		
		$from_query = $from_userid === 0 ? '1' : "chall_creator LIKE '%,$from_userid,%'";
				 
		$conditions = "($from_query)";
		$all = !!Common::getGetString('all');
		if (!$all)
		{
			$conditions .= " AND chall_score > 0";
		}
		if (0 === ($count = $challs->countRows($conditions))) {
			return 'No Data';
		}
		
		$orderby = $challs->getMultiOrderby($by, $dir);
		$tag_2 = $tag == '' ? '' : $tag.'/';
		
		$this->setPageDescr($for_userid, $from_userid, $tag, $count);
		
		$sort_url = 'challs/'.$tag_2.'by/'.$by.'/'.$dir.'/page-1';
		
		$tVars = array(
			'filter_prefix' => $filter_prefix,
			'sort_url' => GWF_WEB_ROOT.$filter_prefix.'challs/'.$tag_2.'by/%BY%/%DIR%/page-1',
			'challs' => $challs->selectObjects('*', $conditions, $orderby),
			'tags' => $show_cloud ? $this->getTags() : '',
			'solved_bits' => $solved_bits,
			'table_title' => $this->getTableTitle($for_userid, $from_userid, $tag, $count),
			'tag' => $tag,
			'by' => $by,
			'dir' => $dir,
			'href_all' => GWF_WEB_ROOT.'all_'.$sort_url.'?all=1',
			'href_scored' => GWF_WEB_ROOT.$sort_url,
			'href_browse' => GWF_WEB_ROOT.'challenge',
			'href_solved' => GWF_WEB_ROOT.'solved_'.$sort_url,
			'href_unsolved' => GWF_WEB_ROOT.'open_'.$sort_url,
			'sel_scored' => $solve_filter === '' && (!$all),
			'sel_all' => $all,
			'sel_solved' => $solve_filter === 'solved',
			'sel_unsolved' => $solve_filter === 'open',
			'show_colors' => $show_colors,
		);
		return $this->module->templatePHP('challs.php', $tVars);
	}
	
	private function getTableTitle($for_userid, $from_userid, $tag, $challcount)
	{
		$module = Module_WeChall::instance();
		$dtag = GWF_HTML::display($tag);
		if ($for_userid != 0)
		{
			return $module->lang('tt_challs_for', array($dtag, GWF_User::getByIDOrGuest($for_userid)->displayUsername()));
		}
		else if ($from_userid != 0)
		{
			return $module->lang('tt_challs_from', array($challcount, $dtag, GWF_User::getByIDOrGuest($from_userid)->displayUsername()));
		}
		else
		{
			return $module->lang('tt_challs', array($dtag));
		}
	}
	
	private function setPageDescr($for_userid, $from_userid, $tag, $challcount)
	{
		$dtag = GWF_HTML::display($tag);
		
		GWF_Website::setPageTitle($this->getTableTitle($for_userid, $from_userid, $tag, $challcount), false);
		
		if ($for_userid != 0) {
			$for_user = GWF_User::getByIDOrGuest($for_userid);
			$for_username = $for_user->displayUsername();
			GWF_Website::setMetaTags($this->module->lang('mt_challs_for', array($dtag, $for_username)), false);
			GWF_Website::setMetaDescr($this->module->lang('md_challs_for', array($dtag, $for_username)), false);
		}
		else if ($from_userid != 0) {
			$from_user = GWF_User::getByIDOrGuest($from_userid);
			$from_username = $from_user->displayUsername();
			GWF_Website::setMetaTags($this->module->lang('mt_challs_from', array($dtag, $from_username)), false);
			GWF_Website::setMetaDescr($this->module->lang('md_challs_from', array($dtag, $from_username)), false);
		}
		else {
			GWF_Website::setMetaTags($this->module->lang('mt_challs', array($dtag, GWF_HTML::display($tag))), false);
			GWF_Website::setMetaDescr($this->module->lang('md_challs', array($dtag, GWF_HTML::display($tag))), false);
		}
	}
	
	
	private function getTags()
	{
		$tags = explode(':', $this->module->cfgChallTags());
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
	public function templateSolvers($cid)
	{
		if (false === ($chall = WC_Challenge::getByID($cid))) {
			return $this->module->error('err_chall');
		}
	}
}

?>
