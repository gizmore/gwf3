<?php

final class GWF_EditConfig extends GWF_Method
{
	public function execute(GWF_Module $module)
	{
		return $this->templateEdit($module);
	}
	
	private function templateEdit(Module_GWF $module)
	{
		$tVars = array();
		return $module->templatePHP('edit_config.php', $tVars);
	}
}

?>