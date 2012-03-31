<?php
/**
 * Interface that allows creating default add forms from GDO tables.
 * @author gizmore
 */
interface GWF_Addable
{
	public function getAddableFields(GWF_User $user); # return array(col),
	public function getAddableFormData(GWF_User $user); # return GWF_Form input array
	public function getAddableActions(GWF_User $user); # return array(string)
}
