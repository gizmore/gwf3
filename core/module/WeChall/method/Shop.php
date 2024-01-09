<?php

final class WeChall_Shop extends GWF_Method
{
	public function getHTAccess()
	{
		return
		'RewriteRule ^shop/?$ index.php?mo=WeChall&me=Shop'.PHP_EOL;
	}
	
	public function execute()
	{
		GWF_Website::setPageTitle('Shop');
		GWF_Website::setMetaDescr('The WeChall spreadshop. Purchase some WeChall clothes and merchandize to support us!');
		return $this->templateShop();
	}
	
	public function templateShop()
	{
		return $this->module->templatePHP('shop.php', []);
	}
	
}
