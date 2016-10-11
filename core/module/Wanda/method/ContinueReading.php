<?php
final class Wanda_ContinueReading extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^wanda/read/on/?$ index.php?mo=Wanda&me=ContinueReading'.PHP_EOL;
	}
	
	public function execute()
	{
	}
	
	
}