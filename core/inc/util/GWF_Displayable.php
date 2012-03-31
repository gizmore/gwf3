<?php
/**
 * Interface of Displayble GDO classes.
 * @deprecated
 * @author gizmore
 */
interface GWF_Displayable
{
	public function getDisplayableFields(GWF_User $user);
	public function displayColumn(GWF_Module $module, GWF_User $user, $col_name);
}
