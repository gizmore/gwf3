<?php
$user = Dog::getUser();
$server = Dog::getServer();
$message = Dog::getIRCMsg()->getArg(1);
$cmd = strtolower(Common::substrUntil($message, ' ', $message));
$msg = Common::substrFrom($message, ' ', $message);
switch ($cmd)
{
	case "ping":
	case "time":
	case "action":
	case "finger": break;
	case 'version': $user->sendCTCP(sprintf('VERSION Dog v%s. Http://dog.gizmore.org', DOG_VERSION)); break;
}

Dog_Module::map('trigger_ctcp', array($cmd, $msg));
?>
