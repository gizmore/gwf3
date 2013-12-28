<?php
/**
 * GWF_Time helper class.
 * Note: If you want dates display with different dateformats you can try to substr() or str_repeat() your gwf_date to appropiate lengths.
 * TODO: Make ready for applications that don't use base/lang files.
 * TODO: Split to different files. GWF_Date, GWF_Validator, GWF_TimeConvert, GWF_Duration?
 * @author gizmore
 * @version 2.92
 */
final class GWF_Time
{
	private static $CACHE = NULL; # Date language cache

	const LEN_MILLI = 17;
	const LEN_SECOND = 14;
	const LEN_MINUTE = 12;
	const LEN_HOUR = 10;
	const LEN_DAY = 8;
	const LEN_MONTH = 6;
	const LEN_YEAR = 4;

	const ONE_SECOND = 1;
	const ONE_MINUTE = 60;
	const ONE_HOUR = 3600;
	const ONE_DAY = 86400;
	const ONE_WEEK = 604800;
	const ONE_MONTH = 2592000;
	const ONE_YEAR = 31536000;

	/**
	 * Get a gwf_date from a timestamp, like YYmmddHHiiss.
	 * @example $date = GWF_Time::getDate();
	 * @see getDateMillis
	 * @param int $len 4-14
	 * @param int $time or NULL
	 * @return string gwf_date
	 */
	public static function getDate($len=14, $time=NULL)
	{
		if ($time === NULL) { $time = time(); }
		$dates = array(4=>'Y',6=>'Ym',8=>'Ymd',10=>'YmdH',12=>'YmdHi',14=>'YmdHis', 17=>'YmdHis000');
		return date($dates[$len], $time);
	}

	/**
	 * Get a datestring like YYmmddHHiissMMM.
	 * @example $date = GWF_Time::getDate();
	 * @see getDate
	 * @param float $microtime
	 * @return string gwf_date
	 */
	public static function getDateMillis($microtime=NULL)
	{
		return self::getDateMM($microtime === NULL ? microtime(true) : $microtime, 3);
	}
	
	public static function getDateMicros($microtime=NULL)
	{
		return self::getDateMM($microtime === NULL ? microtime(true) : $microtime, 6);
	}
	
	private static function getDateMM($microtime, $digits)
	{
		$time = (int)$microtime;
		return self::getDate(14, $time).substr(sprintf('%.0'.$digits.'f', $microtime-$time), 2);
	}

	/**
	 * Get a date in RSS format from a gwf_date.
	 * @param int $time unix timestamp or NULL
	 * @return string rss date
	 */
	public static function rssDate($gwf_date=NULL)
	{
		return $gwf_date === NULL ? self::rssTime() : self::rssTime(self::getTimestamp($gwf_date));
	}

	public static function rssTime($time=NULL)
	{
		return date('r', $time===NULL?time():$time);
	}

	###############
	### Display ###
	###############
	/**
	 * Display a timestamp.
	 * TODO: Function is slow
	 * @see GWF_Time::displayDate
	 * @param $timestamp
	 * @param $langid
	 * @param $default_return
	 * @return unknown_type
	 */
	public static function displayTimestamp($timestamp=NULL, $iso=NULL, $default_return='ERROR')
	{
		if ($timestamp === NULL)
		{
			$timestamp = time();
		}
		if ($iso === NULL)
		{
			$iso = GWF_LangTrans::getBrowserISO();
		}
		return self::displayDateISO(self::getDate(self::LEN_SECOND, $timestamp), $iso, $default_return);
	}

	public static function displayDate($gwf_date, $default_return='ERROR')
	{
		return self::displayDateISO($gwf_date, GWF_LangTrans::getBrowserISO(), $default_return);
	}

	private static function displayDateFormatB($gwf_date, $format, $default_return, $m_names, $month_names, $d_names, $day_names, $unknown='Unknown')
	{
		$replace = array();

		if ($gwf_date == 0) {
			return $unknown;
		}

		$month_names[-1] = $unknown;
		$m_names[-1] = $unknown;

		switch (strlen($gwf_date))
		{
//			case GWF_Date::LEN_NANO: # LOL :)
//			case GWF_Date::LEN_MICRO:
//			case GWF_Date::LEN_MILLI:
			case GWF_Date::LEN_SECOND:
				$replace['s'] = substr($gwf_date, 12, 2);
			case GWF_Date::LEN_MINUTE:
				$replace['i'] = substr($gwf_date, 10, 2);
			case GWF_Date::LEN_HOUR:
				$replace['H'] = substr($gwf_date, 8, 2);
			case GWF_Date::LEN_DAY:
				if (0 === ($day = intval(substr($gwf_date, 6, 2), 10)))
				{
					$replace['d'] = sprintf('%02d', $day);
					$replace['j'] = $day;
					$weekday = '???';
					$replace['l'] = '?';
					$replace['D'] = '?';
				}
				else
				{
					$replace['d'] = sprintf('%02d', $day);
					$replace['j'] = $day;
					$weekday = self::computeWeekDay($gwf_date);
					$replace['l'] = $day_names[$weekday];
					$replace['D'] = $d_names[$weekday];
				}
			case GWF_Date::LEN_MONTH:
				$month = intval(substr($gwf_date, 4, 2), 10);
				$replace['m'] = sprintf('%02d', $month);
				$replace['M'] = $month_names[$month-1];
				$replace['n'] = $month;
				$replace['N'] = $m_names[$month-1];
			case GWF_Date::LEN_YEAR:
				$replace['Y'] = substr($gwf_date, 0, 4); 
				$replace['y'] = substr($gwf_date, 2, 2);
				break;
			default:
				return $default_return;
		}

		$back = '';
		$dflen = strlen($format);
		for ($i = 0; $i < $dflen; $i++)
		{
			$j = substr($format, $i, 1);
			if (isset($replace[$j])) {
				$back .= $replace[$j];
			} else {
				$back .= $j;
			}
		}

		return $back;
	}

