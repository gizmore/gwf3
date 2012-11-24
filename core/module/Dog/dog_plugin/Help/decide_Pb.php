<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <option1>[ or <optionN> ... ]. Let %BOT% choose from a set of options for you.',
		'just' => 'I just told you!',
		'y' => 'Yes!',
		'n' => 'No.',
	),
);
$plugin = Dog::getPlugin();
$plg = $plugin->getName();

# Last input
if (NULL !== ($last = Dog_Conf_Plug_User::getConf($plg, Dog::getUID(), 'last', NULL)))
{
	$last = unserialize($last);
}
else
{
	$last = array();
}

# Split and clean data
$message = $plugin->msg();
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
$diff = 1;
if (count($last) === count($data))
{
	$t = $last;
	sort($t); sort($data);
	$diff = count(array_diff($t, $data));
}

# Yes, same data
if ($diff === 0)
{
	return $plugin->rply('just');
}

# New choose
Dog_Conf_Plug_User::setConf($plg, Dog::getUID(), 'last', serialize($last));

# Yes/No
if (count($data) === 1)
{
	$key = rand(0, 1) ? 'y' : 'n';
	return $plugin->rply($key);
}

# Random
Dog::reply($data[rand(0, count($data)-1)]);
?>
