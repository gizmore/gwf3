<?php
/**
 * A double select for hh:ii
 * @author gizmore
 */
final class GWF_TimeSelect
{
	public static function select($name1='hour', $name2='min', $selected='0000')
	{
		if ($selected === true)
		{
			$selected = sprintf('%02d%02d', Common::getPostInt($name1), Common::getPostInt($name2));
		}
		else
		{
			$selected = sprintf('%04d', $selected);
		}

		$data = array();
		for ($i = 0; $i < 24; $i++)
		{
			$data[] = array($i, $i);
		}
		$sel1 = GWF_Select::display($name1, $data, substr($selected, 0, 2));

		$data = array();
		for ($i = 0; $i < 60; $i++)
		{
			$data[] = array($i, $i);
		}
		$sel2 = GWF_Select::display($name2, $data, substr($selected, 2, 2));

		return $sel1.':'.$sel2;
	}

	public static function isValidTime($arg, $allow_zero)
	{
		if (strlen($arg) !== 4)
		{
			return false;
		}

		$h = substr($arg, 0, 2);
		if ($h < 0 || $h > 23)
		{
			return false;
		}

		$i = substr($arg, 2, 2);
		if ($i < 0 || $i > 59)
		{
			return false;
		}

		return true;
	}
}
