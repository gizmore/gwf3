<?php
/**
 * Interface to make GDO rows and tables searchable.
 * @author gizmore
 */
interface GWF_Searchable
{
	public function getSearchableActions(GWF_User $user);
	public function getSearchableFields(GWF_User $user);
	public function getSearchableFormData(GWF_User $user);
}
