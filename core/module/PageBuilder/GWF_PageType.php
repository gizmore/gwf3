<?php
/**
 * Page type select.
 * @author gizmore
 */
final class GWF_PageType
{
	public static function select(Module_PageBuilder $module, $sel=true)
	{
		$sel = $sel === true ? Common::getPostString('type', '0') : $sel;
		$data = array(array('0', $module->lang('sel_type')));
		if ($module->isAuthor(GWF_User::getStaticOrGuest()))
		{
			$data[] = array(GWF_Page::SMARTY, $module->lang('type_smarty'));
			$data[] = array(GWF_Page::HTML, $module->lang('type_html'));
		}
		else
		{
			$sel = GWF_Page::BBCODE;
		}
		$data[] = array(GWF_Page::BBCODE, $module->lang('type_bbcode'));
		return GWF_Select::display('type', $data, $sel);
	}
	
	public static function validateType(Module_PageBuilder $m, $arg, $locked_mode)
	{
		switch ($arg)
		{
			case GWF_Page::SMARTY:
			case GWF_Page::HTML:
				if ($m->isAuthor(GWF_User::getStaticOrGuest()))
				{
					return false;
				}
				break;
			case GWF_Page::BBCODE: return false;
			default: break;
		}
		return $m->lang('err_type');
	}
}
?>
