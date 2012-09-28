<?php # Usage: %CMD% <integer>. Predict the next sequential integer polled from rand(). When you can predict 20 numbers in a row i send you $100. (gizmore)
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