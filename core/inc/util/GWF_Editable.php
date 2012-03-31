<?php
/**
 * Interface that allows auto form creation to edit GDO rows.
 * @author gizmore
 */
interface GWF_Editable
{
	public function getEditableFields(GWF_User $user);  # return array(col),
	public function getEditableFormData(GWF_User $user); # return GWF_Form input array
	public function getEditableActions(GWF_User $user); # return array(string)
}
