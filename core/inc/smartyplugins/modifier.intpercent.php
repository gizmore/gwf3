<?php
/**
 * Smarty plugin
 *
 * @package Smarty
 * @subpackage PluginsModifierCompiler
 */

/**
 * Gizmore intpercent
 *
 * Type:     modifier
 * Name:     date
 * Date:     Mar 22, 2011
 * Purpose:  convert an integer from range 0-10000 to a percentual presentation, like 100.00%
 * Input:    int to convert
 * Example:  {$var|intpercent:"2"}
 * @author   gizmore
 * @param array $params parameters
 * @return string with compiled code
 */
function smarty_modifier_intpercent($int, $precision=2)
{
	return sprintf('%.0'.$precision.'f%%', $int/100);
}

?>