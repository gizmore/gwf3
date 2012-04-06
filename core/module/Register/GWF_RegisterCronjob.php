<?php
/**
 * Registration cronjob. Deletes old activation rows.
 * @author gizmore
 */
final class GWF_RegisterCronjob extends GWF_Cronjob
{
	public static function onCronjob(Module_Register $module)
	{
		self::start('Register');
		self::deleteOldActivations($module);
		self::end('Register');
	}
	
	private static function deleteOldActivations(Module_Register $module)
	{
		$cut = time() - $module->getActivationThreshold();
		
		self::log('Deleting user activations older than '.GWF_Time::displayTimestamp($cut));

		$table = new GWF_UserActivation(false);
		$result = $table->deleteWhere("timestamp<$cut");
		
		if (0 < ($nDeleted = $table->affectedRows($result)))
		{
			self::log(sprintf('Deleted %d old user activations.', $nDeleted));
		}
	}
}
?>