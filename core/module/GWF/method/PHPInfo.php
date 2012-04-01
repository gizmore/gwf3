<?php
/**
 * print out phpinfo()
 * 
 */
final class GWF_PHPInfo extends GWF_Method
{
	public function getUserGroups() { return array(GWF_Group::ADMIN); }
	
	public function execute()
	{
		$what = Common::getGetInt('what', INFO_ALL);
		phpinfo($what);
		die();
	}
}
