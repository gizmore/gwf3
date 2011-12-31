<?php
/**
 * Ultra Safe Auto Include
 * @author Z
 * @param string $classname
 */
function my_autoloader($classname)
{
	chdir('challenge/are_you_serial');
	require_once './'.str_replace('.', '', $classname).'.php';
	chdir('../../');
}

/**
 * Registers auto include
 */
spl_autoload_register('my_autoloader');
?>
