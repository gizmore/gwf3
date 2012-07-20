<?php
/**
 * GDO IP Address functions.
 * Also has Useragent/IP hash function.
 * Finally we are ready for IPv6.
 * There are 8/9 different IP column types implemented. O-o
 * These are kinda en/de-coding formats for IP to database format, and display them.
 * We have also some tricks to allow IP6 to map into IP4 space, see types below.
 * TODO: Benchmarks
 * TODO: Implement PACK_1 and PACK_2
 * @author gizmore
 * @version 0.96
 */
final class GWF_IP6
{
	# Types
	const INT_32 = 'int_32';		# 4 byte, IPv6 not supported
	const UINT_32 = 'uint_32';		# 4 byte, IPv6 not supported
	const HASH_32_1 = 'hash_32_1';		# 4 byte, Very Lossy on IPv6. IPv6: (24 bit) 0.1%, IPv4 100% ; Maps IPv6 to loopbacks.
	const HASH_32_2 = 'hash_32_2';		# 4 byte, Both Lossy. IPv6: (31 bit) 1%, IPv4: (31 bit) 50% ; maps 50% of v4 (MSB) to v6
	const HASH_32_3 = 'hash_32_3';		# 4 byte, Both Lossy. IPv6: (31 bit) 1%, IPv4: (31 bit) 50% ; maps 50% of v4 (LSB) to v6
	const HASH_64   = 'hash_64';		# 8 byte, Lossy on IPv6 (63 bit) 2%, IPv4: 100%
	const HEX_32_128 = 'hex_32_128';	# 8 or 32 byte, Losless: Both 100%
	const HEX_128 = 'hex_128';		# 32 byte, Losless: Both 100%
	const BIN_32_128 = 'bin_32_128';	# 4 or 16 byte, Losless: Both 100%
	const BIN_128 = 'bin_128';		# 16 byte, Losless: Both 100%
	const AS_IS = 'as_is';			# 3-39 byte, Losless: Both 100% 2-24 byte
	const PACK_1 = 'pack_1';		# 2-24 byte, Losless: Both 100% (not implemented) using 1111==16 bits per char
	const PACK_2 = 'pack_2';		# 2-?? byte, Losless: Both 100% (not implemented) using 3rd party compression

	# UserAgent/IP hash
	const UA_HASH = 'ua_hash';
	const UA_HASH_LEN = 16;

	public static $TYPES = array(self::INT_32, self::UINT_32, self::HASH_32_1, self::HASH_32_2, self::HASH_32_3, self::HASH_64, self::HEX_128, self::HEX_32_128, self::BIN_128, self::BIN_32_128, self::AS_IS, self::PACK_1, self::PACK_2);

	###################
	### Convinience ###
	###################
	/**
	 * Get a GDO Define array.
	 * @param $type IP6 Type
	 * @param $default_null
	 * @param $gdo_flags
	 * @return array
	 */
	public static function gdoDefine($type, $default_null=GDO::NOT_NULL, $gdo_flags=0)
	{
		return array(self::getGDOType($type, $gdo_flags), self::getDefault($type, $default_null), self::getSize($type));
	}

	public static function isValidType($type)
	{
		return in_array($type, self::$TYPES, true);
	}

	/**
	 * Checks if a string is human readable IP.
	 * @param string $string
	 * @return boolean
	 */
	public static function isIP($string)
	{
		return self::isV4($string) || self::isV6($string);
	}

