<?php
final class GWF_LangSwitch
{
	public static function select($name='lang_switch')
	{
		$current = GWF_Language::getCurrentLanguage();
		$langs = GWF_Language::getSupported();

		$data = array();

		foreach ($langs as $lang)
		{
			$lang instanceof GWF_Language;
			$data[] = array($lang->getISO(), $lang->getVar('lang_name'));
		}

		return GWF_Select::display($name, $data, $current->getISO(), self::getOnChange());
	}

	public static function getOnChange()
	{
		# TODO: Use GWF_DOMAIN?
		if (isset($_SERVER['HTTP_HOST']) === false)
		{
			return '';
		}
		$current_url = htmlspecialchars(GWF_Session::getCurrentURL(), ENT_QUOTES);
		$url = Common::getProtocol().'://'.$_SERVER['HTTP_HOST'].'/';
		return 'window.location = \''.$url.'\'+this.value+\''.$current_url.'\'; return true;';
	}
}
