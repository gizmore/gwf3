<?php
/**
 * Smarty read include path plugin
 *
 * @package Smarty
 * @subpackage PluginsInternal
 * @author Monte Ohrt
 */

/**
 * Smarty Internal Read Include Path Class
 *
 * @package Smarty
 * @subpackage PluginsInternal
 */
class Smarty_Internal_Get_Include_Path {

    /**
     * Return full file path from PHP include_path
     *
     * @param string $filepath filepath
     * @return mixed full filepath or false
     */
    public static function getIncludePath($filepath)
    {
        static $_path_array = null;

        if(!isset($_path_array)) {
            $_ini_include_path = ini_get('include_path');
            $_path_array = explode(strpos($_ini_include_path,';') !== false ? ';' : ':',$_ini_include_path);
        }
        foreach ($_path_array as $_include_path) {
            if (file_exists($_include_path . DS . $filepath)) {
                return $_include_path . DS . $filepath;
            }
        }
        return false;
    }

}

?>