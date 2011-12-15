<?php
GWF_File::filewalker(GWF_CORE_PATH.'module/Audit/challs', 'cron_challs', true);
function cron_challs($entry, $fullpath, $args=NULL)
{
	if ($entry === 'cronjob.php')
	{
		require_once $fullpath;
	}
}
?>