<?php
// wechall.stats.2010.05.11.icons,nums.1,4,5.800.600.gizmore.jpg
// wechall.stats.1.month.2010.05.11.icons,nums.1,4,5.800.600.gizmore.jpg
// wechall.stats.2010.05.11.icons,nums.1,4,5..800.600.gizmore.vs.unhandled.jpg
// wechall.stats.1.month.2010.05.11.icons,nums.1,4,5.800.600.gizmore.vs.unhandled.jpg
/**
 * Statgraph img
 * @author gizmore
 */
final class WeChall_GraphStats extends GWF_Method
{
	const MIN_WIDTH = 320;  const MIN_HEIGHT = 240;
	const MAX_WIDTH = 1024; const MAX_HEIGHT = 768;
	
	public function getHTAccess(GWF_Module $module)
	{
		return 
//			'RewriteRule ^wechall\.stats\.(\d{4})\.(\d\d)\.(\d\d)\.\.([0-9,]*|all)\.(\d+)\.(\d+)\.([a-zA-Z_]+)\.jpg$ index.php?mo=WeChall&me=GraphStats&y=$1&m=$2&d=$3&opt=$4&sites=&w=$6&h=$7&user1=$8&no_session=true'.PHP_EOL.
			'RewriteRule ^wechall\.stats\.(\d{4})\.(\d\d)\.(\d\d)\.([a-z,]*)\.([0-9,]*|all)\.(\d+)\.(\d+)\.([^\.]+)\.jpg$ index.php?mo=WeChall&me=GraphStats&y=$1&m=$2&d=$3&opt=$4&sites=$5&w=$6&h=$7&user1=$8&no_session=true'.PHP_EOL.
			'RewriteRule ^wechall\.stats\.(\d+)\.month\.(\d{4})\.(\d\d)\.(\d\d)\.([a-z,]*)\.([0-9,]*|all)\.(\d+)\.(\d+)\.([^\.]+)\.jpg$ index.php?mo=WeChall&me=GraphStats&nm=$1&y=$2&m=$3&d=$4&opt=$5&sites=$6&w=$7&h=$8&user1=$9&no_session=true'.PHP_EOL.
			'RewriteRule ^wechall\.stats\.(\d{4})\.(\d\d)\.(\d\d)\.([a-z,]*)\.([0-9,]*|all)\.(\d+)\.(\d+)\.([^\.]+)\.vs\.([^\.]+)\.jpg$ index.php?mo=WeChall&me=GraphStats&y=$1&m=$2&d=$3&opt=$4&sites=$5&w=$6&h=$7&user1=$8&user2=$9&no_session=true'.PHP_EOL.
			'RewriteRule ^wechall\.stats\.(\d+)\.month\.(\d{4})\.(\d\d)\.(\d\d)\.([a-z,]*)\.([0-9,]*|all)\.(\d+)\.(\d+)\.([^\.]+)\.vs\.([^\.]+)\.jpg$ index.php?mo=WeChall&me=GraphStats&nm=$1&y=$2&m=$3&d=$4&opt=$5&sites=$6&w=$7&h=$8&user1=$9&user2=$10&no_session=true'.PHP_EOL;
	}
	
	private static $COLORS = array( 
		'ff0000', '880000', '00ff00', '008800', '0000ff', '000088',
		'ffff00', '888800', '00ffff', '008888', 'ff00ff', '880088',
		'ffffff', '888888', '000000',
	);
	private static $STYLES = array('solid', 'dashed', 'dotted');
	
	/**
	 * @var GWF_User
	 */
	private $user1;
	/**
	 * @var GWF_User
	 */
	private $user2;
	
	private $start;
	private $end;
	private $sites;
	
	private $withZoom = false;
	private $withIcons = false;
	private $withNumbers = false;
	
	private $width;
	private $height;
	
	
	public function execute(GWF_Module $module)
	{
//		var_dump($_GET);
		
		# POST wrapper
//		if (false !== Common::getPost('display')) {
//			$this->wrapPost($module);
//		}
		
		if (false !== ($error = $this->validate($module))) {
			return $error;
		}
		
		return $this->templateGraph($module);
	}
	
