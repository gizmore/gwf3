<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD%. Pick a random primenumber out of some.',
		'out_no_prime' => 'Your input does not belong to a prime number.',
		'out_no_clue' => 'The prime you have called is temporarily not available.',
		'out_no_neo' => 'Prime Exit dialed. Please call again later!',
		'out_no_error' => 'Your input does not belong to a prime number.',
		'out_your_number' => "Your \x02%s\x02 prime number is: %s.",
		'out_no' => 'winnning',
		'out_no_no' => 'lòósing',
	),
);
$plugin = Dog::getPlugin();

$primus = GWF_Prime::nextPrimeBetween();

switch ($primus)
{
	case GWF_Prime::NO_PRIME: $massage = $plugin->lang('out_no_prime'); break;
	case GWF_Prime::NO_CLUE: $massage = $plugin->lang('out_no_clue'); break;
	case GWF_Prime::NO_NEO: $massage = $plugin->lang('out_no_neo'); break;
	case GWF_Prime::NO_NO_NO: $massage = $plugin->lang('out_no_error'); break;
	case GWF_Prime::NO_NO_NOOOO: $massage = $plugin->lang('out_your_number'); break;
	default:
		$yo = GWF_Random::rand(0, 1) ? 'out_no' : 'out_no_no';
		$yo = $plugin->lang($yo);
		$massage = $plugin->lang('out_your_number', array($yo, $primus));
}

$plugin->reply($massage);
