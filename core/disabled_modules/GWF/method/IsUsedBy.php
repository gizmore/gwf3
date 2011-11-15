<?php

final class GWF_IsUsedBy extends GWF_Method
{
	public function execute(GWF_Module $module)
	{
		$tVars = array(
		);
		return $this->templatePHP('is_used_by.php', $tVars);
	}
	
}

?>