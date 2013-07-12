<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% [<user>]. Give or grab a beer to cool the codemonkeys down.',
		'give1' => 'passes 1 of %d bottles of cold beer around to %s.',
		'steal1' => 'passes 1 of %d bottles of cold beer around to %s, but gizmore steals it!',
		'give2' => 'and %s pass 1 of %d bottles of cold beer around to %s.',
		'steal2' => 'and %s pass 1 of %d bottles of cold beer around to %s, but gizmore steals it!',
		'ouch0' => 'Is there any .vodka left?',
		'ouch1' => 'Alert, Emergency Log!, Critical Error! help!!!!! Beer is empty, repeat. BEER IS EMPTY!',
		'ouch2' => 'I have no beer left.',
	),
);
$plugin = Dog::getPlugin();
$user = Dog::getUser();
$unam = $user->getName();

# Any left?
global $DOTBEERLEFT;
$DOTBEERLEFT = isset($DOTBEERLEFT) ? $DOTBEERLEFT-1 : 100;
// $DOTBEERLEFT = 100;
if ($DOTBEERLEFT < 0)
{
	return $plugin->rply('ouch'.rand(0, 2));
}

# Steal?
$key = ($unam === 'gizmore') || rand(0,3) ? 'give' : 'steal';

# Output
$args = $plugin->argv();
if ( (count($args) === 1) && ( $args[0] != '') && ( $args[0] != $unam) )
{
	$plugin->rplyAction($key.'2', array($user->displayName(), $DOTBEERLEFT, $args[0]));
}
else 
{
	$plugin->rplyAction($key.'1', array($DOTBEERLEFT, $user->displayName()));
}
?>
