<?php # Usage: %CMD% <filename>. Search for a file in the gwf3 code repositry at http://trac.gwf3.gizmore.org
if ($message === '')
{
	return $bot->getHelp('trac');
}

global $results;
$results = array();

if (!(function_exists('lamb_trac_helper')))
{
	function lamb_trac_helper($entry, $fullpath, $search)
	{
		if (stripos($entry, $search) !== false)
		{
			global $results;
			$results[] = $fullpath;
		}
	}
}

GWF_File::filewalker('core', 'lamb_trac_helper', true, true, $message);

$url = 'http://trac.gwf3.gizmore.org/browser/';

switch (count($results))
{
	case 0:
		return $bot->reply('There is no file with that name.');
		
	case 1: case 2: case 3:
		$out = '';
		foreach ($results as $result)
		{
			$out .= ' | '.$url.$result;
		}
		return $bot->reply(substr($out, 3));
		
	default:
		if (count($results) > 10)
		{
			return $bot->reply('There are more than 10 matches. Try again.');
		}
		$out = '';
		foreach ($results as $result)
		{
			$out .= ', '.basename($result);
		}
		return $bot->reply(sprintf('%d matches: %s.', count($results), substr($out, 2)));
}

?>