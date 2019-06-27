<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <word>. Searches urbandictionary for a description.',
		'example' => "\x02Example:\x02 %s",
		'none_yet' => '%s has no definition. Feel free to add one at http://www.urbandictionary.com/add.php?word=%s',
	),
);
$plugin = Dog::getPlugin();

if ('' === ($message = $plugin->msg()))
{
	return $plugin->showHelp();
}

if (!function_exists('fetchDefinitionE'))
{
	function fetchDefinitionE(Dog_Plugin $plugin, $term) {
		$output = array();
		
		$url = 'https://www.urbandictionary.com/define.php?term='.urlencode($term);
		$res = GWF_HTTP::getFromUrl($url);
		if ($res === false) 
		{
			echo "FAILED: $url\n";
			return Dog::lang('err_timeout');
		}
		
		if (!preg_match_all('#<div class="meaning">(.+?)</div>.*?<div class="example">(.*?)</div>#', $res, $arr))
		{
			return $plugin->lang('none_yet', array($term, urlencode($term)));
		}
		
		$definition = trim(html_entity_decode(strip_tags(preg_replace('#<\s*?br\s*?/?\s*?>#', "\n", $arr[1][0])), ENT_QUOTES|ENT_HTML5));
		$definition = strtr($definition, array("\r" => ' ', "\n" => ' '));
		while(false !== strstr($definition, '  ')) 
			$definition = str_replace('  ', ' ', $definition);
			
		if (strlen($definition) > 800) 
			$definition = substr($definition, 0 ,800).'...';
			
		$output['definition'] = $definition;
		
		if (!empty($arr[2])) 
		{
			$example = trim(html_entity_decode(strip_tags(preg_replace('#<\s*?br\s*?/?\s*?>#', "\n", $arr[2][0])), ENT_QUOTES|ENT_HTML5));
			$example = strtr($example, array("\r" => ' | ', "\n" => ' | '));
			
			while(false !== strstr($example, ' |  | ')) 
				$example = str_replace(' |  | ', ' | ', $example);
			while(false !== strstr($example, '  ')) 
				$example = str_replace('  ', ' ', $example);
			
			$example = str_replace("\" ", "\"", $example);
				
			if(strlen($example) > 800) $example = substr($example, 0, 800).'...';
				$output['example'] = $example;
		}

		return $output;
	}
}

$def = fetchDefinitionE($plugin, $message);

if (is_string($def))
{
	$plugin->reply($def);
}
else
{
	$plugin->reply($def['definition']);
	$plugin->rply('example', array($def['example']));
}