	public static function getIP($type=self::INT_32, $ip=false)
	{
		$ip = is_bool($ip) ? self::remoteAddress() : $ip;
		$is6 = self::isV6($ip);
		$is4 = self::isV4($ip);
		if ($is6 && $is4) {
			$ip = self::ip6toIP4($ip);
		}

		switch ($type)
		{
			case self::INT_32: return $is4 ? self::ip4ToInt32($ip) : 0; 
			case self::UINT_32: return $is4 ? self::ip4ToUInt32($ip) : 0; 
			case self::HASH_32_1: return $is4 ? self::ip4ToInt32($ip) : self::ip6ToInt32($ip); 
			case self::HASH_32_2: return $is4 ? self::ip4ToInt32Hash($ip, true) : self::ip6ToInt32Hash($ip, true); 
			case self::HASH_32_3: return $is4 ? self::ip4ToInt32Hash($ip, false) : self::ip6ToInt32Hash($ip, false); 
			case self::HASH_64: return $is4 ? self::ip4ToInt64Hash($ip) : self::ip6ToInt64Hash($ip);
			case self::HEX_32_128: return $is4 ? self::ip4ToHex128($ip, true) : self::ip6ToHex128($ip, true);
			case self::HEX_128: return $is4 ? self::ip4ToHex128($ip, false) : self::ip6ToHex128($ip, false);
			case self::BIN_32_128: return $is4 ? self::ip4ToBlob128($ip, true) : self::ip6ToBlob128($ip, true);
			case self::BIN_128: return $is4 ? self::ip4ToBlob128($ip, false) : self::ip6ToBlob128($ip, false);
			case self::AS_IS: return $is4 ? $ip : self::ip6AsIs($ip);
			case self::PACK_1:
			case self::PACK_2:
			default:
				GWF_Error::err('ERR_PARAMETER', array( __FILE__, __LINE__, 'type'));
				//return false;
				die(htmlspecialchars($type));
		}
	}

	public static function isLocal()
	{
		if (self::serverAddress() === ($ip = self::remoteAddress())) {
			return true;
		}
		if (self::isV6($ip)) {
			return $ip === '::1';
		}
		$a = substr($ip, 0, 3);
		return $a === '127' || $a === '192';
	}

	public static function displayIP($data, $type)
	{
		switch ($type)
		{
			case self::INT_32: return self::int32ToIP($data);
			case self::UINT_32: return self::uint32ToIP($data);
			case self::HASH_32_1: return self::int32ToIP($data);
			case self::HASH_32_2: return self::int32Hash2ToIP($data);
			case self::HASH_32_3: return self::int32Hash3ToIP($data);
			case self::HASH_64: return self::int64HashToIP($data);
			case self::HEX_128: return self::hex128ToIP($data);
			case self::HEX_32_128: return self::hex128ToIP($data);
			case self::BIN_128: return self::bin128ToIP($data);
			case self::BIN_32_128: return self::bin128ToIP($data);
			case self::AS_IS: return $data;
			case self::PACK_1:
			case self::PACK_2:
			default: echo GWF_HTML::err('ERR_PARAMETER', array(__FILE__, __LINE__, 'type')); return false;
		}
	}

	public static function getSize($type)
	{
		switch ($type)
		{
			case self::INT_32:
			case self::UINT_32:
			case self::HASH_32_1:
			case self::HASH_32_2:
			case self::HASH_32_3: return 4;

			case self::HASH_64: return 8;

			case self::BIN_128:
			case self::BIN_32_128: return 16;

			case self::PACK_1:
			case self::PACK_2: return 20; #(2-20)

			case self::HEX_128:
			case self::HEX_32_128: return 32;

			case self::AS_IS: return 39;

			case self::UA_HASH: return 16;

			default: echo GWF_HTML::err('ERR_PARAMETER', array(__FILE__, __LINE__, 'type')); echo $type; return false;
		}
	}
	public static function getDefault($type, $wanted=GDO::NOT_NULL)
	{
		switch ($type)
		{
			case self::INT_32:
			case self::UINT_32:
			case self::HASH_32_1:
			case self::HASH_32_2:
			case self::HASH_32_3:
			case self::HASH_64:
			case self::HEX_32_128:
			case self::HEX_128:
			case self::BIN_32_128:
			case self::BIN_128:
			case self::AS_IS:
			case self::PACK_1:
			case self::PACK_2:
			case self::UA_HASH:
				return $wanted;
			default: echo GWF_HTML::err('ERR_PARAMETER', array(__FILE__, __LINE__, 'type')); return false;
		}
	}
	public static function getGDOType($type, $gdo_flags=0)
	{
		switch ($type)
		{
			case self::HASH_64:
				return GDO::BIGINT|GDO::UNSIGNED|$gdo_flags;

			case self::BIN_32_128:
				return GDO::VARCHAR|GDO::BINARY|$gdo_flags;

			case self::UINT_32:
				return GDO::UINT|$gdo_flags;

			case self::INT_32:
			case self::HASH_32_1:
			case self::HASH_32_2:
			case self::HASH_32_3: 
			case self::BIN_128: 
//				return GDO::CHAR|GDO::ASCII|GDO::CASE_S|$gdo_flags;
				return GDO::CHAR|GDO::BINARY|$gdo_flags;

			case self::HEX_128:
				return GDO::CHAR|GDO::ASCII|GDO::CASE_S|$gdo_flags;

			case self::PACK_1:
			case self::PACK_2:
			case self::HEX_32_128:
			case self::AS_IS:
				return GDO::VARCHAR|GDO::ASCII|GDO::CASE_S|$gdo_flags;

			case self::UA_HASH:
				return GDO::TOKEN|$gdo_flags; 

			default: echo GWF_HTML::err('ERR_PARAMETER', array(__FILE__, __LINE__, 'type')); return false;
		}
	}

