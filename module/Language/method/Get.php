<?php

final class Language_Get extends GWF_Method
{
	public function execute(GWF_Module $module)
	{
		return GWF_Language::getCurrentISO();
	}
}

?>