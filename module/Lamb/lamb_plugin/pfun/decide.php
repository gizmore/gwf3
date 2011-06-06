<?php # Usage : %CMD% <option1>[ or <optionN> ... ]. Let the bot choose of a set of options for you.
$bot = Lamb::instance();

# Last input
global $lamb_decide_last_data;
if (empty($lamb_decide_last_data)) { $lamb_decide_last_data = array(); }

# Split and clean data
$data = preg_split('/(?: or | oder |\|\||\|)/', $message);
$data = array_map('trim', $data);
foreach ($data as $i => $s)
{
	if ($s === '') {
		unset($data[$i]);
	}
}
$data = array_unique($data);

# Same data?
if (count($lamb_decide_last_data) === count($data))
{
	$t = $lamb_decide_last_data;
	sort($t); sort($data);
	$diff = count(array_diff($t, $data));
}
else {
	$diff = 1;
}

# yes, same data
if ($diff === 0) {
	$bot->reply('I just told you!');
	return;
}

# New choose
$lamb_decide_last_data = $data;

# Yes,No
if (count($data) === 1) {
	if (rand(0,1)) {
		$bot->reply('Yes');
	} else {
		$bot->reply('No');
	}
	return;
}

# Random
$bot->reply($data[rand(0, count($data)-1)]);
?>