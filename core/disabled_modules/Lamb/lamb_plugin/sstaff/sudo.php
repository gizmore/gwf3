<?php # Usage: %CMD% <linux command line>. Do Stuff
$bot = Lamb::instance();
$bot->reply('You bet');
return;
exec($message, $output);
foreach ($output as $line)
{
	$bot->reply($line);
}
?>
