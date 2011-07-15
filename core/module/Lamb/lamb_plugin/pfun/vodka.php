<?php # Drink some vodka with Lamb!
switch($user->getName())
{
	case 'Oz': $msg = "Nastrovje!"; break;
	default: $msg = "You are too young for vodka, have no age specified, or your brain would suffer too much!"; break;
} 
$bot->reply($msg);
?>