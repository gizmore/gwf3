<?php
require_once DOG_PATH.'dog_lib/Dog_WC_Solvers.php';
$url = 'http://www.wixxerd.com/challenges/recentlysolved.cfm?cdate=%DATE%';
$format = "%1\$s \x02%2\$s\x02 has just solved \x02%3\$s\x02. This challenge has been solved %4\$d times. (%5\$s)";
dog_wc_solvers('wixxerd', '[wixxerd]', $url, array('#wixxerd'), 100, $format);
?>