	private function validateDimension(Module_WeChall $module)
	{
		$this->width = Common::clamp(intval(Common::getGet('w', 0)), self::MIN_WIDTH, self::MAX_WIDTH);
		$this->height = Common::clamp(intval(Common::getGet('h', 0)), self::MIN_HEIGHT, self::MAX_HEIGHT);
	}
	

	private function validate(Module_WeChall $module)
	{
		$this->validateDimension($module);
		
		if (false === ($this->user1 = GWF_User::getByName(Common::getRequest('user1', '')))) {
			return GWF_HTML::err('ERR_UNKNOWN_USER');
		}
		if (false === ($this->user2 = GWF_User::getByName(Common::getRequest('user2', '')))) {
//			return GWF_HTML::err('ERR_UNKNOWN_USER');
		}
		
		// Check end date
		$this->end = sprintf('%04d%02d%02d', intval(Common::getGet('y',0), 10), intval(Common::getGet('m',0), 10), intval(Common::getGet('d',0), 10));
		if (!GWF_Time::isValidDate($this->end, false, GWF_Date::LEN_DAY)) {
			return $module->error('err_end_date');
		}

		// Check start date
		$regdate1 = $this->user1->getVar('user_regdate');
		$regdate2 = $this->user2 === false ? $regdate1 : $this->user2->getVar('user_regdate');
		$this->start = $regdate1 < $regdate2 ? $regdate1 : $regdate2;
		$this->start = substr($this->start, 0, GWF_Date::LEN_DAY);
		if (0 < ($nm = intval(Common::getGet('nm', 0)))) {
			$time = GWF_Time::getTimestamp($this->end);
			$time -= $nm * GWF_Time::ONE_MONTH;
			$time = GWF_Time::getDate(GWF_Date::LEN_DAY, $time);
			if ($time > $this->start) {
				$this->start = $time;
			}
		}
//		var_dump($this->start);

		// Check sites
		$sites = Common::getGetString('sites');
		if ($sites === 'all') {
			if ($this->user2 === false) {
				$this->sites = WC_Site::getLinkedSites($this->user1->getID());
			} else {
				$this->sites = WC_Site::getLinkedSitesVS2($this->user1->getID(), $this->user2->getID());
			}
			$temp = array();
			foreach ($this->sites as $site)
			{
				$temp[$site->getID()] = $site;
			}
			$this->sites = $temp;
			
		} else {
			$this->sites = array();
			$sites = explode(',', $sites);
			foreach ($sites as $siteid)
			{
//				var_dump($siteid);
				$siteid = intval(trim($siteid));
				if (false !== ($site = WC_Site::getByID($siteid))) {
					$this->sites[$siteid] = $site;
				}
			}
		}
//		if (count($this->sites) === 0) {
//			return $module->error('err_no_sites');
//		}
		
		// Options
		$opts = explode(',', Common::getGet('opt', ''));
		foreach ($opts as $opt) {
			$opt = trim($opt);
			if ($opt === 'icons') {
				$this->withIcons = true;
			} elseif ($opt === 'nums') {
				$this->withNumbers = true;
			} elseif ($opt === 'zoom') {
				$this->withZoom = true;
			}
			
		}
		
		// All ok
		return false;
	}
	
	private function getSites2()
	{
		$back = array();
		foreach ($this->sites as $site)
		{
			$site instanceof WC_Site;
			$back[] = $site->getID();
		}
//		var_dump($back);
		return $back;
	}

