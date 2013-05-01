<?php # Usage: %CMD% <integer>. Predict the next sequential integer polled from GWF_Random::rand(). Predict 20 in a row and i send you $100.
$bot = Lamb::instance();

if ( ($message === '') || (false === Common::isNumeric($message)) )
{
	return $bot->getHelp('predict2');
}

$predicted = (int)$message;

$rand = GWF_Random::rand(0, GWF_Random::RAND_MAX);

if ($rand === $predicted)
{
	return $bot->reply("Well done!");
}
else
{
	return $bot->reply(sprintf('You predicted %s but the outcome was %s.', $predicted, $rand));
}
?>