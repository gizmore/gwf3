<?php
final class GWF_DateSelect
{
	public static function getDateSelects($key, $default, $size, $with_compare, $in_future, $less_selects=false)
	{
		$this_year = intval(date('Y'));
		$minyear = $in_future ? $this_year : 1900;
		$maxyear = $in_future ? $this_year+2 : $this_year; 

		$selects = array();
		switch ($size)
		{
			case GWF_Date::LEN_SECOND:
				$aKey = $key.'s';
				$def = Common::getPost($aKey, substr($default, 12, 2));
				if ($less_selects === true) {
					$selects['s'] = self::getFormInput($aKey, self::STRING, $def, 2);
				} else {
					$selects['s'] = self::getSecondInput($aKey, $def);
				}
			case GWF_Date::LEN_MINUTE:
				$aKey = $key.'i';
				$def = Common::getPost($aKey, substr($default, 10, 2));
				if ($less_selects === true) {
					$selects['i'] = self::getFormInput($aKey, self::STRING, $def, 2);
				} else {
					$selects['i'] = self::getMinuteInput($aKey, $def);
				}
			case GWF_Date::LEN_HOUR;
				$aKey = $key.'h';
				$def = Common::getPost($aKey, substr($default, 8, 2));
				if ($less_selects === true) {
					$selects['h'] = self::getFormInput($aKey, self::STRING, $def, 2);
				} else {
					$selects['h'] = self::getHourInput($aKey, $def);
				}
			case GWF_Date::LEN_DAY:
				$aKey = $key.'d';
				$def = Common::getPost($aKey, substr($default, 6, 2));
				if ($less_selects === true) {
					$selects['d'] = self::getFormInput($aKey, self::STRING, $def, 2);
				} else {
					$selects['d'] = self::getDayInput($aKey, $def);
				}
			case GWF_Date::LEN_MONTH:
				$aKey = $key.'m';
				$def = Common::getPost($aKey, substr($default, 4, 2));
				$selects['m'] = self::getMonthInput($aKey, $def);
			case GWF_Date::LEN_YEAR:
				$aKey = $key.'y';
				$def = Common::getPost($aKey, substr($default, 0, 4));
				if ($less_selects === true) {
					$selects['y'] = self::getFormInput($aKey, self::STRING, $def, 4);
				}
				else {
					$selects['y'] = self::getYearInput($aKey, $def, $minyear, $maxyear);
				}
		}

		$format = strtolower(GWF_HTML::lang('df'.$size));
		$format = str_replace(array('n','j','l'), array('m','d','d'), $format);

		$back = '';
		if ($with_compare)
		{
			$aKey = $key.'c';
			$back = self::getDateCmpInput($aKey, Common::getPost($aKey, 'younger'));
		}

		$taken = array();

		$len = strlen($format);
		for ($i = 0; $i < $len; $i++)
		{
			$c = $format{$i};
			if (isset($selects[$c]))
			{
				if (!in_array($c, $taken)) {
					$back .= $selects[$c];
					$taken[] = $c;
				}
			}
			elseif ($less_selects === true)
			{
				$back .= " $c ";
			}
			else
			{
				$back .= ' ';
			}
		}

		return $back;
	}

	private static function getDateCmpInput($key, $selected)
	{
		$valid = array(
			'older' => GWF_HTML::lang('sel_older'),
			'younger' => GWF_HTML::lang('sel_younger'),
		);
		$back = sprintf('<select name="%s">', $key);
		foreach ($valid as $key => $text)
		{
			$sel = GWF_HTML::selected($selected === $key);
			$back .= sprintf('<option value="%s"%s>%s</option>', $key, $sel, $text);
		}
		$back .= '</select>';
		return $back;
	}

	private static function getSecondInput($key, $selected) { return self::getRangeInput($key, $selected, 0, 59); }
	private static function getMinuteInput($key, $selected) { return self::getRangeInput($key, $selected, 0, 59); }
	private static function getHourInput($key, $selected) { return self::getRangeInput($key, $selected, 0, 23); }
	private static function getRangeInput($key, $selected, $min, $max)
	{
		$back = sprintf('<select name="%s">', $key);
		$selected = (int) $selected;
		while ($min <= $max)
		{
			$sel = GWF_HTML::selected($selected === $min);
			$back .= sprintf('<option value="%02d"%s>%d</option>', $min, $sel, $min);
			$min++;
		}
		$back .= '</select>';
		return $back;
	}

	private static function getDayInput($key, $selected=false)
	{
		$back = sprintf('<select name="%s">', $key);
		$sel = $selected < 1 || $selected > 31 ? ' selected="selected"' : '';
		$back .= sprintf('<option value="00"%s>%s</option>', $sel, GWF_HTML::lang('sel_day'));
		$selected = $sel === '' ? (int) $selected : $selected;
		for ($i = 1; $i <= 31; $i++)
		{
			$sel = $selected === $i ? ' selected="selected"' : '';
			$back .= sprintf('<option value="%02d"%s>%d</option>', $i, $sel, $i);
		}
		$back .= '</select>';
		return $back;
	}

	private static function getMonthInput($key, $selected=false)
	{
		$back = sprintf('<select name="%s">', $key);
		$sel = $selected < 1 || $selected > 12 ? ' selected="selected"' : '';
		$back .= sprintf('<option value="00"%s>%s</option>', $sel, GWF_HTML::lang('sel_month'));
		$selected = $sel === '' ? (int) $selected : $selected;
		for ($i = 1; $i <= 12; $i++)
		{
			$sel = $selected === $i ? ' selected="selected"' : '';
			$back .= sprintf('<option value="%02d"%s>%s</option>', $i, $sel, GWF_HTML::lang('M'.$i));
		}
		$back .= '</select>';
		return $back;
	}

	private static function getYearInput($key, $selected=false, $min=1900, $max=NULL)
	{
		if (!is_numeric($selected)) { $selected = 0; }
		$min = (int) $min;
		if (!is_numeric($max)) { $max = date('Y'); }

		$back = sprintf('<select name="%s">', $key);
		$sel = $selected < $min || $selected > $max ? ' selected="selected"' : '';
		$selected = $sel === '' ? (int) $selected : $selected;
		$back .= sprintf('<option value="0000"%s>%s</option>', $sel, GWF_HTML::lang('sel_year'));
		for ($i = $max; $i >= $min; $i--)
		{
			$sel = $selected === $i ? ' selected="selected"' : '';
			$back .= sprintf('<option value="%04d"%s>%d</option>', $i, $sel, $i);
		}
		$back .= '</select>';
		return $back;
	}	
}
