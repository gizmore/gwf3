<?php
/**
 * Helpdesk default titles and select
 * @author gizmore
 */
final class GWF_HelpdeskTitle
{
	public static function getTitles()
	{
		return GWF_Module::getModule('Helpdesk')->lang('titles');
	}
	
	public static function select($name, $selected)
	{
		$data = array();
		foreach (self::getTitles() as $key => $text)
		{
			$data[] = array($key, $text);
		}
		return GWF_Select::display($name, $data, $selected);
	}
	
	
	public static function validate_title(Module_Helpdesk $m, $arg)
	{
		if ($arg === '0') {
			return $m->lang('err_title');
		}
		if ($arg === 'other') {
			return self::validate_other($m, Common::getPostString('other', ''));
		}
		$titles = self::getTitles();
		if (!isset($titles[$arg])) {
			return $m->lang('err_title');
		}
		return false;
	}
	
	public static function validate_other(Module_Helpdesk $m, $arg)
	{
		$len = GWF_String::strlen($arg);
		if ($len < 2) {
			return $m->lang('err_no_other');
		}
		$maxlen = $m->cfgMaxTitleLen();
		if ($len > $maxlen) {
			return $m->lang('err_other_len', array($maxlen));
		}
		return false;
	}
}
?>
