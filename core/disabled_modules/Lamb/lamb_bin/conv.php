<?php

function do_it($filename) {

include $filename.'.php';

$back = '';
foreach($LAMB_CFG as $key => $val) {
	if (!is_array($val))
		$back .= sprintf('%s = %s'.PHP_EOL, $key, is_string($val) ? '"'.$val.'"' : $val);
	else {
		$back .= sprintf('[%s]', $key).PHP_EOL;
		foreach($val as $k => $v) {
			if(is_array($v)) {
				foreach($v as $serverk => $serverv)
					$back .= sprintf('%s[%s] = "%s"'.PHP_EOL, str_replace(array('ircs', 'irc', 'org', 'net', 'com'), '', preg_replace('/[^A-Za-z]/', '', $LAMB_CFG[$key][$k]['host'])) ,$serverk, $serverv);
			}
			else
				$back .= sprintf('%s = "%s"'.PHP_EOL, $k, $v);
			$back .= PHP_EOL;
		}
	}
}

file_put_contents($filename.'.ini', $back);

}


foreach(array('Lamb_Config', 'Lamb_Config.default',/**/ 'Lamb_Config_dev'/**/) as $file)
	do_it($file);
