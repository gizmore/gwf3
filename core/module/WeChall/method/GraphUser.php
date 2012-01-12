<?php
/*
 * What we do is that we specify that the X-scale should be an ordinary "int" scale (remember that the data values are timestamps which are integers). We then install our custom label callback (with a call to  SetLabelFormatCallback()) which given a timestamp formats it to a suitable human readable form. In our example we will use the PHP function Date() for this purpose.

The callback we use will be
 
// The callback that converts timestamp to minutes and seconds
function  TimeCallback( $aVal) {
    return Date ('H:i:s',$aVal);
} 
 */

//function negation_callback_gu($var) { return round(-$var); }

/**
 * User Graphs;
 * Totalscore, Rank, OnsiteScore
 * @author gizmore
 *
 */
final class WeChall_GraphUser extends GWF_Method
{
	const IMAGE_TYPE = 'png';
	
//	private $max_rank;
//
//	public function inversion_callback($label)
//	{
//		return - $label;
//	}
	
	public function negation_callback($label)
	{
		return - $label;
	}
	
	public function getHTAccess()
	{
		return
			'RewriteRule ^graph/wc_totalscore\.([^/\.]+)\.'.self::IMAGE_TYPE.'$ index.php?mo=WeChall&me=GraphUser&username=$1&type=totalscore&no_session=true'.PHP_EOL.
			'RewriteRule ^graph/wc_totalscore\.([^/\.]+)\.vs\.([^/\.]+)\.'.self::IMAGE_TYPE.'$ index.php?mo=WeChall&me=GraphUser&username=$1&vs=$2&type=totalscore&no_session=true'.PHP_EOL.
			'RewriteRule ^graph/wc_rank\.([^/\.]+)\.'.self::IMAGE_TYPE.'$ index.php?mo=WeChall&me=GraphUser&username=$1&type=rank&no_session=true'.PHP_EOL.
			'RewriteRule ^graph/wc_rank\.([^/\.]+)\.vs\.([^/\.]+)\.'.self::IMAGE_TYPE.'$ index.php?mo=WeChall&me=GraphUser&username=$1&vs=$2&type=rank&no_session=true'.PHP_EOL.
			'';
	}
	
	public function execute()
	{
		GWF3::setConfig('store_last_url', false);
		
		if ('totalscore' === ($type = Common::getGet('type')))
		{
			return $this->graphUserLevel($this->_module, 'userhist_totalscore');
		}
		
		if ('rank' === ($type = Common::getGet('type')))
		{
			return $this->graphUserLevel($this->_module, 'userhist_rank');
		}
		
		return GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
	}
	
	private function graphError($msg)
	{
		die($msg);
	}
	
