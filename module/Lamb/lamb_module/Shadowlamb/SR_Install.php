<?php
final class SR_Install
{
	public static $TABLES = array('SR_Item', 'SR_Party', 'SR_Player', 'SR_Quest', 'SR_Stats', 'SR_PlayerVar');
	public static function onInstall($dropTable=false)
	{
		Lamb_Log::log('SR_Install::onInstall()');
		foreach (self::$TABLES as $classname)
		{
			if (false !== ($table = GDO::table($classname)))
			{
				Lamb_Log::log('SR_Install::onInstall('.$classname.')');
				$table->createTable($dropTable);
			}
		}
	}
}
?>