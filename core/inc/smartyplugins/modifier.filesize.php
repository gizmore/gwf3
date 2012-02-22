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
function smarty_modifier_filesize($bytes, $digits=3, $divisor=1024, $output=0)
{
	$output = (int)$output;
	$digits = (int)$digits;
	$divisor = (int)$divisor;
	static $units = array(
		array(
			array('Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'),
			array('Bytes', 'KiloBytes', 'MegaBytes', 'GigaBytes', 'TerraBytes', 'PetaBytes', 'Exabytes', 'Zettabytes', 'Yottabytes'),
		),
		array(
			array('Bytes', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB'),
			array('Bytes', 'KibiBytes', 'MebiBytes', 'GibiBytes', 'TebiBytes', 'PebiBytes', 'Exbiytes', 'Zebibytes', 'Yobibytes'),
		),
	);
	$foo = $divisor === 1024 ? 1 : 0;
	$unit = 0;
	while ($bytes >= $divisor && $unit < count($units[$foo][$output])-1)
	{
		$bytes /= $divisor;
		$unit++;
	}
	return sprintf('%0.'.$digits.'f %s', $bytes, $units[$foo][$output][$unit]);
//	return Common::humanFilesize();
//    return '('.implode(').(', $params).')';
}

?>
