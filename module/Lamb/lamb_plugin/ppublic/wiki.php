<?php # Usage: %CMD% <page>. Search wikipedia.

$maxlength = 433;
$bot = Lamb::instance();


if ($message === '') {
	return;
}



if (false === ($result = getWikiText($message, 'http://en.wikipedia.org/wiki/', 'Wikipedia does not have an article with this exact name'))) {
	return $bot->reply('Your term doesnt exist: '.$message);
}

$output = substr($result['text'], 0, $maxlength - (strlen($result['link']) + 6));
$output .= '... ('.$result['link'].')';

$bot->reply($output);



function getWikiText($term, $wikiurl, $notfound) {
	$term = str_replace(" ","_",$term);
	$term[0] = strtoupper($term[0]);
	$content = GWF_HTTP::getFromUrl($wikiurl.str_replace("%23","#",urlencode($term)));

	if($content === false || stristr($content,$notfound)) {
		return false;
	}

	$pos = strpos($content,'<div id="contentSub">');
	$content = substr($content,$pos);
	$content = preg_replace("#<tr.*?</tr>#",'',$content);
	$content = str_replace("</li>",",</li>",$content);

	preg_match_all("#<(p|li)>(.*?)</(p|li)>#",$content,$arr);

	$content = "";
	foreach($arr[2] as $row) {
		$row = trim(strip_tags($row));
		if(empty($row)) continue;
		var_dump($content);
		$content.= $row." ";
	}

	$content = html_entity_decode($content);
	$content = str_replace(chr(160)," ",$content);

	$output['text'] = $content;
	$output['link'] = $wikiurl.urlencode($term);
	return $output;
}


?>