	##############
	### Checks ###
	##############
	public static function isV4($ip)
	{
		return strrpos($ip, '.') !== false;
	}

	public static function isV6($ip)
	{
		return strpos($ip, ':') !== false;
	}

	#################
	### HTTP Vars ###
	#################
	public static function remoteAddress() { return Common::getServer('REMOTE_ADDR', '127.0.0.1'); }
	public static function serverAddress() { return Common::getServer('SERVER_ADDR', '127.0.0.1'); }

	/**
	 * @return mixed the proxies forward or via field, or false if no visible proxy.
	 */
	public static function forwarder()
	{
		if (isset($_SERVER['HTTP_VIA'])) { 
			return 'VIA '.$_SERVER['HTTP_VIA'];
		}
		elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			return 'X_FF '.$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else {
			return false;
		}
	}

	/**
	 * return the remote IP address + a proxy info if any (forwarder)
	 * */
	public static function getIPAndForwarder($maxForwardLen)
	{
		$back = self::remoteAddress();
		if (false !== ($forwarder = self::forwarder()))
		{
			$back .= sprintf(' [%s]', Common::trimLen($forwarder, $maxForwardLen, '[..]'));
		}
		return $back;
	}

	public static function getUserAgent() { return Common::getServer('HTTP_USER_AGENT', ''); }

	######################
	### Useragent Hash ###
	######################
//	public static function getUserAgentHash($padding='', $with_ip=true, $hashlen=self::UA_HASH_LEN)
//	{
//		if ($with_ip === true) {
//			$ip_part_len = self::isV6(self::remoteAddress()) ? 8 : 4;
//			$ip_part = substr(self::getIP(self::HEX_32_128), 0, $ip_part_len);
//		} else {
//			$ip_part_len = 0;
//			$ip_part = '';
//		}
//
//		# Field too small!
//		if (0 >= ($ua_part_len = $hashlen - $ip_part_len - strlen($padding))) {
//			return false;
//		}
//		return $padding.$ip_part.substr(md5(self::getUserAgent()), 0, $ua_part_len);
//	}

	###############
	### General ###
	###############
	public static function hex2bin($hex)
	{
		$back = '';
		$len = strlen($hex);
		for ($i = 0; $i < $len; $i+=2)
		{
			$back .= chr(hexdec(substr($hex, $i, 2)));
		}
		return $back;
	}

	public static function dec2bin($dec, $bytes=4)
	{
		return self::hex2bin(substr(sprintf("%08x", $dec), 0, $bytes*2));
	}

	public static function ip6toIP4($ip)
	{
		return substr($ip, strrpos($ip, ':')+1);
	}

	public static function binFF($multi=4)
	{
		return str_repeat(chr(0xff), $multi);
	}

	public static function bin00($multi=4)
	{
		return str_repeat(chr(0x00), $multi);
	}

	#######################
	### From IP to Data ###
	#######################
	public static function ip4ToInt32($ip)
	{
		return inet_pton($ip);
	}

	/**
	 * @param $ip is a IPv4 as string (112.134.156.89)
	 * @return the ip address as _unsigned_ integer
	 */
	public static function ip4ToUInt32($ip)
	{
		$ip = explode('.', $ip);
		$back = 0;
		foreach($ip as $a) {
			$back *= 256;
			$back += intval($a);
		}
		return $back;		
	}

