<?php # Usage: %CMD% <filename>. Search for a file in the gwf3 code repositry at http://trac.gwf3.gizmore.org
if ($message === '')
{
	return $bot->getHelp('trac');
}

global $__LAMB_TRAC_RESULTS, $__LAMB_TRAC_LAST;
$__LAMB_TRAC_RESULTS = array();

# Last command is $
if (!isset($__LAMB_TRAC_LAST)) { $__LAMB_TRAC_LAST = ''; }
$message = str_replace('$', $__LAMB_TRAC_LAST, $message);
$__LAMB_TRAC_LAST = $message;

# The callback function for the filewalker
if (!(function_exists('lamb_trac_helperB')))
{
	function lamb_trac_helperB($entry, $fullpath, $search)
	{
		if (strpos($fullpath, $search) !== false)
		{
			global $__LAMB_TRAC_RESULTS;
			$__LAMB_TRAC_RESULTS[] = $fullpath;
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
	GWF_File::filewalker($dir, 'lamb_trac_helperB', true, true, $message);
}

# Print results
$url = 'http://trac.gwf3.gizmore.org/browser/';
switch (count($__LAMB_TRAC_RESULTS))
{
	case 0:
		return $bot->reply('There is no file with that name.');
		
	case 1: case 2: case 3:
		$out = '';
		foreach ($__LAMB_TRAC_RESULTS as $result)
		{
			$out .= ' | '.$url.$result;
		}
		return $bot->reply(substr($out, 3));
		
	default:
		if (count($__LAMB_TRAC_RESULTS) > 10)
		{
			return $bot->reply(sprintf('There are %d/10 matches. Try again.', count($__LAMB_TRAC_RESULTS)));
		}
		$out = '';
		foreach ($__LAMB_TRAC_RESULTS as $result)
		{
			$out .= ', '.basename($result);
		}
		return $bot->reply(sprintf('%d matches: %s.', count($__LAMB_TRAC_RESULTS), substr($out, 2)));
}
?>
