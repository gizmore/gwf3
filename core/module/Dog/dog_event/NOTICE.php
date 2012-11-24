<?php
$msg = Dog::getIRCMsg()->getArg(0);
Dog_Log::user(Dog::setupUser(), $msg);
Dog_Log::channel(Dog::setupChannel(), $msg);
?>
