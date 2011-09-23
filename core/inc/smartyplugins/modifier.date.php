<?php
/**
 * Smarty plugin
 *
 * @package Smarty
 * @subpackage PluginsModifierCompiler
 */

/**
 * Gizmore date modifier
 *
 * Type:     modifier
 * Name:     date
 * Date:     Mar 22, 2011
 * Purpose:  convert a gdo_date into human readable date
 * Input:    int to convert
 * Example:  {$var|duration:"2"}
 * @author   gizmore
 * @param array $params parameters
 * @return string with compiled code
 */
function smarty_modifier_date($gdo_date)
{
	return GWF_Time::displayDate($gdo_date);
}

?>