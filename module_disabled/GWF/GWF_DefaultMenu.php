<?php

final class GWF_DefaultMenu
{
	private $translator = true;
	
	public static function translator()
	{
		static $translator = true;
		if ($translator === true)
		{
			$module = Module_GWF::instance();
			$translator = $module->onLoadLanguage();
		}
		return $translator;
	}
}