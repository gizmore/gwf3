<?php
final class GWF_Select
{
	public static function display($name, $data, $selected='0', $onchange='')
	{
		$onchange = $onchange === '' ? '' : " onchange=\"{$onchange}\"";
		$back = '<select name="'.$name.'"'.$onchange.'>'.PHP_EOL;
		foreach ($data as $d)
		{
			$sel = $d[0] == $selected ? ' selected="selected"' : '';
			$back .= sprintf('<option value="%s"%s>%s</option>', htmlspecialchars($d[0]), $sel, htmlspecialchars($d[1])).PHP_EOL;
		}
		$back .= '</select>'.PHP_EOL;
		return $back;
	}

	public static function multi($name, $data, $selected=array(), $onchange='')
	{
		$onchange = $onchange === '' ? '' : " onchange=\"{$onchange}\"";
		$back = '<select name="'.$name.'[]" multiple="multiple"'.$onchange.'>'.PHP_EOL;

		foreach ($data as $d)
		{
			$sel = in_array($d[0], $selected, false) ? ' selected="selected"' : '';
			$back .= sprintf('<option value="%s"%s>%s</option>', htmlspecialchars($d[0]), $sel, htmlspecialchars($d[1])).PHP_EOL;
		}
		$back .= '</select>'.PHP_EOL;
		return $back;
	}
}
