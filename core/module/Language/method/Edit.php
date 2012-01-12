<?php
final class Language_Edit extends GWF_Method
{
	public function getUserGroups() { return GWF_Group::STAFF; }
	
	public function execute()
	{
		return GWF_Language::getCurrentISO();
	}
}
?>