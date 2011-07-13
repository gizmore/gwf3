<?php
require_once LAMB::DIR.'Lamb_WC_Solvers.php';

lamb_wc_solvers('WC', '[WeChall]', 'https://www.wechall.net/index.php?mo=WeChall&me=API_ChallSolved&ajax=true&datestamp=%DATE%&no_session=true', array('#wechall'));
?>
