<?php
final class GWF_TimeConvert
{
	/**
	 * Convert a human duration to seconds.
	 * Input may be like 3d5h8i 7s.
	 * Also possible is 1 month 3 days or 1year2sec.
	 * Note that 'i' is used for minutes and 'm' for months.
	 * No unit means default unit, which is seconds.
	 * Supported units are:
	 * s, sec, second, seconds,
	 * i, min, minute, minutes,
	 * h, hour, hours,
	 * d, day, days,
	 * w, week, weeks,
	 * m, month, months,
	 * y, year, years.
	 * @param $duration string is the duration in human format.
	 * @return int duration as seconds
	 * */
	public static function humanToSeconds($duration)
	{
		if (is_int($duration)) { return $duration; }
		if (!is_string($duration)) { return 0; }
		if (Common::isNumeric($duration)) { return (int)$duration; }
		$duration = trim(strtolower($duration));
		if (!preg_match('/^(?:(?:[0-9 ]+[sihdwmy])+)$/', $duration)) { return 0; }
		

		$multis = array('s' => 1,'i' => 60,'h' => 3600,'d' => 86400,'w' => 604800,'m' => 2592000,'y' => 31536000);
		$replace = array(
			'seconds' => 's', 'second' => 's', 'sec' => 's',
			'minutes' => 'i', 'minute' => 'i', 'min' => 'i',
			'hours' => 'h', 'hour' => 'h',
			'days' => 'd', 'day' => 'd',
			'weeks' => 'w', 'week' => 'w',
			'months' => 'm', 'month' => 'm', 'mon' => 'm',
			'years' => 'y', 'year' => 'y',
		);

		$negative = 1;
		$duration = strtolower(trim($duration));
		if ($duration[0] == '-') {
			$negative = -1;
		}
		$duration = trim($duration, '-');
		$duration = str_replace(array_keys($replace), array_values($replace), $duration);
// 		$duration = preg_replace('/[^sihdwmy0-9]/', '', $duration);
		$duration = preg_replace('/([sihdwmy])/', '$1 ', $duration);
		$duration = explode(' ', trim($duration));
		$back = 0;
		foreach ($duration as $d)
		{
			$unit = substr($d, -1);
			if (is_numeric($unit)) {
				$unit = 's';
			}
			else {
				$d = substr($d, 0, -1);
			}
			$d = intval($d);

			$back += $multis[$unit] * $d;
		}
		return $negative * $back;
	}

	################
	### Duration ###
	################
	public static function humanDurationEN($duration, $nUnits=2)
	{
		static $units = true;
		if ($units === true) {
			$units = array('s' => 60,'m' => 60,'h' => 24,'d' => 365,'y' => 1000000);
		}
		return self::humanDurationRaw($duration, $nUnits, $units);
	}

	public static function humanDurationISO($iso, $duration, $nUnits=2)
	{
		static $cache = array();
		if (!isset($cache[$iso]))
		{
			$cache[$iso] = array(
				GWF_HTML::langISO($iso, 'unit_sec_s') => 60,
				GWF_HTML::langISO($iso, 'unit_min_s') => 60,
				GWF_HTML::langISO($iso, 'unit_hour_s') => 24,
				GWF_HTML::langISO($iso, 'unit_day_s') => 365,
				GWF_HTML::langISO($iso, 'unit_year_s') => 1000000,
			);
		}
		return self::humanDurationRaw($duration, $nUnits, $cache[$iso]);
	}

	public static function humanDurationRaw($duration, $nUnits=2, array $units)
	{
		$calced = array();
		foreach ($units as $text => $mod)
		{
			if (0 < ($remainder = $duration % $mod)) {
				$calced[] = $remainder.$text;
			}
			$duration = intval($duration / $mod);
			if ($duration === 0) {
				break;
			}
		}

		if (count($calced) === 0) {
			return '0'.key($units);
		}

		$calced = array_reverse($calced, true);
		$i = 0;
		foreach ($calced as $key => $value)
		{
			$i++;
			if ($i > $nUnits) {
				unset($calced[$key]);
			}
		}

		return implode(' ', $calced);
	}

	/**
	 * Return a human readable duration.
	 * Example: 666 returns 11 minutes 6 seconds.
	 * @param $duration in seconds.
	 * @param $nUnits how many units to display max.
	 * @return string
	 */
	public static function humanDuration($duration, $nUnits=2)
	{
		return self::humanDurationISO(GWF_LangTrans::getBrowserISO(), $duration, $nUnits);
	}

	public static function isValidDuration($string, $min, $max)
	{
		$duration = self::humanToSeconds($string);
		return $duration >= $min && $duration <= $max;
	}

}
