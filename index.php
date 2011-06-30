<?php

require_once 'gwf3.class.php';

$gwf = new GWF3();

echo $gwf->onDisplayPage();
$gwf->onSessionCommit();
unset($gwf);