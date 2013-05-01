<?php
require_once LAMB::DIR.'Lamb_WC_Solvers.php';

$url = 'http://sabrefilms.co.uk/revolutionelite/w3ch4ll/solvers_revel.php?datestamp=%DATE%';
$format = "%s \x02%s\x02 has just solved \x02%s\x02. This challenge has been solved %d times. (http://revolutionelite.co.uk)";

lamb_wc_solvers('RevEl', '[RevEl]', $url, array('#revolutionelite'), 99999, $format);
?>
