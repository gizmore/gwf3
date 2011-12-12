<?php # Drink some vodka with Lamb!
switch($user->getName())
{
	case 'FreeArtMan': $msg = "Ah ... at least. I am not kid!"; break;
	case 'paipai':     $msg = "Chin Chin!"; break;
	case 'puolse':     $msg = "Cheers and congrats!"; break;
	case 'Oz':         $msg = "Nastrovje!"; break;
	case 'dalfor':     $msg = "Vodka? what am I russian?"; break;
	default:           $msg = "You are too young for vodka, have no age specified, or your brain would suffer too much!"; break;
} 
$bot->reply($msg);
?>
