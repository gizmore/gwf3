<?php
/**
 * Smarty plugin
 *
 * @package Smarty
 * @subpackage PluginsModifierCompiler
 */

/**
 * Gizmore duration modifier
 *
 * Type:     modifier
 * Name:     duration
 * Date:     Mar 22, 2011
 * Purpose:  convert seconds to human readable duration like 1h 25m 3s
 * Input:    int to convert
 * Example:  {$var|duration:"2"}
 * @author   gizmore
 * @param array $params parameters
 * @return string with compiled code
 */
function smarty_modifier_duration($seconds, $precision=2)
{
	return GWF_Time::humanDuration($seconds, $precision);
}

?>