	/**
	 * Get the dateformat language cache for an ISO.
	 * @param string $iso
	 * @return array
	 */
	private static function getCache($iso)
	{
		if (isset(self::$CACHE[$iso]))
		{
			return self::$CACHE[$iso];
		}
		if (self::$CACHE === NULL)
		{
			self::$CACHE = array();
		}
		self::$CACHE[$iso] = GWF_HTML::getLang()->langISO($iso, 'datecache');
		return self::$CACHE[$iso];
	}


	/**
	 * Display a date from a GWF_Date.
	 * We format something like 19993112235912 to Monday, January the 1st, 22:33:12
	 * The langid argument should be true for current browser language.
	 * The default return value should be used as 'unknown'(1) or 'never'(2)
	 * @param $gwf_date string
	 * @param $langid default true is browser lang
	 * @param $default_return mixed default string or 1 for unknwon 2 for never
	 * @return string
	 */
	public static function displayDateISO($gwf_date, $iso, $default_return='ERROR')
	{
		if ( ($gwf_date === '') || ($gwf_date == 0) )
		{
			return $default_return;
		}
		$cache = self::getCache($iso);
		return self::displayDateFormatB($gwf_date, $cache[4][strlen($gwf_date)], $default_return, $cache[0], $cache[1], $cache[2], $cache[3]);
	}

	/**
	 * Display a GWF_Date with a custom dateformat.
	 * @param string $gwf_date
	 * @param string $format
	 * @param string $iso
	 * @return string
	 */
	public static function displayDateFormat($gwf_date, $format, $iso=NULL, $default_return='ERROR')
	{
		if ($iso === NULL)
		{
			$iso = GWF_Language::getCurrentISO();
		}
		$cache = self::getCache($iso);
		return self::displayDateFormatB($gwf_date, $format, $default_return, $cache[0], $cache[1], $cache[2], $cache[3]);
	}


	/**
	 * Compute the week of the day for a given GWF_Date.
	 * 0=Sunday.
	 * @param $gwf_date string min length 8
	 * @return int 0-6
	 */
	public static function computeWeekDay($gwf_date)
	{
		$century = array('12' => 6, '13' => 4, '14' => 2, '15'=> 0, # <-- not sure if these are correct :(  
		'16'=>6, '17'=>4, '18'=>2, '19'=>0, '20'=>6, '21'=>4, '22'=>2, '23'=>0); # <-- these are taken from wikipedia
		static $months = array(array(0,3,3,6,1,4,6,2,5,0,3,5), array(6,2,3,6,1,4,6,2,5,0,3,5));
		$step1 = $century[substr($gwf_date, 0, 2)];
		$y = intval(substr($gwf_date, 2, 2), 10); // step2
		$m = intval(substr($gwf_date, 4, 2), 10);
		$d = intval(substr($gwf_date, 6, 2), 10);
		$leap = ($y % 4) === 0 ? 1 : 0;
		$step3 = intval($y / 4);
		$step4 = $months[$leap][$m-1];
		$sum = $step1 + $y + $step3 + $step4 + $d;
		return $sum % 7;
	}

