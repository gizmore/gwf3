<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <func>. Searchs php.net for a function description.',
	),
);
$plugin = Dog::getPlugin();
$argv = $plugin->argv();
$argc = count($argv);

if ($argc !== 1)
{
	return $plugin->showHelp();
}

global $redirects, $message;
$redirects = 0;
$message = $argv[0];

if (!function_exists('fetchFunctionDescription'))
{
	/* language must be '' for en */
	function fetchFunctionDescription($func, $language='en') {
		global $message,$redirects;
		$notfoundtext = 'Nothing matches your query, try search:';
		
		Dog_Log::debug('phpmanual: fetching '.$func.' info');

		$res = GWF_HTTP::getFromUrl('http://'.($language!='en'?$language.'.':'').'php.net/'.$func, false, 'LAST_LANG='.$language);
		if ($res === false) {
			return 'Timeout on contacting '.($language!='en'?$language.'.':'').'php.net';
		}
	
		if (preg_match('/<span class=\"refname\">(.*?)<\/span> &mdash; <span class=\"dc\-title\">(.*?)<\/span>/si', $res, $match)) {
			$match[2] = str_replace(array("\n", "\r"), ' ', strip_tags($match[2]));

			preg_match('/<div class=\"methodsynopsis dc\-description\">(.*?)<\/div>/si', $res, $descmatch);

			$decl = isset($descmatch[1])?strip_tags($descmatch[1]):$match[1];
			$decl = html_entity_decode(str_replace(array("\n", "\r"), ' ', $decl));
			$decl = str_replace($func, "\x02".$func."\x02", $decl);
			$output =  $decl.' - '.html_entity_decode($match[2]).' ( http://'.($language!='en'?$language.'.':'').'php.net/'.$func.' )';
			
		} else {    // if several possibilities
			$output = '';

			if (preg_match_all('/<a href=\"\/manual\/[a-z]+\/(?:.*?)\.php\">(?:<b>)?(.*?)(?:<\/b>)?<\/a><br/i', $res, $matches, PREG_SET_ORDER)) {
				if ($redirects++ < 2)
					return fetchFunctionDescription($matches[0][1]);
				else 
					return $notfoundtext.' http://'.($language!='en'?$language.'.':'').'php.net/search.php?show=wholesite&pattern='.$message;
			} else
				$output = $notfoundtext.' http://'.($language!='en'?$language.'.':'').'php.net/search.php?show=wholesite&pattern='.$func;

		}

		return $output;
	}
}

$text = fetchFunctionDescription($message);
$text = preg_replace('/[ ]{2,}/', ' ', $text);
$plugin->reply(utf8_encode(html_entity_decode($text, ENT_QUOTES)));
