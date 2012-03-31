<?php
/**
 * Maybe needed later :)
 * @author gizmore
 */
abstract class GWF_Cronjob
{
	public static function log($msg) { GWF_Log::logCron('[+] '.$msg); }
	public static function error($msg) { GWF_Log::logCron('[ERROR] '.$msg); return false; }
	public static function warning($msg) { GWF_Log::logCron('[WARNING] '.$msg); }
	public static function notice($msg) { GWF_Log::logCron('[NOTICE] '.$msg); }
	public static function start($modulename) { GWF_Log::logCron('[START] '.$modulename); }
	public static function end($modulename) { GWF_Log::logCron('[DONE] '.$modulename.PHP_EOL); }
}

