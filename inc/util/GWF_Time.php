<?php
define('TIME_THIS_YEAR', date('Y'));
define('TIME_THIS_MONTH', date('m'));
define('TIME_THIS_DAY', date('d'));
/**
 * GDO_Time helper class.
 * TODO: Make ready for applications that don't use base/lang files.
 * @author gizmore
 * @version 2.9
 */
final class GWF_Time
{
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
	
	const THIS_YEAR = TIME_THIS_YEAR;
	
	/**
	 * Get a gdo_date from a timestamp.
	 * @param int $len
	 * @param int $time or NULL
	 * @return string gdo_date
	 */
	public static function getDate($len, $time=NULL)
	{
		if ($time === NULL) { $time = time(); }
		$dates = array(4=>'Y',6=>'Ym',8=>'Ymd',10=>'YmdH',12=>'YmdHi',14=>'YmdHis', 17=>'YmdHis000');
		return date($dates[$len], $time);
	}
	
	/**
	 * Get a datestring like YYmmddHHiissMMM
	 * @param float $microtime
	 * @return string gdo_date
	 */
	public static function getDateMillis($microtime=NULL)
	{
		if ($microtime === null) { $microtime = microtime(true); }
		$time = (int)$microtime;
		return self::getDate(14, $time).sprintf('%.03f', $microtime-$time);
	}
	
	/**
	 * Get a date in RSS format from a gdo_date.
	 * @param int $time unix timestamp or NULL
	 * @return string rss date
	 */
	public static function rssDate($gdo_date=NULL)
	{
		return $gdo_date === NULL ? self::rssTime() : self::rssTime(self::getTimestamp($gdo_date));
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
		if ($timestamp === NULL) {
			$timestamp = time();
		}
		if ($iso === NULL) {
			$iso = GWF_LangTrans::getBrowserISO();
		}
		return self::displayDateISO(self::getDate(GWF_Date::LEN_SECOND, $timestamp), $iso, $default_return);
	}
	
	public static function displayDate($gdo_date, $default_return='ERROR')
	{
		return self::displayDateISO($gdo_date, GWF_LangTrans::getBrowserISO(), $default_return);
	}
	
//	public static function displayDateEN($gdo_date, $default_return='invalid date')
//	{
//		$formats = array(4 => 'Y',6 => 'M Y',8 => 'D, M j, Y',10 => 'M d, Y - H:00',12 => 'M d, Y - H:i',14 => 'M d, Y - H:i:s');
//		if (0 === ($datelen = strlen($gdo_date))) {
//			return 'Never';
//		}
//		if (!isset($formats[$datelen])) {
//		}
//		$format = $formats[$datelen];
//		return self::displayDateFormat($gdo_date, $format, $default_return,
//			array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'),
//			array('January','February','March','April','May','June','July','August','Septemper','October','November','December'), 
//			array('Sun','Mon','Tue','Wed','Thu','Fri','Sat'),
//			array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday')
//			);
//	}
	
