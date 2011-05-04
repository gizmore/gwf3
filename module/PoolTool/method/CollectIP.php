<?php
final class PoolTool_CollectIP extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^playray\.php$ index.php?mo=PoolTool&me=CollectIP&no_session=true'.PHP_EOL;
	}
	public function execute(GWF_Module $module)
	{
		PT_IP::collect(GWF_IP6::getIP(GWF_IP_QUICK, Common::getGet('ip', false)));
		die();
	}
}
?>