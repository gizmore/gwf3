<?php # Codemonkey cool down get a beer...
$server instanceof Lamb_Server;
$user instanceof Lamb_User;
if ($user->getName() === 'gizmore') {
	$steal = '.';
}
elseif (rand(0,3)) {
	$steal = '.';
}
else {
	$steal = ', but gizmore steals it!';
}
$server->sendAction($origin, sprintf('hands %s a cold beer%s', $user->getName(), $steal));
?>