	public static function displayDateFormat($gdo_date, $format, $default_return, $m_names, $month_names, $d_names, $day_names, $unknown='Unknown')
	{
		$replace = array();
		
		if ($gdo_date == 0) {
			return $unknown;
		}
		
		$month_names[-1] = $unknown;
		$m_names[-1] = $unknown;
		
		switch (strlen($gdo_date))
		{
//			case GWF_Date::LEN_NANO: # LOL :)
//			case GWF_Date::LEN_MICRO:
//			case GWF_Date::LEN_MILLI:
			case GWF_Date::LEN_SECOND:
				$replace['s'] = substr($gdo_date, 12, 2);
			case GWF_Date::LEN_MINUTE:
				$replace['i'] = substr($gdo_date, 10, 2);
			case GWF_Date::LEN_HOUR:
				$replace['H'] = substr($gdo_date, 8, 2);
			case GWF_Date::LEN_DAY:
				if (0 === ($day = intval(substr($gdo_date, 6, 2), 10)))
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
					$weekday = self::computeWeekDay($gdo_date);
					$replace['l'] = $day_names[$weekday];
					$replace['D'] = $d_names[$weekday];
				}
			case GWF_Date::LEN_MONTH:
				$month = intval(substr($gdo_date, 4, 2), 10);
				$replace['m'] = sprintf('%02d', $month);
				$replace['M'] = $month_names[$month-1];
				$replace['n'] = $month;
				$replace['N'] = $m_names[$month-1];
			case GWF_Date::LEN_YEAR:
				$replace['Y'] = substr($gdo_date, 0, 4); 
				$replace['y'] = substr($gdo_date, 2, 2);
				break;
			default:
				return $default_return;
//				switch($default_return)
//				{
//					case 1: return $t->langISO($iso, 'unknown');
//					case 2: return $t->langISO($iso, 'never');
//					default: 
//				}
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
	 * Display a date from a GDO date.
	 * We format something like 19993112235912 to Monday, January the 1st, 22:33:12
	 * The langid argument should be true for current browser language.
	 * The default return value should be used as 'unknown'(1) or 'never'(2)
	 * @param $gdo_date string
	 * @param $langid default true is browser lang
	 * @param $default_return mixed default string or 1 for unknwon 2 for never
	 * @return string
	 */
	public static function displayDateISO($gdo_date, $iso, $default_return='ERROR')
	{
		static $cache = array();
		
		$t = GWF_HTML::getLang();
		
		if (!isset($cache[$iso])) {
			$cache[$iso] = $t->langISO($iso,'datecache');
		}
		
		if (1 >= ($datelen = strlen($gdo_date))) {
			return $t->langISO($iso, 'never');
		}
		
		$format = $cache[$iso][4][$datelen];
		return self::displayDateFormat($gdo_date, $format, $default_return, $cache[$iso][0], $cache[$iso][1], $cache[$iso][2], $cache[$iso][3]);
	}
	
	/**
	 * Compute the week of the day for a given gdo date.
	 * 0=Sunday.
	 * @param $gdo_date string min length 8
	 * @return int 0-6
	 */
	public static function computeWeekDay($gdo_date)
	{
		$century = array('12' => 6, '13' => 4, '14' => 2, '15'=> 0, # <-- not sure if these are correct :(  
		'16'=>6, '17'=>4, '18'=>2, '19'=>0, '20'=>6, '21'=>4, '22'=>2, '23'=>0); # <-- these are taken from wikipedia
		static $months = array(array(0,3,3,6,1,4,6,2,5,0,3,5), array(6,2,3,6,1,4,6,2,5,0,3,5));
		$step1 = $century[substr($gdo_date, 0, 2)];
		$y = intval(substr($gdo_date, 2, 2), 10); // step2
		$m = intval(substr($gdo_date, 4, 2), 10);
		$d = intval(substr($gdo_date, 6, 2), 10);
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
	 * Check if a GDO date is valid.
	 * Allow optional zero or blank date.
	 * Length can be: 4y,6m,8d, 10h,12i,14s, 15,16,17ms, 20us, 23ns
	 * @param $date
	 * @param $allowBlank
	 * @param $length
	 * @return unknown_type
	 */
	public static function isValidDate($date, $allowBlank, $length)
	{
		if ( ($date === '' || $date == 0) && $allowBlank) {
			return true;
		}
		if (preg_match('/^\d{'.$length.'}$/', $date) === 0) {
			return false;
		}
		
		$convert = array('y'=>0,'m'=>0,'d'=>0,'h'=>0,'i'=>0,'s'=>0,'ms'=>0, 'us'=>0, 'ns'=>0);
		
		switch ($length)
		{
			case 23: $convert['ns'] += intval(substr(20, 3), 10);
			case 20: $convert['us'] += intval(substr(17, 3), 10);
			case 17: $convert['ms'] += (int) $date{16};
			case 16: $convert['ms'] += (int) $date{15} * 10;
			case 15: $convert['ms'] += (int) $date{14} * 100;
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
				if ($convert['y'] > date('Y')+5) { return false; }
		}
		
		// Check days for months in year 
		if ($length >= 8) {
			if (self::getNumDaysForMonth($convert['m'], $convert['y']) < $convert['d']) {
				return false;
			}
		}
		
		return true; 
	}
	
	private static function getNumDaysForMonth($month, $year)
	{
		$leap = (($year % 4) === 0);
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
	
	public static function getTimestamp($gdo_date)
	{
		if (0 === preg_match('/^(\d{4})?(\d{2})?(\d{2})?(\d{2})?(\d{2})?(\d{2})?$/', $gdo_date, $matches)) {
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
	
	public static function displayAge($gdo_date)
	{
		return self::displayAgeTS(self::getTimestamp($gdo_date));
	}
	
	public static function displayAgeTS($timestamp)
	{
		return self::humanDuration(time()-round($timestamp));
	}
	
	
//	public static function displayAgeEN()
//	{
//		
//	}
	
//	public static function displayAgeISO($iso)
//	{
//		self::getDate($len)
//	}
	
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
?>
