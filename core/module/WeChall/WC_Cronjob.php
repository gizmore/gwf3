<?php
final class WC_Cronjob extends GWF_Cronjob
{
	public static function onCronjob(Module_WeChall $module)
	{

		require_once 'WC_API_Block.php';
		WC_API_Block::cleanup();
		
		require_once 'WC_SolutionBlock.php';
		WC_SolutionBlock::cleanup();

        require_once 'WC_OTW_Cronjob.php';
        (new WC_OTW_Cronjob())->run($module);
	}
}
