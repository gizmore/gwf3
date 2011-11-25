<?php
/**
 * PHP session handler.
 * @author gizmore
 */
final class GWF_Session
{
	/**
	 * @return GWF_User
	 */
	public static function getUser() {
		return self::$USER;
	}
	public static function getSessID() {
		return self::$SESSION->getVar('sess_sid');
	}
	public static function getSessSID() {
		return self::$SESSION->getVar('sess_id');
	}
	public static function getSession() {
		return self::$SESSION;
	}
	public static function haveCookies() {
		return self::$SESSION !== NULL;
	}
	public static function set($var, $value) {
		self::$SESSDATA[$var] = $value;
	}
	public static function exists($var) {
		return isset(self::$SESSDATA[$var]);
	}
	public static function remove($var) {
		unset(self::$SESSDATA[$var]);
	}
	public static function &get($var) {
		return self::$SESSDATA[$var];
	}
	public static function getOrDefault($var, $default=false) {
		return isset(self::$SESSDATA[$var]) ? self::$SESSDATA[$var] : $default;
	}
	public static function getLastURL() {
		return self::$SESSION->getVar('sess_lasturl');
	}
	public static function getCurrentURL() {
		return isset($_SERVER['REDIRECT_URL']) ? $_SERVER['REDIRECT_URL'] : $_SERVER['REQUEST_URI'];
	}
	public static function getUserID() {
		return self::$USER === false ? '0' : self::$USER->getID();
	}
	public static function isLoggedIn() {
		return self::$USER !== false;
	}
	
	
	public static function start($blocking=true)
	{
		
	}

	public static function commit($store_last_url=true)
	{
		
	}
	
	public static function onLogin(GWF_User $user, $bind_to_ip=true, $with_hooks=true)
	{
		
	}
	
	public static function onLogout()
	{
		
	}

	public static function getOnlineSessions()
	{
		
	}
}
?>