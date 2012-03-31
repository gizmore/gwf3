<?php
/**
 * Interface for sortable GDO classes.
 * @author gizmore
 */
interface GWF_Sortable extends GWF_Displayable
{
	public function getSortableDefaultBy(GWF_User $user); # return string
	public function getSortableDefaultDir(GWF_User $user); # return string
	public function getSortableFields(GWF_User $user); # return array(colnames)
}

