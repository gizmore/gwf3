<?php
/**
 * Smarty plugin
 *
 * @package Smarty
 * @subpackage PluginsModifierCompiler
 */

/**
 * Gizmore timestamp modifier
 *
 * Type:     modifier
 * Name:     timestamp
 * Date:     Dec 06, 2011
 * Purpose:  convert a timestamp into human readable date
 * Input:    int to convert
 * Example:  {$var|timestamp:"8"}
 * @author   gizmore
 * @param array $params parameters
 * @return string with compiled code
 */
function smarty_modifier_timestamp($timestamp)
{
	return GWF_Time::displayTimestamp($timestamp, NULL, 'Never');
}

?>