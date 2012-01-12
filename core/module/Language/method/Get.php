<?php

final class Language_Get extends GWF_Method
{
	public function execute()
	{
		return GWF_Language::getCurrentISO();
	}
}

?>