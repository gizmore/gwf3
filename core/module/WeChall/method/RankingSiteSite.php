<?php
final class WeChall_RankingSiteSite extends GWF_Method
{
	public function execute()
	{
		$query = "SELECT regat_uid, SUM(`regat_score`) FROM $regat users WHERE ";
	}
}
?>