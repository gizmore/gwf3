<?php # Usage: %CMD% <word>. Searchs urbandictionary for description.

$bot = Lamb::instance();


if ($message === '')
{
	return $bot->getHelp('wtf');
}


if (!function_exists('fetchDefinition'))
{
	/* language must be '' for en */
	function fetchDefinition($term) {
		$output = array();
		
		$res = GWF_HTTP::getFromUrl('http://www.urbandictionary.com/define.php?term='.$term);
		if ($res === false) 
		{
			return 'Timeout on contacting urbandictionary';
		}
		
		if(strstr($res, "isn't defined <a href")) 
		{
			return array('definition' => $term.' has no definition. Feel free to add one at http://www.urbandictionary.com/add.php?word='.$term);						
		}
	
		preg_match('#<div class="definition">(.+?)</div>.*?<div class="example">(.*?)</div>#s', $res, $arr);
		
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


$def = fetchDefinition($message);
$bot->reply(utf8_encode($def['definition']));

if (isset($def['example']))
	$bot->reply(utf8_encode("\x02Example:\x02 ".$def['example']));

?>
