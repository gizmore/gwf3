<?php

//Magic Values 
define('JBOT_SERVICE', 'http://jbot.de/create.php');
define('JBOT_PREFIX', '<p class="redirect">');
define('JBOT_POSTFIX', '</p>');

//Resources Localization
$lang = array(
    'en' => array(
        'help' => 'Used to minify URLs using http://jbot.de. Usage: .jbot <string_long_url>',
		'error' => 'Sorry! Your request could not be finished successfully due to techical problems. Please try again later or contact your system administrator.'
    ),
);

//Init Plugin
$plugin = Dog::getPlugin();


//Validate Input
if ('' === ($args = $plugin->msg()))
{
    $plugin->rply('help');
	die();
}
 
//Minify URL
if (false === ($reply = jbot_minify($args)))
{
	$plugin->rply('error');
}
else
{
	$plugin->rply($reply);
}


/* ======================================================================= */ 
//stuff behind
/* ======================================================================= */ 
if (!function_exists('jbot_minify'))
{
	/**
	 * Used to minify URLs
	 *
	 * @param string $url The URL you want to be minified by http://jbot.de
	 * @return array An Array containing a Title(1) and an URL(0)
	 */	
	function jbot_minify($url)
	{
		$response = GWF_HTTP::post(array('url' => $url));
		
		
		// 1:1 html leech umgesetzt wie in Ralfs js example http://jbot.de/js/jbotcreate.js
		if(false === ($posStart = strpos($response, JBOT_PREFIX)))
		{
			return false;	
		}
		else
		{
			$posStart += strlen(JBOT_PREFIX);
			if(false === ($posEnd = strpos($response, JBOT_POSTFIX, $posStart)))
			{
				return false;
			}
			$minified = substr($response, $posStart, $posEnd - $posStart);	
		}
		return $minified;
	}
}