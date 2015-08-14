<?php

$repos = 'https://github.com/gizmore/gwf3/';

$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <filename>. Search for a file in the gwf3 code repositry at https://github.com/gizmore/gwf3/', # can't use $repos because of dirty eval in dog_include/Dog_Plugin.php line 159
		'err_file' => 'There is no file with that name.',
		'too_much' => 'There are %d/%d matches. Try again.',
		'out' => '%d matches: %s.',
	),
);
$plugin = Dog::getPlugin();

$message = $plugin->msg();

if ($message === '')
{
	return $plugin->showHelp();
}

global $__DOG_GIT_RESULTS, $__DOG_GIT_LAST;
$__DOG_GIT_RESULTS = array();

# Last command is $
if (!isset($__DOG_GIT_LAST)) { $__DOG_GIT_LAST = ''; }
$message = str_replace('$', $__DOG_GIT_LAST, $message);
$__DOG_GIT_LAST = $message;

# The callback function for the filewalker
if (!(function_exists('dog_git_helper4')))
{
	function dog_git_helper4($entry, $fullpath, $search, $casei=false)
	{
		if ($casei === true)
		{
			if (stripos($fullpath, $search) !== false)
			{
				if (strpos($fullpath, '/disabled_modules/') === false)
				{
					global $__DOG_GIT_RESULTS;
					$__DOG_GIT_RESULTS[] = Common::substrFrom($fullpath, GWF_PATH);
				}
			}
		}
		
		else 
		{
			if (strpos($fullpath, $search) !== false)
			{
				if (strpos($fullpath, '/disabled_modules/') === false)
				{
					global $__DOG_GIT_RESULTS;
					$__DOG_GIT_RESULTS[] = Common::substrFrom($fullpath, GWF_PATH);
				}
			}
		}
	}
}

# Iterate over these dirs
$dirs = array(
'core',
'www/js',
'www/challenge',		
);

foreach ($dirs as $dir)
{
	GWF_File::filewalker(GWF_PATH.$dir, 'dog_git_helper4', true, true, $message);
}

# Print results
$url = $repos.'tree/master/';
switch (count($__DOG_GIT_RESULTS))
{
	case 0:
		return $plugin->rply('err_file');
		
	case 1: case 2: case 3:
		$out = '';
		foreach ($__DOG_GIT_RESULTS as $result)
		{
			$out .= ' | '.$url.$result;
		}
		return Dog::reply(substr($out, 3));
		
	default:
		if (count($__DOG_GIT_RESULTS) > 10)
		{
			return $plugin->rply('too_much', array($__DOG_GIT_RESULTS, 10));
		}
		$out = '';
		foreach ($__DOG_GIT_RESULTS as $result)
		{
			$out .= ', '.basename($result);
		}
		return $plugin->rply('out', array(count($__DOG_GIT_RESULTS), substr($out, 2)));
}
?>
