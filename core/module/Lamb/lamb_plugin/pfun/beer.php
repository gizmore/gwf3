<?php # Codemonkey cool down get a beer...
$server instanceof Lamb_Server;
$user instanceof Lamb_User;

# Steal
if ($user->getName() === 'gizmore') {
	$steal = '.';
}
elseif (rand(0,3)) {
	$steal = '.';
}
else {
	$steal = ', but gizmore steals it!';
}

# Left
global $DOTBEERLEFT;
if (!isset($DOTBEERLEFT))
{
	$DOTBEERLEFT = 100;
}
else
{
	$DOTBEERLEFT--;
}


if ($DOTBEERLEFT < 0)
{
	switch (rand(0, 2))
	{
		case 0: return $bot->reply('Is there any .vodka left?');
		case 1: return $bot->reply('Alert, Emergency Log!, Critical Error! help!!!!! Beer is empty, repeat. BEER IS EMPTY!');
		case 2: return $bot->reply('I have no beer left.');
	}
	
}

#add some options that allow to pass beer to your frends
$args = explode( ' ', $message );
if ((count( $args ) === 1) && ( $args[0] != '') && ( $args[0] != $user->getName()))
{
	$server->sendAction($origin, sprintf('and %s pass %d of %d bottles of cold beer around to %s%s', $user->getName(), 1, $DOTBEERLEFT, $args[0], $steal));
} else 
{
	$server->sendAction($origin, sprintf('passes %d of %d bottles of cold beer around to %s%s', 1, $DOTBEERLEFT, $user->getName(), $steal));
}
?>
