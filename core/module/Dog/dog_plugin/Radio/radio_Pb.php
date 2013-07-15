<?php
$lang = array(
    'en' => array(
        'help' => 'Usage: %CMD% <title>. Search for a random internet radio stream. Hint: Usage of wildcards (* AND ?) is supported.',
        'nope' => 'Sorry, your search revealed no results. Hint: Usage of wildcards (* AND ?) is supported.',
    	'yeps' => '%s ( %s )',
    ),
);
$plugin = Dog::getPlugin();
if ('' === ($message = $plugin->msg()))
{
    $message = '*';
}
 
if (!function_exists('getRandomRadio'))
{
    function getRandomRadio($term)
    {
        $term = str_replace(" ","+",$term);
    	$url = 'http://hagbard.host-ed.me/intranet/radio.php?out=inline&shuffle=true&limit=1&search='.urlencode($term);
        $content = GWF_HTTP::getFromUrl($url.str_replace("%23","#",urlencode($term)).'*');
        if ($content === false || strlen($content) == 0)
        {
            return false;
        }
        echo $content.PHP_EOL;
        $temp = explode('|', $content, 2);
        return array(
        	Common::substrFrom($temp[1], ') ', $temp[1]),
        	$temp[0],
        );
    }
}
 
if (false === ($result = getRandomRadio($message)))
{
    $plugin->rply('nope');
}
else
{
	$plugin->rply('yeps', $result);
}
