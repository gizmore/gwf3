<?php
final class Slay_Key
{
	public static function data()
	{
		$data = array();
		$data[] = array(NULL, GWF_Module::getModule('Slaytags')->lang('th_key'));
		foreach (Slay_Song::$KEYS as $key)
		{
			$data[] = array($key, $key);
		}
		return $data;
	}
	
	public static function select($name)
	{
		$data = self::data();
		return GWF_Select::display($name, $data, Common::getGetString($name));
	}
	
	public static function validate($name, $value, $allow_blank)
	{
		if ($allow_blank && !$value)
		{
			return false;
		}
		
		if (in_array($value, Slay_Song::$KEYS, true))
		{
			return false;
		}
		
		unset($_POST[$name]);
		
		return GWF_Module::getModule('Slaytags')->lang('err_key');
	}
}
