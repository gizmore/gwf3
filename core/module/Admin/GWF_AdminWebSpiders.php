<?php
final class GWF_AdminWebSpiders
{
//	const SPIDER_FILE = 'spider_msn.dat';
//	const SPIDER_FILE = 'spider_test.dat';
	const SPIDER_FILE = 'spider.dat';
	
	public static function installHide(Module_Admin $module, $hide)
	{
		$users = GDO::table('GWF_User');
		$hide = GWF_User::HIDE_ONLINE;
		$spider = GWF_User::WEBSPIDER;
		if ($hide === true) {
			if (false === ($users->update("user_options=user_options|$hide", "user_options&$spider"))) {
				return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
			}
		}
		else {
			$sh = $hide|$spider;
			if (false === ($users->update("user_options=user_options-$hide", "user_options&$sh=$sh"))) {
				return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
			}
		}
		return '';
	}
	
	public static function install(Module_Admin $module, $dropTables)
	{
//		if ($module->cfgRobotUsers() === false) {
//			return '';
//		}
		
		$users = GDO::table('GWF_User');
		$users->deleteWhere("user_name LIKE '[%]'");
		printf('Deleted %d bots.<br/>', $users->affectedRows());
		
		GDO::table('GWF_Webspider')->createTable(true);
		
		$filename = GWF_CORE_PATH.'module/Admin/'.self::SPIDER_FILE;
		if (false === ($fh = fopen($filename, 'r'))) {
			return GWF_HTML::err('ERR_FILE_NOT_FOUND', $filename);
		}
		
		$ips = array();
		$botname = '';
		
		while (true)
		{
			if (false === ($line = fgets($fh))) {
				break;
			}
			$line = trim($line);
			
			if ($line === '' || Common::startsWith($line, '#')) {
				continue;
			}
			
			if (Common::startsWith($line, '['))
			{
				if ($botname !== '') {
					self::install_spider($botname, $ips);
				}
				$line = trim($line, '[]');
				$botname = $line;
				$ips = array();
				echo "SWITCHING TO NEXT BOT: $line<br/>";
			}
			else 
			{
				$ips[] = $line;
			}
		}
		
		if ($botname !== '') {
			self::install_spider($botname, $ips);
			$ips = array();
		}
		fclose($fh);
		
		return '';
	}
	
	private static function insert_bot($botname)
	{
		$user = new GWF_User(array(
			'user_id' => 0,
			'user_options' => GWF_User::BOT|GWF_User::WEBSPIDER,
			'user_name' => $botname,
			'user_password' => GWF_Password::hashPasswordS('webspider'),
			'user_regdate' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
			'user_regip' => GWF_IP6::getIP(GWF_IP_EXACT, '127.0.0.1'),
			'user_email' => '',
			'user_gender' => 'no_gender',
			'user_lastlogin' => 0,
			'user_lastactivity' => 0,
			'user_birthdate' => '00000000',
			'user_avatar_v' => 0,
			'user_countryid' => 0,
			'user_langid' => 0,
			'user_langid2' => 0,
			'user_level' => 0,
			'user_title' => '',
			'user_settings' => NULL,
			'user_data' => NULL,
			'user_credits' => 0.0,
		));
		if (false === ($user->insert())) {
			return false;
		}
		
		echo "Inserted new Bot: $botname<br/>";
		
		return $user;
	}
	
	private static function install_spider($botname, $ips)
	{
		GWF_Numeric::setInputCharset('0123456789abcdef');
		GWF_Numeric::setOutputCharset('0123456789');
		
		$botname = '['.$botname.']';
		if (false === ($user = GWF_User::getByName($botname))) {
			if (false === ($user = self::insert_bot($botname))) {
				return false;
			}
		}
		
		$uid = $user->getID();
		$count = count($ips);
		echo "Installing Bot $botname (UID:$uid) with $count IPs...<br/>";
		
		$ranged = array();
		foreach ($ips as $i => $ip)
		{
			if (self::is_ip_range($ip)) {
				$ranged[] = self::get_ip_range($ip);
				unset($ips[$i]);
			} else {
				$ip6 = GWF_IP6::getIP(GWF_IP6::HEX_128, $ip);
//				var_dump($ip6);
				$ips[$i] = GWF_Numeric::baseConvert($ip6, 16, 10);
			}
		}
		
//		var_dump($ranged); echo '<br/>';
		
		$ranged = self::merge_ranges($ranged);

//		var_dump($ranged); echo '<br/>';
		
		sort($ips);
		foreach ($ips as $ip)
		{
			self::merge_into_ranges($ranged, $ip);
		}
		
		$ranged = self::merge_ranges($ranged);
	
		
		echo "Total Ranges: ".count($ranged).".<br/>";
		
		GWF_Numeric::setInputCharset('0123456789');
		GWF_Numeric::setOutputCharset('0123456789abcdef');
		foreach ($ranged as $range)
		{
			list($min, $max) = $range;
//			echo "Insert range $min-$max<br/>";
			if (false === GWF_Webspider::insertSpider($uid, self::convertToHex($min), self::convertToHex($max))) {
				echo GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
			}
		}
//		var_dump($ranged);
	}
	
