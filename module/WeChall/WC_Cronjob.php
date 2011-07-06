<?php
final class WC_Cronjob extends GWF_Cronjob
{
	public static function onCronjob(Module_WeChall $module)
	{
		require_once 'core/module/WeChall/WC_API_Block.php';
		WC_API_Block::cleanup();
		
		require_once 'core/module/WeChall/WC_SolutionBlock.php';
		WC_SolutionBlock::cleanup();
	}
}
?>