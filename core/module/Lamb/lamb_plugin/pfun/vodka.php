<?php # Drink some vodka with Lamb!
switch($user->getName())
{
	case 'FreeArtMan': $msg = "Ah ... at least. I am not kid!"; break;
	case 'paipai':     $msg = "Chin Chin!"; break;
	case 'puolse':     $msg = "Cheers and congrats!"; break;
	case 'Oz':         $msg = "Nastrovje!"; break;
	case 'sabretooth': $msg = "One vodka, Mr. Bond. Shaken, not stirred."; break;
	case 'dalfor':     $msg = "vodka? what am I russian?"; break;
	default: $msg = "You are too young for vodka, have no age specified, or your brain would suffer too much!"; break;
} 
$bot->reply($msg);
?>