	private static function convertToHex($ip)
	{
		$ip = GWF_Numeric::baseConvert($ip, 10, 16);
		return str_repeat('0', 32-strlen($ip)).$ip;
	}
	
	private static function merge_ranges(array $ranged)
	{
		$back = array();
		# as long as we can merge...
		while (count($ranged) > 0)
		{
			$merged = false;
			# the current item is top of stack
			$curr = array_pop($ranged);
			list($ipmin, $ipmax) = $curr;
//			echo "Checking range $ipmin-$ipmax<br/>";
			
			# So now lets see if any of the remaining can merge it...
			foreach ($ranged as $i => $range2)
			{
				list($ipmin2, $ipmax2) = $range2;
//				echo "..against $ipmin2-$ipmax2<br/>";
				
				# this range completely covers the other range
				if ( (bccomp($ipmin, $ipmin2) <= 0) && (bccomp($ipmax, $ipmax2) >= 0) )
//				if ( ($ipmin <= $ipmin2) && ($ipmax >= $ipmax2))
				{
//					echo "This Range completely covers<br/>";
					$ranged[$i][0] = $ipmin;
					$ranged[$i][1] = $ipmax;
					$curr = false;
					break;
				}
				# The other range completely covers this range
				elseif ( (bccomp($ipmin2, $ipmin) <= 0) && (bccomp($ipmax2, $ipmax) >= 0) )
//				elseif ( ($ipmin2 <= $ipmin) && ($ipmax2 >= $ipmax))
				{
//					echo "Other Range completely covers<br/>";
					$curr = false;
					break;
				}
				
				# The other range walks from left into this range
				elseif ( (bccomp($ipmin, $ipmin2) <= 0) && (bccomp($ipmax, $ipmin2) >= 0) )
//				elseif ($ipmin <= $ipmin2 && $ipmax >= $ipmin2)
				{
//					echo "The other range walks in from left<br/>";
					$ranged[$i][1] = $ipmax;
					$curr = false;
					break;
				}
				
				# The other range walks from right into this range
				elseif ( (bccomp($ipmax, $ipmin2) >= 0) && (bccomp($ipmax2, $ipmax) >= 0) )
//				elseif ($ipmax >= $ipmin2 && $ipmax2 >= $ipmax)
				{
//					echo "The other range walks in from right<br/>";
					$ranged[$i][0] = $ipmin;
					$curr = false;
					break;
				}
				# This range is consecutive left
				elseif (bcsub($ipmin, $ipmax2) === '1')
				{
//					echo "The other range is consecutive left<br/>";
					$ranged[$i][1] = $ipmax;
					$curr = false;
					break;
				}
				# This range is consecutive right
				elseif (bcsub($ipmin2, $ipmax) === '1')
				{
//					echo "The other range is consecutive right<br/>";
					$ranged[$i][0] = $ipmin;
					$curr = false;
					break;
				}
			}
			
			if ($curr !== false) {
//				echo "Could not merge range.<br/>";
				$back[] = $curr;
			}
		}
		
		return array_merge($ranged, $back);
	}
	
	private static function merge_into_ranges(array &$ranged, $ip)
	{
		foreach ($ranged as $i => $range)
		{
			list($ipmin, $ipmax) = $range;
			if (bcsub($ipmin, $ip) === '1') {
				$ranged[$i][0] = $ip;
//				echo "IP is consecutive left.<br/>";
				return true;
			}
			elseif (bcsub($ip, $ipmax) === '1') {
				$ranged[$i][1] = $ip;
//				echo "IP is consecutive right.<br/>";
				return true;
			}
		}
//		echo "New range with single IP.<br/>";
		$ranged[] = array($ip, $ip);
		return true;
	}
	
	private static function is_ip_range($ip)
	{
		return substr_count($ip, '.') < 3;
	}
	
	private static function get_ip_range($ip)
	{
		$count = 3 - substr_count($ip, '.');
		$ipmin = $ip.str_repeat('.0', $count);
		$ipmax = $ip.str_repeat('.255', $count);
//		echo "Crating range from shortcut. $ipmin-$ipmax<br/>";
		return array(
			GWF_Numeric::baseConvert(GWF_IP6::getIP(GWF_IP6::HEX_128, $ipmin), 16, 10),
			GWF_Numeric::baseConvert(GWF_IP6::getIP(GWF_IP6::HEX_128, $ipmax), 16, 10),
		);
	}
	
}
?>