	private function templateGraph(Module_WeChall $module)
	{
		$sites2 = $this->getSites2();
		
//		echo 'User1';
//		var_dump($this->user1->displayUsername());
//		if ($this->user2 !== false) {
//			echo 'User2';
//			var_dump($this->user2->displayUsername());
//		}
//		echo 'Sites';
//		var_dump($sites2);
//		var_dump(sprintf('%d_%d_%d', Common::getGet('y'), Common::getGet('m'), Common::getGet('d')));
//		echo 'Start';
//		var_dump($this->start);
//		echo 'End';
//		var_dump($this->end);
//		echo 'Icons';
//		var_dump($this->withIcons);
//		echo 'Numbers';
//		var_dump($this->withNumbers);
		
		
		$dir = dirname(GWF_JPGRAPH_PATH).'/';
		require_once $dir.'jpgraph.php';
		require_once $dir.'jpgraph_date.php';
		require_once $dir.'jpgraph_line.php';
		require_once $dir.'jpgraph_plotline.php';
		
		$xdata = array();
		$ydata = array();
		$ylast = array();
		$maxperc = 0;
		
		$db = gdo_db();
		$uid1 = $this->user1->getVar('user_id');
		$uid2 = $this->user2 === false ? 0 : $this->user2->getVar('user_id');
//		$history = GWF_TABLE_PREFIX.'wc_user_history2';
		$start = GWF_Time::getTimestamp($this->start);
		$end = GWF_Time::getTimestamp($this->end) + GWF_Time::ONE_DAY;
		
		$no_data = true;
		
		$xdata[$uid1] = array();
		$ydata[$uid1] = array();
		$ylast[$uid1] = array();
		if ($uid2 === 0) {
			$where2 = '';
		}
		else {
			$where2 = " OR userhist_uid=$uid2";
			$xdata[$uid2] = array();
			$ydata[$uid2] = array();
			$ylast[$uid2] = array();
		}
		
		require_once GWF_CORE_PATH.'module/WeChall/WC_HistoryUser2.php';
		$history = GDO::table('WC_HistoryUser2');
		$where = "(userhist_uid=$uid1$where2) AND userhist_date BETWEEN $start AND $end";
		$orderby = 'userhist_date ASC';
		if (false === ($result = $history->select('userhist_uid, userhist_sid, userhist_percent, userhist_date', $where, $orderby)))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
//		$query = "SELECT userhist_uid, userhist_sid, userhist_percent, userhist_date FROM $history WHERE (userhist_uid=$uid1$where2) AND userhist_date BETWEEN $start AND $end ORDER BY userhist_date ASC";
//		if (false === ($result = $db->queryRead($query))) {
//			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
//		}
		
//		while (false !== ($row = $db->fetchRow($result)))
		while (false !== ($row = $history->fetch($result, GDO::ARRAY_N)))
		{
			$siteid = $row[1];
			if (!in_array($siteid, $sites2, true))
			{
				continue; // site not wanted in graph...
			}
			
			$userid = $row[0];
			$percent = $row[2] /100;
			$time = $row[3];
			
			if ($percent > $maxperc) {
				$maxperc = $percent;
			}
			
			if (!isset($xdata[$userid][$siteid])) {
				$xdata[$userid][$siteid] = array();
				$ydata[$userid][$siteid] = array();
				$ylast[$userid][$siteid] = 0;
//				$first[$siteid] = $percent;
				if (!$this->withZoom) {
					$xdata[$userid][$siteid][] = $start;
					$ydata[$userid][$siteid][] = $percent;
				}
			}
			
			$xdata[$userid][$siteid][] = $time;
			$ydata[$userid][$siteid][] = $percent;
			$ylast[$userid][$siteid] = $percent;
			$no_data = false;
		}
		
		if (!$this->withZoom) {
			foreach (array_keys($ydata[$uid1]) as $siteid)
			{
				$xdata[$uid1][$siteid][] = $end;
				$ydata[$uid1][$siteid][] = $ylast[$uid1][$siteid];
			}
			if (isset($ydata[$uid2]))
			{
				foreach (array_keys($ydata[$uid2]) as $siteid)
				{
					$xdata[$uid2][$siteid][] = $end;
					$ydata[$uid2][$siteid][] = $ylast[$uid2][$siteid];
				}
			}
		}
		
//		$xdata[$siteid][] = $end;
//		$ydata[$siteid][] = $percent;
//		$ylast[$siteid] = $percent;
		
//		foreach ($sites2 as $siteid)
//		{
//			$xdata[$siteid][] = $end;
//			$ydata[$siteid][] = isset($ylast[$siteid]) ;
//		}
		
		
		//define the graph
		$dateformat = "d.M.y";
		$datemargin = strlen(date($dateformat)) * 11; 
//		$graph = new Graph($module->cfgGraphWidth()*2, $module->cfgGraphHeight()*2);
		$graph = new Graph($this->width, $this->height);
		if ($no_data) {
			$graph->SetScale('textint', 0, 100, 0, 1);
		} else {
			$graph->SetScale('datlin', 0, 100);
			$graph->xaxis->scale->SetDateFormat($dateformat);
		}
		$graph->SetColor(array(238, 238, 238));
		$graph->SetMarginColor(array(208, 211, 237));
		$graph->title->Set($this->getGraphTitle($module));
		$graph->yaxis->title->Set($module->lang('percentage'));
		$graph->SetShadow();
		$graph->xaxis->SetLabelAngle(90);
		$graph->img->SetMargin(40, 170, 20, $datemargin);
//		$graph->img->SetMargin(40, 140, 0, $datemargin);
		$graph->legend->Pos(0.015, 0.05, "right", "top");
		
		$weights = array(
			$uid1 => 3,
			$uid2 => 1,
		);
		
		$labeled = array();
		
		//make a line for each site (and user)
		foreach ($ydata as $userid => $ydata2)
		{
			$curr_weight = $weights[$userid];
			foreach($ydata2 as $siteid => $data)
			{
	//			var_dump($data);
				if (!(isset($this->sites[$siteid]))) {
					continue;
				}
				$site = $this->sites[$siteid];
				$site instanceof WC_Site;
				$lineplot = new LinePlot($data, $xdata[$userid][$siteid]);
				list($color, $style) = $this->getColorAndStyle($site);
				$lineplot->SetStyle($style);
				$lineplot->SetColor($color);
				$lineplot->SetWeight($curr_weight);
				if($this->withNumbers) {
					$lineplot->value->Show();
				}
				if($this->withIcons) {
					$path = 'dbimg/logo_gif/' . $siteid.'.gif';
					if (is_readable($path)) {
						$lineplot->mark->SetType(MARK_IMG, $path, 0.5);
					}
				}
				
				if (!in_array($siteid, $labeled, true)) {
					$lineplot->SetLegend($site->getVar('site_name'));
					$labeled[] = $siteid;
				}
				$graph->Add($lineplot);
			}
		}
//		$graph->img->SetAntiAliasing();

		if ($no_data) {
			if (count($this->sites) === 0) {
				$text = $module->lang('err_no_sites');
			}
			else {
				$text = $module->lang('err_graph_empty');
			}
			
			$txt = new Text($text);
//			$txt->SetFont(FF_ARIAL,FS_NORMAL,18);
			$txt->SetColor("#0000ff");
			$txt->SetPos(0.45, 0.45, 'center', 'center');			
			$graph->AddText($txt);
		}
		
		$graph->Stroke();
		die();
	}
	
	private function getColorAndStyle(WC_Site $site)
	{
		static $inc = 0;
		static $used = array();
		
		$siteid = $site->getID();
		if (isset($used[$siteid])) {
			return $used[$siteid];
		}
		
		

		$nColors = count(self::$COLORS);
		
		$style = intval($inc / $nColors);
		$style = self::$STYLES[$style];
		
		$color = $site->getVar('site_color');
		if ($color === NULL) {
			$color = self::$COLORS[$inc%$nColors];
		}

		$inc++;
		
		$used[$siteid] = array('#'.$color, $style);
		
		return $used[$siteid];
	}
	
	private function getGraphTitle(Module_WeChall $module)
	{
		if ($this->user2 === false) {
			return $module->lang('pt_stats', array($this->user1->getVar('user_name')));
		} else {
			return $module->lang('pt_stats2', array($this->user1->getVar('user_name'), $this->user2->getVar('user_name')));
		}
	}
	
}
?>