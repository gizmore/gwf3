<?php # Specify your age. Usage: %CMD% <age_in_years>.
$bot instanceof Lamb;
$user = $bot->getCurrentUser();
if ($user->getName() === 'Wyshfire')
{
	return $bot->reply('You are 21');
}
$bot->reply('You have no age specified. An age is required to execute this function.');
?>