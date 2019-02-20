<?php
####conf maxlen,c,i,i,433
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <page>. Search the Wikipedia. http://www.wikipedia.org/',
		'nope' => "Your term doesn't exist.",
	),
);
$plugin = Dog::getPlugin();

if ('' === ($message = $plugin->msg()))
{
	return $plugin->showHelp();
}

if (!function_exists('getWikiText'))
{
	function getWikiText($term, $wikiurl, $notfound)
	{
		$term = str_replace(" ","_",$term);
		$term[0] = strtoupper($term[0]);
		$content = GWF_HTTP::getFromUrl($wikiurl.str_replace("%23","#",urlencode($term)));
	
		if($content === false || stristr($content, $notfound))
		{
			return false;
		}
	
		$pos = strpos($content,'<div id="contentSub">');
		$content = substr($content,$pos);
		$content = preg_replace("#<tr.*?</tr>#",'',$content);
		$content = str_replace("</li>",",</li>",$content);
	
		preg_match_all("#<(p|li)>(.*?)</(p|li)>#",$content,$arr);
	
		$content = "";
		foreach($arr[2] as $row)
		{
			$row = trim(strip_tags($row));
			if (!empty($row))
			{
				$content.= $row." ";
			}
		}
	
		$content = html_entity_decode($content);
		$content = str_replace(chr(160)," ",$content);
	
		$output['text'] = $content;
		$output['link'] = $wikiurl.urlencode($term);
		return $output;
	}
}

if (false === ($result = getWikiText($message, 'http://en.wikipedia.org/wiki/', 'Wikipedia does not have an article with this exact name')))
{
	return $plugin->rply('nope');
}

$maxlength = (int)$plugin->getConf('maxlen', 433);

$output = substr($result['text'], 0, $maxlength - (strlen($result['link']) + 6));
$output .= '... ('.$result['link'].')';

Dog::reply($output);
?>
