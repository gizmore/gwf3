<?php # Usage: %CMD% <integer>. Predict the next sequential integer polled from rand(). $100 won by noother!
$bot = Lamb::instance();

if ( ($message === '') || (false === Common::isNumeric($message)) )
{
	return $bot->getHelp('predict');
}

$predicted = (int)$message;
$max = getrandmax();
$rand = rand(0, getrandmax());

if ($rand === $predicted)
{
	return $bot->reply("Well done!");
}
else
{
	return $bot->reply(sprintf('You predicted %s but the outcome was %s.', $predicted, $rand));
}
?>