<?php

class GWF_DebugInfo {

	#####################
	### Debug Timings ###
	#####################
	public static function getTimings()
	{
		$db = gdo_db();
		$t_sql = $db->getQueryTime();
		$t_total = microtime(true) - GWF_DEBUG_TIME_START;
		$mem_total = memory_get_peak_usage(true);
		$mem_user = memory_get_peak_usage(false);
		return array(
			'queries' => $db->getQueryCount(),
			't_sql' => $t_sql,
			't_php' => $t_total - $t_sql,
			't_total' => $t_total,
			'mem_php' => $mem_total - $mem_user,
			'mem_user' => $mem_user,
			'mem_total' => $mem_total,
			'space_free' => disk_free_space(__FILE__),
			'space_total' => disk_total_space(__FILE__),
			'space_used' => (disk_total_space(__FILE__) - disk_free_space(__FILE__)),
		);
	}
	
}

?>
