<?php
final class Konzert_Kontakt extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^kontakt.html$ index.php?mo=Contact&me=Form'.PHP_EOL;
	}
	
	public function execute()
	{
		return 'ERM';
	}
	
}
?>