<?php
/**
 * 
 * @author spaceone
 */
final class GWF_System
{
	/**
	 *
	 * @return false|array
	 */
	public static function system($cmd)
	{
		$funcs = array('system', 'shell_exec', 'passthru', 'exec', 'popen');
		foreach($funcs as $f)
		{
			if(function_exists($f))
			{
				return call_user_func("self::_{$f}", $cmd);
			}
		}
		return false;
	}

	public static function _system($cmd)
	{
		# string system ( string $command [, int &$return_var ] )
		# returns last line or False on error
		# outputs directly
		ob_start();
		system($cmd, $return_var);
		$back = ob_get_contents();
		ob_end_clean();
		return array($return_var, $back);
	}

	public static function _shell_exec($cmd)
	{
		# string shell_exec ( string $cmd )
		# returns command output
		$back = shell_exec($cmd);
		return array(false, $back);
	}

	public static function _exec($cmd)
	{
		# string exec ( string $command [, array &$output [, int &$return_var ]] )
		# returns last line
		exec($cmd, $array, $return_var);
		$back = implode("\n", $array);
		return array($return_var, $back);
	}

	public static function _popen($cmd)
	{
		# resource popen ( string $command , string $mode )
		$infinite = 999999999999999999999; # FIXME
		$fh = popen($cmd, 'r');
		$back = fread($fh, $infinite);
		pclose($fh);
		return array(false, $back);
	}

	public static function _passthru($cmd)
	{
		# void passthru ( string $command [, int &$return_var ] )
		# outputs directly
		ob_start();
		passthru($cmd, $return_var);
		$back = ob_get_contents();
		ob_end_clean();
		return array($return_var, $back);
	}

}
