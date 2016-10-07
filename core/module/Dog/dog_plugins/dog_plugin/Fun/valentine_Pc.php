<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% [<user>[,...<user>]] [<user>[,...<user>]]. Suggest or dice a probably gay couple of an optional list.',
		'lone' => 'Your´e just a lonely boy.',
		'gar1' => 'I think %s and %s should get a room.',
		'gar2' => 'Have you ever thought about %s and %s getting a room? Gross!',
	),
);
$plugin = Dog::getPlugin();

$channel = Dog::getChannel();
$users = $channel->getUsers();
$sources = $users;
$targets = $users;

if (!function_exists("valentine_valid_users")) {
	function valentine_valid_users($username_csv)
	{
		$users = array();
		$usernames = split(",", $username_csv);
		foreach ($usernames as $username) {
			if ($user = $channel->getUserByName($username)) {
				$users[] = $user;
			}
		}
		return $users;
	}
}

if (!function_exists("valentine_merge_users"))
{
	function valentine_merge_users($usersA, $usersB)
	{
		$valentines = array();
		foreach ($usersA as $user)
		{
			$user instanceof Dog_User;
			if (!$user->isBot())
			{
				if (false === array_search($user, $valentines, true))
				{
					$valentines[] = $user;
				}
			}
		}
		foreach ($usersB as $user)
		{
			$user instanceof Dog_User;
			if (!$user->isBot())
			{
				if (false === array_search($user, $valentines, true))
				{
					$valentines[] = $user;
				}
			}
		}
		return $valentines;
	}
}

if (!function_exists("valentine_shuffle"))
{
	function valentine_shuffle($users)
	{
		if(!shuffle($users)) die('thx dloser!'); // Do the harlem shuffle
		
		$cut = intval(count($users) / 2);
		$left = array_slice($users, $cut, 1);
		$right = array_slice($users, $cut);
		
		return array($left, $right);
	}
}

switch ($plugin->argc())
{
	case 2:
		$targets = valentine_valid_users($plugin->argv(1));
	case 1:
		$sources = valentine_valid_users($plugin->argv(0));
	case 0:
		break;
	default:
		return $plugin->showHelp();
}

var_dump($targets);
var_dump($sources);

$valentines = valentine_merge_users($sources, $targets);
var_dump($valentines);

$valentines = valentine_shuffle($valentines);
var_dump($valentines);

// No partner
if (count($valentines[1]) !== 1)
{
	return $plugin->rply('lone');
}

var_dump($valentines);

$left_d = array_splice($valentines[0], rand(0, count($valentines)), 1);

$right_v = array_rand($valentines[1], 1);

$plugin->rply('gar'.rand(1, 2), array($left_d[0]->getName(), $right_v->getName()));
