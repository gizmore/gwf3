<?php
/**
 * Trigger a fatal error and a notice to test error mails.
 * @author gizmore
 */
final class GWF_TestErrors extends GWF_Method
{
	public function getUserGroups() { return GWF_Group::ADMIN; }
	
	public function execute()
	{
		echo $wurstbude; # Test Notice
		
		wurstbude_5(); # Test Fatal
	}
}
?>