	public static function ip6ToInt32($ip)
	{
		return chr(127).substr(hash('md5', $ip, true), 1, 3);
//		$hash = mhash(MHASH_MD5, $ip);
//		return chr(127).substr($hash, 1, 3);
	}

	public static function ip4ToInt32Hash($ip)
	{
		return self::dec2bin(ip2long($ip)&0x7fffffff);
	}

	public static function ip6ToInt32Hash($ip, $msb)
	{
		$hash = hash('md5', $ip, true);
		if ($msb)
		{
			$first = substr($hash, 0, 1);
			$first |= 0x80;
			return chr($first).substr($hash, 1, 3);
		}
		else
		{
			$last = substr($hash, 3, 1);
			$last |= 0x01;
			return substr($hash, 0, 3).chr($last);
		}
	}

	public static function ip4ToInt64Hash($ip)
	{
		return self::binFF().inet_pton($ip);
	}

	public static function ip6ToInt64Hash($ip)
	{
		return substr(mhash(MHASH_MD5, inet_pton($ip), true), 0, 8);
	}

	public static function ip4ToHex128($ip)
	{
		$ip = '::FFFF:'.$ip;
		return bin2hex(inet_pton($ip));
	}

	public static function ip6ToHex128($ip)
	{
		return bin2hex(inet_pton($ip));
	}

	public static function ip4ToBlob128($ip)
	{
		return inet_pton($ip);
	}

	public static function ip6ToBlob128($ip)
	{
		return inet_pton($ip);
	}

	public static function ip6AsIs($ip)
	{
		return $ip;
	}

	#######################
	### From Data To IP ###
	#######################
	public static function int32ToIP($data)
	{
		return inet_ntop($data);
	}

	public static function uint32ToIP($data)
	{
		$ip = '';
		for ($i = 0; $i < 4; $i++) {

			$current = bcmod($int, 256);
			$int /= 256;
			$ip = ".$current".$ip;

		}
		return substr($ip, 1);
	}

	public static function int32Hash2ToIP($data)
	{
		if ((ord($data[0]) & 0x80) === 0x80)
		{
			return sprintf('UNKNOWN::IPv6::MD5::31bit'); #, self::bin2dec($data)&0x7fffffff);
		}
		else
		{
			return sprintf('%d|%d.%d.%d.%d', ord($data[0]), ord($data[0])|0x80, ord($data[1]), ord($data[2]), ord($data[3]));
		}
	}

	public static function int32Hash3ToIP($data)
	{
		if ((ord($data[3]) & 0x01))
		{
			return sprintf('UNKNOWN::IPv6::MD5::31bit');
		}
		else
		{
			return sprintf('%d|%d.%d.%d.%d', ord($data[1]), ord($data[0]), ord($data[1]), ord($data[2]), ord($data[3])|0x01);
		}
	}

	public static function int64HashToIP($data)
	{
		if (substr($data, 0, 4) === self::binFF())
		{
			return self::int32ToIP(substr($data, 4));
		}
		return 'UNKNOWN::IPv6::MD5::64bit'; # inet_ntop(self::bin00(8).$data);
	}

	public static function hex128ToIP($data)
	{
		return inet_ntop(self::hex2bin($data));
	}

	public static function bin128ToIP($data)
	{
		if (strlen($data) !== 4 && strlen($data) !== 16) {
			return GWF_HTML::lang('unknown');
		}
		return inet_ntop($data);
	}
}


# PHP5.1 fix #
if (!function_exists('inet_pton'))
{
	function inet_pton($ip)
	{
		# ipv4
		if (strpos($ip, '.') !== false) {
			return pack('N',ip2long($ip));
		}
		# ipv6
		elseif (strpos($ip, ':') !== false) {
			$ip = explode(':', $ip);
			$res = str_pad('', (4*(8-count($ip))), '0000', STR_PAD_LEFT);
			foreach ($ip as $seg) {
				$res .= str_pad($seg, 4, '0', STR_PAD_LEFT);
			}
			return pack('H'.strlen($res), $res);
		}
		return false;
	}
}