	private function graphUserLevel(Module_WeChall $module, $type)
	{
		$dir = dirname(GWF_JPGRAPH_PATH).'/';
		require_once $dir.'jpgraph.php';
		require_once $dir.'jpgraph_date.php';
		require_once $dir.'jpgraph_line.php';
		require_once $dir.'jpgraph_plotline.php';
		
		if (false === ($user = GWF_User::getByName(Common::getGet('username', '')))) {
			return $this->graphError(GWF_HTML::lang('ERR_UNKNOWN_USER'));
		}
		
		if (false !== ($vs = Common::getGet('vs'))) {
			$vs = GWF_User::getByName($vs);
		}
		
		$uh = GWF_TABLE_PREFIX.'wc_user_history2';
		
		switch ($type)
		{
			case 'userhist_rank': $type2 = 'rank'; break;
			case 'userhist_totalscore': $type2 = 'totalscore'; break;
			default: die('Unknown Type');
		}
		
		if ($vs === false) {
			$graphtitle = $this->_module->lang('alt_graph_'.$type2, array($user->displayUsername()));
		} else {
			$graphtitle = $this->_module->lang('alt_graph_'.$type2.'_vs', array($user->displayUsername(), $vs->displayUsername()));
		}
		
		$db = gdo_db();
		
		$uid = $user->getID();
		$query = "SELECT userhist_date,$type FROM $uh WHERE userhist_uid=$uid ORDER BY userhist_date ASC";
		if (false === ($result = $db->queryRead($query))) {
			die(GWF_HTML::lang('ERR_DATABASE', array(__FILE__, __LINE__)));
		}
		
		$invert = $type2 === 'rank';
		$highestValue = 0;
//		$lowestValue = 2111222333;
		$xdata = array();
		$ydata = array();
		
		if ($type2==='totalscore') {
			$xdata[] = GWF_Time::getTimestamp($user->getVar('user_regdate'));
			$ydata[] = 0;
//			$highestValue = 20;
		}
		elseif ($type2==='rank') {
			$xdata[] = GWF_Time::getTimestamp($user->getVar('user_regdate'));
			$ydata[] = 0;
//			$del = GWF_User::DELETED;
//			$ydata[] = -GDO::table('GWF_User')->countRows("user_options&$del=0");
//			$highestValue = -$ydata[0];
		}
		
		
		while (false !== ($row = $db->fetchRow($result)))
		{
			$time = intval($row[0]);
			$xdata[] = $time;
			
			$value = intval($row[1]);
			$ydata[] = $invert ? -$value : $value;
			$highestValue = $value > $highestValue ? $value : $highestValue;
//			$lowestValue = $value < $lowestValue ? $value : $lowestValue;
		}
		$db->free($result);
		
		
		// Now the Opponent
		if ($vs !== false)
		{
			$uid2 = $vs->getID();
			$query = "SELECT userhist_date,$type FROM $uh WHERE userhist_uid=$uid2 ORDER BY userhist_date ASC";
			if (false === ($result = $db->queryRead($query))) {
				die(GWF_HTML::lang('ERR_DATABASE', array(__FILE__, __LINE__)));
			}
			
			$xdata2 = array();
			$ydata2 = array();
			if ($type2==='totalscore') {
				$xdata2[] = GWF_Time::getTimestamp($vs->getVar('user_regdate'));
				$ydata2[] = 0;
			}
			elseif ($type2==='rank') {
				$xdata2[] = GWF_Time::getTimestamp($vs->getVar('user_regdate'));
				$ydata2[] = 0;
//				$del = GWF_User::DELETED;
//				$ydata2[] = GDO::table('GWF_User')->countRows("user_options&$del=0");
//				$highestValue = -$ydata2[0];
			}
			
			while (false !== ($row = $db->fetchRow($result)))
			{
				$time = intval($row[0]);
				$xdata2[] = $time;
				
				$value = intval($row[1]);
				$highestValue = $value > $highestValue ? $value : $highestValue;
//				$lowestValue = $value < $lowestValue ? $value : $lowestValue;
				$ydata2[] = $invert ? -$value : $value;
			}
			
			$db->free($result);
		}
		
		if ($type2==='rank')
		{
			$ydata[0] = -$highestValue;
			$ydata2[0] = -$highestValue;
		}		

//		$this->max_rank = $highestValue;
		
		$dateformat = "M.y";
		$datemargin = strlen(date($dateformat)) * 11; 

		//define the graph
		$graph = new Graph($this->_module->cfgGraphWidth(), $this->_module->cfgGraphHeight());
		if ($invert) {
			$graph->SetScale('datlin', -$highestValue, -1);
		}
		else {
			$graph->SetScale('datlin', 0, 1.05 * $highestValue);
		}
		
		$graph->title->Set($graphtitle);
//		$graph->title->SetFont(FF_ARIAL, FS_NORMAL, 12);
		$graph->SetColor(array(238, 238, 238));
		$graph->SetMarginColor(array(208, 211, 237));
		$graph->SetShadow();
		$graph->xaxis->SetLabelAngle(90);
//		$graph->xaxis->SetTickPositions($xticks, NULL, $xdataarray);
		$graph->xaxis->scale->SetDateFormat($dateformat);
		$graph->img->SetMargin(50, 40, 40, $datemargin);
		$graph->legend->Pos(0.011, 0.005, "right", "top");
				
		# Add plots
		$lineplot = new LinePlot($ydata, $xdata);
		$lineplot->SetColor("blue");
		$lineplot->SetWeight(2);
		$lineplot->SetLegend($user->getVar('user_name'));
		$graph->Add($lineplot);
		
		if ($vs !== false)
		{
			$lineplot = new LinePlot($ydata2, $xdata2);
			$lineplot->SetColor("red");
			$lineplot->SetWeight(2);
			$lineplot->SetLegend($vs->getVar('user_name'));
			$graph->Add($lineplot);
		}


		if ($invert) {
			$graph->yaxis->SetLabelFormatCallback(array($this, 'negation_callback'));
			$graph->xaxis->SetLabelSide(SIDE_DOWN);
			$graph->xaxis->setPos('min');
//			$graph->yaxis->SetValueFormatCallback(array($this, 'negation_callback'));
		}
		
		GWF_HTTP::noCache();
		
		// Display the graph
//		$graph->img->SetAntiAliasing();
		$graph->Stroke();
		die();
	}
	
}

?>