<?php
final class SR_Install
{
	public static $TABLES = array('SR_Item', 'SR_Party', 'SR_Player', 'SR_Quest', 'SR_Stats', 'SR_PlayerVar', 'SR_Bounty', 'SR_BountyStats', 'SR_BountyHistory', 'SR_KillProtect', 'SR_BazarItem', 'SR_BazarShop', 'SR_BazarHistory');
	public static function onInstall($dropTable=false)
	{
		Lamb_Log::logDebug(__METHOD__);
		foreach (self::$TABLES as $classname)
		{
			if (false !== ($table = GDO::table($classname)))
			{
				Lamb_Log::logDebug('SR_Install::onInstall('.$classname.')');
				$table->createTable($dropTable);
			}
		}
	}
}
?>