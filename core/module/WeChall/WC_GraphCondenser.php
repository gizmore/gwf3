<?php
/**
 * Reduces the amount of graph entries.
 * Only the latest entry of each day (GWF_Date length 8/YYYYMMDD) is kept.
 * This is achieved by walking the entries by date descending.
 * 
 * User graphs only get reduced if they have more than 100 entries.
 * 
 * Performance could be improved by deleting chunks of entries, but it is planned to run this maybe twice a year.
 */
final class WC_GraphCondenser
{
	const USER_GRAPH_MIN = 100;
	
	#################
	### Statistic ###
	#################
	private $entriesBefore = 0;
	private $entriesAfter = 0;
	
	public function condenseResultText()
	{
		return "Condensed from $this->entriesBefore to $this->entriesAfter entries.";
	}

	###########
	### All ###
	###########
	public function condenseAllGraphs()
	{
		$this->condenseAllSiteGraphs();
		$this->condenseAllUserGraphs();
	}
	
	###################
	### Site graphs ###
	###################
	public function condenseAllSiteGraphs()
	{
		foreach (WC_Site::getSites() as $site)
		{
			$this->condenseSiteGraph($site);
		}
	}
	
	public function condenseSiteGraph(WC_Site $site)
	{
		Module_WeChall::instance()->includeClass('WC_HistorySite');
		
		$sid = $site->getID();
		$table = GDO::table('WC_HistorySite');
		$result = $table->select('sitehist_date', "sitehist_sid=$sid", "sitehist_date DESC");
		
		$lastday = null;
		while ($row = $table->fetch($result, GDO::ARRAY_N))
		{
			$this->entriesBefore++;
			
			$time = $row[0];
			$day = GWF_Time::getDate(8, $time);
			if ($lastday === $day)
			{
				$table->deleteWhere("sitehist_sid=$sid AND sitehist_date=$time");
			}
			else
			{
				$lastday = $day; # next day
				$this->entriesAfter++; # keep
			}
		}
		
		$table->free($result);
	}

	###################
	### User graphs ###
	###################
	public function condenseAllUserGraphs()
	{
		$table = GDO::table('GWF_User');
		$result = $table->select('user_id');
		while ($row = $table->fetch($result, GDO::ARRAY_N))
		{
			$this->condenseUserGraph($row[0]);
		}
	}
	
	public function condenseUserGraph($uid)
	{
		Module_WeChall::instance()->includeClass('WC_HistoryUser2');

		$table = GDO::table('WC_HistoryUser2');
		$result = $table->select('userhist_date', "userhist_uid=$uid", "userhist_date DESC");
		$size = $table->numRows($result);
		if ($size > self::USER_GRAPH_MIN)
		{
			$this->condenseUserGraphB($uid, $table, $result);
		}
		else
		{
			$this->entriesBefore += $size;
			$this->entriesAfter += $size;
		}
		$table->free($result);
	}
	
	private function condenseUserGraphB($uid, GDO $table, $result)
	{
		$lastday = null;
		while ($row = $table->fetch($result, GDO::ARRAY_N))
		{
			$this->entriesBefore++;
			
			$time = $row[0];
			$day = GWF_Time::getDate(8, $time);
			if ($lastday === $day)
			{
				$table->deleteWhere("userhist_uid=$uid AND userhist_date=$time");
			}
			else
			{
				$lastday = $day; # next day
				$this->entriesAfter++; # keep
			}
		}
	}
	
}
