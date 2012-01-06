<?php
final class Language_Edit extends GWF_Method
{
	public function getUserGroups() { return GWF_Group::STAFF; }
	
	public function execute(GWF_Module $module)
	{
		return GWF_Language::getCurrentISO();
	}
}
?>