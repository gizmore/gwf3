<?php
$lang = array(
    'en' => array(
        'help' => 'Used to minify URLs using http://jbot.de. Usage: .jbot <string_long_url>',
		'error' => 'Sorry! Your request could not be finished successfully due to techical problems. Please try again later or contact your system administrator.'
    ),
);

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
		// Magic Values
		$SERVICE = 'http://jbot.de/create.php';
		$PREFIX = '<p class="redirect">';
		$POSTFIX = '</p>';

		$response = GWF_HTTP::post($SERVICE, array('url' => $url));
		// 1:1 html leech umgesetzt wie in Ralfs js example http://jbot.de/js/jbotcreate.js
		if(false === ($posStart = strpos($response, $PREFIX)))
		{
			return false;
		}
		else
		{
			$posStart += strlen($PREFIX);
			if(false === ($posEnd = strpos($response, $POSTFIX, $posStart)))
			{
				return false;
			}
			$minified = substr($response, $posStart, $posEnd - $posStart);
		}
		return $minified;
	}
}

//Init Plugin
$plugin = Dog::getPlugin();

//Validate Input
if ('' === ($args = $plugin->msg()))
{
	return $plugin->showHelp();
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


