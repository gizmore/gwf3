<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <filename>. Search for a file in the gwf3 code repositry at http://trac.gwf3.gizmore.org',
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

global $__DOG_TRAC_RESULTS, $__DOG_TRAC_LAST;
$__DOG_TRAC_RESULTS = array();

# Last command is $
if (!isset($__DOG_TRAC_LAST)) { $__DOG_TRAC_LAST = ''; }
$message = str_replace('$', $__DOG_TRAC_LAST, $message);
$__DOG_TRAC_LAST = $message;

# The callback function for the filewalker
if (!(function_exists('dog_trac_helper4')))
{
	function dog_trac_helper4($entry, $fullpath, $search, $casei=false)
	{
		if ($casei === true)
		{
			if (stripos($fullpath, $search) !== false)
			{
				if (strpos($fullpath, '/disabled_modules/') === false)
				{
					global $__DOG_TRAC_RESULTS;
					$__DOG_TRAC_RESULTS[] = Common::substrFrom($fullpath, GWF_PATH);
				}
			}
		}
		
		else 
		{
			if (strpos($fullpath, $search) !== false)
			{
				if (strpos($fullpath, '/disabled_modules/') === false)
				{
					global $__DOG_TRAC_RESULTS;
					$__DOG_TRAC_RESULTS[] = Common::substrFrom($fullpath, GWF_PATH);
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
	GWF_File::filewalker(GWF_PATH.$dir, 'dog_trac_helper4', true, true, $message);
}

# Print results
$url = 'http://trac.gwf3.gizmore.org/browser/';
switch (count($__DOG_TRAC_RESULTS))
{
	case 0:
		return $plugin->rply('err_file');
		
	case 1: case 2: case 3:
		$out = '';
		foreach ($__DOG_TRAC_RESULTS as $result)
		{
			$out .= ' | '.$url.$result;
		}
		return Dog::reply(substr($out, 3));
		
	default:
		if (count($__DOG_TRAC_RESULTS) > 10)
		{
			return $plugin->rply('too_much', array($__DOG_TRAC_RESULTS, 10));
		}
		$out = '';
		foreach ($__DOG_TRAC_RESULTS as $result)
		{
			$out .= ', '.basename($result);
		}
		return $plugin->rply('out', array(count($__DOG_TRAC_RESULTS), substr($out, 2)));
}
?>