	################
	### Validate ###
	################
	/**
	 * Check if a GWF_Date is valid.
	 * Allow optional zero or blank date.
	 * Length can be: 4y,6m,8d, 10h,12i,14s, 15,16,17ms, 20us, 23ns
	 * @param $date
	 * @param $allowBlank
	 * @param $length
	 * @return boolean
	 */
	public static function isValidDate($date, $allowBlank, $length, $max_future_years=5)
	{
		if ( $allowBlank && ($date === '' || $date == 0))
		{
			return true;
		}

		$convert = array('y'=>0,'m'=>0,'d'=>0,'h'=>0,'i'=>0,'s'=>0,'ms'=>0, 'us'=>0, 'ns'=>0);
		
		if ($length === NULL)
		{
			$length = strlen($date);
		}
		else
		{
			if (!preg_match('/^\d{'.$length.'}$/D', $date))
			{
				return false;
			}
		}

		switch ($length)
		{
			case 23: $convert['ns'] += intval(substr(20, 3), 10);
			case 20: $convert['us'] += intval(substr(17, 3), 10);
			case 17: $convert['ms'] += (int) $date[16];
			case 16: $convert['ms'] += (int) $date[15] * 10;
			case 15: $convert['ms'] += (int) $date[14] * 100;
			case 14: 
				$convert['s'] = intval(substr($date, 12, 2), 10);
				if ($convert['s'] > 59) { return false; }
			case 12:
				$convert['i'] = intval(substr($date, 10, 2), 10);
				if ($convert['i'] > 59) { return false; }
			case 10:
				$convert['h'] = intval(substr($date, 8, 2), 10);
				if ($convert['h'] > 23) { return false; }
			case 8:
				$convert['d'] = intval(substr($date, 6, 2), 10);
				if ($convert['d'] > 31 || $convert['d'] < 1) { return false; }
			case 6: 
				$convert['m'] = intval(substr($date, 4, 2), 10);
				if ($convert['m'] > 12 || $convert['m'] < 1) { return false; }
			case 4:
				$convert['y'] = intval(substr($date, 0, 4), 10);
				if ($convert['y'] > date('Y')+$max_future_years) { return false; }
				return true;
			default:
				return false;
		}

		// Check days for months in year 
		if ($length >= 8)
		{
			if (self::getNumDaysForMonth($convert['m'], $convert['y']) < $convert['d'])
			{
				return false;
			}
		}

		return true; 
	}

	private static function getNumDaysForMonth($month, $year)
	{
		$leap = (($year % 4) === 0) || (($year % 100) === 0);
		switch ($month)
		{
			case 1: case 3: case 5: case 7: case 8: case 10: case 12: return 31;
			case 4: case 6: case 9: case 11: return 30;
			case 2: return $leap ? 29 : 28;
			default: return false;
		}
	}

	/**
	 * Compute an age, in years, from a date compared to current date.
	 * @param $birthdate
	 * @return int -1 on error
	 */
	public static function getAge($birthdate)
	{
		if ((strlen($birthdate) !== 8) || ($birthdate === '00000000')) {
			return -1;
		}
		$now = (int)date('Ymd');
		$birthdate = (int) $birthdate;
		$age = $now - $birthdate;
		return intval($age / 10000, 10);
	}

	public static function getTimestamp($gwf_date)
	{
		if (0 === preg_match('/^(\d{4})?(\d{2})?(\d{2})?(\d{2})?(\d{2})?(\d{2})?$/D', $gwf_date, $matches)) {
			return false;
		}
		return mktime(
			isset($matches[4]) ? intval($matches[4], 10) : 0,
			isset($matches[5]) ? intval($matches[5], 10) : 0,
			isset($matches[6]) ? intval($matches[6], 10) : 0,
			isset($matches[2]) ? intval($matches[2], 10) : 0,
			isset($matches[3]) ? intval($matches[3], 10) : 0,
			isset($matches[1]) ? intval($matches[1], 10) : 0
		);
	}

	public static function displayAge($gwf_date)
	{
		return self::displayAgeTS(self::getTimestamp($gwf_date));
	}

	public static function displayAgeTS($timestamp)
	{
		return self::humanDuration(time()-round($timestamp));
	}
	
	public static function displayAgeISO($gwf_date, $iso)
	{
		return self::displayAgeTSISO(self::getTimestamp($gwf_date), $iso);
	}

	public static function displayAgeTSISO($timestamp, $iso)
	{
		return self::humanDurationISO($iso, time()-round($timestamp));
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
		$duration = (int)$duration;
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
		return self::humanDurationISO(GWF_Language::getCurrentISO(), $duration, $nUnits);
	}


	public static function isValidDuration($string, $min, $max)
	{
		$duration = GWF_TimeConvert::humanToSeconds($string);
		return $duration >= $min && $duration <= $max;
	}


	/**
	 * Get timestamp of start of this week. (Monday)
	 * @return int unix timestamp.
	 * */
	public static function getTimeWeekStart()
	{
		return strtotime('previous monday', time()+self::ONE_DAY);
	}


	/**
	 * Get Long Weekday Names (translated), starting from monday. returns array('monday', 'tuesday', ...); 
	 * @return array
	 */
	public static function getWeekdaysFromMo()
	{
		$l = GWF_HTML::getLang();
		return array($l->lang('D1'),$l->lang('D2'),$l->lang('D3'),$l->lang('D4'),$l->lang('D5'),$l->lang('D6'),$l->lang('D0'));
	}
}

