<?php
/**
 * Smarty plugin
 *
 * @package Smarty
 * @subpackage PluginsModifierCompiler
 */

/**
 * Gizmore Filesize modifier
 *
 * Type:     modifier<br>
 * Name:     humanFilesize<br>
 * Date:     Mar 22, 2011
 * Purpose:  convert bytes to human readable filesize
 * Input:    int to convert
 * Example:  {$var|humanFilesize:"1"}
 * @author   gizmore
 * @param array $params parameters
 * @return string with compiled code
 */
function smarty_modifier_filesize($bytes, $digits=3, $divisor=1024)
{
	static $units = array('Bytes', 'KB', 'MB', 'GB', 'TB', 'PT', 'XX', 'YY', 'ZZ');
	$unit = 0;
	while ($bytes >= $divisor)
	{
		$bytes /= $divisor;
		$unit++;
	}
	$digits = (int)$digits;
	return sprintf('%0.'.$digits.'f %s', $bytes, $units[$unit]);
//	return Common::humanFilesize();
//    return '('.implode(').(', $params).')';
}

?>