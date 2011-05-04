<?php
final class GWF_CategorySelect
{
	public static function single($name, $selected, $parent_id=0)
	{
		
		$data = array();
		$data[] = array('0',GWF_HTML::lang('select_category'));
		
		return GWF_Select::display($name, $data, $selected);
	}
}
?>