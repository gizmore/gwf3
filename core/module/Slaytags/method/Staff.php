<?php
/**
 * Staff methods:
 * 1) RenameTag (Rename a tag)
 * 2) AccpetTag (accept a tag from a slayer and allow him to create more)
 * 3) MergeTags (Merge two tags)
 * @author gizmore
 *
 */
final class Slaytags_Staff extends GWF_Method
{
	public function execute()
	{
		if (isset($_POST['rename_tag']))
		{
			return $this->onRenameTag().$this->templateStaff();
		}
		
		if (isset($_POST['accept_tag']))
		{
			return $this->onAcceptTag().$this->templateStaff();
		}
		
		return $this->templateStaff();
	}
	
	private function formRenameTag()
	{
		
	}	
	
	private function formAcceptTag()
	{
		
	}	
	
	private function templateStaff()
	{
		$formRenameTag = $this->formRenameTag();
		$formAcceptTag = $this->formAcceptTag();
		
		$tVars = array(
		);
		return $this->module->template('staff.tpl', $tVars);
	}
	
}
?>