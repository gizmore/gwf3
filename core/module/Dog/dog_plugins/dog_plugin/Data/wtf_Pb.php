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
		
		$res = GWF_HTTP::getFromUrl('http://www.urbandictionary.com/define.php?term='.$term);
		if ($res === false) 
		{
			return Dog::lang('err_timeout');
		}
		
		if (1 !== preg_match('#<div class=\'meaning\'>(.+?)</div>.*?<div class=\'example\'>(.*?)</div>#s', $res, $arr))
		{
			return $plugin->lang('none_yet', array($term, urlencode($term)));
		}
		
		$definition = trim(html_entity_decode(strip_tags(preg_replace('#<\s*?br\s*?/?\s*?>#', "\n", $arr[1]))));
		$definition = strtr($definition, array("\r" => ' ', "\n" => ' '));
		while(false !== strstr($definition, '  ')) 
			$definition = str_replace('  ', ' ', $definition);
			
		if (strlen($definition) > 800) 
			$definition = substr($definition, 0 ,800).'...';
			
		$output['definition'] = $definition;
		
		if (!empty($arr[2])) 
		{
			$example = trim(html_entity_decode(strip_tags(preg_replace('#<\s*?br\s*?/?\s*?>#', "\n", $arr[2]))));
			$example = strtr($example, array("\r" => ' | ', "\n" => ' | '));
			
			while(false !== strstr($example, ' |  | ')) 
				$example = str_replace(' |  | ', ' | ', $example);
			while(false !== strstr($example, '  ')) 
				$example = str_replace('  ', ' ', $example);
				
			if(strlen($example) > 800) $example = substr($example, 0, 800).'...';
				$output['example'] = $example;
		}

		return $output;
	}
}

$def = fetchDefinitionE($plugin, $message);

if (is_string($def))
{
	return $plugin->reply($def);
}

$plugin->reply(utf8_encode(html_entity_decode($def['definition'], ENT_QUOTES)));
if (isset($def['example']))
{
	$plugin->rply('example', array(utf8_encode(html_entity_decode($def['example'], ENT_QUOTES))));
}

?>
