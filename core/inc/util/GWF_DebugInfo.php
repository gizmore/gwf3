<?php
class GWF_DebugInfo
{
	public static function getTimings($with_diskspace=true)
	{
		$t_sql = $queries = 0;
		if (false !== ($db = gdo_db()))
		{
			$t_sql = $db->getQueryTime();
			$queries = $db->getQueryCount();
		}
		$t_total = microtime(true) - GWF_DEBUG_TIME_START;
		$mem_total = memory_get_peak_usage(true);
		$mem_user = memory_get_peak_usage(false);

		$disk_total = $disk_free = 0;
		if ($with_diskspace)
		{
			$disk_free = disk_free_space(dirname(__FILE__));
			$disk_total = disk_total_space(dirname(__FILE__));
		}

		return array(
			'queries' => $queries,
			't_sql' => $t_sql,
			't_php' => $t_total - $t_sql,
			't_total' => $t_total,
			'mem_php' => $mem_total - $mem_user,
			'mem_user' => $mem_user,
			'mem_total' => $mem_total,
			'space_free' => $disk_free,
			'space_total' => $disk_total,
			'space_used' => $disk_total - $disk_free,
		);
	}
}
