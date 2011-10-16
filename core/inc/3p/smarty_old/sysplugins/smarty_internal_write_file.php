<?php
/**
 * Smarty write file plugin
 *
 * @package Smarty
 * @subpackage PluginsInternal
 * @author Monte Ohrt
 */

/**
 * Smarty Internal Write File Class
 *
 * @package Smarty
 * @subpackage PluginsInternal
 */
class Smarty_Internal_Write_File {

    /**
     * Writes file in a safe way to disk
     *
     * @param string $_filepath complete filepath
     * @param string $_contents file content
     * @param Smarty $smarty    smarty instance
     * @return boolean true
     */
    public static function writeFile($_filepath, $_contents, Smarty $smarty)
    {
        $old_umask = umask(0);
        $_dirpath = dirname($_filepath);
        // if subdirs, create dir structure
        if ($_dirpath !== '.' && !file_exists($_dirpath)) {
            mkdir($_dirpath, $smarty->_dir_perms, true);
        }
        // write to tmp file, then move to overt file lock race condition
        $_tmp_file = tempnam($_dirpath, 'wrt');

        if (!($fd = @fopen($_tmp_file, 'wb'))) {
            $_tmp_file = $_dirpath . DS . uniqid('wrt');
            if (!($fd = @fopen($_tmp_file, 'wb'))) {
                throw new SmartyException("unable to write file {$_tmp_file}");
                return false;
            }
        }

        fwrite($fd, $_contents);
        fclose($fd);

        // remove original file
        if (file_exists($_filepath))
            @unlink($_filepath);
        // rename tmp file
        rename($_tmp_file, $_filepath);
        // set file permissions
        chmod($_filepath, $smarty->_file_perms);
        umask($old_umask);
        return true;
    }

}

?>