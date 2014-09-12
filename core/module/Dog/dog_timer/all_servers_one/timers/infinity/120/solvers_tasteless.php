<?php
require_once DOG_PATH.'dog_lib/Dog_WC_Solvers.php';
$url = 'http://www.wechall.net/index.php?mo=WeChall&me=API_ChallSolvedWarbox&siteid=73&ajax=true&datestamp=%DATE%&no_session=true';
$format = "%1\$s \x02%2\$s\x02 has just solved \x02%3\$s\x02. This challenge has been solved %4\$d times. (%5\$s)";
dog_wc_solvers('TLESS', '[Tasteless]', $url, array('#wechall', '#tasteless'), 200, $format);
