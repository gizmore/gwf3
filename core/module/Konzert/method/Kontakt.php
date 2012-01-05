<?php
final class Konzert_Kontakt extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^kontakt.html$ index.php?mo=Contact&me=Form'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		return 'ERM';
	}
	
}
?>